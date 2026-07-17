<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminParmisiton;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SubAdminController extends Controller
{
    public function Index(Request $request)
    {
        $this->authorizeOwner();

        $query = trim((string) $request->get('q', ''));
        $permissionUserIds = AdminParmisiton::query()->select('user_id');

        $users = User::query()
            ->where(function ($builder) use ($permissionUserIds) {
                $builder->whereIn('is_admin', [1, 2])
                    ->orWhereIn('id', $permissionUserIds);
            })
            ->when($query !== '', function ($builder) use ($query) {
                $builder->where(function ($search) use ($query) {
                    $search->where('id', $query)
                        ->orWhere('email', 'like', '%'.$query.'%')
                        ->orWhere('name', 'like', '%'.$query.'%');
                });
            })
            ->orderBy('is_admin', 'desc')
            ->orderBy('id', 'asc')
            ->limit(200)
            ->get();

        $adminModes = $this->adminModes();
        $permissionGroups = AdminParmisiton::groupedDefinitions();
        $userPermissions = AdminParmisiton::matrixForUsers($users->pluck('id'));

        return view('backend.setting.subadmin', compact('users', 'adminModes', 'query', 'permissionGroups', 'userPermissions'));
    }

    public function Update(Request $request)
    {
        $this->authorizeOwner();

        $request->validate([
            'target_user' => 'required',
            'admin_mode' => 'required|string|in:normal,admin,subadmin,country_admin',
            'password' => 'nullable|string|min:6',
            'permissions' => 'array',
        ]);

        $target = trim((string) $request->target_user);
        $user = User::where('id', $target)->orWhere('email', $target)->first();

        if (!$user) {
            return Redirect()->back()->withInput()->with([
                'messege' => 'User not found',
                'alert-type' => 'error',
            ]);
        }

        if ((int) $user->id === (int) Auth::id() && $request->admin_mode === 'normal') {
            return Redirect()->back()->withInput()->with([
                'messege' => 'You cannot remove your own admin access',
                'alert-type' => 'error',
            ]);
        }

        DB::transaction(function () use ($request, $user) {
            if ($request->admin_mode === 'normal') {
                $user->is_admin = 0;
            } elseif ($request->admin_mode === 'country_admin') {
                $user->is_admin = 2;
                $user->role = 2;
                $user->status = 1;
            } else {
                $user->is_admin = 1;
            }
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->save();

            $permissions = in_array($request->admin_mode, ['normal', 'country_admin'], true)
                ? []
                : array_values(array_intersect(
                    array_keys(AdminParmisiton::definitions()),
                    (array) $request->input('permissions', [])
                ));

            AdminParmisiton::syncUserPermissions((int) $user->id, $permissions, (int) Auth::id());
        });

        return Redirect()->back()->with([
            'messege' => 'Admin permission updated successfully',
            'alert-type' => 'success',
        ]);
    }

    public function Delete(Request $request)
    {
        $this->authorizeOwner();
        $request->validate(['target_user' => 'required']);

        $target = trim((string) $request->target_user);
        $user = User::where('id', $target)->orWhere('email', $target)->first();

        if (!$user) {
            return Redirect()->back()->with([
                'messege' => 'User not found',
                'alert-type' => 'error',
            ]);
        }

        if ((int) $user->id === (int) Auth::id()) {
            return Redirect()->back()->with([
                'messege' => 'You cannot delete your own admin access',
                'alert-type' => 'error',
            ]);
        }

        DB::transaction(function () use ($user) {
            $user->is_admin = 0;
            $user->save();
            AdminParmisiton::where('user_id', (int) $user->id)->delete();
        });

        return Redirect()->back()->with([
            'messege' => 'Admin permission removed successfully',
            'alert-type' => 'success',
        ]);
    }

    public function StoreCountryAdmin(Request $request)
    {
        $this->authorizeOwner();

        $request->validate([
            'target_user' => 'nullable|string|max:190',
            'country_id' => 'required|integer|in:1,2,3',
            'name' => 'nullable|string|max:190',
            'email' => 'nullable|email|max:190',
            'phone' => 'nullable|string|max:50',
            'password' => 'nullable|string|min:6',
        ]);

        $countryId = (int) $request->country_id;
        $target = trim((string) $request->target_user);

        if ($target !== '') {
            $user = User::where('id', $target)->orWhere('email', $target)->first();
            if (!$user) {
                return Redirect()->back()->withInput()->with([
                    'messege' => 'Country admin target user not found',
                    'alert-type' => 'error',
                ]);
            }
        } else {
            if (!$request->filled('email') || !$request->filled('name') || !$request->filled('password')) {
                return Redirect()->back()->withInput()->with([
                    'messege' => 'Name, email, and password are required for a new country admin',
                    'alert-type' => 'error',
                ]);
            }

            if (User::where('email', trim((string) $request->email))->exists()) {
                return Redirect()->back()->withInput()->with([
                    'messege' => 'Email already exists',
                    'alert-type' => 'error',
                ]);
            }

            $user = new User;
            $user->name = trim((string) $request->name);
            $user->email = trim((string) $request->email);
            $user->phone = trim((string) $request->phone);
            $user->password = Hash::make((string) $request->password);
            $user->balance = 0;
            $user->hold_balance = 0;
            $user->level = 1;
            $user->profile = 'store/profile/default.webp';
            $user->date_wise_balance = 0;
            $user->game_balance_date = date('Y-m-d');
        }

        DB::transaction(function () use ($request, $user, $countryId) {
            $user->is_admin = 2;
            $user->role = 2;
            $user->status = 1;
            $user->country_id = $countryId;
            if ($request->filled('phone')) {
                $user->phone = trim((string) $request->phone);
            }
            if ($request->filled('password') && $user->exists) {
                $user->password = Hash::make((string) $request->password);
            }
            $user->save();

            AdminParmisiton::where('user_id', (int) $user->id)->delete();
        });

        return Redirect()->back()->with([
            'messege' => 'Country admin saved successfully',
            'alert-type' => 'success',
        ]);
    }

    private function authorizeOwner(): void
    {
        if (!AdminParmisiton::allowed(Auth::id(), 'setting_admin_manage')) {
            abort(403, 'Only owner admin can manage admin permissions.');
        }
    }

    private function adminModes(): array
    {
        return [
            'normal' => 'Normal User (is_admin = 0)',
            'admin' => 'Admin (is_admin = 1)',
            'subadmin' => 'Sub Admin (is_admin = 1)',
            'country_admin' => 'Country Admin (is_admin = 2)',
        ];
    }
}
