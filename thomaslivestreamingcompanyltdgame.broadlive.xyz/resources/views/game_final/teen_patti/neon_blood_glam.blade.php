@php
  $teenPattiVariantConfig = [
    'blade_id' => 'neon_blood_glam',
    'system_name' => 'neon_blood_glass',
  ];
@endphp

@include('game_final.teen_patti.index', ['teenPattiVariantConfig' => $teenPattiVariantConfig])