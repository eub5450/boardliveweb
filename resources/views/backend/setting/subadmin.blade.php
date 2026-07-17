@extends('backend.layouts.main')

@section('title')
Admin Setting
@endsection
@section('content')
<style>
.jambo-admin-page { background:#f3f7fb; border-radius:14px; padding:14px; }
.jambo-hero { background:linear-gradient(135deg,#08172d,#0c315f 56%,#1765a6); border-radius:14px; color:#fff; padding:18px 20px; margin-bottom:16px; box-shadow:0 10px 28px rgba(8,23,45,.18); }
.jambo-hero h4 { margin:0; font-weight:800; letter-spacing:.2px; color:#fff; }
.jambo-hero p { margin:6px 0 0; color:#d9edff; }
.jambo-toolbar { display:flex; flex-wrap:wrap; gap:10px; align-items:center; justify-content:space-between; margin-bottom:14px; }
.jambo-toolbar form, .jambo-inline { display:flex; flex-wrap:wrap; gap:8px; align-items:center; }
.jambo-panel { border:1px solid #d8e6f3; border-radius:14px; background:#fff; box-shadow:0 8px 20px rgba(20,54,92,.08); overflow:hidden; margin-bottom:16px; }
.jambo-panel-head { padding:14px 16px; border-bottom:1px solid #e7eef7; display:flex; justify-content:space-between; align-items:center; gap:10px; background:#fbfdff; }
.jambo-panel-head h5 { margin:0; color:#17365d; font-weight:800; }
.permission-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:10px; }
.permission-box { border:1px solid #dce8f4; border-radius:12px; padding:10px; background:#f8fbff; }
.permission-box h5 { margin:0 0 8px; font-size:13px; color:#0d3b66; font-weight:800; }
.permission-item { display:flex; gap:7px; align-items:flex-start; font-size:12px; color:#263b53; margin-bottom:6px; line-height:1.25; cursor:pointer; }
.permission-item input { margin-top:2px; }
.admin-permission-actions { display:grid; grid-template-columns:minmax(150px,1fr) minmax(180px,220px) minmax(170px,1fr) auto; gap:8px; align-items:center; margin-bottom:12px; }
.preset-row { display:flex; flex-wrap:wrap; gap:6px; margin:8px 0 12px; }
.preset-row .btn { border-radius:20px; }
.admin-table { margin-bottom:0; background:#fff; }
.admin-table thead th { background:#102a49; color:#eaf6ff; border-color:#102a49; vertical-align:middle; }
.admin-table tbody td { vertical-align:top; color:#243447; }
.admin-user-title { font-weight:800; color:#16395f; }
.admin-user-sub { color:#64748b; font-size:12px; word-break:break-all; }
.access-badge { display:inline-block; border-radius:20px; padding:5px 10px; background:#e9f4ff; color:#0d4d82; font-size:12px; font-weight:700; }
.perm-chip { display:inline-block; border-radius:20px; padding:4px 9px; background:#edf7f0; color:#166534; font-size:12px; font-weight:700; }
.jambo-permission-panel { border:1px solid #dde8f5; border-radius:12px; background:#fbfdff; padding:0; }
.jambo-permission-panel summary { cursor:pointer; padding:10px 12px; color:#14365c; font-weight:800; list-style:none; }
.jambo-permission-panel summary::-webkit-details-marker { display:none; }
.jambo-permission-panel summary:after { content:'Open'; float:right; color:#0b84d8; font-size:12px; }
.jambo-permission-panel[open] summary:after { content:'Close'; }
.jambo-permission-body { padding:0 12px 12px; }
	.jambo-danger-zone { display:flex; justify-content:flex-end; margin-top:8px; }
	.country-admin-card { border:1px solid #c7ddff; border-radius:14px; padding:14px; background:linear-gradient(135deg,#f7fbff,#eef6ff); box-shadow:0 8px 18px rgba(22,78,155,.08); }
	.country-admin-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:10px; align-items:end; }
	.country-admin-note { font-size:12px; color:#48637f; margin-top:8px; }
@media (max-width: 768px) {
  .admin-permission-actions { grid-template-columns:1fr; }
  .jambo-toolbar { display:block; }
  .jambo-toolbar form { margin-bottom:8px; }
}
</style>
<div class="body-content">
  <div class="card mb-4">
    <div class="card-body">
      <section class="forms">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="jambo-admin-page">
                <div class="jambo-hero">
                  <h4>JAMBO Admin Permission Control</h4>
	                    <p>Set Normal, Admin, Sub Admin, or Country Admin access. Country Admin saves as <code style="color:#fff;">is_admin=2</code>, <code style="color:#fff;">role=2</code>, <code style="color:#fff;">status=1</code>.</p>
                </div>

                <div class="jambo-toolbar">
                  <form action="{{URL::to('setting/admin')}}" method="get">
                    <input type="text" name="q" value="{{$query}}" class="form-control" placeholder="Search ID, name, email">
                    <button type="submit" class="btn btn-info">Search</button>
                    @if($query)
                      <a href="{{URL::to('setting/admin')}}" class="btn btn-default">Clear</a>
                    @endif
                  </form>
                  <span class="access-badge">Table: adminparmisiton</span>
	                </div>

	                <div class="jambo-panel">
	                  <div class="jambo-panel-head">
	                    <h5>Country Admin Panel</h5>
	                    <span class="perm-chip">BD / India / Pakistan</span>
	                  </div>
	                  <div class="card-body">
	                    <form action="{{URL::to('setting/country-admin-store')}}" method="post" class="country-admin-card">
	                      @csrf
	                      <div class="country-admin-grid">
	                        <div>
	                          <label>Existing user ID or email</label>
	                          <input type="text" name="target_user" class="form-control" value="{{old('target_user')}}" placeholder="Select existing user">
	                        </div>
	                        <div>
	                          <label>Country</label>
	                          <select name="country_id" class="form-control" required>
	                            <option value="1" @if(old('country_id') == '1') selected @endif>Bangladesh</option>
	                            <option value="2" @if(old('country_id') == '2') selected @endif>India</option>
	                            <option value="3" @if(old('country_id') == '3') selected @endif>Pakistan</option>
	                          </select>
	                        </div>
	                        <div>
	                          <label>New user name</label>
	                          <input type="text" name="name" class="form-control" value="{{old('name')}}" placeholder="Required only for new">
	                        </div>
	                        <div>
	                          <label>New user email</label>
	                          <input type="email" name="email" class="form-control" value="{{old('email')}}" placeholder="Required only for new">
	                        </div>
	                        <div>
	                          <label>Phone</label>
	                          <input type="text" name="phone" class="form-control" value="{{old('phone')}}" placeholder="Optional">
	                        </div>
	                        <div>
	                          <label>Password</label>
	                          <input type="password" name="password" class="form-control" placeholder="Required for new / optional reset">
	                        </div>
	                        <div>
	                          <button type="submit" class="btn btn-primary btn-block">Save Country Admin</button>
	                        </div>
	                      </div>
	                      <div class="country-admin-note">
	                        If existing user is provided, the user is promoted to Country Admin. If existing user is blank, name, email, and password create a new Country Admin. Controller always saves <b>is_admin=2</b>, <b>role=2</b>, <b>status=1</b>, and selected <b>country_id</b>. New-user fields disable existing-user input automatically, and existing-user input disables new-user fields.
	                      </div>
	                    </form>
	                    <div style="font-size:10px;text-align:center;color:#999;padding-top:12px;">Powerd by JAMBOai</div>
	                  </div>
	                </div>

	                <div class="jambo-panel">
                  <div class="jambo-panel-head">
                    <h5>Add or Update Admin</h5>
                    <span class="perm-chip">MFA/session protected</span>
                  </div>
                  <div class="card-body">
                    <form action="{{URL::to('setting/admin-update')}}" method="post" class="jambo-permission-form">
                      @csrf
                      <div class="admin-permission-actions">
                        <input type="text" name="target_user" class="form-control" placeholder="User ID or email" required>
	                        <select name="admin_mode" class="form-control" required>
	                          @foreach($adminModes as $value => $label)
	                            @if($value !== 'country_admin')
	                              <option value="{{$value}}">{{$label}}</option>
	                            @endif
	                          @endforeach
	                        </select>
                        <input type="password" name="password" class="form-control" placeholder="New password optional">
                        <button type="submit" class="btn btn-primary">Save Permission</button>
                      </div>
                      <div class="preset-row">
                        <button type="button" class="btn btn-xs btn-success js-permission-preset" data-preset="admin" data-mode="admin">Admin Full</button>
                        <button type="button" class="btn btn-xs btn-info js-permission-preset" data-preset="subadmin" data-mode="subadmin">Sub Admin Basic</button>
                        <button type="button" class="btn btn-xs btn-default js-permission-preset" data-preset="clear">Clear All</button>
                      </div>
                      <details class="jambo-permission-panel" open>
                        <summary>Select permissions for this user</summary>
                        <div class="jambo-permission-body">
                          <div class="permission-grid">
                            @foreach($permissionGroups as $group => $permissions)
                              <div class="permission-box">
                                <h5>{{$group}}</h5>
                                @foreach($permissions as $key => $label)
                                  <label class="permission-item">
                                    <input type="checkbox" name="permissions[]" value="{{$key}}">
                                    <span>{{$label}}</span>
                                  </label>
                                @endforeach
                              </div>
                            @endforeach
                          </div>
                        </div>
                      </details>
                    </form>
                    <div style="font-size:10px;text-align:center;color:#999;padding-top:12px;">Powerd by JAMBOai</div>
                  </div>
                </div>

                <div class="jambo-panel">
                <div class="jambo-panel-head">
                  <h5>Admin / Sub Admin Users</h5>
                  <span class="perm-chip">{{count($users)}} user(s)</span>
                </div>
                <div class="table-responsive">
                  <table class="table table-bordered table-hover admin-table">
                    <thead>
                      <tr>
                        <th style="min-width:210px;">Admin User</th>
                        <th>Access</th>
                        <th style="min-width:520px;">Permissions</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($users as $user)
                      @php
                        $currentPermissions = $userPermissions[$user->id] ?? [];
                        $enabledCount = collect($currentPermissions)->filter()->count();
	                        $mode = (int)$user->is_admin === 2 ? 'country_admin' : ((int)$user->is_admin === 0 ? 'normal' : (!empty($currentPermissions['setting_admin_manage']) ? 'admin' : 'subadmin'));
	                        $modeLabel = $adminModes[$mode] ?? 'Unknown';
	                        $countryNames = [1 => 'Bangladesh', 2 => 'India', 3 => 'Pakistan'];
                      @endphp
                      <tr>
                        <td>
                          <div class="admin-user-title">#{{$user->id}} - {{$user->name}}</div>
                          <div class="admin-user-sub">{{$user->email}}</div>
                        </td>
                        <td>
	                          <span class="access-badge">{{$modeLabel}}</span>
	                          <div style="margin-top:5px;color:#64748b;font-size:12px;">DB is_admin={{(int)$user->is_admin}}</div>
	                          @if((int)$user->is_admin === 2)
	                            <div style="margin-top:5px;color:#64748b;font-size:12px;">Country: {{$countryNames[(int)$user->country_id] ?? ('ID '.$user->country_id)}}</div>
	                          @endif
	                          <div style="margin-top:8px;"><span class="perm-chip">{{$enabledCount}} permissions on</span></div>
                        </td>
                        <td>
                          <form action="{{URL::to('setting/admin-update')}}" method="post" class="jambo-permission-form">
                            @csrf
                            <input type="hidden" name="target_user" value="{{$user->id}}">
                            <div class="admin-permission-actions">
	                              <select name="admin_mode" class="form-control" required>
	                                @foreach($adminModes as $value => $label)
	                                  @if($value !== 'country_admin' || $mode === 'country_admin')
	                                    <option value="{{$value}}" @if($mode === $value) selected @endif>{{$label}}</option>
	                                  @endif
	                                @endforeach
	                              </select>
                              <input type="password" name="password" class="form-control" placeholder="New password optional">
                              <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                            <div class="preset-row">
                              <button type="button" class="btn btn-xs btn-success js-permission-preset" data-preset="admin" data-mode="admin">Admin Full</button>
                              <button type="button" class="btn btn-xs btn-info js-permission-preset" data-preset="subadmin" data-mode="subadmin">Sub Admin Basic</button>
                              <button type="button" class="btn btn-xs btn-default js-permission-preset" data-preset="clear">Clear All</button>
                            </div>
                            <details class="jambo-permission-panel">
                              <summary>Edit {{$user->name}} permissions</summary>
                              <div class="jambo-permission-body">
                                <div class="permission-grid">
                                  @foreach($permissionGroups as $group => $permissions)
                                    <div class="permission-box">
                                      <h5>{{$group}}</h5>
                                      @foreach($permissions as $key => $label)
                                        <label class="permission-item">
                                          <input type="checkbox" name="permissions[]" value="{{$key}}" @if(!empty($currentPermissions[$key])) checked @endif>
                                          <span>{{$label}}</span>
                                        </label>
                                      @endforeach
                                    </div>
                                  @endforeach
                                </div>
                              </div>
                            </details>
                          </form>
                          @if((int)$user->id !== (int)Auth::id())
                          <form action="{{URL::to('setting/admin-delete')}}" method="post" onsubmit="return confirm('Remove admin permission for {{$user->id}}?')" class="jambo-danger-zone">
                            @csrf
                            <input type="hidden" name="target_user" value="{{$user->id}}">
                            <button type="submit" class="btn btn-sm btn-danger">Delete Admin Permission</button>
                          </form>
                          @endif
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
  var presets = {
    admin: ['sidebar_access','sidebar_coin_balance','sidebar_menu_dashboard','sidebar_menu_host','sidebar_host_add','sidebar_host_active','sidebar_host_pending','sidebar_host_transfer','sidebar_menu_agency','sidebar_agency_create','sidebar_agency_list','sidebar_menu_protal','sidebar_protal_create','sidebar_protal_list','sidebar_protal_recall_create','sidebar_protal_recall_history','sidebar_protal_recharge','sidebar_protal_recharge_list','sidebar_protal_new_recall','sidebar_protal_recall_list','sidebar_menu_support','sidebar_support_index','sidebar_menu_ranking','sidebar_ranking_list','sidebar_menu_user_balance','sidebar_user_balance_wallet','sidebar_menu_coin_generate','sidebar_coin_generate_generate','sidebar_menu_ban','sidebar_ban_id','sidebar_menu_live','sidebar_live_list','sidebar_menu_game_control','sidebar_game_fruits_detail','sidebar_game_fruits_lock','sidebar_game_teenpatti_detail','sidebar_game_greedy_detail','sidebar_game_fruits_pattern','sidebar_menu_setting','sidebar_setting_banner','sidebar_setting_country','sidebar_setting_gift_data','sidebar_setting_agora','sidebar_setting_email_change','sidebar_setting_admin','sidebar_setting_audio_background','sidebar_setting_store','dashboard_access','dashboard_vip_offer','dashboard_version_update','dashboard_profit_loss','dashboard_total_serve_coin','dashboard_coin_generate_game','dashboard_game_pro_balance','dashboard_game_pro_balance_manage','profile_search','profile_balance','profile_sensitive_info','profile_other_ids','profile_power_buttons','profile_vip_frames_edit','profile_password_daytime','setting_admin_manage'],
    subadmin: ['sidebar_access','sidebar_coin_balance','sidebar_menu_dashboard','sidebar_menu_host','sidebar_host_add','sidebar_host_active','sidebar_host_pending','sidebar_host_transfer','sidebar_menu_agency','sidebar_agency_create','sidebar_agency_list','sidebar_menu_protal','sidebar_protal_create','sidebar_protal_list','sidebar_protal_recall_create','sidebar_protal_recall_history','sidebar_protal_recharge','sidebar_protal_recharge_list','sidebar_protal_new_recall','sidebar_protal_recall_list','sidebar_menu_support','sidebar_support_index','sidebar_menu_ranking','sidebar_ranking_list','sidebar_menu_ban','sidebar_ban_id','sidebar_menu_live','sidebar_live_list','sidebar_menu_setting','sidebar_setting_banner','sidebar_setting_store','dashboard_access','dashboard_country_game_balance_cards','dashboard_game_pro_balance','profile_search','profile_balance','profile_power_buttons','profile_vip_frames_edit']
  };
	  document.querySelectorAll('.js-permission-preset').forEach(function (button) {
    button.addEventListener('click', function () {
      var form = button.closest('form');
      if (!form) return;
      var preset = button.getAttribute('data-preset');
      var selected = presets[preset] || [];
      var mode = button.getAttribute('data-mode');
      var select = form.querySelector('select[name="admin_mode"]');
      if (mode && select) select.value = mode;
      if (preset === 'clear' && select) select.value = 'normal';
      form.querySelectorAll('input[name="permissions[]"]').forEach(function (checkbox) {
        checkbox.checked = selected.indexOf(checkbox.value) !== -1;
	      });
	    });
	  });
	  document.querySelectorAll('form[action$="setting/country-admin-store"]').forEach(function (form) {
	    var existing = form.querySelector('input[name="target_user"]');
	    var newFields = Array.prototype.slice.call(form.querySelectorAll('input[name="name"], input[name="email"], input[name="password"]'));
	    function hasNewValue() {
	      return newFields.some(function (field) { return field.value.trim() !== ''; });
	    }
	    function syncCountryAdminInputs(source) {
	      var hasExisting = existing && existing.value.trim() !== '';
	      var hasNew = hasNewValue();
	      if (source === 'existing' && hasExisting) {
	        newFields.forEach(function (field) { field.value = ''; field.disabled = true; });
	        existing.disabled = false;
	        return;
	      }
	      if (source === 'new' && hasNew) {
	        if (existing) { existing.value = ''; existing.disabled = true; }
	        newFields.forEach(function (field) { field.disabled = false; });
	        return;
	      }
	      if (existing) existing.disabled = hasNew;
	      newFields.forEach(function (field) { field.disabled = hasExisting; });
	    }
	    if (existing) existing.addEventListener('input', function () { syncCountryAdminInputs('existing'); });
	    newFields.forEach(function (field) { field.addEventListener('input', function () { syncCountryAdminInputs('new'); }); });
	    syncCountryAdminInputs();
	  });
	});
	</script>
@endsection
