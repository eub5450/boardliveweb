-- GameFinal setup-only SQL export
-- Generated: 2026-06-03 23:00:33 +06:00
-- Source database: play_local
-- Includes schema for all bd_game_final_* tables.
-- Includes data only for setup tables: bd_game_final_games, bd_game_final_boards, bd_game_final_settings, bd_game_final_runtime_settings
-- Runtime tables exported empty: bd_game_final_audit_logs, bd_game_final_bet_summaries, bd_game_final_bets, bd_game_final_heartbeats, bd_game_final_rounds, bd_game_final_security_blocks, bd_game_final_settlement_items, bd_game_final_settlements, bd_game_final_tokens, bd_game_final_wallet_journals
-- Excludes users table and all non-GameFinal tables.

SET FOREIGN_KEY_CHECKS=0;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `bd_game_final_audit_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bd_game_final_audit_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `game_id` bigint(20) unsigned DEFAULT NULL,
  `game_round_id` bigint(20) unsigned DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `event_type` varchar(255) NOT NULL,
  `message` varchar(255) DEFAULT NULL,
  `payload_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`payload_json`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bd_game_final_audit_logs_game_id_index` (`game_id`),
  KEY `bd_game_final_audit_logs_game_round_id_index` (`game_round_id`),
  KEY `bd_game_final_audit_logs_user_id_index` (`user_id`),
  KEY `bd_game_final_audit_logs_event_type_index` (`event_type`)
) ENGINE=InnoDB AUTO_INCREMENT=9735 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `bd_game_final_bet_summaries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bd_game_final_bet_summaries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `game_id` bigint(20) unsigned NOT NULL,
  `game_round_id` bigint(20) unsigned NOT NULL,
  `canonical_board_key` varchar(255) NOT NULL,
  `total_amount` decimal(14,2) NOT NULL DEFAULT 0.00,
  `total_players` int(10) unsigned NOT NULL DEFAULT 0,
  `potential_payout` decimal(14,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bdgf_bet_summaries_round_board_unique` (`game_round_id`,`canonical_board_key`),
  KEY `bd_game_final_bet_summaries_game_id_index` (`game_id`),
  KEY `bd_game_final_bet_summaries_game_round_id_index` (`game_round_id`),
  KEY `bd_game_final_bet_summaries_canonical_board_key_index` (`canonical_board_key`)
) ENGINE=InnoDB AUTO_INCREMENT=28730 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `bd_game_final_bets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bd_game_final_bets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `game_id` bigint(20) unsigned NOT NULL,
  `game_round_id` bigint(20) unsigned NOT NULL,
  `round_no` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `amount` decimal(14,2) NOT NULL,
  `frontend_board_key` varchar(255) NOT NULL,
  `canonical_board_key` varchar(255) NOT NULL,
  `payout_multiplier` decimal(12,2) NOT NULL DEFAULT 1.00,
  `potential_win` decimal(14,2) NOT NULL DEFAULT 0.00,
  `win_balance` decimal(14,2) NOT NULL DEFAULT 0.00,
  `now_user_balance` decimal(14,2) NOT NULL DEFAULT 0.00,
  `request_uid` varchar(255) DEFAULT NULL,
  `settlement_item_id` bigint(20) unsigned DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `meta_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta_json`)),
  `settled_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bd_game_final_bets_request_uid_unique` (`request_uid`),
  KEY `bd_game_final_bets_game_id_index` (`game_id`),
  KEY `bd_game_final_bets_game_round_id_index` (`game_round_id`),
  KEY `bd_game_final_bets_round_no_index` (`round_no`),
  KEY `bd_game_final_bets_user_id_index` (`user_id`),
  KEY `bd_game_final_bets_frontend_board_key_index` (`frontend_board_key`),
  KEY `bd_game_final_bets_canonical_board_key_index` (`canonical_board_key`),
  KEY `bd_game_final_bets_settlement_item_id_index` (`settlement_item_id`),
  KEY `bd_game_final_bets_status_index` (`status`),
  KEY `bdgf_bets_round_status_user_idx` (`game_round_id`,`status`,`user_id`),
  KEY `bdgf_bets_game_round_user_status_idx` (`game_id`,`game_round_id`,`user_id`,`status`),
  KEY `bdgf_bets_round_board_user_idx` (`game_round_id`,`canonical_board_key`,`user_id`),
  KEY `bdgf_bets_round_id_idx` (`game_round_id`,`id`),
  KEY `bdgf_bets_user_id_idx` (`user_id`,`id`),
  KEY `bdgf_bets_user_game_id_idx` (`user_id`,`game_id`,`id`)
) ENGINE=InnoDB AUTO_INCREMENT=473 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `bd_game_final_boards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bd_game_final_boards` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `game_id` bigint(20) unsigned NOT NULL,
  `frontend_key` varchar(255) NOT NULL,
  `canonical_key` varchar(255) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  `payout_multiplier` decimal(12,2) NOT NULL DEFAULT 1.00,
  `display_order` int(10) unsigned NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `ui_meta_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`ui_meta_json`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bd_game_final_boards_game_id_canonical_key_unique` (`game_id`,`canonical_key`),
  KEY `bd_game_final_boards_game_id_index` (`game_id`),
  KEY `bd_game_final_boards_canonical_key_index` (`canonical_key`)
) ENGINE=InnoDB AUTO_INCREMENT=114 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `bd_game_final_games`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bd_game_final_games` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `game_code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `frontend_slug` varchar(255) DEFAULT NULL,
  `sort_order` int(10) unsigned NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bd_game_final_games_game_code_unique` (`game_code`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `bd_game_final_heartbeats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bd_game_final_heartbeats` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `game_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `game_round_id` bigint(20) unsigned DEFAULT NULL,
  `network_ms` int(11) DEFAULT NULL,
  `client_meta_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`client_meta_json`)),
  `last_seen_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bd_game_final_heartbeats_game_id_user_id_unique` (`game_id`,`user_id`),
  KEY `bd_game_final_heartbeats_game_id_index` (`game_id`),
  KEY `bd_game_final_heartbeats_user_id_index` (`user_id`),
  KEY `bd_game_final_heartbeats_game_round_id_index` (`game_round_id`),
  KEY `bd_game_final_heartbeats_last_seen_at_index` (`last_seen_at`),
  KEY `bdgf_heartbeats_seen_game_idx` (`last_seen_at`,`game_id`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `bd_game_final_rounds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bd_game_final_rounds` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `game_id` bigint(20) unsigned NOT NULL,
  `round_no` varchar(255) NOT NULL,
  `start_at` timestamp NULL DEFAULT NULL,
  `bet_close_at` timestamp NULL DEFAULT NULL,
  `reveal_at` timestamp NULL DEFAULT NULL,
  `settle_at` timestamp NULL DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'betting',
  `winner_board_key` varchar(255) DEFAULT NULL,
  `decision_mode` varchar(255) DEFAULT NULL,
  `decision_snapshot_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`decision_snapshot_json`)),
  `result_payload_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`result_payload_json`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bd_game_final_rounds_game_id_round_no_unique` (`game_id`,`round_no`),
  KEY `bd_game_final_rounds_game_id_index` (`game_id`),
  KEY `bd_game_final_rounds_round_no_index` (`round_no`),
  KEY `bd_game_final_rounds_status_index` (`status`),
  KEY `bd_game_final_rounds_winner_board_key_index` (`winner_board_key`)
) ENGINE=InnoDB AUTO_INCREMENT=9047 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `bd_game_final_runtime_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bd_game_final_runtime_settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(100) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bd_game_final_runtime_settings_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=111 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `bd_game_final_security_blocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bd_game_final_security_blocks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `game_id` bigint(20) unsigned DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `reason` varchar(255) NOT NULL,
  `trigger` varchar(80) DEFAULT NULL,
  `ip_address` varchar(64) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'active',
  `blocked_at` timestamp NULL DEFAULT NULL,
  `lifted_at` timestamp NULL DEFAULT NULL,
  `meta_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta_json`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bd_game_final_security_blocks_user_id_status_index` (`user_id`,`status`),
  KEY `bd_game_final_security_blocks_game_id_user_id_status_index` (`game_id`,`user_id`,`status`),
  KEY `bd_game_final_security_blocks_game_id_index` (`game_id`),
  KEY `bd_game_final_security_blocks_user_id_index` (`user_id`),
  KEY `bd_game_final_security_blocks_status_index` (`status`),
  KEY `bd_game_final_security_blocks_blocked_at_index` (`blocked_at`),
  KEY `bdgf_blocks_status_lifted_id_idx` (`status`,`lifted_at`,`id`),
  KEY `bdgf_blocks_user_status_scope_idx` (`user_id`,`status`,`lifted_at`,`game_id`,`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `bd_game_final_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bd_game_final_settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `game_id` bigint(20) unsigned NOT NULL,
  `bet_duration_sec` int(10) unsigned NOT NULL DEFAULT 30,
  `start_bet_popup_sec` decimal(5,2) NOT NULL DEFAULT 3.00,
  `start_bet_wait_sec` decimal(5,2) NOT NULL DEFAULT 1.50,
  `stop_bet_popup_sec` decimal(5,2) NOT NULL DEFAULT 3.00,
  `stop_bet_wait_sec` decimal(5,2) NOT NULL DEFAULT 1.50,
  `stop_duration_sec` decimal(5,2) NOT NULL DEFAULT 4.50,
  `reveal_duration_sec` decimal(5,2) unsigned NOT NULL DEFAULT 6.00,
  `reveal_wait_sec` decimal(5,2) NOT NULL DEFAULT 2.00,
  `winner_popup_sec` decimal(5,2) NOT NULL DEFAULT 1.00,
  `winner_wait_sec` decimal(5,2) NOT NULL DEFAULT 0.50,
  `settle_duration_sec` decimal(5,2) unsigned NOT NULL DEFAULT 2.50,
  `settle_wait_sec` decimal(5,2) NOT NULL DEFAULT 1.00,
  `max_distinct_boards_per_user` int(10) unsigned NOT NULL DEFAULT 1,
  `min_bet` decimal(14,2) NOT NULL DEFAULT 1.00,
  `max_bet` decimal(14,2) NOT NULL DEFAULT 9999999.00,
  `risk_mode` varchar(255) NOT NULL DEFAULT 'safe_low_liability',
  `reserve_buffer` decimal(14,2) NOT NULL DEFAULT 0.00,
  `repeat_limit` int(10) unsigned NOT NULL DEFAULT 3,
  `manual_winner_board` varchar(255) DEFAULT NULL,
  `manual_lock_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `game_status` varchar(255) NOT NULL DEFAULT 'active',
  `maintenance_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `maintenance_allowed_user_id` bigint(20) unsigned DEFAULT NULL,
  `maintenance_message` varchar(255) DEFAULT NULL,
  `ui_meta_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`ui_meta_json`)),
  `decision_balance_amount` decimal(14,2) NOT NULL DEFAULT 0.00,
  `healthy_balance_threshold` decimal(14,2) NOT NULL DEFAULT 0.00,
  `weighted_random_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `weighted_random_spread` int(10) unsigned NOT NULL DEFAULT 3,
  `avoid_last_n_winners` int(10) unsigned NOT NULL DEFAULT 3,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bd_game_final_settings_game_id_unique` (`game_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `bd_game_final_settlement_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bd_game_final_settlement_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `game_settlement_id` bigint(20) unsigned NOT NULL,
  `game_round_id` bigint(20) unsigned NOT NULL,
  `game_bet_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `canonical_board_key` varchar(255) NOT NULL,
  `bet_amount` decimal(14,2) NOT NULL DEFAULT 0.00,
  `payout_multiplier` decimal(12,2) NOT NULL DEFAULT 1.00,
  `win_amount` decimal(14,2) NOT NULL DEFAULT 0.00,
  `net_result` decimal(14,2) NOT NULL DEFAULT 0.00,
  `result_status` varchar(255) NOT NULL DEFAULT 'lost',
  `wallet_before` decimal(14,2) NOT NULL DEFAULT 0.00,
  `wallet_after` decimal(14,2) NOT NULL DEFAULT 0.00,
  `meta_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta_json`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bdgf_settlement_items_game_bet_unique` (`game_bet_id`),
  KEY `bd_game_final_settlement_items_game_settlement_id_index` (`game_settlement_id`),
  KEY `bd_game_final_settlement_items_game_round_id_index` (`game_round_id`),
  KEY `bd_game_final_settlement_items_game_bet_id_index` (`game_bet_id`),
  KEY `bd_game_final_settlement_items_user_id_index` (`user_id`),
  KEY `bd_game_final_settlement_items_canonical_board_key_index` (`canonical_board_key`),
  KEY `bd_game_final_settlement_items_result_status_index` (`result_status`),
  KEY `bdgf_settlement_items_round_user_status_idx` (`game_round_id`,`user_id`,`result_status`),
  KEY `bdgf_items_round_id_idx` (`game_round_id`,`id`),
  KEY `bdgf_items_user_id_idx` (`user_id`,`id`)
) ENGINE=InnoDB AUTO_INCREMENT=473 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `bd_game_final_settlements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bd_game_final_settlements` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `game_id` bigint(20) unsigned DEFAULT NULL,
  `game_round_id` bigint(20) unsigned NOT NULL,
  `winner_board_key` varchar(255) DEFAULT NULL,
  `settlement_run_uid` varchar(255) DEFAULT NULL,
  `settlement_status` varchar(255) NOT NULL DEFAULT 'processing',
  `total_bet_amount` decimal(14,2) NOT NULL DEFAULT 0.00,
  `total_payout_amount` decimal(14,2) NOT NULL DEFAULT 0.00,
  `total_winning_bets` int(10) unsigned NOT NULL DEFAULT 0,
  `total_losing_bets` int(10) unsigned NOT NULL DEFAULT 0,
  `net_house_result` decimal(14,2) NOT NULL DEFAULT 0.00,
  `meta_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta_json`)),
  `settled_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bd_game_final_settlements_game_round_id_unique` (`game_round_id`),
  UNIQUE KEY `bdgf_settlements_game_round_unique` (`game_id`,`game_round_id`),
  KEY `bd_game_final_settlements_winner_board_key_index` (`winner_board_key`),
  KEY `bd_game_final_settlements_settlement_run_uid_index` (`settlement_run_uid`),
  KEY `bd_game_final_settlements_settlement_status_index` (`settlement_status`),
  KEY `bdgf_settlements_game_round_status_idx` (`game_id`,`game_round_id`,`settlement_status`)
) ENGINE=InnoDB AUTO_INCREMENT=9083 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `bd_game_final_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bd_game_final_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `game_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `token_hash` varchar(40) NOT NULL,
  `token_type` varchar(255) NOT NULL DEFAULT 'entry',
  `parent_token_id` bigint(20) unsigned DEFAULT NULL,
  `device_fingerprint` varchar(64) DEFAULT NULL,
  `meta_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta_json`)),
  `issued_at` timestamp NULL DEFAULT NULL,
  `last_seen_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `revoked_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bd_game_final_tokens_game_id_index` (`game_id`),
  KEY `bd_game_final_tokens_user_id_index` (`user_id`),
  KEY `bd_game_final_tokens_token_hash_index` (`token_hash`),
  KEY `bd_game_final_tokens_token_type_index` (`token_type`),
  KEY `bd_game_final_tokens_parent_token_id_index` (`parent_token_id`),
  KEY `bd_game_final_tokens_device_fingerprint_index` (`device_fingerprint`),
  KEY `bd_game_final_tokens_expires_at_index` (`expires_at`),
  KEY `bd_game_final_tokens_revoked_at_index` (`revoked_at`),
  KEY `bdgf_tokens_type_revoked_expires_idx` (`token_type`,`revoked_at`,`expires_at`),
  KEY `bdgf_tokens_game_user_type_idx` (`game_id`,`user_id`,`token_type`),
  KEY `bdgf_tokens_hash_idx` (`token_hash`),
  KEY `bdgf_tokens_expires_idx` (`expires_at`)
) ENGINE=InnoDB AUTO_INCREMENT=3764 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `bd_game_final_wallet_journals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bd_game_final_wallet_journals` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `game_id` bigint(20) unsigned DEFAULT NULL,
  `game_round_id` bigint(20) unsigned DEFAULT NULL,
  `game_bet_id` bigint(20) unsigned DEFAULT NULL,
  `game_settlement_id` bigint(20) unsigned DEFAULT NULL,
  `game_settlement_item_id` bigint(20) unsigned DEFAULT NULL,
  `reference_uid` varchar(120) DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `direction` varchar(255) NOT NULL,
  `amount` decimal(14,2) NOT NULL,
  `balance_before` decimal(14,2) NOT NULL,
  `balance_after` decimal(14,2) NOT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `meta_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta_json`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bdgf_wallet_reference_uid_unique` (`reference_uid`),
  KEY `bd_game_final_wallet_journals_game_id_index` (`game_id`),
  KEY `bd_game_final_wallet_journals_game_round_id_index` (`game_round_id`),
  KEY `bd_game_final_wallet_journals_game_bet_id_index` (`game_bet_id`),
  KEY `bd_game_final_wallet_journals_game_settlement_id_index` (`game_settlement_id`),
  KEY `bd_game_final_wallet_journals_game_settlement_item_id_index` (`game_settlement_item_id`),
  KEY `bd_game_final_wallet_journals_user_id_index` (`user_id`),
  KEY `bd_game_final_wallet_journals_direction_index` (`direction`),
  KEY `bd_game_final_wallet_journals_reason_index` (`reason`),
  KEY `bdgf_wallet_user_direction_created_idx` (`user_id`,`direction`,`created_at`),
  KEY `bdgf_wallet_game_round_user_direction_idx` (`game_id`,`game_round_id`,`user_id`,`direction`),
  KEY `bdgf_wallet_user_id_idx` (`user_id`,`id`),
  KEY `bdgf_wallet_reason_id_idx` (`reason`,`id`)
) ENGINE=InnoDB AUTO_INCREMENT=970 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;


-- Setup data only

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

LOCK TABLES `bd_game_final_games` WRITE;
/*!40000 ALTER TABLE `bd_game_final_games` DISABLE KEYS */;
INSERT INTO `bd_game_final_games` (`id`, `game_code`, `name`, `is_active`, `frontend_slug`, `sort_order`, `created_at`, `updated_at`) VALUES (1,'fruits_loop','Fruits Loop',1,'fruits_loop',24,'2026-05-25 01:56:18','2026-05-31 05:56:40'),(2,'teen_patti','Teen Patti',1,'teen_patti',1,'2026-05-25 08:38:31','2026-05-31 05:56:40'),(3,'teen_patti_king','TeenPatti King',1,'teen_patti_king',2,'2026-05-25 08:38:31','2026-05-31 05:56:40'),(4,'teen_patti_sultan','TeenPatti Sultan',1,'teen_patti_sultan',3,'2026-05-25 08:38:31','2026-05-31 05:56:40'),(5,'teen_patti_warfront','TeenPatti Warfront',1,'teen_patti_warfront',4,'2026-05-25 08:38:31','2026-05-31 05:56:40'),(6,'teen_patti_neon','TeenPatti Neon Blitz',1,'teen_patti_neon',5,'2026-05-25 08:38:31','2026-05-31 05:56:40'),(7,'teen_patti_shogun','TeenPatti Shogun',1,'teen_patti_shogun',6,'2026-05-25 08:38:31','2026-05-31 05:56:40'),(8,'teen_patti_glacier','TeenPatti Glacier',1,'teen_patti_glacier',7,'2026-05-25 08:38:31','2026-05-31 05:56:40'),(9,'lucky77','Lucky 77',1,'lucky77',8,'2026-05-25 08:38:31','2026-05-31 05:56:40'),(10,'lucky77_max','BD Lucky 77 Max',1,'lucky77_max',9,'2026-05-25 08:38:31','2026-05-31 05:56:40'),(11,'lucky7_pro','Lucky 7 Pro',1,'lucky7_pro',10,'2026-05-25 08:38:31','2026-05-31 05:56:40'),(12,'lucky77_mirage','Lucky 77 Mirage',1,'lucky77_mirage',11,'2026-05-25 08:38:31','2026-05-31 05:56:40'),(13,'lucky77_ironfront','Lucky 77 Iron Front',1,'lucky77_ironfront',12,'2026-05-25 08:38:31','2026-05-31 05:56:40'),(14,'lucky77_lotus','Lucky 77 Lotus',1,'lucky77_lotus',13,'2026-05-25 08:38:31','2026-05-31 05:56:40'),(15,'lucky77_nebula','Lucky 77 Nebula',1,'lucky77_nebula',14,'2026-05-25 08:38:31','2026-05-31 05:56:40'),(16,'lucky77_carnival','Lucky 77 Carnival',1,'lucky77_carnival',15,'2026-05-25 08:38:31','2026-05-31 05:56:40'),(17,'lucky88_master','Lucky 88 Master',1,'lucky88_master',16,'2026-05-25 08:38:31','2026-05-31 05:56:40'),(18,'fruit_slot','Fruit Slot',1,'fruit_slot',17,'2026-05-25 08:38:31','2026-05-31 05:56:40'),(19,'fruit_slot_oasis','Fruit Slot Oasis',1,'fruit_slot_oasis',18,'2026-05-25 08:38:31','2026-05-31 05:56:40'),(20,'fruit_slot_arsenal','Fruit Slot Arsenal',1,'fruit_slot_arsenal',19,'2026-05-25 08:38:31','2026-05-31 05:56:40'),(21,'fruit_slot_arcade','Fruit Slot Neon Arcade',1,'fruit_slot_arcade',20,'2026-05-25 08:38:32','2026-05-31 05:56:40'),(22,'fruit_slot_lotus','Fruit Slot Lotus Garden',1,'fruit_slot_lotus',21,'2026-05-25 08:38:32','2026-05-31 05:56:40'),(23,'fruit_slot_glacier','Fruit Slot Glacier Spin',1,'fruit_slot_glacier',22,'2026-05-25 08:38:32','2026-05-31 05:56:40'),(24,'fruits_loop_ruby','Fruits Loop Ruby',1,'fruits_loop_ruby',25,'2026-05-27 05:16:50','2026-05-31 05:56:40'),(25,'fruits_loop_emerald','Fruits Loop Emerald',1,'fruits_loop_emerald',26,'2026-05-27 05:16:50','2026-05-31 05:56:40'),(26,'greedy','Greedy',1,'greedy',23,'2026-05-29 15:36:36','2026-05-31 05:56:40');
/*!40000 ALTER TABLE `bd_game_final_games` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `bd_game_final_boards` WRITE;
/*!40000 ALTER TABLE `bd_game_final_boards` DISABLE KEYS */;
INSERT INTO `bd_game_final_boards` (`id`, `game_id`, `frontend_key`, `canonical_key`, `display_name`, `payout_multiplier`, `display_order`, `is_active`, `ui_meta_json`, `created_at`, `updated_at`) VALUES (1,1,'apple','apple','Apple',3.00,1,1,NULL,'2026-05-25 01:56:18','2026-05-31 17:07:38'),(2,1,'orange','orange','Orange',3.00,2,1,NULL,'2026-05-25 01:56:18','2026-05-31 17:07:38'),(3,1,'grapes','grapes','Grapes',3.00,3,1,NULL,'2026-05-25 01:56:18','2026-05-31 17:07:38'),(4,2,'A','A','A',3.00,1,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(5,2,'B','B','B',3.00,2,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(6,2,'C','C','C',3.00,3,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(7,3,'A','A','A',3.00,1,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(8,3,'B','B','B',3.00,2,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(9,3,'C','C','C',3.00,3,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(10,4,'A','A','A',3.00,1,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(11,4,'B','B','B',3.00,2,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(12,4,'C','C','C',3.00,3,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(13,5,'A','A','A',3.00,1,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(14,5,'B','B','B',3.00,2,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(15,5,'C','C','C',3.00,3,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(16,6,'A','A','A',3.00,1,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(17,6,'B','B','B',3.00,2,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(18,6,'C','C','C',3.00,3,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(19,7,'A','A','A',3.00,1,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(20,7,'B','B','B',3.00,2,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(21,7,'C','C','C',3.00,3,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(22,8,'A','A','A',3.00,1,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(23,8,'B','B','B',3.00,2,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(24,8,'C','C','C',3.00,3,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(25,9,'melon','melon','Melon',2.00,1,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(26,9,'slot','slot','77',7.00,2,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(27,9,'plum','plum','Plum',2.00,3,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(28,10,'melon','melon','Melon',2.00,1,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(29,10,'slot','slot','77',7.00,2,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(30,10,'plum','plum','Plum',2.00,3,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(31,11,'melon','melon','Melon',2.00,1,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(32,11,'slot','slot','77',7.00,2,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(33,11,'plum','plum','Plum',2.00,3,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(34,12,'melon','melon','Melon',2.00,1,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(35,12,'slot','slot','77',7.00,2,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(36,12,'plum','plum','Plum',2.00,3,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(37,13,'melon','melon','Melon',2.00,1,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(38,13,'slot','slot','77',7.00,2,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(39,13,'plum','plum','Plum',2.00,3,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(40,14,'melon','melon','Melon',2.00,1,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(41,14,'slot','slot','77',7.00,2,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(42,14,'plum','plum','Plum',2.00,3,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(43,15,'melon','melon','Melon',2.00,1,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(44,15,'slot','slot','77',7.00,2,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(45,15,'plum','plum','Plum',2.00,3,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(46,16,'melon','melon','Melon',2.00,1,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(47,16,'slot','slot','77',7.00,2,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(48,16,'plum','plum','Plum',2.00,3,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(49,17,'melon','melon','Melon',2.00,1,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(50,17,'slot','slot','88',7.00,2,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(51,17,'plum','plum','Plum',2.00,3,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(52,18,'apple','apple','Apple',5.00,1,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(53,18,'watermelon','watermelon','Watermelon',45.00,2,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(54,18,'cherry','cherry','Cherry',25.00,3,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(55,18,'banana','banana','Banana',5.00,4,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(56,18,'grapes','grapes','Grapes',15.00,5,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(57,18,'orange','orange','Orange',5.00,6,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(58,18,'mango','mango','Mango',5.00,7,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(59,18,'pineapple','pineapple','Pineapple',10.00,8,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(60,19,'apple','apple','Apple',5.00,1,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(61,19,'watermelon','watermelon','Watermelon',45.00,2,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(62,19,'cherry','cherry','Cherry',25.00,3,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(63,19,'banana','banana','Banana',5.00,4,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(64,19,'grapes','grapes','Grapes',15.00,5,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(65,19,'orange','orange','Orange',5.00,6,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(66,19,'mango','mango','Mango',5.00,7,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(67,19,'pineapple','pineapple','Pineapple',10.00,8,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(68,20,'apple','apple','Apple',5.00,1,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(69,20,'watermelon','watermelon','Watermelon',45.00,2,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(70,20,'cherry','cherry','Cherry',25.00,3,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(71,20,'banana','banana','Banana',5.00,4,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(72,20,'grapes','grapes','Grapes',15.00,5,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(73,20,'orange','orange','Orange',5.00,6,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(74,20,'mango','mango','Mango',5.00,7,1,NULL,'2026-05-25 08:38:31','2026-05-31 17:07:38'),(75,20,'pineapple','pineapple','Pineapple',10.00,8,1,NULL,'2026-05-25 08:38:32','2026-05-31 17:07:38'),(76,21,'apple','apple','Apple',5.00,1,1,NULL,'2026-05-25 08:38:32','2026-05-31 17:07:38'),(77,21,'watermelon','watermelon','Watermelon',45.00,2,1,NULL,'2026-05-25 08:38:32','2026-05-31 17:07:38'),(78,21,'cherry','cherry','Cherry',25.00,3,1,NULL,'2026-05-25 08:38:32','2026-05-31 17:07:38'),(79,21,'banana','banana','Banana',5.00,4,1,NULL,'2026-05-25 08:38:32','2026-05-31 17:07:38'),(80,21,'grapes','grapes','Grapes',15.00,5,1,NULL,'2026-05-25 08:38:32','2026-05-31 17:07:38'),(81,21,'orange','orange','Orange',5.00,6,1,NULL,'2026-05-25 08:38:32','2026-05-31 17:07:38'),(82,21,'mango','mango','Mango',5.00,7,1,NULL,'2026-05-25 08:38:32','2026-05-31 17:07:38'),(83,21,'pineapple','pineapple','Pineapple',10.00,8,1,NULL,'2026-05-25 08:38:32','2026-05-31 17:07:38'),(84,22,'apple','apple','Apple',5.00,1,1,NULL,'2026-05-25 08:38:32','2026-05-31 17:07:38'),(85,22,'watermelon','watermelon','Watermelon',45.00,2,1,NULL,'2026-05-25 08:38:32','2026-05-31 17:07:38'),(86,22,'cherry','cherry','Cherry',25.00,3,1,NULL,'2026-05-25 08:38:32','2026-05-31 17:07:38'),(87,22,'banana','banana','Banana',5.00,4,1,NULL,'2026-05-25 08:38:32','2026-05-31 17:07:38'),(88,22,'grapes','grapes','Grapes',15.00,5,1,NULL,'2026-05-25 08:38:32','2026-05-31 17:07:38'),(89,22,'orange','orange','Orange',5.00,6,1,NULL,'2026-05-25 08:38:32','2026-05-31 17:07:38'),(90,22,'mango','mango','Mango',5.00,7,1,NULL,'2026-05-25 08:38:32','2026-05-31 17:07:38'),(91,22,'pineapple','pineapple','Pineapple',10.00,8,1,NULL,'2026-05-25 08:38:32','2026-05-31 17:07:38'),(92,23,'apple','apple','Apple',5.00,1,1,NULL,'2026-05-25 08:38:32','2026-05-31 17:07:38'),(93,23,'watermelon','watermelon','Watermelon',45.00,2,1,NULL,'2026-05-25 08:38:32','2026-05-31 17:07:38'),(94,23,'cherry','cherry','Cherry',25.00,3,1,NULL,'2026-05-25 08:38:32','2026-05-31 17:07:38'),(95,23,'banana','banana','Banana',5.00,4,1,NULL,'2026-05-25 08:38:32','2026-05-31 17:07:38'),(96,23,'grapes','grapes','Grapes',15.00,5,1,NULL,'2026-05-25 08:38:32','2026-05-31 17:07:38'),(97,23,'orange','orange','Orange',5.00,6,1,NULL,'2026-05-25 08:38:32','2026-05-31 17:07:38'),(98,23,'mango','mango','Mango',5.00,7,1,NULL,'2026-05-25 08:38:32','2026-05-31 17:07:38'),(99,23,'pineapple','pineapple','Pineapple',10.00,8,1,NULL,'2026-05-25 08:38:32','2026-05-31 17:07:38'),(100,24,'cherry','cherry','Cherry',3.00,1,1,NULL,'2026-05-27 05:16:50','2026-05-31 17:07:38'),(101,24,'pineapple','pineapple','Pineapple',3.00,2,1,NULL,'2026-05-27 05:16:50','2026-05-31 17:07:38'),(102,24,'grapes','grapes','Grapes',3.00,3,1,NULL,'2026-05-27 05:16:50','2026-05-31 17:07:38'),(103,25,'cherry','cherry','Cherry',3.00,1,1,NULL,'2026-05-27 05:16:50','2026-05-31 17:07:38'),(104,25,'pineapple','pineapple','Pineapple',3.00,2,1,NULL,'2026-05-27 05:16:50','2026-05-31 17:07:38'),(105,25,'grapes','grapes','Grapes',3.00,3,1,NULL,'2026-05-27 05:16:50','2026-05-31 17:07:38'),(106,26,'apple','apple','Apple',5.00,1,1,NULL,'2026-05-29 15:36:36','2026-05-31 17:07:38'),(107,26,'watermelon','watermelon','Watermelon',45.00,2,1,NULL,'2026-05-29 15:36:36','2026-05-31 17:07:38'),(108,26,'cherry','cherry','Cherry',25.00,3,1,NULL,'2026-05-29 15:36:36','2026-05-31 17:07:38'),(109,26,'banana','banana','Banana',5.00,4,1,NULL,'2026-05-29 15:36:36','2026-05-31 17:07:38'),(110,26,'grapes','grapes','Grapes',15.00,5,1,NULL,'2026-05-29 15:36:36','2026-05-31 17:07:38'),(111,26,'orange','orange','Orange',5.00,6,1,NULL,'2026-05-29 15:36:36','2026-05-31 17:07:38'),(112,26,'mango','mango','Mango',5.00,7,1,NULL,'2026-05-29 15:36:36','2026-05-31 17:07:38'),(113,26,'pineapple','pineapple','Pineapple',10.00,8,1,NULL,'2026-05-29 15:36:36','2026-05-31 17:07:38');
/*!40000 ALTER TABLE `bd_game_final_boards` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `bd_game_final_settings` WRITE;
/*!40000 ALTER TABLE `bd_game_final_settings` DISABLE KEYS */;
INSERT INTO `bd_game_final_settings` (`id`, `game_id`, `bet_duration_sec`, `start_bet_popup_sec`, `start_bet_wait_sec`, `stop_bet_popup_sec`, `stop_bet_wait_sec`, `stop_duration_sec`, `reveal_duration_sec`, `reveal_wait_sec`, `winner_popup_sec`, `winner_wait_sec`, `settle_duration_sec`, `settle_wait_sec`, `max_distinct_boards_per_user`, `min_bet`, `max_bet`, `risk_mode`, `reserve_buffer`, `repeat_limit`, `manual_winner_board`, `manual_lock_enabled`, `game_status`, `maintenance_enabled`, `maintenance_allowed_user_id`, `maintenance_message`, `ui_meta_json`, `decision_balance_amount`, `healthy_balance_threshold`, `weighted_random_enabled`, `weighted_random_spread`, `avoid_last_n_winners`, `created_at`, `updated_at`) VALUES (1,1,20,3.00,1.50,3.00,1.50,4.50,6.00,2.00,1.00,0.50,2.50,1.00,2,1.00,9999999.00,'safe_low_liability',0.00,3,NULL,0,'active',0,NULL,NULL,'{\"lobby_banner_url\":\"\",\"primary_color\":\"#0b0715\",\"accent_color\":\"#ffd76e\",\"clock_theme\":\"casino\",\"chip_theme\":\"classic\",\"chair_theme\":\"classic\",\"item_theme\":\"default\",\"popup_theme\":\"popup_01\"}',9608.00,0.00,0,3,3,'2026-05-25 01:56:18','2026-06-01 10:26:07'),(2,2,20,3.00,1.50,3.00,1.50,4.50,6.00,2.00,1.00,0.50,2.50,1.00,3,1.00,9999999.00,'safe_low_liability',0.00,3,NULL,0,'active',0,NULL,'This game is in developer mode. Only approved developer IDs can enter.','{\"lobby_banner_url\":\"\",\"primary_color\":\"#0b0715\",\"accent_color\":\"#ffd76e\",\"clock_theme\":\"casino\",\"chip_theme\":\"classic\",\"chair_theme\":\"classic\",\"item_theme\":\"default\",\"popup_theme\":\"popup_01\"}',9608.00,0.00,0,3,3,'2026-05-25 08:38:31','2026-06-01 10:26:07'),(3,3,20,3.00,1.50,3.00,1.50,4.50,6.00,2.00,1.00,0.50,2.50,1.00,3,1.00,9999999.00,'safe_low_liability',0.00,3,NULL,0,'active',1,NULL,'This game is in developer mode. Only approved developer IDs can enter.','{\"lobby_banner_url\":\"\",\"primary_color\":\"#0b0715\",\"accent_color\":\"#ffd76e\",\"clock_theme\":\"casino\",\"chip_theme\":\"classic\",\"chair_theme\":\"classic\",\"item_theme\":\"default\",\"popup_theme\":\"popup_01\"}',9608.00,0.00,0,3,3,'2026-05-25 08:38:31','2026-06-01 10:26:07'),(4,4,20,3.00,1.50,3.00,1.50,4.50,6.00,2.00,1.00,0.50,2.50,1.00,3,1.00,9999999.00,'safe_low_liability',0.00,3,NULL,0,'active',1,NULL,'This game is in developer mode. Only approved developer IDs can enter.','{\"lobby_banner_url\":\"\",\"primary_color\":\"#0b0715\",\"accent_color\":\"#ffd76e\",\"clock_theme\":\"casino\",\"chip_theme\":\"classic\",\"chair_theme\":\"classic\",\"item_theme\":\"default\",\"popup_theme\":\"popup_01\"}',9608.00,0.00,0,3,3,'2026-05-25 08:38:31','2026-06-01 10:26:07'),(5,5,20,3.00,1.50,3.00,1.50,4.50,6.00,2.00,1.00,0.50,2.50,1.00,3,1.00,9999999.00,'safe_low_liability',0.00,3,NULL,0,'active',1,NULL,'This game is in developer mode. Only approved developer IDs can enter.','{\"lobby_banner_url\":\"\",\"primary_color\":\"#0b0715\",\"accent_color\":\"#ffd76e\",\"clock_theme\":\"casino\",\"chip_theme\":\"classic\",\"chair_theme\":\"classic\",\"item_theme\":\"default\",\"popup_theme\":\"popup_01\"}',9608.00,0.00,0,3,3,'2026-05-25 08:38:31','2026-06-01 10:26:07'),(6,6,20,3.00,1.50,3.00,1.50,4.50,6.00,2.00,1.00,0.50,2.50,1.00,3,1.00,9999999.00,'safe_low_liability',0.00,3,NULL,0,'active',1,NULL,'This game is in developer mode. Only approved developer IDs can enter.','{\"lobby_banner_url\":\"\",\"primary_color\":\"#0b0715\",\"accent_color\":\"#ffd76e\",\"clock_theme\":\"casino\",\"chip_theme\":\"classic\",\"chair_theme\":\"classic\",\"item_theme\":\"default\",\"popup_theme\":\"popup_01\"}',9608.00,0.00,0,3,3,'2026-05-25 08:38:31','2026-06-01 10:26:07'),(7,7,20,3.00,1.50,3.00,1.50,4.50,6.00,2.00,1.00,0.50,2.50,1.00,3,1.00,9999999.00,'safe_low_liability',0.00,3,NULL,0,'active',1,NULL,'This game is in developer mode. Only approved developer IDs can enter.','{\"lobby_banner_url\":\"\",\"primary_color\":\"#0b0715\",\"accent_color\":\"#ffd76e\",\"clock_theme\":\"casino\",\"chip_theme\":\"classic\",\"chair_theme\":\"classic\",\"item_theme\":\"default\",\"popup_theme\":\"popup_01\"}',9608.00,0.00,0,3,3,'2026-05-25 08:38:31','2026-06-01 10:26:07'),(8,8,20,3.00,1.50,3.00,1.50,4.50,6.00,2.00,1.00,0.50,2.50,1.00,3,1.00,9999999.00,'safe_low_liability',0.00,3,NULL,0,'active',1,NULL,'This game is in developer mode. Only approved developer IDs can enter.','{\"lobby_banner_url\":\"\",\"primary_color\":\"#0b0715\",\"accent_color\":\"#ffd76e\",\"clock_theme\":\"casino\",\"chip_theme\":\"classic\",\"chair_theme\":\"classic\",\"item_theme\":\"default\",\"popup_theme\":\"popup_01\"}',9608.00,0.00,0,3,3,'2026-05-25 08:38:31','2026-06-01 10:26:07'),(9,9,20,3.00,1.50,3.00,1.50,4.50,6.00,2.00,1.00,0.50,2.50,1.00,3,1.00,9999999.00,'safe_low_liability',0.00,3,NULL,0,'active',1,NULL,'This game is in developer mode. Only approved developer IDs can enter.','{\"lobby_banner_url\":\"\",\"primary_color\":\"#0b0715\",\"accent_color\":\"#ffd76e\",\"clock_theme\":\"casino\",\"chip_theme\":\"classic\",\"chair_theme\":\"classic\",\"item_theme\":\"default\",\"popup_theme\":\"popup_01\"}',9608.00,0.00,0,3,3,'2026-05-25 08:38:31','2026-06-01 10:26:07'),(10,10,20,3.00,1.50,3.00,1.50,4.50,6.00,2.00,1.00,0.50,2.50,1.00,3,1.00,9999999.00,'safe_low_liability',0.00,3,NULL,0,'active',1,NULL,'This game is in developer mode. Only approved developer IDs can enter.','{\"lobby_banner_url\":\"\",\"primary_color\":\"#0b0715\",\"accent_color\":\"#ffd76e\",\"clock_theme\":\"casino\",\"chip_theme\":\"classic\",\"chair_theme\":\"classic\",\"item_theme\":\"default\",\"popup_theme\":\"popup_01\"}',9608.00,0.00,0,3,3,'2026-05-25 08:38:31','2026-06-01 10:26:07'),(11,11,20,3.00,1.50,3.00,1.50,4.50,6.00,2.00,1.00,0.50,2.50,1.00,3,1.00,9999999.00,'safe_low_liability',0.00,3,NULL,0,'active',1,NULL,'This game is in developer mode. Only approved developer IDs can enter.','{\"lobby_banner_url\":\"\",\"primary_color\":\"#0b0715\",\"accent_color\":\"#ffd76e\",\"clock_theme\":\"casino\",\"chip_theme\":\"classic\",\"chair_theme\":\"classic\",\"item_theme\":\"default\",\"popup_theme\":\"popup_01\"}',9608.00,0.00,0,3,3,'2026-05-25 08:38:31','2026-06-01 10:26:07'),(12,12,20,3.00,1.50,3.00,1.50,4.50,6.00,2.00,1.00,0.50,2.50,1.00,3,1.00,9999999.00,'safe_low_liability',0.00,3,NULL,0,'active',1,NULL,'This game is in developer mode. Only approved developer IDs can enter.','{\"lobby_banner_url\":\"\",\"primary_color\":\"#0b0715\",\"accent_color\":\"#ffd76e\",\"clock_theme\":\"casino\",\"chip_theme\":\"classic\",\"chair_theme\":\"classic\",\"item_theme\":\"default\",\"popup_theme\":\"popup_01\"}',9608.00,0.00,0,3,3,'2026-05-25 08:38:31','2026-06-01 10:26:07'),(13,13,20,3.00,1.50,3.00,1.50,4.50,6.00,2.00,1.00,0.50,2.50,1.00,3,1.00,9999999.00,'safe_low_liability',0.00,3,NULL,0,'active',1,NULL,'This game is in developer mode. Only approved developer IDs can enter.','{\"lobby_banner_url\":\"\",\"primary_color\":\"#0b0715\",\"accent_color\":\"#ffd76e\",\"clock_theme\":\"casino\",\"chip_theme\":\"classic\",\"chair_theme\":\"classic\",\"item_theme\":\"default\",\"popup_theme\":\"popup_01\"}',9608.00,0.00,0,3,3,'2026-05-25 08:38:31','2026-06-01 10:26:07'),(14,14,20,3.00,1.50,3.00,1.50,4.50,6.00,2.00,1.00,0.50,2.50,1.00,3,1.00,9999999.00,'safe_low_liability',0.00,3,NULL,0,'active',1,NULL,'This game is in developer mode. Only approved developer IDs can enter.','{\"lobby_banner_url\":\"\",\"primary_color\":\"#0b0715\",\"accent_color\":\"#ffd76e\",\"clock_theme\":\"casino\",\"chip_theme\":\"classic\",\"chair_theme\":\"classic\",\"item_theme\":\"default\",\"popup_theme\":\"popup_01\"}',9608.00,0.00,0,3,3,'2026-05-25 08:38:31','2026-06-01 10:26:07'),(15,15,20,3.00,1.50,3.00,1.50,4.50,6.00,2.00,1.00,0.50,2.50,1.00,3,1.00,9999999.00,'safe_low_liability',0.00,3,NULL,0,'active',1,NULL,'This game is in developer mode. Only approved developer IDs can enter.','{\"lobby_banner_url\":\"\",\"primary_color\":\"#0b0715\",\"accent_color\":\"#ffd76e\",\"clock_theme\":\"casino\",\"chip_theme\":\"classic\",\"chair_theme\":\"classic\",\"item_theme\":\"default\",\"popup_theme\":\"popup_01\"}',9608.00,0.00,0,3,3,'2026-05-25 08:38:31','2026-06-01 10:26:07'),(16,16,20,3.00,1.50,3.00,1.50,4.50,6.00,2.00,1.00,0.50,2.50,1.00,3,1.00,9999999.00,'safe_low_liability',0.00,3,NULL,0,'active',1,NULL,'This game is in developer mode. Only approved developer IDs can enter.','{\"lobby_banner_url\":\"\",\"primary_color\":\"#0b0715\",\"accent_color\":\"#ffd76e\",\"clock_theme\":\"casino\",\"chip_theme\":\"classic\",\"chair_theme\":\"classic\",\"item_theme\":\"default\",\"popup_theme\":\"popup_01\"}',9608.00,0.00,0,3,3,'2026-05-25 08:38:31','2026-06-01 10:26:07'),(17,17,20,3.00,1.50,3.00,1.50,4.50,6.00,2.00,1.00,0.50,2.50,1.00,3,1.00,9999999.00,'safe_low_liability',0.00,3,NULL,0,'active',1,NULL,'This game is in developer mode. Only approved developer IDs can enter.','{\"lobby_banner_url\":\"\",\"primary_color\":\"#0b0715\",\"accent_color\":\"#ffd76e\",\"clock_theme\":\"casino\",\"chip_theme\":\"classic\",\"chair_theme\":\"classic\",\"item_theme\":\"default\",\"popup_theme\":\"popup_01\"}',9608.00,0.00,0,3,3,'2026-05-25 08:38:31','2026-06-01 10:26:07'),(18,18,30,3.00,1.50,3.00,1.50,4.50,6.00,2.00,1.00,0.50,2.50,1.00,8,1.00,9999999.00,'safe_low_liability',0.00,3,NULL,0,'active',1,NULL,'This game is in developer mode. Only approved developer IDs can enter.','{\"lobby_banner_url\":\"\",\"primary_color\":\"#0b0715\",\"accent_color\":\"#ffd76e\",\"clock_theme\":\"casino\",\"chip_theme\":\"classic\",\"chair_theme\":\"classic\",\"item_theme\":\"default\",\"popup_theme\":\"popup_01\"}',9608.00,0.00,0,3,3,'2026-05-25 08:38:31','2026-06-01 10:26:07'),(19,19,30,3.00,1.50,3.00,1.50,4.50,6.00,2.00,1.00,0.50,2.50,1.00,8,1.00,9999999.00,'safe_low_liability',0.00,3,NULL,0,'active',1,NULL,'This game is in developer mode. Only approved developer IDs can enter.','{\"lobby_banner_url\":\"\",\"primary_color\":\"#0b0715\",\"accent_color\":\"#ffd76e\",\"clock_theme\":\"casino\",\"chip_theme\":\"classic\",\"chair_theme\":\"classic\",\"item_theme\":\"default\",\"popup_theme\":\"popup_01\"}',9608.00,0.00,0,3,3,'2026-05-25 08:38:31','2026-06-01 10:26:07'),(20,20,30,3.00,1.50,3.00,1.50,4.50,6.00,2.00,1.00,0.50,2.50,1.00,8,1.00,9999999.00,'safe_low_liability',0.00,3,NULL,0,'active',1,NULL,'This game is in developer mode. Only approved developer IDs can enter.','{\"lobby_banner_url\":\"\",\"primary_color\":\"#0b0715\",\"accent_color\":\"#ffd76e\",\"clock_theme\":\"casino\",\"chip_theme\":\"classic\",\"chair_theme\":\"classic\",\"item_theme\":\"default\",\"popup_theme\":\"popup_01\"}',9608.00,0.00,0,3,3,'2026-05-25 08:38:31','2026-06-01 10:26:07'),(21,21,30,3.00,1.50,3.00,1.50,4.50,6.00,2.00,1.00,0.50,2.50,1.00,8,1.00,9999999.00,'safe_low_liability',0.00,3,NULL,0,'active',1,NULL,'This game is in developer mode. Only approved developer IDs can enter.','{\"lobby_banner_url\":\"\",\"primary_color\":\"#0b0715\",\"accent_color\":\"#ffd76e\",\"clock_theme\":\"casino\",\"chip_theme\":\"classic\",\"chair_theme\":\"classic\",\"item_theme\":\"default\",\"popup_theme\":\"popup_01\"}',9608.00,0.00,0,3,3,'2026-05-25 08:38:32','2026-06-01 10:26:07'),(22,22,30,3.00,1.50,3.00,1.50,4.50,6.00,2.00,1.00,0.50,2.50,1.00,8,1.00,9999999.00,'safe_low_liability',0.00,3,NULL,0,'active',1,NULL,'This game is in developer mode. Only approved developer IDs can enter.','{\"lobby_banner_url\":\"\",\"primary_color\":\"#0b0715\",\"accent_color\":\"#ffd76e\",\"clock_theme\":\"casino\",\"chip_theme\":\"classic\",\"chair_theme\":\"classic\",\"item_theme\":\"default\",\"popup_theme\":\"popup_01\"}',9608.00,0.00,0,3,3,'2026-05-25 08:38:32','2026-06-01 10:26:07'),(23,23,30,3.00,1.50,3.00,1.50,4.50,6.00,2.00,1.00,0.50,2.50,1.00,8,1.00,9999999.00,'safe_low_liability',0.00,3,NULL,0,'active',1,NULL,'This game is in developer mode. Only approved developer IDs can enter.','{\"lobby_banner_url\":\"\",\"primary_color\":\"#0b0715\",\"accent_color\":\"#ffd76e\",\"clock_theme\":\"casino\",\"chip_theme\":\"classic\",\"chair_theme\":\"classic\",\"item_theme\":\"default\",\"popup_theme\":\"popup_01\"}',9608.00,0.00,0,3,3,'2026-05-25 08:38:32','2026-06-01 10:26:07'),(24,24,20,3.00,1.50,3.00,1.50,4.50,6.00,2.00,1.00,0.50,2.50,1.00,2,1.00,9999999.00,'safe_low_liability',0.00,3,NULL,0,'active',1,NULL,'This game is in developer mode. Only approved developer IDs can enter.','{\"lobby_banner_url\":\"\",\"primary_color\":\"#0b0715\",\"accent_color\":\"#ffd76e\",\"clock_theme\":\"casino\",\"chip_theme\":\"classic\",\"chair_theme\":\"classic\",\"item_theme\":\"default\",\"popup_theme\":\"popup_01\"}',9608.00,0.00,0,3,3,'2026-05-27 05:16:50','2026-06-01 10:26:07'),(25,25,20,3.00,1.50,3.00,1.50,4.50,6.00,2.00,1.00,0.50,2.50,1.00,2,1.00,9999999.00,'safe_low_liability',0.00,3,NULL,0,'active',1,NULL,'This game is in developer mode. Only approved developer IDs can enter.','{\"lobby_banner_url\":\"\",\"primary_color\":\"#0b0715\",\"accent_color\":\"#ffd76e\",\"clock_theme\":\"casino\",\"chip_theme\":\"classic\",\"chair_theme\":\"classic\",\"item_theme\":\"default\",\"popup_theme\":\"popup_01\"}',9608.00,0.00,0,3,3,'2026-05-27 05:16:50','2026-06-01 10:26:07'),(26,26,30,3.00,1.50,3.00,1.50,4.50,6.00,2.00,1.00,0.50,2.50,1.00,8,1.00,9999999.00,'safe_low_liability',0.00,3,NULL,0,'active',0,NULL,NULL,NULL,9608.00,0.00,0,3,3,'2026-05-29 15:36:36','2026-06-01 10:26:07');
/*!40000 ALTER TABLE `bd_game_final_settings` ENABLE KEYS */;
UNLOCK TABLES;

LOCK TABLES `bd_game_final_runtime_settings` WRITE;
/*!40000 ALTER TABLE `bd_game_final_runtime_settings` DISABLE KEYS */;
INSERT INTO `bd_game_final_runtime_settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (51,'realtime_mode','polling','2026-05-29 12:37:21','2026-05-29 12:37:21'),(52,'poll_interval_ms','1500','2026-05-29 12:37:21','2026-05-29 12:37:21'),(53,'websocket_url','','2026-05-29 12:37:21','2026-05-29 12:37:21'),(54,'websocket_protocols','','2026-05-29 12:37:21','2026-05-29 12:37:21'),(55,'pusher_accounts','[]','2026-05-29 12:37:21','2026-05-29 12:37:21'),(56,'pusher_app_id','','2026-05-29 12:37:21','2026-05-29 12:37:21'),(57,'pusher_key','','2026-05-29 12:37:21','2026-05-29 12:37:21'),(58,'pusher_secret','','2026-05-29 12:37:21','2026-05-29 12:37:21'),(59,'pusher_cluster','mt1','2026-05-29 12:37:21','2026-05-29 12:37:21'),(60,'pusher_host','','2026-05-29 12:37:21','2026-05-29 12:37:21'),(61,'pusher_port','443','2026-05-29 12:37:21','2026-05-29 12:37:21'),(62,'pusher_scheme','https','2026-05-29 12:37:21','2026-05-29 12:37:21'),(63,'pusher_active_index','0','2026-05-29 12:37:21','2026-05-29 12:37:21'),(64,'pusher_failed_indexes','[]','2026-05-29 12:37:21','2026-05-29 12:37:21'),(65,'maintenance_allowed_user_ids','[]','2026-05-29 12:37:21','2026-05-29 12:37:21'),(66,'redis_enabled','','2026-05-29 12:37:21','2026-05-29 12:37:21'),(67,'jobs_enabled','','2026-05-29 12:37:21','2026-05-29 12:37:21'),(68,'cron_enabled','','2026-05-29 12:37:21','2026-05-29 12:37:21'),(69,'config_version','3','2026-05-29 12:37:21','2026-05-29 12:37:21'),(70,'config_updated_at','2026-05-29T18:37:21+01:00','2026-05-29 12:37:21','2026-05-29 12:37:21');
/*!40000 ALTER TABLE `bd_game_final_runtime_settings` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;


SET FOREIGN_KEY_CHECKS=1;
