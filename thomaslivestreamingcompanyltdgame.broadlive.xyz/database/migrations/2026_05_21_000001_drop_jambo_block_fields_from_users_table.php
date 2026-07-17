<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'jambo_blocked_at')) {
                $table->dropColumn('jambo_blocked_at');
            }
        });

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'jambo_block_reason')) {
                $table->dropColumn('jambo_block_reason');
            }
        });
    }

    public function down(): void
    {
        // JAMBOai blocks live in bd_game_final_security_blocks, not users.
    }
};
