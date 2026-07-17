<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Battle\Fortune\FortuneTray;
use App\Models\Battle\Fortune\FortunePots;
use App\Models\User;
use App\Models\Battle\Fortune\FortuneSetting;
use App\Models\Gift;
use App\Models\CoinBegRecived;
use App\Models\FortuneLock;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class FixGameIssues extends Command
{
    protected $signature = 'game:fix-all-issues 
                            {--batch-size=50 : Batch size for processing}
                            {--timeout=300 : Script timeout in seconds}
                            {--dry-run : Run without making actual changes}
                            {--force : Force process even recent trays}';
    
    protected $description = 'গেমের সকল সমস্যা সমাধান করে';
    
    private $batchSize;
    private $isDryRun;
    private $forceMode;
    private $stats = [];
    private $pendingBalanceUpdates = [];
    private $userCache = [];
    private $settingCache = null;
    private $recentTrayIds = [];
    
    public function handle()
    {
        $this->batchSize = (int) $this->option('batch-size');
        $this->isDryRun = $this->option('dry-run');
        $this->forceMode = $this->option('force');
        
        set_time_limit($this->option('timeout'));
        
        $this->stats = [
            'trays_no_winner' => 0,
            'trays_incomplete' => 0,
            'trays_completed_checked' => 0,
            'trays_with_unprocessed_pots' => 0,
            'pots_processed' => 0,
            'winners_found' => 0,
            'losers_marked' => 0,
            'amount_paid' => 0,
            'payouts_fixed' => 0,
            'locks_created' => 0,
            'locks_removed' => 0,
            'unprocessed_pots_fixed' => 0,
            'errors' => 0
        ];
        
    
        $startTime = now();
        
        try {
            if (!$this->forceMode) {
                $this->recentTrayIds = $this->getRecentTrayIds();
                $this->line("    Skipping " . count($this->recentTrayIds) . " most recent trays");
            }
            
          
            $this->processTraysByType('no_winner');
            
          
            $this->processTraysByType('incomplete');
            
           
            $this->processTraysByType('completed_with_unprocessed');
            
           
            $this->processTraysByType('completed_check_payouts');
           
            $this->checkUserLocks();
            
            $this->flushBalanceUpdates();
            
            $endTime = now();
            $duration = $endTime->diffInSeconds($startTime);
            
            $this->displayStatistics($duration);
            
          
            
        } catch (\Exception $e) {
            $this->error('❌ Fatal error: ' . $e->getMessage());
           
            
            return Command::FAILURE;
        }
        
        $this->info('✅ গেমের সমস্যা সমাধান সম্পন্ন হয়েছে!');
        return Command::SUCCESS;
    }
    
    private function getRecentTrayIds()
    {
        $cacheKey = 'recent_tray_ids';
        
        return Cache::remember($cacheKey, 60, function() {
            return FortuneTray::orderBy('id', 'desc')
                ->limit(2)
                ->pluck('id')
                ->toArray();
        });
    }
    
    private function processTraysByType($type)
    {
        $query = $this->buildTypeQuery($type);
        
        if (!$this->forceMode && !empty($this->recentTrayIds)) {
            $query->whereNotIn('id', $this->recentTrayIds);
        }
        
        $totalCount = $query->count();
        
        if ($totalCount === 0) {
            $this->line("    No {$type} trays found to process");
            return;
        }
        if($totalCount>0){
        $this->line("    Found {$totalCount} {$type} trays to process");
        }
        $processed = 0;
        $errors = 0;
        
        $query->orderBy('id')
              ->chunkById($this->batchSize, function($trays) use ($type, &$processed, &$errors, $totalCount) {
                  foreach ($trays as $tray) {
                      $success = $this->processTrayWithLock($tray, $type);
                      
                      if ($success) {
                          $processed++;
                      } else {
                          $errors++;
                      }
                      
                      if ($processed % 50 === 0) {
                          $this->line("        Progress: {$processed}/{$totalCount} (Errors: {$errors})");
                      }
                  }
              }, 'id');
        
        switch ($type) {
            case 'no_winner':
                $this->stats['trays_no_winner'] = $processed;
                break;
            case 'incomplete':
                $this->stats['trays_incomplete'] = $processed;
                break;
            case 'completed_with_unprocessed':
                $this->stats['trays_with_unprocessed_pots'] = $processed;
                break;
            case 'completed_check_payouts':
                $this->stats['trays_completed_checked'] = $processed;
                break;
        }
        
        
    }
    
    private function buildTypeQuery($type)
    {
        switch ($type) {
            case 'no_winner':
                return FortuneTray::where('status', 0)
                    ->where('result_status', 0)
                    ->where('created_at', '<', Carbon::now()->subMinutes(3));
                    
            case 'incomplete':
                return FortuneTray::where('status', 0)
                    ->where('result_status', 1)
                    ->where('created_at', '<', Carbon::now()->subMinutes(2));
                    
            case 'completed_with_unprocessed':
                // Find trays marked complete but have unprocessed pots (status=0)
                return FortuneTray::where('status', 1)
                    ->where('result_status', 1)
                    ->whereExists(function($query) {
                        $query->select(DB::raw(1))
                              ->from('fortune_pots')
                              ->whereColumn('fortune_pots.tray_id', 'fortune_trays.tray_id')
                              ->where('fortune_pots.status', 0);
                    });
                    
            case 'completed_check_payouts':
                // Find completed trays with processed pots to check for underpayments
                return FortuneTray::where('status', 1)
                    ->where('result_status', 1)
                    ->where('created_at', '<', Carbon::now()->subMinutes(5))
                    ->whereNotExists(function($query) {
                        $query->select(DB::raw(1))
                              ->from('fortune_pots')
                              ->whereColumn('fortune_pots.tray_id', 'fortune_trays.tray_id')
                              ->where('fortune_pots.status', 0);
                    });
                    
            default:
                throw new \InvalidArgumentException("Invalid type: {$type}");
        }
    }
    
    private function processTrayWithLock($tray, $type)
    {
        $lockKey = "tray_lock_{$tray->id}";
        $lock = Cache::lock($lockKey, 60);
        
        if (!$lock->get()) {
            $this->warn("    Skipping tray {$tray->id} - already being processed by another process");
            return false;
        }
        
        try {
            DB::beginTransaction();
            
            $freshTray = FortuneTray::lockForUpdate()->find($tray->id);
            
            if (!$freshTray) {
                DB::rollBack();
                $lock->release();
                return false;
            }
            
            // Check for unprocessed pots regardless of type
            $unprocessedCount = FortunePots::where('tray_id', $freshTray->tray_id)
                ->where('status', 0)
                ->count();
            
            if ($unprocessedCount > 0) {
                $this->line("        Tray {$freshTray->tray_id} has {$unprocessedCount} unprocessed pots");
            }
            
            $this->processTrayLogic($freshTray, $type);
            
            DB::commit();
            return true;
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            $this->stats['errors']++;
            
            Log::error("Failed to process tray {$tray->id}", [
                'error' => $e->getMessage(),
                'type' => $type,
                'trace' => $e->getTraceAsString()
            ]);
            
            return false;
            
        } finally {
            $lock->release();
        }
    }
    
    private function processTrayLogic($tray, $type)
    {
        switch ($type) {
            case 'no_winner':
                $winner = $this->determineWinnerForTray($tray);
                
                if (!$this->isDryRun && $winner) {
                    $tray->winner = $winner;
                    $tray->result_status = 1;
                    $tray->save();
                 
                }
                
                $this->processTrayPots($tray);
                
                if (!$this->isDryRun) {
                    $tray->status = 1;
                    $tray->save();
                }
                
                break;
                
            case 'incomplete':
                $this->processTrayPots($tray);
                
                if (!$this->isDryRun) {
                    $tray->status = 1;
                    $tray->save();
                }
                
                break;
                
            case 'completed_with_unprocessed':
                // Handle trays that are marked complete but have unprocessed pots
                $this->processUnprocessedPots($tray);
                break;
                
            case 'completed_check_payouts':
                // Check for underpayments in processed pots
                $this->checkTrayPayouts($tray);
                break;
        }
    }
    
    private function processUnprocessedPots($tray)
    {
        
        
        // Get all unprocessed pots for this tray
        $unprocessedPots = FortunePots::where('tray_id', $tray->tray_id)
            ->where('status', 0)
            ->lockForUpdate()
            ->get();
        
        if ($unprocessedPots->isEmpty()) {
            return;
        }
        
        $winnerCount = 0;
        $loserCount = 0;
        $amountPaid = 0;
        
        // Process winner pots
        $winnerPots = $unprocessedPots->where('pot_no', $tray->winner);
        foreach ($winnerPots as $pot) {
            $correctAmount = $pot->amount * 3;
            
            if (!$this->isDryRun) {
                // Queue balance update for user
                $this->queueBalanceUpdate($pot->user_id, $correctAmount);
                
                // Update pot
                $pot->serve_balance = $correctAmount;
                $pot->status = 1;
                $pot->processed_by = 'cron_fix_unprocessed';
                $pot->processed_at = now();
                $pot->save();
            }
            
            $winnerCount++;
            $amountPaid += $correctAmount;
            if($correctAmount>0){
            $this->line("          Winner pot {$pot->id}: User {$pot->user_id} paid {$correctAmount} TK");
            }
        }
        
        // Process loser pots
        $loserPots = $unprocessedPots->where('pot_no', '!=', $tray->winner);
        foreach ($loserPots as $pot) {
            if (!$this->isDryRun) {
                $pot->status = 10; // Lost status
                $pot->processed_by = 'cron_fix_unprocessed';
                $pot->processed_at = now();
                $pot->save();
            }
            
            $loserCount++;
        }
        
        // Update statistics
        $this->stats['unprocessed_pots_fixed'] += ($winnerCount + $loserCount);
        $this->stats['winners_found'] += $winnerCount;
        $this->stats['losers_marked'] += $loserCount;
        $this->stats['amount_paid'] += $amountPaid;
        $this->stats['pots_processed'] += ($winnerCount + $loserCount);
        if($amountPaid>0){
        $this->line("        Tray {$tray->tray_id}: Processed {$winnerCount} winners (paid {$amountPaid} TK) and {$loserCount} losers");
        }
    }
    
    private function determineWinnerForTray($tray)
    {
        $potTotals = FortunePots::where('tray_id', $tray->tray_id)
            ->select('pot_no', DB::raw('SUM(amount) as total'))
            ->groupBy('pot_no')
            ->get()
            ->keyBy('pot_no');
        
        $setting = $this->getSetting();
        
        if (!$setting) {
            $options = ['apple', 'watermelon', 'saven_win'];
            return $options[array_rand($options)];
        }
        
        $payouts = [
            'apple' => ($potTotals['apple']->total ?? 0) * 3,
            'watermelon' => ($potTotals['watermelon']->total ?? 0) * 3,
            'saven_win' => ($potTotals['saven_win']->total ?? 0) * 3
        ];
        
        if ($setting->pots_name && isset($payouts[$setting->pots_name])) {
            return $setting->pots_name;
        }
        
        foreach ($payouts as $pot => $amount) {
            if ($amount <= $setting->game_balance) {
                return $pot;
            }
        }
        
        return array_search(min($payouts), $payouts);
    }
    
    private function processTrayPots($tray)
    {
        // First check for any unprocessed pots
        $unprocessedPots = FortunePots::where('tray_id', $tray->tray_id)
            ->where('status', 0)
            ->lockForUpdate()
            ->get();
        
        if ($unprocessedPots->isEmpty()) {
            return;
        }
        
        // Process winner pots
        $winnerPots = $unprocessedPots->where('pot_no', $tray->winner);
        foreach ($winnerPots as $pot) {
            $correctAmount = $pot->amount * 3;
            $dueAmount = $correctAmount - $pot->serve_balance;
            
            if (!$this->isDryRun) {
                $this->queueBalanceUpdate($pot->user_id, $dueAmount);
                
                $pot->serve_balance = $correctAmount;
                $pot->status = 1;
                $pot->processed_by = 'cron_fix';
                $pot->processed_at = now();
                $pot->save();
            }
            
            $this->stats['winners_found']++;
            $this->stats['amount_paid'] += $dueAmount;
            $this->stats['pots_processed']++;
        }
        
        // Process loser pots
        $loserPots = $unprocessedPots->where('pot_no', '!=', $tray->winner);
        foreach ($loserPots as $pot) {
            if (!$this->isDryRun) {
                $pot->status = 10;
                $pot->processed_by = 'cron_fix';
                $pot->processed_at = now();
                $pot->save();
            }
            
            $this->stats['losers_marked']++;
            $this->stats['pots_processed']++;
        }
        
        $this->line("        Tray {$tray->tray_id}: {$winnerPots->count()} winners, {$loserPots->count()} losers");
    }
    
    private function checkTrayPayouts($tray)
    {
        $fixedCount = 0;
        
        $winnerPots = FortunePots::where('tray_id', $tray->tray_id)
            ->where('pot_no', $tray->winner)
            ->where('status', 1)
            ->get();
        
        foreach ($winnerPots as $pot) {
            $correctAmount = $pot->amount * 3;
            
            if ($pot->serve_balance < $correctAmount) {
                $dueAmount = $correctAmount - $pot->serve_balance;
                
                if (!$this->isDryRun) {
                    $this->queueBalanceUpdate($pot->user_id, $dueAmount);
                    
                    $pot->serve_balance = $correctAmount;
                    $pot->processed_by = 'cron_fix_payout';
                    $pot->processed_at = now();
                    $pot->save();
                }
                
                $this->stats['payouts_fixed']++;
                $this->stats['amount_paid'] += $dueAmount;
                $fixedCount++;
                
                $this->line("          Fixed underpayment: Pot {$pot->id}, User {$pot->user_id}, Added {$dueAmount} TK");
            }
            
            if ($pot->serve_balance > $correctAmount) {
                $excessAmount = $pot->serve_balance - $correctAmount;
                
              
                
                $this->line("          Warning: Overpayment detected for pot {$pot->id}, Excess: {$excessAmount} TK");
            }
        }
        
        if ($fixedCount > 0) {
            $this->line("        Tray {$tray->tray_id}: Fixed {$fixedCount} underpayments");
        }
    }
    
    private function queueBalanceUpdate($userId, $amount)
    {
        if ($amount <= 0) {
            return;
        }
        
        $key = "user_{$userId}";
        
        if (!isset($this->pendingBalanceUpdates[$key])) {
            $this->pendingBalanceUpdates[$key] = [
                'user_id' => $userId,
                'amount' => 0
            ];
        }
        
        $this->pendingBalanceUpdates[$key]['amount'] += $amount;
    }
    
    private function flushBalanceUpdates()
    {
        if ($this->isDryRun || empty($this->pendingBalanceUpdates)) {
            $this->pendingBalanceUpdates = [];
            return;
        }
        
        $totalAmount = 0;
        $userCount = 0;
        
        DB::transaction(function() use (&$totalAmount, &$userCount) {
            foreach ($this->pendingBalanceUpdates as $update) {
                if ($update['amount'] <= 0) {
                    continue;
                }
                
                DB::table('users')
                    ->where('id', $update['user_id'])
                    ->increment('balance', $update['amount']);
                
                $totalAmount += $update['amount'];
                $userCount++;
            }
            
            if ($totalAmount > 0) {
                DB::table('fortune_settings')
                    ->where('id', 1)
                    ->decrement('game_balance', $totalAmount);
            }
        });
        
        $this->line("    Flushed balance updates: {$userCount} users, total {$totalAmount} TK");
        
        $this->pendingBalanceUpdates = [];
    }
    
    private function checkUserLocks()
    {
        $activeUserIds = FortunePots::where('status', 0)
            ->where('created_at', '>', Carbon::now()->subDay())
            ->distinct('user_id')
            ->pluck('user_id')
            ->toArray();
        
        $this->line("    Checking " . count($activeUserIds) . " active users");
        
        $checked = 0;
        $locksCreated = 0;
        $locksRemoved = 0;
        
        foreach ($activeUserIds as $userId) {
            $user = User::find($userId);
            
            if (!$user || $user->auto_lock_status != 0) {
                continue;
            }
            
            $todaySanding = Gift::where('sander_id', $user->id)
                ->whereDate('date', date('Y-m-d'))
                ->sum('value');
            
            $coinBegReceived = CoinBegRecived::where('user_id', $user->id)
                ->sum('amount');
            
            $totalBalance = $todaySanding + $user->balance + $coinBegReceived;
            $todayBalance = $user->date_wise_balance;
            
            if ($todayBalance <= 0) {
                continue;
            }
            
            $ratio = $totalBalance / $todayBalance;
            
            if ($ratio < 0.7) {
                $existingLock = FortuneLock::where('user_id', $user->id)
                    ->where('type', 1)
                    ->first();
                
                if (!$existingLock && !$this->isDryRun) {
                    FortuneLock::create([
                        'user_id' => $user->id,
                        'imei_number' => $user->imei_number,
                        'auto_lock_active' => 'auto win',
                        'parcentage' => 10,
                        'type' => 1
                    ]);
                    
                    $locksCreated++;
                    
                 
                    
                    $this->line("          User {$user->id} locked (ratio: " . round($ratio * 100, 2) . "%)");
                }
            }
            
            elseif ($ratio > 1.1) {
                $deleted = FortuneLock::where('user_id', $user->id)
                    ->where('type', 1)
                    ->whereNotNull('auto_lock_active')
                    ->delete();
                
                if ($deleted && !$this->isDryRun) {
                    $locksRemoved++;
                    
                  
                    
                    $this->line("          User {$user->id} unlocked (ratio: " . round($ratio * 100, 2) . "%)");
                }
            }
            
            $checked++;
            
            if ($checked % 100 === 0) {
                $this->line("        User check progress: {$checked}/" . count($activeUserIds));
            }
        }
        
        $this->stats['locks_created'] = $locksCreated;
        $this->stats['locks_removed'] = $locksRemoved;
        
        if($locksRemoved || $locksCreated){
        $this->line("    User locks: {$locksCreated} created, {$locksRemoved} removed");
        }
    }
    
    private function getSetting()
    {
        if (!$this->settingCache) {
            $this->settingCache = FortuneSetting::first();
        }
        
        return $this->settingCache;
    }
    
   private function displayStatistics($duration)
    {
        // Only show full statistics if winners were found
        if ($this->stats['winners_found'] > 0) {
            $this->info('✅====================================');
            $this->info('✅ সমস্যা সমাধান সম্পন্ন হয়েছে!');
            $this->info('✅====================================');
            
            $this->table(
                ['📊 পরিসংখ্যান', '🔢 সংখ্যা'],
                [
                    ['🎲 Trays with winner set (result_status: 0 → 1)', $this->stats['trays_no_winner']],
                    ['🔄 Incomplete trays processed', $this->stats['trays_incomplete']],
                    ['🔍 Completed trays with unprocessed pots', $this->stats['trays_with_unprocessed_pots']],
                    ['📝 Completed trays checked for payouts', $this->stats['trays_completed_checked']],
                    ['💰 Unprocessed pots fixed', $this->stats['unprocessed_pots_fixed']],
                    ['💵 Wrong payouts fixed', $this->stats['payouts_fixed']],
                    ['🎮 Total pots processed', $this->stats['pots_processed']],
                    ['🏆 Winners found', $this->stats['winners_found']],
                    ['😞 Losers marked', $this->stats['losers_marked']],
                    ['💵 Total amount paid', $this->stats['amount_paid'] . ' TK'],
                    ['🔒 User locks created', $this->stats['locks_created']],
                    ['🔓 User locks removed', $this->stats['locks_removed']],
                    ['⚠️ Errors encountered', $this->stats['errors']],
                    ['⏱️ Time taken', $duration . ' seconds'],
                    ['🎭 Mode', $this->isDryRun ? 'DRY RUN' : 'LIVE'],
                ]
            );
            
            if ($this->isDryRun) {
                $this->warn('⚠️  DRY RUN MODE - No actual changes were made');
            }
            
            // Only show unprocessed pots summary if winners were found
            if ($this->stats['winners_found'] > 0) {
                $this->info('✅ Unprocessed pots summary:');
                $this->line("    - Fixed {$this->stats['unprocessed_pots_fixed']} unprocessed pots");
                $this->line("    - Paid {$this->stats['amount_paid']} TK to winners");
                $this->line("    - Marked " . ($this->stats['unprocessed_pots_fixed'] - $this->stats['winners_found']) . " pots as lost");
            }
            
            $this->info('✅ গেমের সমস্যা সমাধান সম্পন্ন হয়েছে!');
        } else {
            // Log nothing when no winners found (only show in log file if needed)
          
        }
    }
}