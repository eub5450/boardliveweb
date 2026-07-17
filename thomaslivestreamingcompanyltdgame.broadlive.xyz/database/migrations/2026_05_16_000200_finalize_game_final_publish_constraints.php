<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FinalizeGameFinalPublishConstraints extends Migration
{
    public function up()
    {
        Schema::table('bd_game_final_settlements', function (Blueprint $table) {
            if (!Schema::hasColumn('bd_game_final_settlements', 'game_id')) {
                $table->unsignedBigInteger('game_id')->nullable()->after('id');
            }
        });

        // Backfill settlement.game_id from rounds table for existing rows.
        DB::statement("UPDATE bd_game_final_settlements s INNER JOIN bd_game_final_rounds r ON r.id = s.game_round_id SET s.game_id = r.game_id WHERE s.game_id IS NULL");

        Schema::table('bd_game_final_settlements', function (Blueprint $table) {
            if (!$this->indexExists('bd_game_final_settlements', 'bdgf_settlements_game_round_unique')) {
                $table->unique(['game_id', 'game_round_id'], 'bdgf_settlements_game_round_unique');
            }

            if (!$this->indexExists('bd_game_final_settlements', 'bdgf_settlements_game_round_status_idx')) {
                $table->index(['game_id', 'game_round_id', 'settlement_status'], 'bdgf_settlements_game_round_status_idx');
            }
        });

        Schema::table('bd_game_final_tokens', function (Blueprint $table) {
            if (!$this->indexExists('bd_game_final_tokens', 'bdgf_tokens_hash_idx')) {
                $table->index('token_hash', 'bdgf_tokens_hash_idx');
            }

            if (Schema::hasColumn('bd_game_final_tokens', 'expires_at') && !$this->indexExists('bd_game_final_tokens', 'bdgf_tokens_expires_idx')) {
                $table->index('expires_at', 'bdgf_tokens_expires_idx');
            }

            if (Schema::hasColumn('bd_game_final_tokens', 'expired_at') && !$this->indexExists('bd_game_final_tokens', 'bdgf_tokens_expired_idx')) {
                $table->index('expired_at', 'bdgf_tokens_expired_idx');
            }
        });

        Schema::table('bd_game_final_bets', function (Blueprint $table) {
            if (!$this->indexExists('bd_game_final_bets', 'bdgf_bets_game_round_user_status_idx')) {
                $table->index(['game_id', 'game_round_id', 'user_id', 'status'], 'bdgf_bets_game_round_user_status_idx');
            }
        });

        Schema::table('bd_game_final_settlement_items', function (Blueprint $table) {
            if (!$this->indexExists('bd_game_final_settlement_items', 'bdgf_settlement_items_round_user_status_idx')) {
                $table->index(['game_round_id', 'user_id', 'result_status'], 'bdgf_settlement_items_round_user_status_idx');
            }
        });

        Schema::table('bd_game_final_wallet_journals', function (Blueprint $table) {
            if (Schema::hasColumn('bd_game_final_wallet_journals', 'reference_uid') && !$this->indexExists('bd_game_final_wallet_journals', 'bdgf_wallet_reference_uid_unique')) {
                $table->unique('reference_uid', 'bdgf_wallet_reference_uid_unique');
            }

            if (!$this->indexExists('bd_game_final_wallet_journals', 'bdgf_wallet_game_round_user_direction_idx')) {
                $table->index(['game_id', 'game_round_id', 'user_id', 'direction'], 'bdgf_wallet_game_round_user_direction_idx');
            }
        });
    }

    public function down()
    {
        Schema::table('bd_game_final_wallet_journals', function (Blueprint $table) {
            if ($this->indexExists('bd_game_final_wallet_journals', 'bdgf_wallet_game_round_user_direction_idx')) {
                $table->dropIndex('bdgf_wallet_game_round_user_direction_idx');
            }

            if ($this->indexExists('bd_game_final_wallet_journals', 'bdgf_wallet_reference_uid_unique')) {
                $table->dropUnique('bdgf_wallet_reference_uid_unique');
            }
        });

        Schema::table('bd_game_final_settlement_items', function (Blueprint $table) {
            if ($this->indexExists('bd_game_final_settlement_items', 'bdgf_settlement_items_round_user_status_idx')) {
                $table->dropIndex('bdgf_settlement_items_round_user_status_idx');
            }
        });

        Schema::table('bd_game_final_bets', function (Blueprint $table) {
            if ($this->indexExists('bd_game_final_bets', 'bdgf_bets_game_round_user_status_idx')) {
                $table->dropIndex('bdgf_bets_game_round_user_status_idx');
            }
        });

        Schema::table('bd_game_final_tokens', function (Blueprint $table) {
            if ($this->indexExists('bd_game_final_tokens', 'bdgf_tokens_hash_idx')) {
                $table->dropIndex('bdgf_tokens_hash_idx');
            }

            if ($this->indexExists('bd_game_final_tokens', 'bdgf_tokens_expires_idx')) {
                $table->dropIndex('bdgf_tokens_expires_idx');
            }

            if ($this->indexExists('bd_game_final_tokens', 'bdgf_tokens_expired_idx')) {
                $table->dropIndex('bdgf_tokens_expired_idx');
            }
        });

        Schema::table('bd_game_final_settlements', function (Blueprint $table) {
            if ($this->indexExists('bd_game_final_settlements', 'bdgf_settlements_game_round_status_idx')) {
                $table->dropIndex('bdgf_settlements_game_round_status_idx');
            }

            if ($this->indexExists('bd_game_final_settlements', 'bdgf_settlements_game_round_unique')) {
                $table->dropUnique('bdgf_settlements_game_round_unique');
            }

            if (Schema::hasColumn('bd_game_final_settlements', 'game_id')) {
                $table->dropColumn('game_id');
            }
        });
    }

    protected function indexExists(string $table, string $indexName): bool
    {
        $rows = DB::select("SHOW INDEX FROM {$table} WHERE Key_name = ?", [$indexName]);
        return !empty($rows);
    }
}
