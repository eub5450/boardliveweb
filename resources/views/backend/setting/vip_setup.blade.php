@extends('backend.layouts.main')
@section('title')
VIP Setup
@endsection
@section('content')
<style>
    .vip-setup-page { padding: 14px; }
    .vip-setup-page .card { border-radius: 12px; box-shadow: 0 4px 16px rgba(20,54,92,.08); margin-bottom: 18px; }
    .vip-setup-page .card-title { font-weight: 700; color: #0d3b66; margin: 0; }
    .vip-setup-page .card-header { background: #f7fbff; border-bottom: 1px solid #e3ecf5; padding: 10px 14px; }
    .vip-setup-page .form-group { margin-bottom: 12px; }
    .vip-setup-page label { font-weight: 600; color: #223b58; }
    .vip-setup-page .config-json-area { font-family: Menlo, Consolas, monospace; font-size: 12px; min-height: 340px; }
    .vip-setup-page .hint { color:#6c7a90; font-size:12px; }
    .vip-setup-page .grid-2 { display:grid; grid-template-columns:repeat(auto-fit,minmax(240px,1fr)); gap:12px; }
    .vip-setup-page .subtle-note { background:#fff9e6; border-left:3px solid #f6c343; padding:8px 12px; border-radius:6px; color:#5c4a00; font-size:12px; margin-bottom:10px; }
</style>

<div class="vip-setup-page">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title">VIP Setup - Dynamic Configuration</h4>
            <span class="hint">Public API: <code>/api/vip_setup_config</code></span>
        </div>
        <div class="card-body">
            <div class="subtle-note">
                Structured fields below cover the most-edited values.
                For anything else (tiers, benefits, comparison rows, gradient colors)
                edit the full JSON at the bottom. Both are saved in one submit.
            </div>

            <form action="{{ route('admin.vip_setup.update') }}" method="post">
                @csrf

                {{-- Hero --}}
                <h5 class="mt-2 mb-2" style="color:#17365d;font-weight:800;">Hero / Progress</h5>
                <div class="grid-2">
                    <div class="form-group">
                        <label>Current Progress Points</label>
                        <input type="number" min="0" name="hero_progress_current"
                               class="form-control"
                               value="{{ old('hero_progress_current', $config['hero']['progress_current'] ?? 0) }}">
                    </div>
                    <div class="form-group">
                        <label>Target Progress Points</label>
                        <input type="number" min="1" name="hero_progress_target"
                               class="form-control"
                               value="{{ old('hero_progress_target', $config['hero']['progress_target'] ?? 1000) }}">
                    </div>
                    <div class="form-group">
                        <label>VIP Renews In (days from now)</label>
                        <input type="number" min="0" name="hero_renew_days_from_now"
                               class="form-control"
                               value="{{ old('hero_renew_days_from_now', $config['hero']['renew_days_from_now'] ?? 30) }}">
                    </div>
                </div>

                {{-- Plans --}}
                <h5 class="mt-3 mb-2" style="color:#17365d;font-weight:800;">Plans</h5>
                @php
                    $monthly = collect($config['plans'] ?? [])->firstWhere('id','monthly') ?: [];
                    $yearly  = collect($config['plans'] ?? [])->firstWhere('id','yearly')  ?: [];
                @endphp
                <div class="grid-2">
                    <div class="form-group">
                        <label>Monthly Price (display)</label>
                        <input type="text" name="plan_monthly_price" class="form-control"
                               value="{{ old('plan_monthly_price', $monthly['price_display'] ?? '$6.99') }}">
                    </div>
                    <div class="form-group">
                        <label>Monthly Subtitle</label>
                        <input type="text" name="plan_monthly_subtitle" class="form-control"
                               value="{{ old('plan_monthly_subtitle', $monthly['subtitle'] ?? '') }}">
                    </div>
                    <div class="form-group">
                        <label>Yearly Price (display)</label>
                        <input type="text" name="plan_yearly_price" class="form-control"
                               value="{{ old('plan_yearly_price', $yearly['price_display'] ?? '$59.99') }}">
                    </div>
                    <div class="form-group">
                        <label>Yearly Subtitle</label>
                        <input type="text" name="plan_yearly_subtitle" class="form-control"
                               value="{{ old('plan_yearly_subtitle', $yearly['subtitle'] ?? '') }}">
                    </div>
                </div>

                {{-- Upgrade button / Notes --}}
                <h5 class="mt-3 mb-2" style="color:#17365d;font-weight:800;">Upgrade Button &amp; Notes</h5>
                <div class="grid-2">
                    <div class="form-group">
                        <label>Upgrade Button Label</label>
                        <input type="text" name="upgrade_label" class="form-control"
                               value="{{ old('upgrade_label', $config['upgrade_button']['label'] ?? 'Upgrade VIP') }}">
                    </div>
                    <div class="form-group">
                        <label>Secure Note</label>
                        <input type="text" name="secure_note" class="form-control"
                               value="{{ old('secure_note', $config['secure_note'] ?? '') }}">
                    </div>
                    <div class="form-group">
                        <label>Parental Notice Title</label>
                        <input type="text" name="parental_title" class="form-control"
                               value="{{ old('parental_title', $config['parental_notice']['title'] ?? '') }}">
                    </div>
                    <div class="form-group">
                        <label>Parental Notice Body</label>
                        <textarea name="parental_body" class="form-control" rows="2">{{ old('parental_body', $config['parental_notice']['body'] ?? '') }}</textarea>
                    </div>
                </div>

                {{-- Raw JSON --}}
                <h5 class="mt-3 mb-2" style="color:#17365d;font-weight:800;">Full Config JSON</h5>
                <p class="hint">
                    Edit tiers, benefits, comparison rows, gradient colors, etc. by editing this JSON directly.
                    Structured fields above override the matching keys inside this JSON on save.
                </p>
                <div class="form-group">
                    <textarea name="config_json_raw"
                              class="form-control config-json-area"
                              spellcheck="false"
                    >{{ old('config_json_raw', $prettyJson) }}</textarea>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    <button type="submit" class="btn btn-primary">Save VIP Setup</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
