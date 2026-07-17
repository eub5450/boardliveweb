<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\PortalRecharge;
use App\Models\PortalTransfer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProtalController extends Controller
{
    public function profile()
    {
        $id = Auth::id();
        $countryId = (int) Auth::user()->country_id;

        $data['protal_recharge'] = PortalRecharge::where('user_id', $id)
            ->where('master_protal_id', $id)
            ->where('is_recall', 0)
            ->sum('amount');

        $data['protal_transfer'] = PortalRecharge::where('recharge_by', $id)->sum('amount');
        $data['protal_recharge_details'] = PortalRecharge::where('user_id', $id)
            ->where('master_protal_id', $id)
            ->where('is_recall', 0)
            ->orderBy('id', 'desc')
            ->get();

        $data['protal_transfer_details'] = PortalRecharge::where('recharge_by', $id)
            ->orderBy('id', 'desc')
            ->get();

        $data['protal_users'] = User::where('status', 1)
            ->where('is_coin_protal_active', 1)
            ->where('country_id', $countryId)
            ->where('id', '!=', $id)
            ->get();

        return view('author.protal.index')->with($data);
    }

    public function TransferStore(Request $request)
    {
        $request->validate([
            'protal_id' => 'required',
            'deposit' => 'required|numeric|min:1',
        ]);

        $id = Auth::id();
        $countryId = (int) Auth::user()->country_id;
        $targetPortal = User::where('id', $request->protal_id)
            ->where('status', 1)
            ->where('is_coin_protal_active', 1)
            ->where('country_id', $countryId)
            ->first();

        if (!$targetPortal) {
            return Redirect()->back()->with([
                'messege' => 'Portal user not found for this country',
                'alert-type' => 'error',
            ]);
        }

        $protalRecharge = PortalRecharge::where('user_id', $id)
            ->where('master_protal_id', $id)
            ->where('is_recall', 0)
            ->sum('amount');

        $protalTransfer = PortalRecharge::where('recharge_by', $id)->sum('amount');
        $balance = $protalRecharge - $protalTransfer;

        if ($balance < $request->deposit) {
            return Redirect()->back()->with([
                'messege' => 'Please check your balance',
                'alert-type' => 'error',
            ]);
        }

        $deposit = new PortalRecharge;
        $deposit->user_id = $targetPortal->id;
        $deposit->trxid = 'mp-' . rand(2586, 589898);
        $deposit->amount = $request->deposit;
        $deposit->date = date('Y-m-d');
        $deposit->recharge_by = $id;
        $deposit->status = 'Approved';
        $deposit->save();

        return Redirect()->back()->with([
            'messege' => 'Portal deposit successful',
            'alert-type' => 'success',
        ]);
    }

    public function Index()
    {
        $id = Auth::id();
        $countryId = (int) Auth::user()->country_id;

        $data = User::where('status', 1)
            ->where('is_coin_protal_active', 1)
            ->where('country_id', $countryId)
            ->where('id', '!=', $id)
            ->get();

        return view('author.protal.manage', compact('data'));
    }

    public function RecallCreate()
    {
        $countryId = (int) Auth::user()->country_id;
        $users = User::where('country_id', $countryId)->where('status', 1)->orderBy('id')->get(['id', 'name', 'balance']);
        $protals = User::where('country_id', $countryId)->where('is_coin_protal_active', 1)->where('status', 1)->orderBy('id')->get(['id', 'name']);

        return view('author.protal.recall_create', compact('users', 'protals'));
    }

    public function RecallStore(Request $request)
    {
        $request->validate([
            'user_id' => 'required|numeric',
            'amount' => 'required|numeric|min:1',
            'protal_id' => 'required|numeric',
        ]);

        $countryId = (int) Auth::user()->country_id;
        $user = User::where('id', $request->user_id)->where('country_id', $countryId)->first();
        $portal = User::where('id', $request->protal_id)
            ->where('country_id', $countryId)
            ->where('is_coin_protal_active', 1)
            ->first();

        if (!$user || !$portal) {
            return Redirect()->back()->with([
                'messege' => 'User or portal not found for this country',
                'alert-type' => 'error',
            ]);
        }

        if ($user->balance < $request->amount) {
            return Redirect()->back()->with([
                'messege' => 'User balance is not enough',
                'alert-type' => 'warning',
            ]);
        }

        DB::transaction(function () use ($user, $portal, $request) {
            $user->balance -= $request->amount;
            $user->save();

            $deposit = new PortalRecharge;
            $deposit->user_id = $portal->id;
            $deposit->trxid = 'recall-' . rand(2586, 589898);
            $deposit->amount = $request->amount;
            $deposit->date = date('Y-m-d');
            $deposit->recharge_by = Auth::id();
            $deposit->status = 'Approved';
            $deposit->is_recall = 1;
            $deposit->save();
        });

        return Redirect()->route('country.author.protal-recall-list')->with([
            'messege' => 'Location recall successful',
            'alert-type' => 'success',
        ]);
    }

    public function RecallIndex()
    {
        $countryId = (int) Auth::user()->country_id;
        $data = PortalRecharge::join('users', 'users.id', '=', 'portal_recharges.user_id')
            ->where('portal_recharges.is_recall', 1)
            ->where('users.country_id', $countryId)
            ->orderBy('portal_recharges.id', 'desc')
            ->select('portal_recharges.*', 'users.name as portal_name')
            ->get();

        return view('author.protal.recall_index', compact('data'));
    }
}
