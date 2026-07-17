<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminLoginLocksTable extends Migration
{
    public function up()
    {
        Schema::create('admin_login_locks', function (Blueprint $table) {
            $table->id();
            $table->string('scope', 64)->default('thomas-admin')->unique();
            $table->string('email')->nullable();
            $table->unsignedTinyInteger('attempts')->default(0);
            $table->timestamp('locked_until')->nullable()->index();
            $table->string('last_ip', 64)->nullable();
            $table->string('last_user_agent', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('admin_login_locks');
    }
}
