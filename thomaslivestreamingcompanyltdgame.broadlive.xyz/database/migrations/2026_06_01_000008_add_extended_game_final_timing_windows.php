<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('bd_game_final_settings')) {
            return;
        }

        $columns = [
            'reveal_wait_sec' => "ALTER TABLE bd_game_final_settings ADD reveal_wait_sec DECIMAL(5,2) NOT NULL DEFAULT 2.00 AFTER reveal_duration_sec",
            'winner_popup_sec' => "ALTER TABLE bd_game_final_settings ADD winner_popup_sec DECIMAL(5,2) NOT NULL DEFAULT 1.00 AFTER reveal_wait_sec",
            'winner_wait_sec' => "ALTER TABLE bd_game_final_settings ADD winner_wait_sec DECIMAL(5,2) NOT NULL DEFAULT 0.50 AFTER winner_popup_sec",
            'settle_wait_sec' => "ALTER TABLE bd_game_final_settings ADD settle_wait_sec DECIMAL(5,2) NOT NULL DEFAULT 1.00 AFTER settle_duration_sec",
        ];

        foreach ($columns as $column => $sql) {
            if (!Schema::hasColumn('bd_game_final_settings', $column)) {
                DB::statement($sql);
            }
        }

        DB::statement('ALTER TABLE bd_game_final_settings MODIFY reveal_duration_sec DECIMAL(5,2) UNSIGNED NOT NULL DEFAULT 6.00');
        DB::statement('ALTER TABLE bd_game_final_settings MODIFY settle_duration_sec DECIMAL(5,2) UNSIGNED NOT NULL DEFAULT 2.50');

        DB::table('bd_game_final_settings')->update([
            'reveal_wait_sec' => 2.00,
            'winner_popup_sec' => 1.00,
            'winner_wait_sec' => 0.50,
            'settle_wait_sec' => 1.00,
        ]);
    }

    public function down(): void
    {
        if (!Schema::hasTable('bd_game_final_settings')) {
            return;
        }

        foreach (['settle_wait_sec', 'winner_wait_sec', 'winner_popup_sec', 'reveal_wait_sec'] as $column) {
            if (Schema::hasColumn('bd_game_final_settings', $column)) {
                DB::statement("ALTER TABLE bd_game_final_settings DROP COLUMN {$column}");
            }
        }
    }
};
