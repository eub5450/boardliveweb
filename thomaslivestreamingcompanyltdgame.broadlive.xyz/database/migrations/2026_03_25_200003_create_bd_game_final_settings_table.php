<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBdGameFinalSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('bd_game_final_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('game_id')->unique();
            $table->unsignedInteger('bet_duration_sec')->default(30);
            $table->unsignedInteger('stop_duration_sec')->default(3);
            $table->unsignedInteger('reveal_duration_sec')->default(3);
            $table->unsignedInteger('settle_duration_sec')->default(2);
            $table->unsignedInteger('max_distinct_boards_per_user')->default(1);
            $table->decimal('min_bet', 14, 2)->default(1);
            $table->decimal('max_bet', 14, 2)->default(9999999);
            $table->string('risk_mode')->default('safe_low_liability');
            $table->decimal('reserve_buffer', 14, 2)->default(0);
            $table->unsignedInteger('repeat_limit')->default(3);
            $table->string('manual_winner_board')->nullable();
            $table->boolean('manual_lock_enabled')->default(false);
            $table->string('game_status')->default('active');
            $table->decimal('decision_balance_amount', 14, 2)->default(0);
            $table->decimal('healthy_balance_threshold', 14, 2)->default(0);
            $table->boolean('weighted_random_enabled')->default(false);
            $table->unsignedInteger('weighted_random_spread')->default(3);
            $table->unsignedInteger('avoid_last_n_winners')->default(3);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bd_game_final_settings');
    }
}
