@extends('backend.layouts.main')
@section('title')
System Setting
@endsection

@section('content')
<style>
    .system-setting-page {
        padding: 12px 0 24px;
    }

    .system-setting-shell {
        display: grid;
        gap: 20px;
    }

    .system-setting-hero {
        background: linear-gradient(135deg, #10243f 0%, #1b3b66 55%, #245188 100%);
        border-radius: 12px;
        color: #fff;
        padding: 24px;
        box-shadow: 0 18px 45px rgba(16, 36, 63, 0.18);
    }

    .system-setting-hero-top {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }

    .system-setting-kicker {
        display: inline-flex;
        align-items: center;
        padding: 6px 12px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.14);
        font-size: 12px;
        font-weight: 600;
        letter-spacing: .04em;
        text-transform: uppercase;
    }

    .system-setting-title {
        margin: 12px 0 6px;
        font-size: 28px;
        font-weight: 700;
        color: #fff;
    }

    .system-setting-subtitle {
        margin: 0;
        max-width: 760px;
        color: rgba(255, 255, 255, 0.82);
        font-size: 14px;
        line-height: 1.6;
    }

    .system-setting-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 18px;
    }

    .system-setting-tag {
        display: inline-flex;
        align-items: center;
        padding: 8px 12px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.12);
        color: #fff;
        font-size: 12px;
        font-weight: 600;
    }

    .system-setting-form {
        display: grid;
        gap: 20px;
    }

    .setting-panel {
        background: #fff;
        border: 1px solid #e7edf5;
        border-radius: 12px;
        box-shadow: 0 10px 28px rgba(15, 23, 42, 0.06);
        overflow: hidden;
    }

    .setting-panel-head {
        display: flex;
        flex-wrap: wrap;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
        padding: 20px 22px 14px;
        border-bottom: 1px solid #eef3f8;
        background: #fbfdff;
    }

    .setting-panel-title {
        margin: 0;
        color: #122033;
        font-size: 18px;
        font-weight: 700;
    }

    .setting-panel-text {
        margin: 6px 0 0;
        color: #66758a;
        font-size: 13px;
        line-height: 1.6;
        max-width: 760px;
    }

    .setting-panel-badge {
        display: inline-flex;
        align-items: center;
        padding: 8px 12px;
        border-radius: 999px;
        background: #eef5ff;
        color: #245188;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
    }

    .setting-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
        padding: 22px;
    }

    .setting-field {
        display: grid;
        gap: 8px;
    }

    .setting-field-full {
        grid-column: 1 / -1;
    }

    .setting-label-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .setting-label {
        margin: 0;
        color: #223247;
        font-size: 14px;
        font-weight: 700;
    }

    .setting-help {
        margin: 0;
        color: #78879c;
        font-size: 12px;
        line-height: 1.55;
    }

    .setting-input,
    .setting-select {
        width: 100%;
        min-height: 46px;
        border: 1px solid #d8e2ee;
        border-radius: 10px;
        padding: 11px 14px;
        color: #172536;
        background: #fff;
        transition: border-color .2s ease, box-shadow .2s ease, background-color .2s ease;
    }

    .setting-input:focus,
    .setting-select:focus {
        border-color: #3573c8;
        box-shadow: 0 0 0 4px rgba(53, 115, 200, 0.12);
        outline: 0;
    }

    .setting-toggle {
        position: relative;
        display: inline-flex;
        align-items: center;
        gap: 12px;
        min-height: 46px;
        padding: 10px 0 4px;
    }

    .setting-toggle input[type="checkbox"] {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .setting-toggle-track {
        position: relative;
        width: 50px;
        height: 28px;
        border-radius: 999px;
        background: #ced8e5;
        transition: background-color .2s ease;
        flex-shrink: 0;
    }

    .setting-toggle-track::after {
        content: '';
        position: absolute;
        top: 3px;
        left: 4px;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background: #fff;
        box-shadow: 0 4px 10px rgba(16, 24, 40, 0.18);
        transition: transform .2s ease;
    }

    .setting-toggle input[type="checkbox"]:checked + .setting-toggle-track {
        background: #2a7be4;
    }

    .setting-toggle input[type="checkbox"]:checked + .setting-toggle-track::after {
        transform: translateX(20px);
    }

    .setting-toggle-copy {
        display: grid;
        gap: 2px;
    }

    .setting-toggle-title {
        color: #223247;
        font-size: 14px;
        font-weight: 700;
        line-height: 1.3;
    }

    .setting-toggle-text {
        color: #78879c;
        font-size: 12px;
        line-height: 1.45;
    }

    .setting-actions {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 18px 22px 22px;
        border-top: 1px solid #eef3f8;
        background: #fbfdff;
    }

    .setting-actions-note {
        color: #6e7f93;
        font-size: 12px;
        line-height: 1.55;
        margin: 0;
        max-width: 600px;
    }

    .setting-save-btn {
        min-width: 170px;
        min-height: 46px;
        border: 0;
        border-radius: 10px;
        padding: 12px 18px;
        background: linear-gradient(135deg, #1f6fd8 0%, #2f8bff 100%);
        color: #fff;
        font-size: 14px;
        font-weight: 700;
        box-shadow: 0 12px 24px rgba(31, 111, 216, 0.24);
    }

    .setting-save-btn:hover,
    .setting-save-btn:focus {
        color: #fff;
    }

    .setting-alert {
        border: 0;
        border-radius: 12px;
        padding: 14px 16px;
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.06);
    }

    .setting-alert ul {
        margin: 0;
        padding-left: 18px;
    }

    .setting-status-alert {
        display: flex;
        align-items: center;
        gap: 10px;
        border-radius: 12px;
        padding: 14px 16px;
        background: #ecfdf3;
        border: 1px solid #c9f1d9;
        color: #166534;
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.05);
    }

    @media (max-width: 991px) {
        .setting-grid {
            grid-template-columns: 1fr;
        }

        .system-setting-title {
            font-size: 24px;
        }
    }

    @media (max-width: 575px) {
        .system-setting-page {
            padding-top: 4px;
        }

        .system-setting-hero,
        .setting-panel-head,
        .setting-grid,
        .setting-actions {
            padding-left: 16px;
            padding-right: 16px;
        }

        .system-setting-title {
            font-size: 22px;
        }

        .setting-save-btn {
            width: 100%;
        }
    }
</style>

<div class="body-content system-setting-page">
    <div class="system-setting-shell">
        @if (session('messege'))
            <div class="setting-status-alert">
                <strong>{{ session('messege') }}</strong>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger setting-alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="system-setting-hero">
            <div class="system-setting-hero-top">
                <div>
                    <span class="system-setting-kicker">Admin Control Center</span>
                    <h1 class="system-setting-title">System Setting</h1>
                    <p class="system-setting-subtitle">
                        Manage portal transfer rules and live reward rules from one panel. Changes here affect the active Broadlive API behavior directly, so this page is organized for fast review and safer editing.
                    </p>
                </div>
                <span class="system-setting-tag">Live config page</span>
            </div>
            <div class="system-setting-tags">
                <span class="system-setting-tag">Portal rules</span>
                <span class="system-setting-tag">V4 reward setup</span>
                <span class="system-setting-tag">Legacy reward setup</span>
                <span class="system-setting-tag">Mobile responsive</span>
            </div>
        </section>

        <form action="{{ URL::to('setting/system-setting-update') }}" method="post" class="system-setting-form">
            @csrf

            <section class="setting-panel">
                <div class="setting-panel-head">
                    <div>
                        <h2 class="setting-panel-title">Portal Transfer Rules</h2>
                        <p class="setting-panel-text">
                            Controls the direct portal transfer minimum and the allowed portal-to-portal amount range and step.
                        </p>
                    </div>
                    <span class="setting-panel-badge">API V3 + V4</span>
                </div>

                <div class="setting-grid">
                    <div class="setting-field">
                        <div class="setting-label-row">
                            <label for="portal_min_transfer_amount" class="setting-label">Direct Transfer Minimum</label>
                        </div>
                        <input type="number" name="portal_min_transfer_amount" id="portal_min_transfer_amount" class="setting-input" min="1" required title="Minimum amount for portal to user transfer in API V3 and V4." value="{{ old('portal_min_transfer_amount', $portalMinTransferAmount) }}">
                        <p class="setting-help">Minimum amount used by portal to user transfer in API V3 and V4.</p>
                    </div>

                    <div class="setting-field">
                        <div class="setting-label-row">
                            <label for="portal_to_portal_min_amount" class="setting-label">Portal To Portal Minimum</label>
                        </div>
                        <input type="number" name="portal_to_portal_min_amount" id="portal_to_portal_min_amount" class="setting-input" min="1" required title="First allowed amount for portal to portal transfer." value="{{ old('portal_to_portal_min_amount', $portalToPortalMinAmount) }}">
                        <p class="setting-help">Smallest allowed amount for portal to portal transfer.</p>
                    </div>

                    <div class="setting-field">
                        <div class="setting-label-row">
                            <label for="portal_to_portal_max_amount" class="setting-label">Portal To Portal Maximum</label>
                        </div>
                        <input type="number" name="portal_to_portal_max_amount" id="portal_to_portal_max_amount" class="setting-input" min="1" required title="Last allowed amount for portal to portal transfer." value="{{ old('portal_to_portal_max_amount', $portalToPortalMaxAmount) }}">
                        <p class="setting-help">Largest allowed amount for portal to portal transfer.</p>
                    </div>

                    <div class="setting-field">
                        <div class="setting-label-row">
                            <label for="portal_to_portal_step_amount" class="setting-label">Portal To Portal Step</label>
                        </div>
                        <input type="number" name="portal_to_portal_step_amount" id="portal_to_portal_step_amount" class="setting-input" min="1" required title="Only min plus multiples of this step are allowed." value="{{ old('portal_to_portal_step_amount', $portalToPortalStepAmount) }}">
                        <p class="setting-help">Valid portal-to-portal amount rule is minimum + step, up to maximum.</p>
                    </div>
                </div>
            </section>

            <section class="setting-panel">
                <div class="setting-panel-head">
                    <div>
                        <h2 class="setting-panel-title">Reward Setup (V4)</h2>
                        <p class="setting-panel-text">
                            Controls the daily live reward used by the active V4 daytime endpoint.
                        </p>
                    </div>
                    <span class="setting-panel-badge">api/v4/video_day_time_request</span>
                </div>

                <div class="setting-grid">
                    <div class="setting-field">
                        <div class="setting-label-row">
                            <span class="setting-label">V4 Reward Active</span>
                        </div>
                        <label class="setting-toggle" title="Enable or disable the V4 daily live reward.">
                            <input type="hidden" name="video_reward_v4_enabled" value="0">
                            <input type="checkbox" name="video_reward_v4_enabled" id="video_reward_v4_enabled" value="1" {{ old('video_reward_v4_enabled', $videoRewardV4Enabled) ? 'checked' : '' }}>
                            <span class="setting-toggle-track"></span>
                            <span class="setting-toggle-copy">
                                <span class="setting-toggle-title">Reward switch</span>
                                <span class="setting-toggle-text">Turns the V4 daily live reward on or off.</span>
                            </span>
                        </label>
                    </div>

                    <div class="setting-field">
                        <div class="setting-label-row">
                            <label for="video_reward_v4_threshold_minutes" class="setting-label">V4 Target Minutes</label>
                        </div>
                        <input type="number" name="video_reward_v4_threshold_minutes" id="video_reward_v4_threshold_minutes" class="setting-input" min="1" max="1440" required title="Required total live minutes in one day before the V4 reward is sent." value="{{ old('video_reward_v4_threshold_minutes', $videoRewardV4ThresholdMinutes) }}">
                        <p class="setting-help">Required total live minutes in one day before reward issue.</p>
                    </div>

                    <div class="setting-field">
                        <div class="setting-label-row">
                            <label for="video_reward_v4_amount" class="setting-label">V4 Reward Amount</label>
                        </div>
                        <input type="number" name="video_reward_v4_amount" id="video_reward_v4_amount" class="setting-input" min="1" required title="Gift coin amount sent after the V4 daily live target is completed." value="{{ old('video_reward_v4_amount', $videoRewardV4Amount) }}">
                        <p class="setting-help">Gift coin amount sent after the V4 live target is completed.</p>
                    </div>

                    <div class="setting-field">
                        <div class="setting-label-row">
                            <label for="video_reward_v4_sender_id" class="setting-label">V4 Sender ID</label>
                        </div>
                        <input type="number" name="video_reward_v4_sender_id" id="video_reward_v4_sender_id" class="setting-input" min="1" required title="User ID used to send the V4 reward gift." value="{{ old('video_reward_v4_sender_id', $videoRewardV4SenderId) }}">
                        <p class="setting-help">User ID used to send the reward gift entry.</p>
                    </div>

                    <div class="setting-field setting-field-full">
                        <div class="setting-label-row">
                            <label for="video_reward_v4_gift_name" class="setting-label">V4 Gift Name</label>
                        </div>
                        <input type="text" name="video_reward_v4_gift_name" id="video_reward_v4_gift_name" class="setting-input" required title="Gift asset name stored in gifts for V4 reward." value="{{ old('video_reward_v4_gift_name', $videoRewardV4GiftName) }}">
                        <p class="setting-help">Gift asset name saved in gifts when V4 reward is created.</p>
                    </div>
                </div>
            </section>

            <section class="setting-panel">
                <div class="setting-panel-head">
                    <div>
                        <h2 class="setting-panel-title">Reward Setup (Legacy API)</h2>
                        <p class="setting-panel-text">
                            Controls the legacy daytime reward path, including blocked-time behavior for older clients.
                        </p>
                    </div>
                    <span class="setting-panel-badge">api/video_day_time_request</span>
                </div>

                <div class="setting-grid">
                    <div class="setting-field">
                        <div class="setting-label-row">
                            <span class="setting-label">Legacy Reward Active</span>
                        </div>
                        <label class="setting-toggle" title="Enable or disable the legacy daily live reward.">
                            <input type="hidden" name="video_reward_legacy_enabled" value="0">
                            <input type="checkbox" name="video_reward_legacy_enabled" id="video_reward_legacy_enabled" value="1" {{ old('video_reward_legacy_enabled', $videoRewardLegacyEnabled) ? 'checked' : '' }}>
                            <span class="setting-toggle-track"></span>
                            <span class="setting-toggle-copy">
                                <span class="setting-toggle-title">Reward switch</span>
                                <span class="setting-toggle-text">Turns the legacy daily live reward on or off.</span>
                            </span>
                        </label>
                    </div>

                    <div class="setting-field">
                        <div class="setting-label-row">
                            <label for="video_reward_legacy_threshold_minutes" class="setting-label">Legacy Target Minutes</label>
                        </div>
                        <input type="number" name="video_reward_legacy_threshold_minutes" id="video_reward_legacy_threshold_minutes" class="setting-input" min="1" max="1440" required title="Required total live minutes in one day before the legacy reward is sent." value="{{ old('video_reward_legacy_threshold_minutes', $videoRewardLegacyThresholdMinutes) }}">
                        <p class="setting-help">Required total live minutes in one day before reward issue.</p>
                    </div>

                    <div class="setting-field">
                        <div class="setting-label-row">
                            <label for="video_reward_legacy_amount" class="setting-label">Legacy Reward Amount</label>
                        </div>
                        <input type="number" name="video_reward_legacy_amount" id="video_reward_legacy_amount" class="setting-input" min="1" required title="Gift coin amount sent after the legacy daily live target is completed." value="{{ old('video_reward_legacy_amount', $videoRewardLegacyAmount) }}">
                        <p class="setting-help">Gift coin amount sent after the legacy live target is completed.</p>
                    </div>

                    <div class="setting-field">
                        <div class="setting-label-row">
                            <label for="video_reward_legacy_sender_id" class="setting-label">Legacy Sender ID</label>
                        </div>
                        <input type="number" name="video_reward_legacy_sender_id" id="video_reward_legacy_sender_id" class="setting-input" min="1" required title="User ID used to send the legacy reward gift." value="{{ old('video_reward_legacy_sender_id', $videoRewardLegacySenderId) }}">
                        <p class="setting-help">User ID used to send the legacy reward gift entry.</p>
                    </div>

                    <div class="setting-field setting-field-full">
                        <div class="setting-label-row">
                            <label for="video_reward_legacy_gift_name" class="setting-label">Legacy Gift Name</label>
                        </div>
                        <input type="text" name="video_reward_legacy_gift_name" id="video_reward_legacy_gift_name" class="setting-input" required title="Gift asset name stored in gifts for the legacy reward." value="{{ old('video_reward_legacy_gift_name', $videoRewardLegacyGiftName) }}">
                        <p class="setting-help">Gift asset name saved in gifts when the legacy reward is created.</p>
                    </div>

                    <div class="setting-field">
                        <div class="setting-label-row">
                            <span class="setting-label">Legacy Block Time</span>
                        </div>
                        <label class="setting-toggle" title="When active, the legacy reward is blocked inside the configured time window.">
                            <input type="hidden" name="video_reward_legacy_block_enabled" value="0">
                            <input type="checkbox" name="video_reward_legacy_block_enabled" id="video_reward_legacy_block_enabled" value="1" {{ old('video_reward_legacy_block_enabled', $videoRewardLegacyBlockEnabled) ? 'checked' : '' }}>
                            <span class="setting-toggle-track"></span>
                            <span class="setting-toggle-copy">
                                <span class="setting-toggle-title">Blocked window</span>
                                <span class="setting-toggle-text">Uses the blocked time window for legacy reward control.</span>
                            </span>
                        </label>
                    </div>

                    <div class="setting-field">
                        <div class="setting-label-row">
                            <label for="video_reward_legacy_block_start" class="setting-label">Legacy Block Start</label>
                        </div>
                        <input type="time" step="1" name="video_reward_legacy_block_start" id="video_reward_legacy_block_start" class="setting-input" required title="Blocked window start time in server timezone." value="{{ old('video_reward_legacy_block_start', $videoRewardLegacyBlockStart) }}">
                        <p class="setting-help">Blocked window start time in server timezone.</p>
                    </div>

                    <div class="setting-field">
                        <div class="setting-label-row">
                            <label for="video_reward_legacy_block_end" class="setting-label">Legacy Block End</label>
                        </div>
                        <input type="time" step="1" name="video_reward_legacy_block_end" id="video_reward_legacy_block_end" class="setting-input" required title="Blocked window end time in server timezone." value="{{ old('video_reward_legacy_block_end', $videoRewardLegacyBlockEnd) }}">
                        <p class="setting-help">Blocked window end time in server timezone.</p>
                    </div>
                </div>

                <div class="setting-actions">
                    <p class="setting-actions-note">
                        Save only after reviewing values carefully. This page controls live portal transfer and reward behavior for active Broadlive APIs.
                    </p>
                    <button type="submit" class="btn setting-save-btn">Save System Setting</button>
                </div>
            </section>
        </form>
    </div>
</div>
@endsection
