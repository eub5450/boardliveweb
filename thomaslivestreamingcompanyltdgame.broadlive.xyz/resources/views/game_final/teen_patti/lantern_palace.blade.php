@php
  $teenPattiVariantConfig = [
    'blade_id' => 'lantern_palace',
    'system_name' => 'palace_glass',
  ];
@endphp

@include('game_final.teen_patti.index', ['teenPattiVariantConfig' => $teenPattiVariantConfig])