<?php

namespace App\Http\Controllers\Api\V4;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\PortalRecharge;
use App\Models\PortalTransfer;
use App\Models\VipList;
use App\Models\User;
use App\Models\Notification;
use Carbon\Carbon;
use App\Models\PortalRecall;
use App\Models\ProtalToPTransfer;
use App\Models\Setting;
use App\Services\PortalService;
use App\Services\VipService;

class PortalController extends Controller
{
    private $ACCESS_TOKEN = "0411f0028cfb768b3a3d96ac3aa37dw3e5";

    private function portalMinTransferAmount(): int
    {
        $setting = Setting::find(1);
        $value = (int) data_get($setting, 'portal_min_transfer_amount', 50000);

        return $value > 0 ? $value : 50000;
    }

    // ---------------------------------------------------------
    // ⚡ FAST INDEX API
    // ---------------------------------------------------------
    public function Index(Request $request)
    {
        if ($request->access_token !== $this->ACCESS_TOKEN) {
            return response()->json(['message' => 'Unauthorized', 'code' => 401]);
        }

        if ($request->user_id != auth()->id()) {
            return response()->json(['message' => 'Login User And Send User ID Not Same', 'code' => 401]);
        }

        $user_id = $request->user_id;

        // FAST BALANCE USING SERVICE
        $balance = PortalService::balance($user_id);

        return response()->json([
            'message' => 'Data Found!',
            'code' => 200,
            'balance' => $balance,

            'recharge_list' =>
                PortalRecharge::where('user_id', $user_id)
                    ->where('status', 'Approved')
                    ->latest()->limit(20)->get(),

            'transfer_list' =>
                PortalTransfer::where('portal_user_id', $user_id)
                    ->latest()->limit(20)->get(),

            'protal_list' =>
                ProtalToPTransfer::where('user_id', $user_id)
                    ->latest()->limit(20)->get(),

            'protal_transfer_received_list' =>
                ProtalToPTransfer::where('portal_user_id', $user_id)
                    ->latest()->limit(20)->get(),
        ]);
    }



    // ---------------------------------------------------------
    // ⚡ FAST TRANSFER API
    // ---------------------------------------------------------
    public function Transfer(Request $request)
    {
        if ($request->access_token !== $this->ACCESS_TOKEN) {
            return response()->json(['message' => 'Unauthorized', 'code' => 401]);
        }

        if ($request->user_id != auth()->id()) {
            return response()->json(['message' => 'User ID mismatch', 'code' => 401]);
        }

        $sender_id = $request->user_id;
        $receiver_id = $request->transfer_member_id;
        $amount = $request->amount;

        // FAST BALANCE SERVICE
        $balance = PortalService::balance($sender_id);

        if ($balance < $amount) {
            return response()->json(['message' => 'Insufficient Balance', 'code' => 401]);
        }

        $minimumAmount = $this->portalMinTransferAmount();

        if ($amount < $minimumAmount) {
            return response()->json([
                'message' => 'Minimum Transfer Amount ' . $minimumAmount,
                'code' => 401
            ]);
        }

        $receiver = User::find($receiver_id);

        if (!$receiver) {
            return response()->json(['message' => 'Receiver Not Found', 'code' => 401]);
        }

        // CREATE TRANSFER
        PortalTransfer::create([
            'portal_user_id' => $sender_id,
            'user_id'        => $receiver->id,
            'amount'         => $amount,
            'trxid'          => uniqid('recharge_'),
            'date'           => now()->toDateString(),
        ]);

        // FAST BALANCE INCREMENT
        $receiver->increment('balance', $amount);

        // VIP SERVICE → Handles all VIP logic
        VipService::updateVip($receiver, $amount);

        // CREATE NOTIFICATION
        Notification::create([
            'user_id' => $receiver->id,
            'date'    => now()->toDateString(),
            'message' => "{$amount} Point Recharge Successfully From BD Point Reseller"
        ]);

        return response()->json(['message' => 'Transfer Successful!', 'code' => 200]);
    }



    // ---------------------------------------------------------
    // ⚡ PORTAL → PORTAL TRANSFER API
    // ---------------------------------------------------------
    public function ProtalTransfer(Request $request)
    {
        if ($request->access_token !== $this->ACCESS_TOKEN) {
            return response()->json(['message' => 'Unauthorized', 'code' => 401]);
        }

        if ($request->user_id != auth()->id()) {
            return response()->json(['message' => 'User ID mismatch', 'code' => 401]);
        }

        $sender_id = $request->user_id;
        $amount = $request->amount;
        $receiver_id = $request->transfer_member_id;

        // VALID AMOUNTS (5 Lakh → 1 Crore)
        $valid_targets = range(500000, 10000000, 100000);

        if (!in_array($amount, $valid_targets)) {
            return response()->json(['message' => 'Min Amount 5 Lakh', 'code' => 401]);
        }

        // FAST BALANCE SERVICE
        $balance = PortalService::balance($sender_id);

        if ($balance < $amount) {
            return response()->json(['message' => 'Balance Not Available', 'code' => 401]);
        }

        $receiver = User::find($receiver_id);

        if (!$receiver) {
            return response()->json(['message' => 'ID Not Found', 'code' => 401]);
        }

        if ($receiver->is_coin_protal_active != 1) {
            return response()->json(['message' => 'User Portal Not Active', 'code' => 401]);
        }

        // RECORD PORTAL TO PORTAL TRANSFER
        ProtalToPTransfer::create([
            'user_id'        => $sender_id,
            'portal_user_id' => $receiver->id,
            'amount'         => $amount,
            'trxid'          => uniqid('protal_to_protal_'),
            'date'           => now()->toDateString(),
        ]);

        return response()->json(['message' => 'Portal Balance Transfer Successful', 'code' => 200]);
    }

    public function RechargeHistory(Request $request)
    {
        if ($request->access_token !== $this->ACCESS_TOKEN) {
            return response()->json([[
                'message' => 'Unauthorized',
                'code' => '401',
            ]], 401, [], JSON_UNESCAPED_UNICODE);
        }

        if ($request->user_id != auth()->id()) {
            return response()->json([[
                'message' => 'User ID mismatch',
                'code' => '401',
            ]], 401, [], JSON_UNESCAPED_UNICODE);
        }

        $records = PortalRecharge::where('user_id', $request->user_id)
            ->orderBy('id', 'desc')
            ->limit(50)
            ->get()
            ->map(function ($record) {
                $status = strtolower((string) $record->status);
                $approved = $status === 'approved' || $status === 'success' || $status === '1';

                return [
                    'amount' => strval($record->amount ?? 0),
                    'coins' => strval($record->coins ?? $record->amount ?? 0),
                    'date' => strval($record->date ?? $record->created_at ?? ''),
                    'status' => $approved ? 1 : 0,
                ];
            })
            ->values();

        return response()->json($records, 200, [], JSON_UNESCAPED_UNICODE);
    }
}
