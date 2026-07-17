<?php

namespace App\Http\Middleware;

use App\Services\GameFinal\GameAdminSecurityService;
use Closure;
use Illuminate\Http\Request;

class EnsureGameFinalAdminPassphrase
{
    protected $security;

    public function __construct(GameAdminSecurityService $security)
    {
        $this->security = $security;
    }

    public function handle(Request $request, Closure $next)
    {
        if ($this->security->isVerified($request->session())) {
            return $next($request);
        }

        return redirect()
            ->route('admin.game-final.security')
            ->with('error', 'Security verification required to access Game Final controls.');
    }
}
