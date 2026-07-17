<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('bd_game_final_security_blocks')) {
            return;
        }

        Schema::create('bd_game_final_security_blocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('game_id')->nullable()->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('reason', 255);
            $table->string('trigger', 80)->nullable();
            $table->string('ip_address', 64)->nullable();
            $table->string('user_agent', 255)->nullable();
            $table->string('status', 20)->default('active')->index();
            $table->timestamp('blocked_at')->nullable()->index();
            $table->timestamp('lifted_at')->nullable();
            $table->json('meta_json')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index(['game_id', 'user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bd_game_final_security_blocks');
    }
};
