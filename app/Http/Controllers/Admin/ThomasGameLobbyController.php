<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminParmisiton;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;

class ThomasGameLobbyController extends Controller
{
    private const CONNECTION = 'thomas_game_lobby';

    public function Index()
    {
        $this->authorizeThomasLobby();

        $data = $this->loadLobbyData();

        return view('backend.game.thomas_lobby')->with($data);
    }

    public function Update(Request $request)
    {
        $this->authorizeThomasLobby();

        $request->validate([
            'game_code' => 'required|string|max:80',
            'mode' => 'required|in:live,maintenance',
        ]);

        $conn = $this->thomasConnection();
        $gameCode = trim((string) $request->input('game_code'));
        $mode = (string) $request->input('mode');
        $now = date('Y-m-d H:i:s');

        $game = $conn->table('bd_game_final_games')->where('game_code', $gameCode)->first();
        if (!$game) {
            throw ValidationException::withMessages([
                'game_code' => 'Game room not found in Thomas lobby.',
            ]);
        }

        $conn->transaction(function () use ($conn, $game, $mode, $now) {
            $isLive = $mode === 'live';

            $conn->table('bd_game_final_games')
                ->where('id', $game->id)
                ->update([
                    'is_active' => $isLive ? 1 : 0,
                    'updated_at' => $now,
                ]);

            $payload = [
                'game_status' => $isLive ? 'live' : 'maintenance',
                'maintenance_enabled' => $isLive ? 0 : 1,
                'maintenance_allowed_user_id' => null,
                'maintenance_message' => $isLive
                    ? 'All approved lobby users can enter when the room is active.'
                    : 'This game is in maintenance. Please wait.',
                'updated_at' => $now,
            ];

            $existing = $conn->table('bd_game_final_settings')->where('game_id', $game->id)->first();
            if ($existing) {
                $conn->table('bd_game_final_settings')->where('game_id', $game->id)->update($payload);
                return;
            }

            $payload['game_id'] = $game->id;
            $payload['created_at'] = $now;
            $conn->table('bd_game_final_settings')->insert($payload);
        });

        return redirect('admin/thomas-game-lobby')->with([
            'messege' => 'Thomas game lobby status updated successfully',
            'alert-type' => 'success',
        ]);
    }

    private function authorizeThomasLobby(): void
    {
        if (!AdminParmisiton::allowed(Auth::id(), 'sidebar_game_teenpatti_detail')) {
            abort(403, 'Thomas Game Lobby permission required.');
        }
    }

    private function loadLobbyData(): array
    {
        $conn = $this->thomasConnection();
        $ready = Schema::connection(self::CONNECTION)->hasTable('bd_game_final_games')
            && Schema::connection(self::CONNECTION)->hasTable('bd_game_final_settings');

        if (!$ready) {
            return [
                'domainName' => $this->thomasDomain(),
                'lobbyUrl' => 'https://' . $this->thomasDomain() . '/play_bd_game',
                'adminUrl' => 'https://' . $this->thomasDomain() . '/thomas-admin',
                'games' => collect(),
                'summary' => [
                    'total' => 0,
                    'live' => 0,
                    'maintenance' => 0,
                ],
                'errorMessage' => 'Thomas game tables are not ready.',
            ];
        }

        $games = $conn->table('bd_game_final_games as g')
            ->leftJoin('bd_game_final_settings as s', 's.game_id', '=', 'g.id')
            ->select(
                'g.id',
                'g.game_code',
                'g.name',
                'g.frontend_slug',
                'g.is_active',
                'g.sort_order',
                's.game_status',
                's.maintenance_enabled',
                's.maintenance_message',
                's.ui_meta_json'
            )
            ->orderBy('g.sort_order')
            ->get()
            ->map(function ($game) {
                $meta = json_decode((string) ($game->ui_meta_json ?? ''), true);
                $banner = is_array($meta) ? trim((string) ($meta['lobby_banner_url'] ?? '')) : '';
                $isLive = (int) $game->is_active === 1
                    && strtolower((string) ($game->game_status ?? 'live')) === 'live'
                    && !(bool) ($game->maintenance_enabled ?? false);

                return [
                    'id' => (int) $game->id,
                    'game_code' => (string) $game->game_code,
                    'name' => (string) $game->name,
                    'frontend_slug' => (string) ($game->frontend_slug ?? $game->game_code),
                    'banner' => $banner,
                    'is_live' => $isLive,
                    'status_label' => $isLive ? 'Live Mode' : 'Maintenance Mode',
                    'status_text' => $isLive ? 'Users can play this room now.' : 'Users see maintenance mode instantly.',
                    'maintenance_message' => (string) ($game->maintenance_message ?? ''),
                ];
            });

        return [
            'domainName' => $this->thomasDomain(),
            'lobbyUrl' => 'https://' . $this->thomasDomain() . '/play_bd_game',
            'adminUrl' => 'https://' . $this->thomasDomain() . '/thomas-admin',
            'games' => $games,
            'summary' => [
                'total' => $games->count(),
                'live' => $games->where('is_live', true)->count(),
                'maintenance' => $games->where('is_live', false)->count(),
            ],
            'errorMessage' => null,
        ];
    }

    private function thomasConnection()
    {
        $env = $this->readEnvFile($this->thomasRoot() . '/.env');

        Config::set('database.connections.' . self::CONNECTION, [
            'driver' => 'mysql',
            'host' => $env['DB_HOST'] ?? '127.0.0.1',
            'port' => $env['DB_PORT'] ?? '3306',
            'database' => $env['DB_DATABASE'] ?? '',
            'username' => $env['DB_USERNAME'] ?? '',
            'password' => $env['DB_PASSWORD'] ?? '',
            'unix_socket' => $env['DB_SOCKET'] ?? '',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
        ]);

        DB::purge(self::CONNECTION);

        return DB::connection(self::CONNECTION);
    }

    private function readEnvFile(string $path): array
    {
        if (!is_readable($path)) {
            throw ValidationException::withMessages([
                'env' => 'Thomas game environment file is not readable.',
            ]);
        }

        $values = [];
        foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
            $line = trim($line);
            if ($line === '' || strpos($line, '#') === 0 || strpos($line, '=') === false) {
                continue;
            }

            [$key, $value] = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);
            if ((strpos($value, '"') === 0 && substr($value, -1) === '"') || (strpos($value, "'") === 0 && substr($value, -1) === "'")) {
                $value = substr($value, 1, -1);
            }

            $values[$key] = $value;
        }

        return $values;
    }

    private function thomasRoot(): string
    {
        return '/var/www/broadlive/subdomains/thomaslivestreamingcompanyltdgame.broadlive.xyz/current';
    }

    private function thomasDomain(): string
    {
        return 'thomaslivestreamingcompanyltdgame.broadlive.xyz';
    }
}
