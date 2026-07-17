<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bd_game_final_bets', function (Blueprint $table) {
            $this->addIndexIfMissing($table, 'bd_game_final_bets', ['game_round_id', 'canonical_board_key', 'user_id'], 'bdgf_bets_round_board_user_idx');
            $this->addIndexIfMissing($table, 'bd_game_final_bets', ['game_round_id', 'id'], 'bdgf_bets_round_id_idx');
            $this->addIndexIfMissing($table, 'bd_game_final_bets', ['user_id', 'id'], 'bdgf_bets_user_id_idx');
            $this->addIndexIfMissing($table, 'bd_game_final_bets', ['user_id', 'game_id', 'id'], 'bdgf_bets_user_game_id_idx');
        });

        Schema::table('bd_game_final_settlement_items', function (Blueprint $table) {
            $this->addIndexIfMissing($table, 'bd_game_final_settlement_items', ['game_round_id', 'id'], 'bdgf_items_round_id_idx');
            $this->addIndexIfMissing($table, 'bd_game_final_settlement_items', ['user_id', 'id'], 'bdgf_items_user_id_idx');
        });

        Schema::table('bd_game_final_wallet_journals', function (Blueprint $table) {
            $this->addIndexIfMissing($table, 'bd_game_final_wallet_journals', ['user_id', 'id'], 'bdgf_wallet_user_id_idx');
            $this->addIndexIfMissing($table, 'bd_game_final_wallet_journals', ['reason', 'id'], 'bdgf_wallet_reason_id_idx');
        });

        Schema::table('bd_game_final_security_blocks', function (Blueprint $table) {
            $this->addIndexIfMissing($table, 'bd_game_final_security_blocks', ['status', 'lifted_at', 'id'], 'bdgf_blocks_status_lifted_id_idx');
            $this->addIndexIfMissing($table, 'bd_game_final_security_blocks', ['user_id', 'status', 'lifted_at', 'game_id', 'id'], 'bdgf_blocks_user_status_scope_idx');
        });
    }

    public function down(): void
    {
        $this->dropIndexIfExists('bd_game_final_security_blocks', 'bdgf_blocks_user_status_scope_idx');
        $this->dropIndexIfExists('bd_game_final_security_blocks', 'bdgf_blocks_status_lifted_id_idx');
        $this->dropIndexIfExists('bd_game_final_wallet_journals', 'bdgf_wallet_reason_id_idx');
        $this->dropIndexIfExists('bd_game_final_wallet_journals', 'bdgf_wallet_user_id_idx');
        $this->dropIndexIfExists('bd_game_final_settlement_items', 'bdgf_items_user_id_idx');
        $this->dropIndexIfExists('bd_game_final_settlement_items', 'bdgf_items_round_id_idx');
        $this->dropIndexIfExists('bd_game_final_bets', 'bdgf_bets_user_game_id_idx');
        $this->dropIndexIfExists('bd_game_final_bets', 'bdgf_bets_user_id_idx');
        $this->dropIndexIfExists('bd_game_final_bets', 'bdgf_bets_round_id_idx');
        $this->dropIndexIfExists('bd_game_final_bets', 'bdgf_bets_round_board_user_idx');
    }

    protected function addIndexIfMissing(Blueprint $table, string $tableName, array $columns, string $indexName): void
    {
        if (!$this->indexExists($tableName, $indexName)) {
            $table->index($columns, $indexName);
        }
    }

    protected function dropIndexIfExists(string $tableName, string $indexName): void
    {
        if ($this->indexExists($tableName, $indexName)) {
            Schema::table($tableName, function (Blueprint $table) use ($indexName) {
                $table->dropIndex($indexName);
            });
        }
    }

    protected function indexExists(string $tableName, string $indexName): bool
    {
        try {
            return !empty(DB::select('SHOW INDEX FROM `' . $tableName . '` WHERE Key_name = ?', [$indexName]));
        } catch (\Throwable $e) {
            return false;
        }
    }
};
