<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\GameFinal\GameAdminController;
use App\Http\Controllers\InstallController;

Route::get('/install', [InstallController::class, 'show'])->name('install.show');
Route::post('/install', [InstallController::class, 'store'])->name('install.store');

Route::get('/thomas-admin', [LoginController::class, 'showLoginForm'])->middleware(['guest', 'throttle:admin-auth'])->name('thomas.admin.login');
Route::post('/thomas-admin', [LoginController::class, 'login'])->middleware(['guest', 'throttle:admin-auth'])->name('thomas.admin.login.submit');

Auth::routes(['register' => false, 'reset' => false, 'verify' => false, 'confirm' => false]);

Route::middleware(['auth', 'admin'])->group(function () {
	Route::get('/admin/game-final/security', [GameAdminController::class, 'security'])->name('admin.game-final.security');
	Route::post('/admin/game-final/security', [GameAdminController::class, 'verifySecurity'])->middleware('throttle:admin-auth')->name('admin.game-final.security.verify');
	Route::post('/admin/game-final/security/lock', [GameAdminController::class, 'lockSecurity'])->name('admin.game-final.security.lock');

	Route::middleware('game_final.admin_pass')->group(function () {
		Route::get('/admin', [GameAdminController::class, 'dashboard'])->name('admin.dashboard');
		Route::get('/admin/game-final', [GameAdminController::class, 'dashboard'])->name('admin.game-final.dashboard');
		Route::get('/admin/game-final/game-time', [GameAdminController::class, 'gameTime'])->name('admin.game-final.game-time');
		Route::get('/admin/game-final/games', [GameAdminController::class, 'games'])->name('admin.game-final.games');
		Route::get('/admin/game-final/live-monitor', [GameAdminController::class, 'liveMonitor'])->name('admin.game-final.live-monitor');
		Route::get('/admin/game-final/rounds', [GameAdminController::class, 'rounds'])->name('admin.game-final.rounds');
		Route::get('/admin/game-final/rounds/{round}', [GameAdminController::class, 'roundDetail'])->name('admin.game-final.rounds.detail');
		Route::get('/admin/game-final/bets', [GameAdminController::class, 'bets'])->name('admin.game-final.bets');
		Route::get('/admin/game-final/users', [GameAdminController::class, 'users'])->name('admin.game-final.users');
		Route::get('/admin/game-final/users/{user}', [GameAdminController::class, 'userProfile'])->name('admin.game-final.users.profile');
		Route::post('/admin/game-final/game-balance-transfer', [GameAdminController::class, 'gameBalanceTransfer'])->name('admin.game-final.game-balance-transfer');
		Route::post('/admin/game-final/wallet-transfer', [GameAdminController::class, 'walletTransfer'])->name('admin.game-final.wallet-transfer');
		Route::post('/admin/game-final/user-lock', [GameAdminController::class, 'blockUser'])->name('admin.game-final.user-lock');
		Route::post('/admin/game-final/user-lock/{block}/lift', [GameAdminController::class, 'liftBlock'])->name('admin.game-final.user-lock.lift');
		Route::get('/admin/game-final/payouts', [GameAdminController::class, 'payouts'])->name('admin.game-final.payouts');
		Route::post('/admin/game-final', [GameAdminController::class, 'update'])->name('admin.game-final.update');
	});
});

Route::redirect('/', '/play_bd_game');
Route::redirect('/home', '/play_bd_game');
Route::redirect('/play', '/play_bd_game');
