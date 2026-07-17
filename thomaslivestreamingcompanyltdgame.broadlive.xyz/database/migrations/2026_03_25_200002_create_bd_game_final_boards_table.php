<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBdGameFinalBoardsTable extends Migration
{
    public function up()
    {
        Schema::create('bd_game_final_boards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('game_id')->index();
            $table->string('frontend_key');
            $table->string('canonical_key')->index();
            $table->string('display_name');
            $table->decimal('payout_multiplier', 12, 2)->default(1);
            $table->unsignedInteger('display_order')->default(0);
            $table->boolean('is_active')->default(1);
            $table->json('ui_meta_json')->nullable();
            $table->timestamps();
            $table->unique(['game_id', 'canonical_key']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('bd_game_final_boards');
    }
}
