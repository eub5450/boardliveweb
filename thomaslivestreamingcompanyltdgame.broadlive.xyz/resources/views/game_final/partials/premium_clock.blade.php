@php
  $theme = $theme ?? 'neon';
  $hostId = $hostId ?? null;
  $hostClass = trim(($hostClass ?? '') . ' gf-premium-clock-host');
  $rootId = $rootId ?? null;
  $rootClass = trim(($rootClass ?? '') . ' gf-premium-clock gf-theme-' . $theme);
  $valueId = $valueId ?? null;
  $valueText = $valueText ?? '--';
  $valueClass = trim(($valueClass ?? '') . ' gf-premium-number');
  $subId = $subId ?? null;
  $subText = array_key_exists('subText', get_defined_vars()) ? $subText : 'SYNC';
  $subClass = trim(($subClass ?? '') . ' gf-premium-sub');
  $handId = $handId ?? null;
@endphp
<div @if($hostId) id="{{ $hostId }}" @endif class="{{ $hostClass }}">
  <div @if($rootId) id="{{ $rootId }}" @endif class="{{ $rootClass }}" style="--p:1;--timer-angle:-90deg;">
    <div class="gf-premium-scene"></div>
    <div class="gf-premium-rim gf-premium-rim-1"></div>
    <div class="gf-premium-rim gf-premium-rim-2"></div>
    <div class="gf-premium-rim gf-premium-rim-3"></div>
    <div class="gf-premium-badge gf-premium-badge-top"></div>
    <div class="gf-premium-badge gf-premium-badge-right"></div>
    <div class="gf-premium-badge gf-premium-badge-bottom"></div>
    <div class="gf-premium-badge gf-premium-badge-left"></div>
    <div class="gf-premium-dot gf-premium-dot-1"></div>
    <div class="gf-premium-dot gf-premium-dot-2"></div>
    <div class="gf-premium-dot gf-premium-dot-3"></div>
    <div class="gf-premium-dot gf-premium-dot-4"></div>
    <div class="gf-premium-shard gf-premium-shard-1"></div>
    <div class="gf-premium-shard gf-premium-shard-2"></div>
    <div class="gf-premium-shard gf-premium-shard-3"></div>
    <div class="gf-premium-shard gf-premium-shard-4"></div>
    <div class="gf-premium-progress"></div>
    <div class="gf-premium-core"></div>
    <div class="gf-premium-overlay"></div>
    @if ($handId)
      <div id="{{ $handId }}" class="gf-premium-hand"></div>
      <div class="gf-premium-pivot"></div>
    @endif
    <div @if($valueId) id="{{ $valueId }}" @endif class="{{ $valueClass }}" data-value="{{ $valueText }}">{{ $valueText }}</div>
    @if ($subText !== null)
      <div @if($subId) id="{{ $subId }}" @endif class="{{ $subClass }}">{{ $subText }}</div>
    @endif
  </div>
</div>