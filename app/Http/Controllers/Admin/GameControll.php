<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FuritsPotsBackup;
use App\Models\GameBalanceWithdraw;
use App\Models\Battle\Fortune\FortuneSetting;
use App\Models\Game\Fivestar\FivestarSetting;
use App\Models\Battle\Fortune\FortuneTray;
use App\Models\Battle\Fortune\FortunePots;
use App\Models\Game\Grady\GradySetting;
use App\Models\LuckyGiftSetting;
use App\Models\FruitsGamePattan;
use App\Models\Battle\TeenPattiSetting;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Kreait\Firebase\Contract\Database;
use App\Models\Battle\TeenPattiTray;
use App\Models\Battle\TeenPattiPots;
use App\Models\Game\Grady\GradyTray;
use DB;
use App\Models\Game\Grady\GradyPots;
class GameControll extends Controller
{
    
    public function __construct(Database $database)
    {
        $this->database = $database;
    }
    public function Index(Request $request)
    {
        $game=FortuneSetting::find(1);
        if($request->type=='withdraw'){
         $game->game_balance-=$request->amount;
        }else{
         $game->game_balance+=$request->amount;
        }
        $game->save();
        $data=new GameBalanceWithdraw;
        $data->game_name='friuts';
        $data->amount=$request->amount;
        $data->type=$request->type;
        $data->date=date('Y-m-d');
        $data->save();
        $notification=array(
                'messege'=>'Game Balance Withdraw Success!!',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
    }
    public function TeenPattiIndex(Request $request)
    {
        $game=TeenPattiSetting::find(1);
        if($request->type=='withdraw'){
         $game->game_balance-=$request->amount;
        }else{
         $game->game_balance+=$request->amount;
        }
        $game->save();
        $data=new GameBalanceWithdraw;
        $data->game_name='TeenPatti';
        $data->amount=$request->amount;
        $data->type=$request->type;
        $data->date=date('Y-m-d');
        $data->save();
        $notification=array(
                'messege'=>'Game Balance Withdraw Success!!',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
    }public function TeenPattiSecIndex(Request $request)
    {
        $game=TeenPattiSetting::find(1);
        if($request->type=='withdraw'){
         $game->second_balance-=$request->amount;
        }else{
         $game->second_balance+=$request->amount;
        }
        $game->save();
        $data=new GameBalanceWithdraw;
        $data->game_name='TeenPatti';
        $data->amount=$request->amount;
        $data->type=$request->type;
        $data->date=date('Y-m-d');
        $data->save();
        $notification=array(
                'messege'=>'Game Balance Withdraw Success!!',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
    }public function TeenPattithirdIndex(Request $request)
    {
        $game=TeenPattiSetting::find(1);
        if($request->type=='withdraw'){
         $game->third_balance-=$request->amount;
        }else{
         $game->third_balance+=$request->amount;
        }
        $game->save();
        $data=new GameBalanceWithdraw;
        $data->game_name='TeenPatti';
        $data->amount=$request->amount;
        $data->type=$request->type;
        $data->date=date('Y-m-d');
        $data->save();
        $notification=array(
                'messege'=>'Game Balance Withdraw Success!!',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
    }
    public function FiveIndex(Request $request)
    {
        $game=FivestarSetting::find(1);
        if($request->type=='withdraw'){
         $game->game_balance-=$request->amount;
        }else{
         $game->game_balance+=$request->amount;
        }
        $game->save();
        $data=new GameBalanceWithdraw;
        $data->game_name='Five';
        $data->amount=$request->amount;
        $data->type=$request->type;
        $data->date=date('Y-m-d');
        $data->save();
        $notification=array(
                'messege'=>'Game Balance Withdraw Success!!',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
    }
    public function GreedyIndex(Request $request)
    {
        $game=GradySetting::find(1);
        if($request->type=='withdraw'){
         $game->game_balance-=$request->amount;
        }else{
         $game->game_balance+=$request->amount;
        }
        $game->save();
        $data=new GameBalanceWithdraw;
        $data->game_name='Greedy';
        $data->amount=$request->amount;
        $data->type=$request->type;
        $data->date=date('Y-m-d');
        $data->save();
        $notification=array(
                'messege'=>'Game Balance Withdraw Success!!',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
    }
    public function LuckyIndex(Request $request)
    {
        $game=LuckyGiftSetting::find(1);
        if($request->type=='withdraw'){
         $game->balance-=$request->amount;
        }else{
         $game->balance+=$request->amount;
        }
        $game->save();
        $data=new GameBalanceWithdraw;
        $data->game_name='Lucky';
        $data->amount=$request->amount;
        $data->type=$request->type;
        $data->date=date('Y-m-d');
        $data->save();
        $notification=array(
                'messege'=>'Game Balance Withdraw Success!!',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
    }
    public function GreedySecIndex(Request $request)
    {
        $game=GradySetting::find(1);
        if($request->type=='withdraw'){
         $game->second_balance-=$request->amount;
        }else{
         $game->second_balance+=$request->amount;
        }
        $game->save();
        $data=new GameBalanceWithdraw;
        $data->game_name='Greedy';
        $data->amount=$request->amount;
        $data->type=$request->type;
        $data->date=date('Y-m-d');
        $data->save();
        $notification=array(
                'messege'=>'Game Balance Withdraw Success!!',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
    }
    public function GreedythirdIndex(Request $request)
    {
        $game=GradySetting::find(1);
        if($request->type=='withdraw'){
         $game->third_balance-=$request->amount;
        }else{
         $game->third_balance+=$request->amount;
        }
        $game->save();
        $data=new GameBalanceWithdraw;
        $data->game_name='Greedy';
        $data->amount=$request->amount;
        $data->type=$request->type;
        $data->date=date('Y-m-d');
        $data->save();
        $notification=array(
                'messege'=>'Game Balance Withdraw Success!!',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
    }
    public function FruitsSecIndex(Request $request)
    {
        
        $game=FortuneSetting::find(1);
        if($request->type=='withdraw'){
         $game->second_balance-=$request->amount;
        }else{
         $game->second_balance+=$request->amount;
        }
        $game->save();
        $data=new GameBalanceWithdraw;
        $data->game_name='friuts';
        $data->amount=$request->amount;
        $data->type=$request->type;
        $data->date=date('Y-m-d');
        $data->save();
        $notification=array(
                'messege'=>'Game Balance Withdraw Success!!',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
    }
    public function FruitsthirdIndex(Request $request)
    {
        
        $game=FortuneSetting::find(1);
        if($request->type=='withdraw'){
         $game->third_balance-=$request->amount;
        }else{
         $game->third_balance+=$request->amount;
        }
        $game->save();
        $data=new GameBalanceWithdraw;
        $data->game_name='friuts';
        $data->amount=$request->amount;
        $data->type=$request->type;
        $data->date=date('Y-m-d');
        $data->save();
        $notification=array(
                'messege'=>'Game Balance Withdraw Success!!',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
    }
    // =========================
    // Clean up old game records
    // =========================
    public function FruitsClear()
    {
        DB::transaction(function () {
            $this->cleanupFortuneGame();
            $this->cleanupGradyGame();
            $this->cleanupTeenPattiGame();
           // $this->updateGamePattern();
        });

        return redirect()->back()->with([
            'messege' => 'Cleanup Completed Successfully!!',
            'alert-type' => 'success'
        ]);
    }

    private function cleanupFortuneGame()
    {
        $totalRecords = FortuneTray::count();
        $recordsToDelete = $totalRecords - 50;

        if ($recordsToDelete > 0) {
            $trays = FortuneTray::orderBy('created_at')->limit($recordsToDelete)->get();
            foreach ($trays as $tray) {
                $pots = FortunePots::where('tray_id', $tray->tray_id)->get();
                foreach ($pots as $pot) {
                    FuritsPotsBackup::create([
                        'tray_id' => $pot->tray_id,
                        'user_id' => $pot->user_id,
                        'amount' => $pot->amount,
                        'pot_no' => $pot->pot_no,
                        'status' => $pot->status,
                        'serve_balance' => $pot->serve_balance,
                        'date' => $pot->created_at,
                        'game_name' => 'friuts'
                    ]);
                    $pot->delete();
                }
                $tray->delete();
            }
        }
    }

    private function cleanupGradyGame()
    {
        $totalRecords = GradyTray::count();
        $recordsToDelete = $totalRecords - 50;

        if ($recordsToDelete > 0) {
            $trays = GradyTray::orderBy('created_at')->limit($recordsToDelete)->get();
            foreach ($trays as $tray) {
                $pots = GradyPots::where('tray_id', $tray->tray_id)->get();
                foreach ($pots as $pot) {
                    FuritsPotsBackup::create([
                        'tray_id' => $pot->tray_id,
                        'user_id' => $pot->user_id,
                        'amount' => $pot->amount,
                        'pot_no' => $pot->pot_no,
                        'status' => $pot->status,
                        'serve_balance' => $pot->win_balance,
                        'date' => $pot->created_at,
                        'game_name' => 'greedy'
                    ]);
                    $pot->delete();
                }
                $tray->delete();
            }
        }
    }

    private function cleanupTeenPattiGame()
    {
        $totalRecords = TeenPattiTray::count();
        $recordsToDelete = $totalRecords - 50;

        if ($recordsToDelete > 0) {
            $trays = TeenPattiTray::orderBy('created_at')->limit($recordsToDelete)->get();
            foreach ($trays as $tray) {
                $pots = TeenPattiPots::where('tray_id', $tray->tray_id)->get();
                foreach ($pots as $pot) {
                    FuritsPotsBackup::create([
                        'tray_id' => $pot->tray_id,
                        'user_id' => $pot->user_id,
                        'amount' => $pot->amount,
                        'pot_no' => $pot->pot_no,
                        'status' => $pot->status,
                        'serve_balance' => $pot->serve_balance,
                        'date' => $pot->created_at,
                        'game_name' => 'TeenPatti'
                    ]);
                    $pot->delete();
                }
                $tray->delete();
            }
        }
    }

    public function reverseAndSaveData()
    {
        // Fetch all entries from the FruitsGamePattan model
    $fruitsGamePattan = FruitsGamePattan::orderBy('id')->get();

    // Step 1: Assign temporary unique IDs
    $tempIdOffset = 10000; // Ensure this is larger than any existing ID
    foreach ($fruitsGamePattan as $fruit) {
        $fruit->update(['id' => $fruit->id + $tempIdOffset]);
    }

    // Step 2: Fetch the updated entries and reverse them
    $reversedFruitsGamePattan = FruitsGamePattan::orderBy('id')->get()->reverse()->values();

    // Step 3: Reassign the correct IDs in reverse order
    foreach ($reversedFruitsGamePattan as $index => $fruit) {
        $fruit->update(['id' => $index + 1]);
    }
        $notification=array(
                'messege'=>'Pattern Revarse Successfull!!',
                'alert-type'=>'success'
            );
            return Redirect()->back()->with($notification);
    }
}
