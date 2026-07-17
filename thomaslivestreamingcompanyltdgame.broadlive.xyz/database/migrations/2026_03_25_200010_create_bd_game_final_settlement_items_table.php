<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBdGameFinalSettlementItemsTable extends Migration
{
    public function up()
    {
        Schema::create('bd_game_final_settlement_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('game_settlement_id')->index();
            $table->unsignedBigInteger('game_round_id')->index();
            $table->unsignedBigInteger('game_bet_id')->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('canonical_board_key')->index();
            $table->decimal('bet_amount', 14, 2)->default(0);
            $table->decimal('payout_multiplier', 12, 2)->default(1);
            $table->decimal('win_amount', 14, 2)->default(0);
            $table->decimal('net_result', 14, 2)->default(0);
            $table->string('result_status')->default('lost')->index();
            $table->decimal('wallet_before', 14, 2)->default(0);
            $table->decimal('wallet_after', 14, 2)->default(0);
            $table->json('meta_json')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bd_game_final_settlement_items');
    }
}
