@php
    $jamboAiAllowedAdminId = env('JAMBOAI_PET_ALLOWED_ADMIN_ID', '11133');
    $jamboAiAdminId = auth()->check() ? (string) auth()->id() : '';
    $jamboAiEnabled = $jamboAiAdminId !== '' && hash_equals((string) $jamboAiAllowedAdminId, $jamboAiAdminId);
@endphp
@if($jamboAiEnabled)
    @php
        $jamboAiPetIcon = file_exists(public_path('assets/jamboai/jamboai-pet-icon.png'))
            ? asset('assets/jamboai/jamboai-pet-icon.png')
            : asset('assets/jamboai/jamboai-pet.svg');
    @endphp
    <link rel="stylesheet" href="{{ asset('assets/jamboai/jamboai-pet.css') }}?v=20260608-agentflow">
    <script>
        window.JAMBOAI_PET_CONFIG = {
            enabled: true,
            currentAdminId: @json($jamboAiAdminId),
            sourceApp: @json('broadlive'),
            sourceDomain: @json('broadlive.xyz'),
            iconSrc: @json($jamboAiPetIcon),
            apiBase: @json(url('/api/jambo-ai')),
            pollMs: 15000
        };
    </script>
    <script src="{{ asset('assets/jamboai/jamboai-pet.js') }}?v=20260608-agentflow" defer></script>
@endif
