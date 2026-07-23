<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\Setting;
use Cart;
use Log;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

   
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * User id allowed to log in during maintenance mode (the same super-admin
     * bypass id already used elsewhere in this codebase, e.g.
     * JamboAiTaskController::ALLOWED_ADMIN_ID, ProfileController,
     * ProtalController).
     */
    const MAINTENANCE_BYPASS_ADMIN_ID = 11133;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $input = $request->all();

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $ip = $request->ip();
        $userAgent = $request->userAgent();

        if(auth()->attempt(array('email' => $input['email'], 'password' => $input['password'])))
        {
            $user = auth()->user();
            $maintenanceOn = (bool) optional(Setting::find(1))->maintenance_mode;

            if ($maintenanceOn && (int) $user->id !== self::MAINTENANCE_BYPASS_ADMIN_ID) {
                Log::warning('Admin panel login blocked - maintenance mode active', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'ip' => $ip,
                    'user_agent' => $userAgent,
                ]);
                auth()->logout();
                return redirect()->route('login')
                    ->with('error', 'The admin panel is under maintenance. Please try again later.');
            }

            Log::info('Admin panel login success', [
                'user_id' => $user->id,
                'email' => $user->email,
                'is_admin' => $user->is_admin,
                'ip' => $ip,
                'user_agent' => $userAgent,
            ]);

            if ($user->is_admin == 1) {
                return redirect()->route('admin.dashboard');
            }else{
                    return redirect()->route('author.dashboard');

            }
        }else{
            Log::warning('Admin panel login failed', [
                'email' => $input['email'] ?? null,
                'ip' => $ip,
                'user_agent' => $userAgent,
            ]);
            return redirect()->route('login')
                ->with('error','Email-Address And Password Are Wrong.');
        }

    }

}