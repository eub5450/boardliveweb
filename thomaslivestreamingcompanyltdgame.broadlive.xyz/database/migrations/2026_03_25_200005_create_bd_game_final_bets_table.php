<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBdGameFinalBetsTable extends Migration
{
    public function up()
    {
        Schema::create('bd_game_final_bets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('game_id')->index();
            $table->unsignedBigInteger('game_round_id')->index();
            $table->string('round_no')->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->decimal('amount', 14, 2);
            $table->string('frontend_board_key')->index();
            $table->string('canonical_board_key')->index();
            $table->decimal('payout_multiplier', 12, 2)->default(1);
            $table->decimal('potential_win', 14, 2)->default(0);
            $table->decimal('win_balance', 14, 2)->default(0);
            $table->decimal('now_user_balance', 14, 2)->default(0);
            $table->string('request_uid')->nullable()->unique();
            $table->unsignedBigInteger('settlement_item_id')->nullable()->index();
            $table->string('status')->default('pending')->index();
            $table->json('meta_json')->nullable();
            $table->timestamp('settled_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bd_game_final_bets');
    }
}
