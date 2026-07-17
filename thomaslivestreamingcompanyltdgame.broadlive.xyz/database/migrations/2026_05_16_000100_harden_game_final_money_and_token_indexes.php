<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class HardenGameFinalMoneyAndTokenIndexes extends Migration
{
    protected function indexExists($table, $index)
    {
        return !empty(DB::select('SHOW INDEX FROM `' . $table . '` WHERE Key_name = ?', [$index]));
    }

    public function up()
    {
        Schema::table('bd_game_final_wallet_journals', function (Blueprint $table) {
            if (!Schema::hasColumn('bd_game_final_wallet_journals', 'reference_uid')) {
                $table->string('reference_uid', 120)->nullable()->after('game_settlement_item_id');
            }
        });

        Schema::table('bd_game_final_wallet_journals', function (Blueprint $table) {
            if (!$this->indexExists('bd_game_final_wallet_journals', 'bdgf_wallet_reference_uid_unique')) {
                $table->unique('reference_uid', 'bdgf_wallet_reference_uid_unique');
            }
            if (!$this->indexExists('bd_game_final_wallet_journals', 'bdgf_wallet_user_direction_created_idx')) {
                $table->index(['user_id', 'direction', 'created_at'], 'bdgf_wallet_user_direction_created_idx');
            }
        });

        Schema::table('bd_game_final_settlement_items', function (Blueprint $table) {
            if (!$this->indexExists('bd_game_final_settlement_items', 'bdgf_settlement_items_game_bet_unique')) {
                $table->unique('game_bet_id', 'bdgf_settlement_items_game_bet_unique');
            }
            if (!$this->indexExists('bd_game_final_settlement_items', 'bdgf_settlement_items_round_user_status_idx')) {
                $table->index(['game_round_id', 'user_id', 'result_status'], 'bdgf_settlement_items_round_user_status_idx');
            }
        });

        Schema::table('bd_game_final_bets', function (Blueprint $table) {
            if (!$this->indexExists('bd_game_final_bets', 'bdgf_bets_round_status_user_idx')) {
                $table->index(['game_round_id', 'status', 'user_id'], 'bdgf_bets_round_status_user_idx');
            }
        });

        Schema::table('bd_game_final_tokens', function (Blueprint $table) {
            if (!$this->indexExists('bd_game_final_tokens', 'bdgf_tokens_type_revoked_expires_idx')) {
                $table->index(['token_type', 'revoked_at', 'expires_at'], 'bdgf_tokens_type_revoked_expires_idx');
            }
            if (!$this->indexExists('bd_game_final_tokens', 'bdgf_tokens_game_user_type_idx')) {
                $table->index(['game_id', 'user_id', 'token_type'], 'bdgf_tokens_game_user_type_idx');
            }
        });

        Schema::table('bd_game_final_heartbeats', function (Blueprint $table) {
            if (!$this->indexExists('bd_game_final_heartbeats', 'bdgf_heartbeats_seen_game_idx')) {
                $table->index(['last_seen_at', 'game_id'], 'bdgf_heartbeats_seen_game_idx');
            }
        });
    }

    public function down()
    {
        Schema::table('bd_game_final_heartbeats', function (Blueprint $table) {
            $table->dropIndex('bdgf_heartbeats_seen_game_idx');
        });

        Schema::table('bd_game_final_tokens', function (Blueprint $table) {
            $table->dropIndex('bdgf_tokens_type_revoked_expires_idx');
            $table->dropIndex('bdgf_tokens_game_user_type_idx');
        });

        Schema::table('bd_game_final_bets', function (Blueprint $table) {
            $table->dropIndex('bdgf_bets_round_status_user_idx');
        });

        Schema::table('bd_game_final_settlement_items', function (Blueprint $table) {
            $table->dropUnique('bdgf_settlement_items_game_bet_unique');
            $table->dropIndex('bdgf_settlement_items_round_user_status_idx');
        });

        Schema::table('bd_game_final_wallet_journals', function (Blueprint $table) {
            $table->dropUnique('bdgf_wallet_reference_uid_unique');
            $table->dropIndex('bdgf_wallet_user_direction_created_idx');
            if (Schema::hasColumn('bd_game_final_wallet_journals', 'reference_uid')) {
                $table->dropColumn('reference_uid');
            }
        });
    }
}
