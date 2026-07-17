@php
  $teenPattiVariantConfig = [
    'blade_id' => 'glacier_crystal',
    'system_name' => 'glacier_glass',
  ];
@endphp

@include('game_final.teen_patti.index', ['teenPattiVariantConfig' => $teenPattiVariantConfig])