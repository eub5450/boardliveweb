<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGameFinalRuntimeAndMaintenanceSettings extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('bd_game_final_runtime_settings')) {
            Schema::create('bd_game_final_runtime_settings', function (Blueprint $table) {
                $table->id();
                $table->string('key', 100)->unique();
                $table->text('value')->nullable();
                $table->timestamps();
            });
        }

        Schema::table('bd_game_final_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('bd_game_final_settings', 'maintenance_enabled')) {
                $table->boolean('maintenance_enabled')->default(false)->after('game_status');
            }
            if (!Schema::hasColumn('bd_game_final_settings', 'maintenance_allowed_user_id')) {
                $table->unsignedBigInteger('maintenance_allowed_user_id')->nullable()->after('maintenance_enabled');
            }
            if (!Schema::hasColumn('bd_game_final_settings', 'maintenance_message')) {
                $table->string('maintenance_message', 255)->nullable()->after('maintenance_allowed_user_id');
            }
        });
    }

    public function down()
    {
        Schema::table('bd_game_final_settings', function (Blueprint $table) {
            if (Schema::hasColumn('bd_game_final_settings', 'maintenance_message')) {
                $table->dropColumn('maintenance_message');
            }
            if (Schema::hasColumn('bd_game_final_settings', 'maintenance_allowed_user_id')) {
                $table->dropColumn('maintenance_allowed_user_id');
            }
            if (Schema::hasColumn('bd_game_final_settings', 'maintenance_enabled')) {
                $table->dropColumn('maintenance_enabled');
            }
        });

        Schema::dropIfExists('bd_game_final_runtime_settings');
    }
}
