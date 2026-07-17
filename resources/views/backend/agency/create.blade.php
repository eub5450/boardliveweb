@extends('backend.layouts.main')

@section('title')
Create Agency
@endsection

@section('content')
<style>
    .agency-page {
        background: #f4f6f8;
        min-height: calc(100vh - 90px);
        padding: 18px;
        color: #111827;
    }
    .agency-shell {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        box-shadow: 0 14px 34px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }
    .agency-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 18px 20px;
        border-bottom: 1px solid #e5e7eb;
        background: linear-gradient(180deg, #ffffff, #f8fafc);
    }
    .agency-header h4 {
        margin: 0;
        color: #111827;
        font-size: 18px;
        font-weight: 800;
    }
    .agency-header span {
        color: #64748b;
        font-size: 12px;
        font-weight: 700;
    }
    .agency-form {
        padding: 20px;
    }
    .agency-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
    }
    .agency-field {
        min-width: 0;
    }
    .agency-field label {
        color: #374151;
        display: block;
        font-size: 12px;
        font-weight: 800;
        margin-bottom: 7px;
        text-transform: uppercase;
        letter-spacing: 0;
    }
    .agency-field .form-control {
        width: 100%;
        height: 42px;
        border-radius: 8px;
        border: 1px solid #d1d5db;
        background: #ffffff;
        color: #111827;
        font-size: 14px;
        font-weight: 700;
        box-shadow: none;
    }
    .agency-field .form-control:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
    }
    .agency-upload {
        display: grid;
        grid-template-columns: 1fr 82px;
        gap: 12px;
        align-items: end;
    }
    .agency-preview {
        width: 82px;
        height: 82px;
        border-radius: 8px;
        border: 1px solid #d1d5db;
        background: #f8fafc;
        object-fit: cover;
    }
    .agency-help {
        display: block;
        margin-top: 6px;
        color: #64748b;
        font-size: 11px;
        font-weight: 700;
    }
    .agency-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding-top: 18px;
        margin-top: 18px;
        border-top: 1px solid #e5e7eb;
    }
    .agency-actions .btn {
        border-radius: 8px;
        font-size: 13px;
        font-weight: 800;
        padding: 10px 16px;
    }
    @media (max-width: 768px) {
        .agency-page {
            padding: 10px;
        }
        .agency-header {
            align-items: flex-start;
            flex-direction: column;
        }
        .agency-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="body-content agency-page">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="agency-shell">
        <div class="agency-header">
            <div>
                <h4>Create Agency</h4>
                <span>Agency owner, verification image, and phone details</span>
            </div>
            <a href="{{ URL::to('agency_list') }}" class="btn btn-outline-secondary btn-sm">Agency Directory</a>
        </div>

        <form action="{{ URL::to('agency_store') }}" method="post" enctype="multipart/form-data" class="agency-form">
            @csrf
            <div class="agency-grid">
                <div class="agency-field">
                    <label for="agency_user_id">Member ID</label>
                    <input type="text" name="user_id" class="form-control agency_user_id" placeholder="Member ID" value="{{ old('user_id') }}" id="agency_user_id" required>
                </div>
                <div class="agency-field">
                    <label for="name">User Name</label>
                    <input type="text" name="name" class="form-control" placeholder="User Name" value="{{ old('name') }}" id="name" readonly required>
                </div>
                <div class="agency-field">
                    <label for="agency_name">Agency Name</label>
                    <input type="text" name="agency_name" class="form-control" placeholder="Agency Name" value="{{ old('agency_name') }}" id="agency_name" required>
                </div>
                <div class="agency-field">
                    <label for="agencycode">Agency Code</label>
                    <input type="text" name="agency_code" readonly class="form-control" placeholder="Agency Code" id="agencycode" value="{{ old('agency_code') }}">
                </div>
                <div class="agency-field">
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" class="form-control" id="phone" placeholder="Phone Number" value="{{ old('phone') }}" required>
                </div>
                <div></div>
                <div class="agency-field">
                    <label for="photo_id">Photo ID</label>
                    <div class="agency-upload">
                        <div>
                            <input type="file" name="photo_id" class="form-control agency-image-input" id="photo_id" onchange="readAgencyPreview(this, '#photo_preview');" required accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
                            <small class="agency-help">JPG, JPEG, PNG or WEBP. Max 2MB.</small>
                        </div>
                        <img src="{{ URL::to('store/profile/default.png') }}" id="photo_preview" class="agency-preview" alt="Photo ID">
                    </div>
                </div>
                <div class="agency-field">
                    <label for="selfie">Selfie</label>
                    <div class="agency-upload">
                        <div>
                            <input type="file" name="selfie" class="form-control agency-image-input" id="selfie" onchange="readAgencyPreview(this, '#selfie_preview');" required accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
                            <small class="agency-help">JPG, JPEG, PNG or WEBP. Max 2MB.</small>
                        </div>
                        <img src="{{ URL::to('store/profile/default.png') }}" id="selfie_preview" class="agency-preview" alt="Selfie">
                    </div>
                </div>
            </div>
            <div class="agency-actions">
                <button type="reset" class="btn btn-light">Reset</button>
                <button type="submit" class="btn btn-success">Save Agency</button>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    function validateAgencyImage(input) {
        if (!input.files || !input.files[0]) {
            return true;
        }
        var file = input.files[0];
        var validTypes = ['image/jpeg', 'image/png', 'image/webp'];
        var maxSize = 2 * 1024 * 1024;
        if (validTypes.indexOf(file.type) === -1 || file.size > maxSize) {
            alert('Only JPG, JPEG, PNG or WEBP files are allowed and max file size is 2MB.');
            input.value = '';
            return false;
        }
        return true;
    }

    function readAgencyPreview(input, target) {
        if (!validateAgencyImage(input)) {
            $(target).attr('src', '');
            return;
        }
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $(target).attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
