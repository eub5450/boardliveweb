<?php

namespace App\Support\GameFinal;

class GameRegistry
{
    public static function views(): array
    {
        return [
            'teen_patti' => 'game_final.teen_patti.classic_table',
            'teen_patti_king' => 'game_final.teen_patti.royal_court',
            'teen_patti_sultan' => 'game_final.teen_patti.lantern_palace',
            'teen_patti_warfront' => 'game_final.teen_patti.battle_command',
            'teen_patti_neon' => 'game_final.teen_patti.neon_blood_glam',
            'teen_patti_shogun' => 'game_final.teen_patti.shogun_court',
            'teen_patti_glacier' => 'game_final.teen_patti.glacier_crystal',
            'lucky77' => 'game_final.lucky77.index',
            'lucky77_max' => 'game_final.lucky77.max_lounge',
            'lucky7_pro' => 'game_final.lucky77.pro_lounge',
            'lucky77_mirage' => 'game_final.lucky77.index',
            'lucky77_ironfront' => 'game_final.lucky77.index',
            'lucky77_lotus' => 'game_final.lucky77.index',
            'lucky77_nebula' => 'game_final.lucky77.index',
            'lucky77_carnival' => 'game_final.lucky77.index',
            'lucky88_master' => 'game_final.lucky77.master_wheel',
            'fruit_slot' => 'game_final.fruit_slot.index',
            'fruit_slot_oasis' => 'game_final.fruit_slot.index',
            'fruit_slot_arsenal' => 'game_final.fruit_slot.index',
            'fruit_slot_arcade' => 'game_final.fruit_slot.index',
            'fruit_slot_lotus' => 'game_final.fruit_slot.index',
            'fruit_slot_glacier' => 'game_final.fruit_slot.index',
            'greedy' => 'game_final.fruit_slot.index',
            'fruits_loop' => 'game_final.fruits_loop.index',
            'fruits_loop_ruby' => 'game_final.fruits_loop.index',
            'fruits_loop_emerald' => 'game_final.fruits_loop.index',
        ];
    }

    public static function view($gameCode)
    {
        $views = static::views();

        if (isset($views[$gameCode])) {
            return $views[$gameCode];
        }

        return null;
    }
}
