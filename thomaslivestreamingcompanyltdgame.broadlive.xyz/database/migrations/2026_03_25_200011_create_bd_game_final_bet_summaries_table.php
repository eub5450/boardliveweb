<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBdGameFinalBetSummariesTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('bd_game_final_bet_summaries')) {
            return;
        }

        Schema::create('bd_game_final_bet_summaries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('game_id')->index();
            $table->unsignedBigInteger('game_round_id')->index();
            $table->string('canonical_board_key')->index();
            $table->decimal('total_amount', 14, 2)->default(0);
            $table->unsignedInteger('total_players')->default(0);
            $table->decimal('potential_payout', 14, 2)->default(0);
            $table->timestamps();
            $table->unique(['game_round_id', 'canonical_board_key']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('bd_game_final_bet_summaries');
    }
}
