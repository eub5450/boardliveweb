<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use PDO;
use Throwable;

class InstallController extends Controller
{
    private string $lockFile = 'app/install.lock';

    public function show()
    {
        if ($this->isLocked()) {
            abort(404);
        }

        return view('install', [
            'defaults' => [
                'app_url' => config('app.url') ?: request()->getSchemeAndHttpHost(),
                'db_host' => env('DB_HOST', '127.0.0.1'),
                'db_port' => env('DB_PORT', '3306'),
                'db_database' => env('DB_DATABASE', ''),
                'db_username' => env('DB_USERNAME', ''),
            ],
        ]);
    }

    public function store(Request $request)
    {
        if ($this->isLocked()) {
            abort(404);
        }

        $data = $request->validate([
            'app_url' => ['nullable', 'url'],
            'db_host' => ['required', 'string', 'max:255'],
            'db_port' => ['required', 'integer', 'min:1', 'max:65535'],
            'db_database' => ['required', 'string', 'max:128'],
            'db_username' => ['required', 'string', 'max:128'],
            'db_password' => ['nullable', 'string', 'max:255'],
            'admin_secret' => ['required', 'string', 'min:6', 'max:255'],
        ]);

        try {
            $this->testDatabase($data);
            $this->prepareRuntimeFolders();
            $this->writeEnvironment($data);

            Artisan::call('optimize:clear');

            File::put(storage_path($this->lockFile), now()->toDateTimeString() . PHP_EOL);
            $deleted = $this->deleteDeploymentZips();

            return view('install', [
                'completed' => true,
                'deletedZips' => $deleted,
            ]);
        } catch (Throwable $exception) {
            return back()
                ->withInput($request->except('db_password', 'admin_secret'))
                ->withErrors(['setup' => $exception->getMessage()]);
        }
    }

    private function isLocked(): bool
    {
        return File::exists(storage_path($this->lockFile));
    }

    private function testDatabase(array $data): void
    {
        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
            $data['db_host'],
            $data['db_port'],
            $data['db_database']
        );

        new PDO($dsn, $data['db_username'], $data['db_password'] ?? '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);
    }

    private function prepareRuntimeFolders(): void
    {
        foreach ([
            storage_path('framework/cache/data'),
            storage_path('framework/sessions'),
            storage_path('framework/views'),
            storage_path('logs'),
            base_path('bootstrap/cache'),
        ] as $path) {
            File::ensureDirectoryExists($path, 0775, true);
        }

        File::put(storage_path('logs/laravel.log'), File::exists(storage_path('logs/laravel.log')) ? File::get(storage_path('logs/laravel.log')) : '');
    }

    private function writeEnvironment(array $data): void
    {
        $envPath = base_path('.env');
        $env = File::exists($envPath) ? File::get($envPath) : File::get(base_path('.env.example'));

        $values = [
            'APP_ENV' => 'production',
            'APP_DEBUG' => 'false',
            'APP_URL' => $data['app_url'] ?: request()->getSchemeAndHttpHost(),
            'APP_KEY' => env('APP_KEY') ?: 'base64:' . base64_encode(random_bytes(32)),
            'DB_CONNECTION' => 'mysql',
            'DB_HOST' => $data['db_host'],
            'DB_PORT' => (string) $data['db_port'],
            'DB_DATABASE' => $data['db_database'],
            'DB_USERNAME' => $data['db_username'],
            'DB_PASSWORD' => $data['db_password'] ?? '',
            'BD_GAME_FINAL_ADMIN_SECURITY_SECRET' => $data['admin_secret'],
            'BD_GAME_FINAL_ADMIN_SECURITY_SECRET_HASH' => hash('sha256', $data['admin_secret']),
        ];

        foreach ($values as $key => $value) {
            $line = $key . '=' . $this->formatEnvValue($value);
            if (preg_match('/^' . preg_quote($key, '/') . '=/m', $env)) {
                $env = preg_replace('/^' . preg_quote($key, '/') . '=.*/m', $line, $env);
            } else {
                $env .= PHP_EOL . $line;
            }
        }

        File::put($envPath, rtrim($env) . PHP_EOL);
    }

    private function formatEnvValue(string $value): string
    {
        if ($value === '') {
            return '';
        }

        if (preg_match('/\s|#|"|\'|=/', $value)) {
            return '"' . str_replace('"', '\"', $value) . '"';
        }

        return $value;
    }

    private function deleteDeploymentZips(): array
    {
        $deleted = [];

        foreach ([base_path('*.zip'), public_path('*.zip')] as $pattern) {
            foreach (glob($pattern) ?: [] as $zipFile) {
                if (is_file($zipFile) && @unlink($zipFile)) {
                    $deleted[] = basename($zipFile);
                }
            }
        }

        return array_values(array_unique($deleted));
    }
}
