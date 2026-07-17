<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Services\GameFinal\GameTokenService;

class BdGameFinalIssueEntryTokenCommand extends Command
{
    protected $signature = 'bdgamefinal:issue-entry-token {gameCode} {userId}';
    protected $description = 'Issue entry token';

    public function handle(GameTokenService $tokens)
    {
        $user = User::find($this->argument('userId'));
        if (!$user) {
            $this->error('User not found');
            return 1;
        }
        $issued = $tokens->issueEntryToken($this->argument('gameCode'), $user->id, null, ['issued_from' => 'artisan']);
        $plain = $issued['plain_token'] ?? null;
        if (!$plain) {
            $this->error('Invalid game code');
            return 1;
        }
        $this->line($plain);
        return 0;
    }
}
