@php
    $rawKey = trim((string) ($key ?? ''));
    $label = trim((string) ($label ?? $rawKey));
    $display = $label !== '' ? $label : 'Pending';
    $normalized = strtolower(str_replace([' ', '-'], '_', $rawKey !== '' ? $rawKey : $display));
    $parts = preg_split('/[\s_\-]+/', $display, -1, PREG_SPLIT_NO_EMPTY) ?: [];
    $abbr = collect($parts)->map(function ($part) {
        return substr((string) $part, 0, 1);
    })->take(2)->implode('');
    $icon = trim((string) ($icon ?? ''));
    $abbr = $icon !== '' ? $icon : strtoupper($abbr ?: substr($display, 0, 2));

    $fruitKeys = ['apple', 'berry', 'bonus', 'cherry', 'date', 'fruit', 'grape', 'jade', 'koi', 'lemon', 'lotus', 'melon', 'palm', 'pine'];
    $cardKeys = ['ace', 'king', 'queen', 'jack', 'player', 'banker', 'dragon', 'tiger'];
    $numberKeys = ['77', '88', 'seven', 'lucky'];
    $tone = 'neutral';

    foreach ($fruitKeys as $candidate) {
        if (str_contains($normalized, $candidate)) {
            $tone = 'fruit';
            break;
        }
    }

    if ($tone === 'neutral') {
        foreach ($cardKeys as $candidate) {
            if (str_contains($normalized, $candidate)) {
                $tone = 'card';
                break;
            }
        }
    }

    if ($tone === 'neutral') {
        foreach ($numberKeys as $candidate) {
            if (str_contains($normalized, $candidate)) {
                $tone = 'number';
                break;
            }
        }
    }
@endphp

<span class="board-token board-token-{{ $tone }}" title="{{ $display }}">
    <span class="board-token-icon" aria-hidden="true">{{ $abbr }}</span>
    <span class="board-token-label">{{ strtoupper($display) }}</span>
</span>
