<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Str;

class GenerateApiTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bdgame:generate-api-tokens {--force : Regenerate tokens even if present}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate api_token and api_token_refresh for users missing them';

    public function handle()
    {
        $force = $this->option('force');

        $query = User::query();
        if ($force) {
            $users = $query->get();
        } else {
            $users = $query->whereNull('api_token')->orWhereNull('api_token_refresh')->get();
        }

        $count = 0;
        foreach ($users as $user) {
            $updated = false;
            if (!$user->api_token || $force) {
                $user->api_token = Str::random(80);
                $updated = true;
            }
            if (!$user->api_token_refresh || $force) {
                $user->api_token_refresh = Str::random(80);
                $updated = true;
            }
            if ($updated) {
                $user->save();
                $this->line('Updated user id: ' . $user->id . ' (email: ' . ($user->email ?? 'n/a') . ')');
                $count++;
            }
        }

        $this->info('Done. Tokens generated for ' . $count . ' user(s).');
        return 0;
    }
}
