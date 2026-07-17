<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE `bd_game_final_settings` MODIFY `reveal_duration_sec` DECIMAL(5,2) UNSIGNED NOT NULL DEFAULT 6.00");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE `bd_game_final_settings` MODIFY `reveal_duration_sec` INT(10) UNSIGNED NOT NULL DEFAULT 6");
    }
};
