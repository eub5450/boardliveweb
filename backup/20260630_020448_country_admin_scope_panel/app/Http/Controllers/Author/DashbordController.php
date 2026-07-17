<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashbordController extends Controller
{
    public function Home()
    {
        $admin = Auth::user();
        $countryId = (int) $admin->country_id;
        $country = DB::table('countries')->where('id', $countryId)->first();

        $dashboard = [
            'country_id' => $countryId,
            'country_name' => $country ? ucfirst($country->name) : 'Country '.$countryId,
            'admin_name' => $admin->name,
            'admin_email' => $admin->email,
            'total_users' => User::where('country_id', $countryId)->count(),
            'active_users' => User::where('country_id', $countryId)->where('status', 1)->count(),
            'blocked_users' => User::where('country_id', $countryId)->where('status', '!=', 1)->count(),
            'active_hosts' => User::where('country_id', $countryId)->where('is_host_id', 1)->where('status', 1)->count(),
            'pending_hosts' => User::where('country_id', $countryId)->where('is_host_id', 2)->where('status', 1)->count(),
            'agencies' => DB::table('agencies')->where('country_id', $countryId)->count(),
            'active_agencies' => DB::table('agencies')->where('country_id', $countryId)->where('status', 1)->count(),
            'pending_agencies' => DB::table('agencies')->where('country_id', $countryId)->where(function ($query) {
                $query->whereNull('status')->orWhere('status', '!=', 1);
            })->count(),
            'live_rooms' => DB::table('user_lives')
                ->join('users', 'users.id', '=', 'user_lives.user_id')
                ->where('users.country_id', $countryId)
                ->count(),
            'total_balance' => User::where('country_id', $countryId)->sum('balance'),
            'hold_balance' => User::where('country_id', $countryId)->sum('hold_balance'),
            'portal_recharge' => DB::table('portal_recharges')
                ->join('users', 'users.id', '=', 'portal_recharges.user_id')
                ->where('users.country_id', $countryId)
                ->where('portal_recharges.is_recall', 0)
                ->sum('portal_recharges.amount'),
            'portal_recall' => DB::table('portal_recharges')
                ->join('users', 'users.id', '=', 'portal_recharges.user_id')
                ->where('users.country_id', $countryId)
                ->where('portal_recharges.is_recall', 1)
                ->sum('portal_recharges.amount'),
            'portal_transfer' => DB::table('portal_transfers')
                ->join('users', 'users.id', '=', 'portal_transfers.portal_user_id')
                ->where('users.country_id', $countryId)
                ->sum('portal_transfers.amount'),
            'gift_sent_value' => DB::table('gifts')
                ->join('users', 'users.id', '=', 'gifts.sander_id')
                ->where('users.country_id', $countryId)
                ->sum('gifts.value'),
            'gift_received_value' => DB::table('gifts')
                ->join('users', 'users.id', '=', 'gifts.reciever_id')
                ->where('users.country_id', $countryId)
                ->sum('gifts.value'),
        ];

        $recentUsers = User::where('country_id', $countryId)
            ->orderBy('id', 'desc')
            ->limit(8)
            ->get(['id', 'name', 'email', 'phone', 'balance', 'is_host_id', 'is_agency', 'status', 'created_at']);

        $topHosts = User::where('country_id', $countryId)
            ->where('is_host_id', 1)
            ->orderBy('total_recived_gifts', 'desc')
            ->limit(5)
            ->get(['id', 'name', 'phone', 'total_recived_gifts', 'balance', 'status']);

        return view('author.home', compact('dashboard', 'recentUsers', 'topHosts'));
    }
}