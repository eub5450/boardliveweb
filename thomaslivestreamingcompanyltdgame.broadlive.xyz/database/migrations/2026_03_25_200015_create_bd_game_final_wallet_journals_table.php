<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBdGameFinalWalletJournalsTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('bd_game_final_wallet_journals')) {
            return;
        }

        Schema::create('bd_game_final_wallet_journals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('game_id')->nullable()->index();
            $table->unsignedBigInteger('game_round_id')->nullable()->index();
            $table->unsignedBigInteger('game_bet_id')->nullable()->index();
            $table->unsignedBigInteger('game_settlement_id')->nullable()->index();
            $table->unsignedBigInteger('game_settlement_item_id')->nullable()->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('direction')->index();
            $table->decimal('amount', 14, 2);
            $table->decimal('balance_before', 14, 2);
            $table->decimal('balance_after', 14, 2);
            $table->string('reason')->nullable()->index();
            $table->json('meta_json')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bd_game_final_wallet_journals');
    }
}
