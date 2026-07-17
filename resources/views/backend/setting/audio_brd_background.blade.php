@extends('backend.layouts.main')

@section('title', 'Audio Board Backgrounds')

@section('content')
@php $brandName = config('app.name') ?: 'Live App'; @endphp
<style>
.jambo-background-page { background:#f3f7fb; border-radius:18px; padding:16px; }
.jambo-background-hero { display:flex; flex-wrap:wrap; gap:18px; justify-content:space-between; align-items:flex-end; background:linear-gradient(135deg,#071a31 0%,#0f3f73 52%,#1e78b8 100%); border-radius:18px; padding:22px 24px; box-shadow:0 16px 36px rgba(8,32,58,.18); color:#fff; margin-bottom:18px; }
.jambo-background-hero h3 { margin:4px 0 8px; font-size:28px; font-weight:800; color:#fff; }
.jambo-background-hero p { margin:0; max-width:680px; color:#d8efff; line-height:1.55; }
.jambo-eyebrow { display:inline-block; border-radius:999px; padding:6px 12px; background:rgba(255,255,255,.15); color:#eaf7ff; font-size:12px; font-weight:800; letter-spacing:.08em; text-transform:uppercase; }
.jambo-hero-stat { min-width:170px; border-radius:16px; background:rgba(255,255,255,.12); padding:14px 16px; text-align:right; }
.jambo-hero-stat strong { display:block; font-size:34px; line-height:1; font-weight:800; color:#fff; }
.jambo-hero-stat span { display:block; margin-top:6px; color:#d8efff; font-size:12px; letter-spacing:.04em; text-transform:uppercase; }
.jambo-alert { border:none; border-radius:14px; box-shadow:0 10px 22px rgba(16,46,80,.08); margin-bottom:16px; }
.jambo-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(320px,1fr)); gap:16px; }
.jambo-card { background:#fff; border:1px solid #dbe7f3; border-radius:18px; box-shadow:0 10px 24px rgba(15,42,76,.08); overflow:hidden; display:flex; flex-direction:column; }
.jambo-preview-shell { position:relative; padding:14px; background:linear-gradient(180deg,#eff7ff 0%,#dcefff 100%); }
.jambo-preview-shell img { width:100%; height:220px; object-fit:cover; border-radius:14px; display:block; background:#c8dff4; }
.jambo-empty-preview { height:220px; border-radius:14px; display:flex; align-items:center; justify-content:center; background:linear-gradient(135deg,#dae8f5,#edf6ff); color:#5d7288; font-weight:700; }
.jambo-chip-row { position:absolute; top:24px; left:24px; right:24px; display:flex; justify-content:space-between; gap:8px; }
.jambo-chip { display:inline-flex; align-items:center; border-radius:999px; padding:6px 12px; background:rgba(7,26,49,.78); color:#eff8ff; font-size:11px; font-weight:800; letter-spacing:.04em; text-transform:uppercase; }
.jambo-card-body { padding:18px; display:flex; flex-direction:column; gap:14px; }
.jambo-card-title { margin:0; font-size:20px; font-weight:800; color:#14365c; }
.jambo-card-subtitle { margin:4px 0 0; color:#6a7d91; font-size:13px; }
.jambo-path-box { border:1px dashed #c7d8e8; border-radius:12px; background:#f8fbff; padding:12px; font-size:12px; line-height:1.5; color:#44617d; word-break:break-all; }
.jambo-path-box strong { display:block; margin-bottom:6px; color:#173a60; font-size:12px; letter-spacing:.04em; text-transform:uppercase; }
.jambo-upload-form { display:flex; flex-direction:column; gap:12px; }
.jambo-upload-field { border:1px solid #cfdeec; border-radius:14px; background:#f9fcff; padding:14px; cursor:pointer; transition:border-color .2s ease, box-shadow .2s ease; }
.jambo-upload-field:hover { border-color:#74a9d9; box-shadow:0 6px 16px rgba(31,119,189,.12); }
.jambo-upload-field input[type=file] { display:block; width:100%; margin-top:10px; }
.jambo-upload-label { display:flex; justify-content:space-between; align-items:center; gap:12px; }
.jambo-upload-label strong { color:#15365b; font-size:14px; font-weight:800; }
.jambo-upload-label span { color:#5f748a; font-size:12px; }
.jambo-actions { display:flex; flex-wrap:wrap; justify-content:space-between; align-items:center; gap:10px; }
.jambo-help { color:#6b8095; font-size:12px; line-height:1.45; }
.jambo-btn { border:none; border-radius:999px; padding:11px 18px; background:linear-gradient(135deg,#0f538d,#1d82c2); color:#fff; font-weight:800; letter-spacing:.02em; box-shadow:0 10px 18px rgba(15,83,141,.18); }
.jambo-btn:hover { background:linear-gradient(135deg,#0d497b,#186ea5); color:#fff; }
.jambo-empty-card { padding:40px 24px; text-align:center; color:#5f7387; }
.jambo-empty-card h4 { color:#16395d; font-weight:800; margin-bottom:8px; }
.jambo-footer { margin-top:14px; text-align:right; font-size:10px; color:#6d8195; }
@media (max-width: 767px) {
  .jambo-background-page { padding:12px; }
  .jambo-background-hero { padding:18px; }
  .jambo-background-hero h3 { font-size:24px; }
  .jambo-hero-stat { width:100%; text-align:left; }
  .jambo-actions { align-items:flex-start; }
}
</style>

<div class="body-content">
  <div class="jambo-background-page">
    <div class="jambo-background-hero">
      <div>
        <span class="jambo-eyebrow">Setting Menu</span>
        <h3>Audio Board Background Manager</h3>
        <p>Keep {{ $brandName }} audio board backgrounds clean, branded, and easy to maintain. Each update replaces the current image with a safer upload flow and instant visual review.</p>
      </div>
      <div class="jambo-hero-stat">
        <strong>{{ $data->count() }}</strong>
        <span>Default backgrounds</span>
      </div>
    </div>

    @if(session('success'))
      <div class="alert alert-success jambo-alert">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
      <div class="alert alert-danger jambo-alert">
        <strong>Upload could not be completed.</strong>
        <ul style="margin:8px 0 0 18px;">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <div class="jambo-grid">
      @forelse ($data as $item)
        <div class="jambo-card">
          <div class="jambo-preview-shell">
            <div class="jambo-chip-row">
              <span class="jambo-chip">Default #{{ $loop->iteration }}</span>
              <span class="jambo-chip">ID {{ $item->id }}</span>
            </div>
            @if(!empty($item->preview_url))
              <img src="{{ $item->preview_url }}" alt="Background {{ $loop->iteration }}" data-preview>
            @else
              <div class="jambo-empty-preview">No image configured</div>
            @endif
          </div>

          <div class="jambo-card-body">
            <div>
              <h4 class="jambo-card-title">Audio Background {{ $loop->iteration }}</h4>
              <p class="jambo-card-subtitle">Update the default image shown for this board slot.</p>
            </div>

            <div class="jambo-path-box">
              <strong>Current file path</strong>
              {{ $item->image ?: 'No image path saved yet.' }}
            </div>

            <form action="{{ route('audio-backgrounds.update', $item->id) }}" method="POST" enctype="multipart/form-data" class="jambo-upload-form">
              @csrf
              @method('PUT')

              <label class="jambo-upload-field">
                <div class="jambo-upload-label">
                  <strong>Select replacement image</strong>
                  <span data-file-label>JPG, PNG, WEBP</span>
                </div>
                <input type="file" name="image" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" required>
              </label>

              <div class="jambo-actions">
                <div class="jambo-help">Upload a clean branded image. Recommended landscape artwork, maximum 5 MB.</div>
                <button type="submit" class="btn jambo-btn">Update Background</button>
              </div>
            </form>
          </div>
        </div>
      @empty
        <div class="jambo-card jambo-empty-card">
          <h4>No audio backgrounds found</h4>
          <p>Default board background rows are missing in the database. Add the rows first, then return to this page.</p>
        </div>
      @endforelse
    </div>

    <div class="jambo-footer">Powerd by JAMBOai</div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.jambo-upload-form').forEach(function (form) {
    var input = form.querySelector('input[type="file"]');
    if (!input) return;

    input.addEventListener('change', function () {
      var label = form.querySelector('[data-file-label]');
      if (label) {
        label.textContent = input.files && input.files[0] ? input.files[0].name : 'JPG, PNG, WEBP';
      }

      var preview = form.closest('.jambo-card').querySelector('[data-preview]');
      if (preview && input.files && input.files[0]) {
        preview.src = URL.createObjectURL(input.files[0]);
      }
    });
  });
});
</script>
@endsection
