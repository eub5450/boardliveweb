<?php

namespace App\Services;

use App\Models\PortalRecharge;
use App\Models\PortalTransfer;
use App\Models\PortalRecall;
use App\Models\ProtalToPTransfer;

class PortalService
{
    public static function balance($user_id)
    {
        return cache()->remember("balance_$user_id", 1, function () use ($user_id) {

            $recharge = PortalRecharge::where('user_id', $user_id)
                ->where('status', 'Approved')->sum('amount');

            $transfer = PortalTransfer::where('portal_user_id', $user_id)->sum('amount');
            $recall = PortalRecall::where('protal_id', $user_id)->sum('amount');

            $sent = ProtalToPTransfer::where('user_id', $user_id)->sum('amount');
            $received = ProtalToPTransfer::where('portal_user_id', $user_id)->sum('amount');

            return ($recharge + $received) - ($transfer + $recall + $sent);
        });
    }
}
