<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\GameFinal\AppPackageVerificationService;

class TestAppAccessCommand extends Command
{
    protected $signature = 'bdgamefinal:test-app-access {--package=} {--password=} {--list}';
    protected $description = 'Inspect app access verification configuration';

    public function handle(AppPackageVerificationService $verification)
    {
        if ($this->option('list')) {
            return $this->showConfig($verification);
        }

        $package = $this->option('package');
        $password = $this->option('password');

        $this->line('');
        $this->info('=== App Access Verification Test ===');
        $this->line('');

        if ($package) {
            $this->testPackage($verification, $package);
        }

        if ($password) {
            $this->testPassword($verification, $password);
        }

        $this->line('');
        return $this->showConfig($verification);
    }

    protected function testPackage(AppPackageVerificationService $verification, string $package)
    {
        $allowed = $verification->isPackageAllowed($package);

        $this->line("Testing Package: <comment>$package</comment>");
        $this->line('Allowed Packages: <info>' . implode(', ', $verification->getAllowedPackages()) . '</info>');

        if ($allowed) {
            $this->line('Result: <fg=green>PACKAGE RECOGNIZED - Developer secret still required</>', 1);
        } else {
            $this->line('Result: <fg=red>NOT ALLOWED - Requires Developer Secret</>', 1);
        }

        $this->line('');
    }

    protected function testPassword(AppPackageVerificationService $verification, string $password)
    {
        $correct = $verification->verifyPassword($password);

        $this->line('Testing Password: <comment>' . str_repeat('*', strlen($password)) . '</comment>');

        if ($correct) {
            $this->line('Result: <fg=green>CORRECT - Access Granted</>', 1);
        } else {
            $this->line('Result: <fg=red>INCORRECT - Access Denied</>', 1);
        }

        $this->line('');
    }

    protected function showConfig(AppPackageVerificationService $verification)
    {
        $this->info('Configuration:');

        $packages = $verification->getAllowedPackages();
        if (!empty($packages)) {
            $this->line('  Allowed Packages:');
            foreach ($packages as $pkg) {
                $this->line("    - <comment>$pkg</comment>");
            }
        } else {
            $this->line('  Allowed Packages: <fg=yellow>None configured</>', 1);
        }

        $this->line('  Password Auth Configured: <comment>' . ($verification->passwordAuthAvailable() ? 'yes' : 'no') . '</comment>');

        $this->line('');
        $this->line('Usage Examples:');
        $this->line('  <info>php artisan bdgamefinal:test-app-access --list</info>');
        $this->line('  <info>php artisan bdgamefinal:test-app-access --package=com.yourcompany.app</info>');
        $this->line('  <info>php artisan bdgamefinal:test-app-access --password=YOUR_SECRET</info>');

        return 0;
    }
}
