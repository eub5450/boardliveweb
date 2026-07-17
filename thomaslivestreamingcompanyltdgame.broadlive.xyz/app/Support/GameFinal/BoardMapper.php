<?php

namespace App\Support\GameFinal;

class BoardMapper
{
    public static function config($gameCode)
    {
        return config('bd_game_final.games.' . $gameCode, []);
    }

    public static function normalize($gameCode, $value)
    {
        $value = (string) $value;
        $boards = self::config($gameCode)['boards'] ?? [];
        foreach ($boards as $board) {
            $frontend = (string) ($board['frontend_key'] ?? $board['canonical_key']);
            $canonical = (string) $board['canonical_key'];
            $aliases = $board['aliases'] ?? [];
            if ($value === $frontend || $value === $canonical || in_array($value, $aliases, true)) {
                return $canonical;
            }
        }
        return $value;
    }

    public static function frontendKey($gameCode, $canonical)
    {
        $canonical = self::normalize($gameCode, $canonical);
        $boards = self::config($gameCode)['boards'] ?? [];
        foreach ($boards as $board) {
            if ((string) $board['canonical_key'] === $canonical) {
                return (string) ($board['frontend_key'] ?? $board['canonical_key']);
            }
        }
        return $canonical;
    }

    public static function multiplier($gameCode, $canonical)
    {
        $canonical = self::normalize($gameCode, $canonical);
        $boards = self::config($gameCode)['boards'] ?? [];
        foreach ($boards as $board) {
            if ((string) $board['canonical_key'] === $canonical) {
                return (float) $board['multiplier'];
            }
        }
        return 1;
    }

    public static function allCanonical($gameCode)
    {
        $rows = self::config($gameCode)['boards'] ?? [];
        return array_map(function ($row) {
            return (string) $row['canonical_key'];
        }, $rows);
    }
}
