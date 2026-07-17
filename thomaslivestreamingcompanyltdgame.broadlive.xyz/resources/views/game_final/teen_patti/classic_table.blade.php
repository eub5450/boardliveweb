@php
  $teenPattiVariantConfig = [
    'blade_id' => 'classic_table',
    'system_name' => 'classic_glass',
  ];
@endphp

@include('game_final.teen_patti.index', ['teenPattiVariantConfig' => $teenPattiVariantConfig])