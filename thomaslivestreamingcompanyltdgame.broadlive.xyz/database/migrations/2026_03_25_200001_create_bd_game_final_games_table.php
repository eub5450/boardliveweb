<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBdGameFinalGamesTable extends Migration
{
    public function up()
    {
        Schema::create('bd_game_final_games', function (Blueprint $table) {
            $table->id();
            $table->string('game_code')->unique();
            $table->string('name');
            $table->boolean('is_active')->default(1);
            $table->string('frontend_slug')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bd_game_final_games');
    }
}
