@php
  $teenPattiVariantConfig = [
    'blade_id' => 'royal_court',
    'system_name' => 'royal_glass',
  ];
@endphp

@include('game_final.teen_patti.index', ['teenPattiVariantConfig' => $teenPattiVariantConfig])