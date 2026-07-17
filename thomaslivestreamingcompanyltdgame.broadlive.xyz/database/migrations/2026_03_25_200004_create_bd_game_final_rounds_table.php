<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBdGameFinalRoundsTable extends Migration
{
    public function up()
    {
        Schema::create('bd_game_final_rounds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('game_id')->index();
            $table->string('round_no')->index();
            $table->timestamp('start_at')->nullable();
            $table->timestamp('bet_close_at')->nullable();
            $table->timestamp('reveal_at')->nullable();
            $table->timestamp('settle_at')->nullable();
            $table->string('status')->default('betting')->index();
            $table->string('winner_board_key')->nullable()->index();
            $table->string('decision_mode')->nullable();
            $table->json('decision_snapshot_json')->nullable();
            $table->json('result_payload_json')->nullable();
            $table->timestamps();
            $table->unique(['game_id', 'round_no']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('bd_game_final_rounds');
    }
}
