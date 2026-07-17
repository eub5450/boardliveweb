@php
  $teenPattiVariantConfig = [
    'blade_id' => 'battle_command',
    'system_name' => 'warfront_glass',
  ];
@endphp

@include('game_final.teen_patti.index', ['teenPattiVariantConfig' => $teenPattiVariantConfig])