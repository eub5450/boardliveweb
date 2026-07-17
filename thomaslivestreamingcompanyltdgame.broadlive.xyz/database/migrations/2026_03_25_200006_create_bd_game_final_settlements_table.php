<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBdGameFinalSettlementsTable extends Migration
{
    public function up()
    {
        Schema::create('bd_game_final_settlements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('game_round_id')->unique();
            $table->string('winner_board_key')->nullable()->index();
            $table->string('settlement_run_uid')->nullable()->index();
            $table->string('settlement_status')->default('processing')->index();
            $table->decimal('total_bet_amount', 14, 2)->default(0);
            $table->decimal('total_payout_amount', 14, 2)->default(0);
            $table->unsignedInteger('total_winning_bets')->default(0);
            $table->unsignedInteger('total_losing_bets')->default(0);
            $table->decimal('net_house_result', 14, 2)->default(0);
            $table->json('meta_json')->nullable();
            $table->timestamp('settled_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bd_game_final_settlements');
    }
}
