@extends('backend.layouts.main')
@section('title')
Protal setting
@endsection
@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="body-content">
    <div class="card mb-4">
        <div class="card-body">
            <div class="form-group">
                <div class="col-sm-12">
                    <h4 class="text-center font-weight-bold font-italic mt-3">Protal setting</h4>
                </div>
            </div>

            <form action="{{ URL::to('setting/system-setting-update') }}" method="post" class="form-inline">
                @csrf

                <div class="form-group col-md-8 mb-3">
                    <label for="portal_min_transfer_amount" class="col-sm-4 col-form-label text-right">
                        Direct Transfer Minimum
                    </label>
                    <input
                        type="number"
                        name="portal_min_transfer_amount"
                        id="portal_min_transfer_amount"
                        class="form-control col-sm-8"
                        min="1"
                        required
                        title="Minimum amount for portal to user transfer in API V3 and V4."
                        value="{{ old('portal_min_transfer_amount', $portalMinTransferAmount) }}"
                    >
                </div>

                <div class="form-group col-md-12 mb-3">
                    <small class="text-muted">
                        Minimum amount used by portal to user transfer in API V3 and V4.
                    </small>
                </div>

                <div class="form-group col-md-8 mb-3">
                    <label for="portal_to_portal_min_amount" class="col-sm-4 col-form-label text-right">
                        Portal To Portal Min
                    </label>
                    <input
                        type="number"
                        name="portal_to_portal_min_amount"
                        id="portal_to_portal_min_amount"
                        class="form-control col-sm-8"
                        min="1"
                        required
                        title="First allowed amount for portal to portal transfer."
                        value="{{ old('portal_to_portal_min_amount', $portalToPortalMinAmount) }}"
                    >
                </div>

                <div class="form-group col-md-12 mb-3">
                    <small class="text-muted">
                        Smallest allowed amount for portal to portal transfer.
                    </small>
                </div>

                <div class="form-group col-md-8 mb-3">
                    <label for="portal_to_portal_max_amount" class="col-sm-4 col-form-label text-right">
                        Portal To Portal Max
                    </label>
                    <input
                        type="number"
                        name="portal_to_portal_max_amount"
                        id="portal_to_portal_max_amount"
                        class="form-control col-sm-8"
                        min="1"
                        required
                        title="Last allowed amount for portal to portal transfer."
                        value="{{ old('portal_to_portal_max_amount', $portalToPortalMaxAmount) }}"
                    >
                </div>

                <div class="form-group col-md-12 mb-3">
                    <small class="text-muted">
                        Largest allowed amount for portal to portal transfer.
                    </small>
                </div>

                <div class="form-group col-md-8 mb-3">
                    <label for="portal_to_portal_step_amount" class="col-sm-4 col-form-label text-right">
                        Portal To Portal Step
                    </label>
                    <input
                        type="number"
                        name="portal_to_portal_step_amount"
                        id="portal_to_portal_step_amount"
                        class="form-control col-sm-8"
                        min="1"
                        required
                        title="Only min plus multiples of this step are allowed."
                        value="{{ old('portal_to_portal_step_amount', $portalToPortalStepAmount) }}"
                    >
                </div>

                <div class="form-group col-md-12 mb-3">
                    <small class="text-muted">
                        Valid portal to portal amount rule is: minimum + step, up to maximum.
                    </small>
                </div>

                <div class="form-group col-md-12 mt-4 mb-2">
                    <h5 class="font-weight-bold">Reward Setup (V4)</h5>
                </div>

                <div class="form-group col-md-8 mb-3">
                    <label for="video_reward_v4_enabled" class="col-sm-4 col-form-label text-right">
                        V4 Reward Active
                    </label>
                    <div class="col-sm-8 d-flex align-items-center">
                        <input type="hidden" name="video_reward_v4_enabled" value="0">
                        <input
                            type="checkbox"
                            name="video_reward_v4_enabled"
                            id="video_reward_v4_enabled"
                            value="1"
                            class="mr-2"
                            title="Enable or disable the V4 daily live reward."
                            {{ old('video_reward_v4_enabled', $videoRewardV4Enabled) ? 'checked' : '' }}
                        >
                        <small class="text-muted mb-0">V4 daily live reward on or off.</small>
                    </div>
                </div>

                <div class="form-group col-md-8 mb-3">
                    <label for="video_reward_v4_threshold_minutes" class="col-sm-4 col-form-label text-right">
                        V4 Target Minutes
                    </label>
                    <input
                        type="number"
                        name="video_reward_v4_threshold_minutes"
                        id="video_reward_v4_threshold_minutes"
                        class="form-control col-sm-8"
                        min="1"
                        max="1440"
                        required
                        title="Required total live minutes in one day before the V4 reward is sent."
                        value="{{ old('video_reward_v4_threshold_minutes', $videoRewardV4ThresholdMinutes) }}"
                    >
                </div>

                <div class="form-group col-md-8 mb-3">
                    <label for="video_reward_v4_amount" class="col-sm-4 col-form-label text-right">
                        V4 Reward Amount
                    </label>
                    <input
                        type="number"
                        name="video_reward_v4_amount"
                        id="video_reward_v4_amount"
                        class="form-control col-sm-8"
                        min="1"
                        required
                        title="Gift coin amount sent after the V4 daily live target is completed."
                        value="{{ old('video_reward_v4_amount', $videoRewardV4Amount) }}"
                    >
                </div>

                <div class="form-group col-md-8 mb-3">
                    <label for="video_reward_v4_sender_id" class="col-sm-4 col-form-label text-right">
                        V4 Sender ID
                    </label>
                    <input
                        type="number"
                        name="video_reward_v4_sender_id"
                        id="video_reward_v4_sender_id"
                        class="form-control col-sm-8"
                        min="1"
                        required
                        title="User ID used to send the V4 reward gift."
                        value="{{ old('video_reward_v4_sender_id', $videoRewardV4SenderId) }}"
                    >
                </div>

                <div class="form-group col-md-8 mb-3">
                    <label for="video_reward_v4_gift_name" class="col-sm-4 col-form-label text-right">
                        V4 Gift Name
                    </label>
                    <input
                        type="text"
                        name="video_reward_v4_gift_name"
                        id="video_reward_v4_gift_name"
                        class="form-control col-sm-8"
                        required
                        title="Gift asset name stored in gifts for V4 reward."
                        value="{{ old('video_reward_v4_gift_name', $videoRewardV4GiftName) }}"
                    >
                </div>

                <div class="form-group col-md-12 mb-3">
                    <small class="text-muted">
                        Used by `api/v4/video_day_time_request`.
                    </small>
                </div>

                <div class="form-group col-md-12 mt-4 mb-2">
                    <h5 class="font-weight-bold">Reward Setup (Legacy API)</h5>
                </div>

                <div class="form-group col-md-8 mb-3">
                    <label for="video_reward_legacy_enabled" class="col-sm-4 col-form-label text-right">
                        Legacy Reward Active
                    </label>
                    <div class="col-sm-8 d-flex align-items-center">
                        <input type="hidden" name="video_reward_legacy_enabled" value="0">
                        <input
                            type="checkbox"
                            name="video_reward_legacy_enabled"
                            id="video_reward_legacy_enabled"
                            value="1"
                            class="mr-2"
                            title="Enable or disable the legacy daily live reward."
                            {{ old('video_reward_legacy_enabled', $videoRewardLegacyEnabled) ? 'checked' : '' }}
                        >
                        <small class="text-muted mb-0">Legacy daily live reward on or off.</small>
                    </div>
                </div>

                <div class="form-group col-md-8 mb-3">
                    <label for="video_reward_legacy_threshold_minutes" class="col-sm-4 col-form-label text-right">
                        Legacy Target Minutes
                    </label>
                    <input
                        type="number"
                        name="video_reward_legacy_threshold_minutes"
                        id="video_reward_legacy_threshold_minutes"
                        class="form-control col-sm-8"
                        min="1"
                        max="1440"
                        required
                        title="Required total live minutes in one day before the legacy reward is sent."
                        value="{{ old('video_reward_legacy_threshold_minutes', $videoRewardLegacyThresholdMinutes) }}"
                    >
                </div>

                <div class="form-group col-md-8 mb-3">
                    <label for="video_reward_legacy_amount" class="col-sm-4 col-form-label text-right">
                        Legacy Reward Amount
                    </label>
                    <input
                        type="number"
                        name="video_reward_legacy_amount"
                        id="video_reward_legacy_amount"
                        class="form-control col-sm-8"
                        min="1"
                        required
                        title="Gift coin amount sent after the legacy daily live target is completed."
                        value="{{ old('video_reward_legacy_amount', $videoRewardLegacyAmount) }}"
                    >
                </div>

                <div class="form-group col-md-8 mb-3">
                    <label for="video_reward_legacy_sender_id" class="col-sm-4 col-form-label text-right">
                        Legacy Sender ID
                    </label>
                    <input
                        type="number"
                        name="video_reward_legacy_sender_id"
                        id="video_reward_legacy_sender_id"
                        class="form-control col-sm-8"
                        min="1"
                        required
                        title="User ID used to send the legacy reward gift."
                        value="{{ old('video_reward_legacy_sender_id', $videoRewardLegacySenderId) }}"
                    >
                </div>

                <div class="form-group col-md-8 mb-3">
                    <label for="video_reward_legacy_gift_name" class="col-sm-4 col-form-label text-right">
                        Legacy Gift Name
                    </label>
                    <input
                        type="text"
                        name="video_reward_legacy_gift_name"
                        id="video_reward_legacy_gift_name"
                        class="form-control col-sm-8"
                        required
                        title="Gift asset name stored in gifts for the legacy reward."
                        value="{{ old('video_reward_legacy_gift_name', $videoRewardLegacyGiftName) }}"
                    >
                </div>

                <div class="form-group col-md-8 mb-3">
                    <label for="video_reward_legacy_block_enabled" class="col-sm-4 col-form-label text-right">
                        Legacy Block Time
                    </label>
                    <div class="col-sm-8 d-flex align-items-center">
                        <input type="hidden" name="video_reward_legacy_block_enabled" value="0">
                        <input
                            type="checkbox"
                            name="video_reward_legacy_block_enabled"
                            id="video_reward_legacy_block_enabled"
                            value="1"
                            class="mr-2"
                            title="When active, the legacy reward is blocked inside the configured time window."
                            {{ old('video_reward_legacy_block_enabled', $videoRewardLegacyBlockEnabled) ? 'checked' : '' }}
                        >
                        <small class="text-muted mb-0">Use blocked time window for legacy reward.</small>
                    </div>
                </div>

                <div class="form-group col-md-8 mb-3">
                    <label for="video_reward_legacy_block_start" class="col-sm-4 col-form-label text-right">
                        Legacy Block Start
                    </label>
                    <input
                        type="time"
                        step="1"
                        name="video_reward_legacy_block_start"
                        id="video_reward_legacy_block_start"
                        class="form-control col-sm-8"
                        required
                        title="Blocked window start time in server timezone."
                        value="{{ old('video_reward_legacy_block_start', $videoRewardLegacyBlockStart) }}"
                    >
                </div>

                <div class="form-group col-md-8 mb-3">
                    <label for="video_reward_legacy_block_end" class="col-sm-4 col-form-label text-right">
                        Legacy Block End
                    </label>
                    <input
                        type="time"
                        step="1"
                        name="video_reward_legacy_block_end"
                        id="video_reward_legacy_block_end"
                        class="form-control col-sm-8"
                        required
                        title="Blocked window end time in server timezone."
                        value="{{ old('video_reward_legacy_block_end', $videoRewardLegacyBlockEnd) }}"
                    >
                </div>

                <div class="form-group col-md-12 mb-3">
                    <small class="text-muted">
                        Used by `api/video_day_time_request`. Legacy reward block time follows the server timezone in that controller.
                    </small>
                </div>

                <div class="form-group col-md-12 mb-3">
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
