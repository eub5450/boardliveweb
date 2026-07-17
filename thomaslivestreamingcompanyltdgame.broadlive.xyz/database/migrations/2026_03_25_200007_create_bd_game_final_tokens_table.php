<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBdGameFinalTokensTable extends Migration
{
    public function up()
    {
        Schema::create('bd_game_final_tokens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('game_id')->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('token_hash', 40)->index();
            $table->string('token_type')->default('entry')->index();
            $table->unsignedBigInteger('parent_token_id')->nullable()->index();
            $table->string('device_fingerprint', 64)->nullable()->index();
            $table->json('meta_json')->nullable();
            $table->timestamp('issued_at')->nullable();
            $table->timestamp('last_seen_at')->nullable();
            $table->timestamp('expires_at')->nullable()->index();
            $table->timestamp('revoked_at')->nullable()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bd_game_final_tokens');
    }
}
