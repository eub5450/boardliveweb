<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AdminLoginLock;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm(Request $request)
    {
        if ($request->is('login')) {
            return redirect()->route('thomas.admin.login');
        }

        $email = strtolower(trim((string) old('email', (string) $request->query('email', ''))));
        $locked = $email !== '' ? $this->adminLoginIsLocked($request, $email) : false;

        return view('auth.login', [
            'adminLoginLock' => null,
            'adminLoginLocked' => $locked,
            'adminLoginRemainingMinutes' => $locked ? $this->adminLoginRemainingMinutes($request, $email) : 0,
            'adminLoginEmail' => $email,
        ]);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $email = strtolower(trim((string) $request->input('email')));
        if ($this->adminLoginIsLocked($request, $email)) {
            return redirect()
                ->route('thomas.admin.login')
                ->withInput(['email' => $email])
                ->with('error', $this->lockedMessage($request, $email));
        }

        if (Auth::attempt(['email' => $email, 'password' => $request->input('password')])) {
            $user = Auth::user();
            if ((int) ($user->is_admin ?? 0) === 1 && $this->adminAccountIsActive($user)) {
                $request->session()->regenerate();
                $this->clearAdminLoginLock($request, $email);
                return redirect()->route('admin.dashboard');
            }

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return $this->recordAdminLoginFailure($request, $email);
        }

        return $this->recordAdminLoginFailure($request, $email);
    }

    protected function recordAdminLoginFailure(Request $request, string $email)
    {
        $lock = AdminLoginLock::firstOrNew(['scope' => $this->adminLoginScope($request, $email)]);
        $attempts = min(2, ((int) $lock->attempts) + 1);
        $lock->fill([
            'email' => $email,
            'attempts' => $attempts,
            'last_ip' => (string) $request->ip(),
            'last_user_agent' => substr((string) $request->userAgent(), 0, 255),
        ]);

        if ($attempts >= 2) {
            $lock->locked_until = now()->addMinutes(30);
            $lock->save();

            return redirect()
                ->route('thomas.admin.login')
                ->withInput(['email' => $email])
                ->with('error', $this->lockedMessage($request, $email));
        }

        $lock->locked_until = null;
        $lock->save();

        return redirect()
            ->route('thomas.admin.login')
            ->withInput(['email' => $email])
            ->with('warning', 'Wrong email or password. You have one chance left.');
    }

    protected function currentAdminLock(Request $request, string $email)
    {
        return AdminLoginLock::where('scope', $this->adminLoginScope($request, $email))->first();
    }

    protected function adminLoginIsLocked(Request $request, string $email): bool
    {
        $lock = $this->currentAdminLock($request, $email);
        return $lock && $lock->locked_until && $lock->locked_until->isFuture();
    }

    protected function adminLoginRemainingMinutes(Request $request, string $email): int
    {
        $lock = $this->currentAdminLock($request, $email);
        if (!$lock || !$lock->locked_until || !$lock->locked_until->isFuture()) {
            return 0;
        }

        return max(1, now()->diffInMinutes($lock->locked_until, false));
    }

    protected function lockedMessage(Request $request, string $email): string
    {
        return 'Admin panel login is locked for ' . $this->adminLoginRemainingMinutes($request, $email) . ' minutes.';
    }

    protected function clearAdminLoginLock(Request $request, string $email): void
    {
        AdminLoginLock::where('scope', $this->adminLoginScope($request, $email))->delete();
    }

    protected function adminLoginScope(Request $request, string $email): string
    {
        return 'thomas-admin:' . sha1(strtolower(trim($email)) . '|' . (string) $request->ip());
    }

    protected function adminAccountIsActive($user): bool
    {
        $status = $user->status ?? null;

        return in_array((string) $status, ['1', 'active'], true);
    }
}
