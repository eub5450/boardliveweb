<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMaintenanceModeToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            if (!Schema::hasColumn('settings', 'maintenance_mode')) {
                $table->boolean('maintenance_mode')->default(0)->after('id');
            }
            if (!Schema::hasColumn('settings', 'maintenance_mode_by')) {
                $table->unsignedBigInteger('maintenance_mode_by')->nullable()->after('maintenance_mode');
            }
            if (!Schema::hasColumn('settings', 'maintenance_mode_at')) {
                $table->timestamp('maintenance_mode_at')->nullable()->after('maintenance_mode_by');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            if (Schema::hasColumn('settings', 'maintenance_mode')) {
                $table->dropColumn('maintenance_mode');
            }
            if (Schema::hasColumn('settings', 'maintenance_mode_by')) {
                $table->dropColumn('maintenance_mode_by');
            }
            if (Schema::hasColumn('settings', 'maintenance_mode_at')) {
                $table->dropColumn('maintenance_mode_at');
            }
        });
    }
}
