<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApiTokensToUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'api_token')) {
                $table->string('api_token', 80)->nullable()->unique();
            }
            if (!Schema::hasColumn('users', 'api_token_refresh')) {
                $table->string('api_token_refresh', 80)->nullable()->unique();
            }
            if (!Schema::hasColumn('users', 'is_app_access')) {
                $table->boolean('is_app_access')->default(false)->index();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'api_token_refresh')) {
                $table->dropColumn('api_token_refresh');
            }
            if (Schema::hasColumn('users', 'api_token')) {
                $table->dropColumn('api_token');
            }
            if (Schema::hasColumn('users', 'is_app_access')) {
                $table->dropColumn('is_app_access');
            }
        });
    }
}
