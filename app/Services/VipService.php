<?php

namespace App\Services;

use App\Models\VipList;
use Carbon\Carbon;

class VipService
{
    public static function updateVip($user, $amount)
    {
        $vipLevels = [
            1000000  => 1,
            2000000  => 2,
            3000000  => 3,
            4000000  => 4,
            6000000  => 5,
            8000000  => 6,
            10000000 => 7,
        ];

        foreach ($vipLevels as $threshold => $vipNo) {

            if ($amount >= $threshold) {

                $user->is_vip = $vipNo;
                $user->vip_timeline = Carbon::now()->addDays(15);

                VipList::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'vip_no'  => $vipNo,
                    ],
                    [
                        'active_date' => now(),
                        'end_date'    => now()->addDays(15),
                        'is_active'   => 1,
                        'image'       => "store/vip/{$vipNo}.png"
                    ]
                );
            }
        }

        $user->save();
    }
}
