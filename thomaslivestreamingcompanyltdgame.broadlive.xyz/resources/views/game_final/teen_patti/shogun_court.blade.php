@php
  $teenPattiVariantConfig = [
    'blade_id' => 'shogun_court',
    'system_name' => 'shogun_glass',
  ];
@endphp

@include('game_final.teen_patti.index', ['teenPattiVariantConfig' => $teenPattiVariantConfig])