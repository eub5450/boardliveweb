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
            'start_bet_popup_sec' => "ALTER TABLE bd_game_final_settings ADD start_bet_popup_sec DECIMAL(5,2) NOT NULL DEFAULT 3.00 AFTER bet_duration_sec",
            'start_bet_wait_sec' => "ALTER TABLE bd_game_final_settings ADD start_bet_wait_sec DECIMAL(5,2) NOT NULL DEFAULT 1.50 AFTER start_bet_popup_sec",
            'stop_bet_popup_sec' => "ALTER TABLE bd_game_final_settings ADD stop_bet_popup_sec DECIMAL(5,2) NOT NULL DEFAULT 3.00 AFTER start_bet_wait_sec",
            'stop_bet_wait_sec' => "ALTER TABLE bd_game_final_settings ADD stop_bet_wait_sec DECIMAL(5,2) NOT NULL DEFAULT 1.50 AFTER stop_bet_popup_sec",
        ];

        foreach ($columns as $column => $sql) {
            if (!Schema::hasColumn('bd_game_final_settings', $column)) {
                DB::statement($sql);
            }
        }

        DB::statement('ALTER TABLE bd_game_final_settings MODIFY stop_duration_sec DECIMAL(5,2) NOT NULL DEFAULT 4.50');
        DB::statement('ALTER TABLE bd_game_final_settings MODIFY settle_duration_sec DECIMAL(5,2) NOT NULL DEFAULT 1.50');
        DB::table('bd_game_final_settings')->update([
            'bet_duration_sec' => 20,
            'start_bet_popup_sec' => 3.00,
            'start_bet_wait_sec' => 1.50,
            'stop_bet_popup_sec' => 3.00,
            'stop_bet_wait_sec' => 1.50,
            'stop_duration_sec' => 4.50,
            'settle_duration_sec' => 1.50,
        ]);
    }

    public function down(): void
    {
        if (!Schema::hasTable('bd_game_final_settings')) {
            return;
        }

        foreach (['stop_bet_wait_sec', 'stop_bet_popup_sec', 'start_bet_wait_sec', 'start_bet_popup_sec'] as $column) {
            if (Schema::hasColumn('bd_game_final_settings', $column)) {
                DB::statement("ALTER TABLE bd_game_final_settings DROP COLUMN {$column}");
            }
        }

        DB::statement('ALTER TABLE bd_game_final_settings MODIFY stop_duration_sec INT UNSIGNED NOT NULL DEFAULT 5');
        DB::statement('ALTER TABLE bd_game_final_settings MODIFY settle_duration_sec INT UNSIGNED NOT NULL DEFAULT 4');
    }
};
