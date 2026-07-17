<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBdGameFinalHeartbeatsTable extends Migration
{
    public function up()
    {
        Schema::create('bd_game_final_heartbeats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('game_id')->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('game_round_id')->nullable()->index();
            $table->integer('network_ms')->nullable();
            $table->json('client_meta_json')->nullable();
            $table->timestamp('last_seen_at')->nullable()->index();
            $table->timestamps();
            $table->unique(['game_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('bd_game_final_heartbeats');
    }
}
