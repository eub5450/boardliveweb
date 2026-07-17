<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BdGameFinalCompactDatabaseCommand extends Command
{
    protected $signature = 'bdgamefinal:compact-db
        {--hours=24 : Prune no-bet settled or finished rounds older than this many hours}
        {--keep-per-game=10 : Always keep this many latest rounds per game}
        {--history-hours=6 : Prune detailed played-round history older than this many hours; use 0 to fall back to history-days}
        {--history-days=0 : Prune detailed played-round history older than this many days; use 0 to disable}
        {--target-mb=5 : Best-effort max size for compactable GameFinal tables; use 0 to disable size-pressure pruning}
        {--token-hours=24 : Prune expired or revoked tokens older than this many hours}
        {--heartbeat-hours=2 : Prune inactive heartbeat rows older than this many hours}
        {--audit-hours=6 : Prune stale non-admin audit rows without round history older than this many hours}
        {--chunk=500 : Delete no-bet rounds in this chunk size}
        {--dry-run : Show candidates without deleting}
        {--force : Delete without confirmation}
        {--no-optimize : Skip OPTIMIZE TABLE after pruning}';

    protected $description = 'Compact GameFinal database tables by pruning old runtime rows, expired tokens, stale heartbeats, and oversized played history.';

    public function handle()
    {
        $hours = max(1, (int) $this->option('hours'));
        $keepPerGame = max(3, (int) $this->option('keep-per-game'));
        $historyHours = max(0, (int) $this->option('history-hours'));
        $historyDays = max(0, (int) $this->option('history-days'));
        $targetMb = max(0.0, (float) $this->option('target-mb'));
        $tokenHours = max(1, (int) $this->option('token-hours'));
        $heartbeatHours = max(1, (int) $this->option('heartbeat-hours'));
        $auditHours = max(1, (int) $this->option('audit-hours'));
        $chunkSize = max(100, (int) $this->option('chunk'));
        $dryRun = (bool) $this->option('dry-run');
        $force = (bool) $this->option('force');

        $tables = (array) config('bd_game_final.tables', []);
        $roundsTable = $tables['rounds'] ?? 'bd_game_final_rounds';
        $betsTable = $tables['bets'] ?? 'bd_game_final_bets';
        $tokensTable = $tables['tokens'] ?? 'bd_game_final_tokens';
        $heartbeatsTable = $tables['heartbeats'] ?? 'bd_game_final_heartbeats';
        $auditLogsTable = $tables['audit_logs'] ?? 'bd_game_final_audit_logs';

        foreach ([$roundsTable, $betsTable] as $requiredTable) {
            if (!Schema::hasTable($requiredTable)) {
                $this->error('Missing required table: ' . $requiredTable);
                return self::FAILURE;
            }
        }

        $cutoff = Carbon::now()->subHours($hours);
        $tokenCutoff = Carbon::now()->subHours($tokenHours);
        $heartbeatCutoff = Carbon::now()->subHours($heartbeatHours);
        $auditCutoff = Carbon::now()->subHours($auditHours);
        $historyCutoff = $historyHours > 0
            ? Carbon::now()->subHours($historyHours)
            : ($historyDays > 0 ? Carbon::now()->subDays($historyDays) : null);
        $historyLabel = $historyCutoff
            ? ($historyHours > 0 ? ($historyHours . 'h') : ($historyDays . 'd'))
            : 'disabled';
        $protectedRoundIds = $this->latestRoundIdsPerGame($roundsTable, $keepPerGame);
        $roundQuery = $this->noBetRoundQuery($roundsTable, $betsTable, $cutoff, $protectedRoundIds);
        $playedRoundQuery = $historyCutoff
            ? $this->playedRoundQuery($roundsTable, $betsTable, $historyCutoff, $protectedRoundIds)
            : null;
        $candidateRounds = (clone $roundQuery)->count();
        $candidatePlayedRounds = $playedRoundQuery ? (clone $playedRoundQuery)->count() : 0;
        $candidatePlayedBets = $playedRoundQuery ? $this->relatedRowCount($betsTable, 'game_round_id', $playedRoundQuery) : 0;
        $candidateTokens = $this->expiredTokenQuery($tokensTable, $tokenCutoff)->count();
        $candidateHeartbeats = $this->staleHeartbeatQuery($heartbeatsTable, $heartbeatCutoff)->count();
        $candidateAuditLogs = $this->staleAuditLogQuery($auditLogsTable, $auditCutoff)->count();
        $sizeBefore = $this->tableSizes($this->compactTables($tables));
        $sizeBeforeMb = $this->totalMb($sizeBefore);
        $sizePressureActive = $targetMb > 0 && $sizeBeforeMb > $targetMb;
        $sizePressureQuery = $sizePressureActive
            ? $this->settledRoundQuery($roundsTable, Carbon::now(), $protectedRoundIds)
            : null;
        $candidatePressureRounds = $sizePressureQuery ? (clone $sizePressureQuery)->count() : 0;
        $candidatePressureBets = $sizePressureQuery ? $this->relatedRowCount($betsTable, 'game_round_id', $sizePressureQuery) : 0;

        $this->line('GameFinal DB compaction candidates');
        $this->line('No-bet settled/finished rounds older than ' . $hours . 'h: ' . $candidateRounds);
        $this->line('Played detail rounds older than ' . $historyLabel . ': ' . $candidatePlayedRounds . ' rounds / ' . $candidatePlayedBets . ' bets');
        $this->line('Size-pressure target: ' . ($targetMb > 0 ? (number_format($targetMb, 3) . ' MB') : 'disabled'));
        $this->line('Size-pressure eligible rounds: ' . $candidatePressureRounds . ' rounds / ' . $candidatePressureBets . ' bets');
        $this->line('Expired/revoked tokens older than ' . $tokenHours . 'h: ' . $candidateTokens);
        $this->line('Stale heartbeats older than ' . $heartbeatHours . 'h: ' . $candidateHeartbeats);
        $this->line('Stale non-admin audit rows older than ' . $auditHours . 'h: ' . $candidateAuditLogs);
        $this->line('Protected latest rounds per game: ' . $keepPerGame);
        $this->line('Current GameFinal table size: ' . number_format($sizeBeforeMb, 3) . ' MB');

        if (
            $dryRun
            || (
                $candidateRounds === 0
                && $candidatePlayedRounds === 0
                && $candidatePressureRounds === 0
                && $candidateTokens === 0
                && $candidateHeartbeats === 0
                && $candidateAuditLogs === 0
            )
        ) {
            $this->printSizeTable($sizeBefore);
            return self::SUCCESS;
        }

        if (!$force && !$this->confirm('Delete these old runtime/history rows now?')) {
            $this->warn('Compaction cancelled.');
            return self::SUCCESS;
        }

        $deleted = $this->pruneNoBetRounds($roundQuery, $tables, $chunkSize);
        if ($playedRoundQuery) {
            $deleted = $this->mergeDeletedRows($deleted, $this->prunePlayedRounds($playedRoundQuery, $tables, $chunkSize));
        }
        if ($sizePressureQuery) {
            $deleted = $this->mergeDeletedRows($deleted, $this->prunePlayedRounds($sizePressureQuery, $tables, $chunkSize));
        }
        $deleted[$tokensTable] = $this->expiredTokenQuery($tokensTable, $tokenCutoff)->delete();
        $deleted[$heartbeatsTable] = $this->staleHeartbeatQuery($heartbeatsTable, $heartbeatCutoff)->delete();
        $deleted[$auditLogsTable] = (int) ($deleted[$auditLogsTable] ?? 0) + $this->staleAuditLogQuery($auditLogsTable, $auditCutoff)->delete();

        $this->line('Deleted rows:');
        foreach ($deleted as $table => $count) {
            $this->line('  ' . $table . ': ' . $count);
        }

        if (!$this->option('no-optimize')) {
            $this->optimizeTables($this->compactTables($tables));
        }

        $sizeAfter = $this->tableSizes($this->compactTables($tables));
        $this->line('GameFinal table size after compaction: ' . number_format($this->totalMb($sizeAfter), 3) . ' MB');
        $this->line('Approx. reclaimed: ' . number_format(max(0, $this->totalMb($sizeBefore) - $this->totalMb($sizeAfter)), 3) . ' MB');
        $this->printSizeTable($sizeAfter);

        return self::SUCCESS;
    }

    protected function latestRoundIdsPerGame(string $roundsTable, int $keepPerGame): array
    {
        $ids = [];
        $gameIds = DB::table($roundsTable)->distinct()->pluck('game_id');

        foreach ($gameIds as $gameId) {
            $ids = array_merge($ids, DB::table($roundsTable)
                ->where('game_id', $gameId)
                ->orderByDesc('id')
                ->limit($keepPerGame)
                ->pluck('id')
                ->map(fn ($id) => (int) $id)
                ->all());
        }

        return array_values(array_unique($ids));
    }

    protected function noBetRoundQuery(string $roundsTable, string $betsTable, Carbon $cutoff, array $protectedRoundIds)
    {
        return DB::table($roundsTable . ' as rounds')
            ->whereIn('rounds.status', ['settled', 'finished'])
            ->where('rounds.created_at', '<', $cutoff)
            ->when($protectedRoundIds, fn ($query) => $query->whereNotIn('rounds.id', $protectedRoundIds))
            ->whereNotExists(function ($query) use ($betsTable) {
                $query->selectRaw('1')
                    ->from($betsTable . ' as bets')
                    ->whereColumn('bets.game_round_id', 'rounds.id');
            });
    }

    protected function playedRoundQuery(string $roundsTable, string $betsTable, Carbon $cutoff, array $protectedRoundIds)
    {
        return $this->settledRoundQuery($roundsTable, $cutoff, $protectedRoundIds)
            ->whereExists(function ($query) use ($betsTable) {
                $query->selectRaw('1')
                    ->from($betsTable . ' as bets')
                    ->whereColumn('bets.game_round_id', 'rounds.id');
            });
    }

    protected function settledRoundQuery(string $roundsTable, Carbon $cutoff, array $protectedRoundIds)
    {
        return DB::table($roundsTable . ' as rounds')
            ->whereIn('rounds.status', ['settled', 'finished'])
            ->where('rounds.created_at', '<', $cutoff)
            ->when($protectedRoundIds, fn ($query) => $query->whereNotIn('rounds.id', $protectedRoundIds));
    }

    protected function relatedRowCount(string $table, string $roundColumn, $roundQuery): int
    {
        if (!Schema::hasTable($table)) {
            return 0;
        }

        return (int) DB::table($table)
            ->whereIn($roundColumn, (clone $roundQuery)->select('rounds.id'))
            ->count();
    }

    protected function expiredTokenQuery(string $tokensTable, Carbon $tokenCutoff)
    {
        if (!Schema::hasTable($tokensTable)) {
            return DB::query()->whereRaw('1 = 0');
        }

        return DB::table($tokensTable)
            ->where(function ($query) use ($tokenCutoff) {
                $query->where('expires_at', '<', $tokenCutoff)
                    ->orWhere('revoked_at', '<', $tokenCutoff);
            });
    }

    protected function staleHeartbeatQuery(string $heartbeatsTable, Carbon $heartbeatCutoff)
    {
        if (!Schema::hasTable($heartbeatsTable)) {
            return DB::query()->whereRaw('1 = 0');
        }

        return DB::table($heartbeatsTable)
            ->where(function ($query) use ($heartbeatCutoff) {
                $query->whereNull('last_seen_at')
                    ->orWhere('last_seen_at', '<', $heartbeatCutoff);
            });
    }

    protected function staleAuditLogQuery(string $auditLogsTable, Carbon $auditCutoff)
    {
        if (!Schema::hasTable($auditLogsTable)) {
            return DB::query()->whereRaw('1 = 0');
        }

        return DB::table($auditLogsTable)
            ->where('created_at', '<', $auditCutoff)
            ->where(function ($query) {
                $query->whereNull('event_type')
                    ->orWhere('event_type', 'not like', 'admin\_%');
            })
            ->where(function ($query) {
                $query->whereNull('game_round_id')
                    ->orWhere('event_type', 'client_security_report');
            });
    }

    protected function pruneNoBetRounds($roundQuery, array $tables, int $chunkSize): array
    {
        $roundsTable = $tables['rounds'] ?? 'bd_game_final_rounds';
        $childTables = [
            $tables['bet_summaries'] ?? 'bd_game_final_bet_summaries' => 'game_round_id',
            $tables['settlement_items'] ?? 'bd_game_final_settlement_items' => 'game_round_id',
            $tables['audit_logs'] ?? 'bd_game_final_audit_logs' => 'game_round_id',
            $tables['settlements'] ?? 'bd_game_final_settlements' => 'game_round_id',
            $roundsTable => 'id',
        ];

        $deleted = array_fill_keys(array_keys($childTables), 0);

        while (true) {
            $ids = (clone $roundQuery)
                ->orderBy('rounds.id')
                ->limit($chunkSize)
                ->pluck('rounds.id')
                ->map(fn ($id) => (int) $id)
                ->all();

            if (!$ids) {
                break;
            }

            foreach ($childTables as $table => $column) {
                if (!Schema::hasTable($table)) {
                    continue;
                }

                $deleted[$table] += DB::table($table)->whereIn($column, $ids)->delete();
            }
        }

        return $deleted;
    }

    protected function prunePlayedRounds($roundQuery, array $tables, int $chunkSize): array
    {
        $roundsTable = $tables['rounds'] ?? 'bd_game_final_rounds';
        $betsTable = $tables['bets'] ?? 'bd_game_final_bets';
        $walletJournalsTable = $tables['wallet_journals'] ?? 'bd_game_final_wallet_journals';
        $settlementItemsTable = $tables['settlement_items'] ?? 'bd_game_final_settlement_items';
        $settlementsTable = $tables['settlements'] ?? 'bd_game_final_settlements';
        $auditLogsTable = $tables['audit_logs'] ?? 'bd_game_final_audit_logs';
        $betSummariesTable = $tables['bet_summaries'] ?? 'bd_game_final_bet_summaries';

        $deleted = array_fill_keys([
            $walletJournalsTable,
            $settlementItemsTable,
            $betsTable,
            $betSummariesTable,
            $auditLogsTable,
            $settlementsTable,
            $roundsTable,
        ], 0);

        while (true) {
            $roundIds = (clone $roundQuery)
                ->orderBy('rounds.id')
                ->limit($chunkSize)
                ->pluck('rounds.id')
                ->map(fn ($id) => (int) $id)
                ->all();

            if (!$roundIds) {
                break;
            }

            $betIds = $this->idsFor($betsTable, 'game_round_id', $roundIds);
            $settlementIds = $this->idsFor($settlementsTable, 'game_round_id', $roundIds);
            $settlementItemIds = $this->idsFor($settlementItemsTable, 'game_round_id', $roundIds);

            if (Schema::hasTable($walletJournalsTable)) {
                $deleted[$walletJournalsTable] += DB::table($walletJournalsTable)
                    ->where(function ($query) {
                        $query->whereNull('reason')
                            ->orWhereNotIn('reason', ['admin_deposit', 'admin_withdraw']);
                    })
                    ->where(function ($query) use ($roundIds, $betIds, $settlementIds, $settlementItemIds) {
                        $query->whereIn('game_round_id', $roundIds);

                        if ($betIds) {
                            $query->orWhereIn('game_bet_id', $betIds);
                        }

                        if ($settlementIds) {
                            $query->orWhereIn('game_settlement_id', $settlementIds);
                        }

                        if ($settlementItemIds) {
                            $query->orWhereIn('game_settlement_item_id', $settlementItemIds);
                        }
                    })
                    ->delete();
            }

            $deleted[$settlementItemsTable] += $this->deleteByRoundIds($settlementItemsTable, 'game_round_id', $roundIds);
            $deleted[$betsTable] += $this->deleteByRoundIds($betsTable, 'game_round_id', $roundIds);
            $deleted[$betSummariesTable] += $this->deleteByRoundIds($betSummariesTable, 'game_round_id', $roundIds);
            $deleted[$auditLogsTable] += $this->deleteByRoundIds($auditLogsTable, 'game_round_id', $roundIds);
            $deleted[$settlementsTable] += $this->deleteByRoundIds($settlementsTable, 'game_round_id', $roundIds);
            $deleted[$roundsTable] += $this->deleteByRoundIds($roundsTable, 'id', $roundIds);
        }

        return $deleted;
    }

    protected function idsFor(string $table, string $column, array $ids): array
    {
        if (!$ids || !Schema::hasTable($table)) {
            return [];
        }

        return DB::table($table)
            ->whereIn($column, $ids)
            ->pluck('id')
            ->map(fn ($id) => (int) $id)
            ->all();
    }

    protected function deleteByRoundIds(string $table, string $column, array $ids): int
    {
        if (!$ids || !Schema::hasTable($table)) {
            return 0;
        }

        return DB::table($table)->whereIn($column, $ids)->delete();
    }

    protected function mergeDeletedRows(array $left, array $right): array
    {
        foreach ($right as $table => $count) {
            $left[$table] = (int) ($left[$table] ?? 0) + (int) $count;
        }

        return $left;
    }

    protected function compactTables(array $tables): array
    {
        return array_values(array_unique(array_filter([
            $tables['rounds'] ?? 'bd_game_final_rounds',
            $tables['bet_summaries'] ?? 'bd_game_final_bet_summaries',
            $tables['settlements'] ?? 'bd_game_final_settlements',
            $tables['settlement_items'] ?? 'bd_game_final_settlement_items',
            $tables['tokens'] ?? 'bd_game_final_tokens',
            $tables['audit_logs'] ?? 'bd_game_final_audit_logs',
            $tables['wallet_journals'] ?? 'bd_game_final_wallet_journals',
            $tables['heartbeats'] ?? 'bd_game_final_heartbeats',
        ])));
    }

    protected function optimizeTables(array $tables): void
    {
        foreach ($tables as $table) {
            if (!Schema::hasTable($table)) {
                continue;
            }

            DB::statement('OPTIMIZE TABLE ' . $this->quoteIdentifier($table));
            $this->line('Optimized ' . $table);
        }
    }

    protected function tableSizes(array $tables): array
    {
        if (!$tables) {
            return [];
        }

        $database = DB::connection()->getDatabaseName();
        $placeholders = implode(',', array_fill(0, count($tables), '?'));

        return DB::select(
            'SELECT table_name, table_rows, ROUND((data_length + index_length) / 1024 / 1024, 3) AS mb
             FROM information_schema.tables
             WHERE table_schema = ? AND table_name IN (' . $placeholders . ')
             ORDER BY (data_length + index_length) DESC',
            array_merge([$database], $tables)
        );
    }

    protected function printSizeTable(array $rows): void
    {
        foreach ($rows as $row) {
            $this->line(str_pad((string) $row->table_name, 38) . ' ' . str_pad((string) $row->table_rows, 10) . ' rows ' . number_format((float) $row->mb, 3) . ' MB');
        }
    }

    protected function totalMb(array $rows): float
    {
        return array_reduce($rows, fn ($total, $row) => $total + (float) $row->mb, 0.0);
    }

    protected function quoteIdentifier(string $identifier): string
    {
        return '`' . str_replace('`', '``', $identifier) . '`';
    }
}
