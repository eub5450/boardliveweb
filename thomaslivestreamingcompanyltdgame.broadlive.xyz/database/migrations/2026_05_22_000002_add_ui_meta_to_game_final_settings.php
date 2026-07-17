<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUiMetaToGameFinalSettings extends Migration
{
    public function up()
    {
        Schema::table('bd_game_final_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('bd_game_final_settings', 'ui_meta_json')) {
                $table->json('ui_meta_json')->nullable()->after('maintenance_message');
            }
        });
    }

    public function down()
    {
        Schema::table('bd_game_final_settings', function (Blueprint $table) {
            if (Schema::hasColumn('bd_game_final_settings', 'ui_meta_json')) {
                $table->dropColumn('ui_meta_json');
            }
        });
    }
}
