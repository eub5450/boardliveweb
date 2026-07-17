@extends('subadmin.layouts.main')
@section('content')

<div class="body-content">
@php
    $adminCan = function ($key, $default = false) {
        return \App\Models\AdminParmisiton::allowed(Auth::id(), $key, $default);
    };
    $dashboardAccess = $adminCan('dashboard_access');
    $canSeeGameData = $adminCan('dashboard_game_data', $dashboardAccess);
    $canSeeRealtimeFeeds = $adminCan('dashboard_realtime_feeds', $dashboardAccess);
@endphp
<style>
  .subadmin-dashboard-section{margin-bottom:20px}
  .subadmin-card{border:1px solid #e5e7eb;border-radius:8px;background:#fff;box-shadow:0 10px 24px rgba(15,23,42,.08);min-height:130px}
  .subadmin-card .card-body{padding:18px}
  .subadmin-kicker{font-size:11px;font-weight:800;letter-spacing:.04em;text-transform:uppercase;color:#64748b;margin-bottom:6px}
  .subadmin-value{font-size:24px;font-weight:900;color:#111827;line-height:1.1;margin:0}
  .subadmin-meta{font-size:12px;color:#64748b;margin-top:8px}
  .subadmin-game-icon{width:38px;height:38px;border-radius:8px;display:flex;align-items:center;justify-content:center;background:#eef2ff;color:#2563eb;font-size:20px;margin-bottom:10px}
  .subadmin-feed-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(320px,1fr));gap:16px}
  .subadmin-feed-card{border:1px solid #e5e7eb;border-radius:8px;background:#fff;box-shadow:0 10px 24px rgba(15,23,42,.08);overflow:hidden}
  .subadmin-feed-head{padding:14px 16px;border-bottom:1px solid #eef2f7;display:flex;align-items:center;justify-content:space-between}
  .subadmin-feed-head h4{font-size:15px;font-weight:900;margin:0;color:#111827}
  .subadmin-feed-search{padding:12px 16px;border-bottom:1px solid #eef2f7}
  .subadmin-feed-search input{width:100%;border:1px solid #d7dde8;border-radius:7px;padding:8px 10px;font-size:13px}
  .chat-list{max-height:420px;overflow-y:auto;padding:10px}
  .chat-item{display:flex;gap:12px;padding:12px;border-bottom:1px solid #eef2f7}
  .chat-avatar img,.chat-avatar>div{width:44px!important;height:44px!important;border-radius:50%}
  .chat-info h5{font-size:13px;font-weight:800;margin:0 0 4px;color:#111827}
  .chat-info p{font-size:12px;margin:0;color:#374151}
  .feed-meta,.feed-empty{font-size:11px;color:#64748b;margin-top:6px}
</style>

 
<div class="row">
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
        <div class="card card-stats statistic-box mb-4">
            <div class="card-header card-header-warning card-header-icon position-relative border-0 text-right px-3 py-0">
                <div class="card-icon d-flex align-items-center justify-content-center">
                    <i class="typcn typcn-download"></i>
                </div>
                <p class="card-category text-uppercase fs-10 font-weight-bold text-muted">Active Host</p>
                <h3 class="card-title fs-21 font-weight-bold">{{$active_host}}</h3>
            </div>
            <div class="card-footer p-3">
            </div>
        </div>
    </div> 
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
        <div class="card card-stats statistic-box mb-4">
            <div class="card-header card-header-danger card-header-icon position-relative border-0 text-right px-3 py-0">
                <div class="card-icon d-flex align-items-center justify-content-center">
                    <i class="typcn typcn-home-outline"></i>
                </div>
                <p class="card-category text-uppercase fs-10 font-weight-bold text-muted">Total User</p>
                <h3 class="card-title fs-21 font-weight-bold"> {{$total_users}} </h3>
            </div>
            <div class="card-footer p-3">
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
        <div class="card card-stats statistic-box mb-4">
            <div class="card-header card-header-danger card-header-icon position-relative border-0 text-right px-3 py-0">
                <div class="card-icon d-flex align-items-center justify-content-center">
                    <i class="typcn typcn-home-outline"></i>
                </div>
                <p class="card-category text-uppercase fs-10 font-weight-bold text-muted">Total Agency</p>
                <h3 class="card-title fs-21 font-weight-bold"> {{$total_agency}} </h3>
            </div>
            <div class="card-footer p-3">
            </div>
        </div>
    </div>

    @if($canSeeGameData)
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
        <div class="subadmin-card subadmin-dashboard-section">
            <div class="card-body">
                <div class="subadmin-game-icon"><i class="typcn typcn-leaf"></i></div>
                <div class="subadmin-kicker">Fruits Game Balance</div>
                <p class="subadmin-value">{{ (int) round(($fruts_game_balance->game_balance ?? 0) + ($fruts_game_balance->second_balance ?? 0) + ($fruts_game_balance->third_balance ?? 0)) }}</p>
                <div class="subadmin-meta">Main + 2nd + 3rd balance</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
        <div class="subadmin-card subadmin-dashboard-section">
            <div class="card-body">
                <div class="subadmin-game-icon"><i class="typcn typcn-spade"></i></div>
                <div class="subadmin-kicker">Teen Patti Balance</div>
                <p class="subadmin-value">{{ (int) round(($teenpatti_game_balance->game_balance ?? 0) + ($teenpatti_game_balance->second_balance ?? 0) + ($teenpatti_game_balance->third_balance ?? 0)) }}</p>
                <div class="subadmin-meta">Main + 2nd + 3rd balance</div>
            </div>
        </div>
    </div>
    @endif
    @if($canSeeRealtimeFeeds)
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
        <div class="subadmin-card subadmin-dashboard-section">
            <div class="card-body">
                <div class="subadmin-game-icon"><i class="typcn typcn-cog"></i></div>
                <div class="subadmin-kicker">Greedy Balance</div>
                <p class="subadmin-value">{{ (int) round(($greedy_game_balance->game_balance ?? 0) + ($greedy_game_balance->second_balance ?? 0) + ($greedy_game_balance->third_balance ?? 0)) }}</p>
                <div class="subadmin-meta">Main + 2nd + 3rd balance</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
        <div class="subadmin-card subadmin-dashboard-section">
            <div class="card-body">
                <div class="subadmin-game-icon"><i class="typcn typcn-star"></i></div>
                <div class="subadmin-kicker">Five Star Balance</div>
                <p class="subadmin-value">{{ (int) round($five_game_balance->game_balance ?? 0) }}</p>
                <div class="subadmin-meta">Current game balance</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
        <div class="subadmin-card subadmin-dashboard-section">
            <div class="card-body">
                <div class="subadmin-game-icon"><i class="typcn typcn-message"></i></div>
                <div class="subadmin-kicker">Comments Last Hour</div>
                <p class="subadmin-value">{{ (int) ($realtime_comment_count ?? 0) }}</p>
                <div class="subadmin-meta">Live room comment activity</div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
        <div class="subadmin-card subadmin-dashboard-section">
            <div class="card-body">
                <div class="subadmin-game-icon"><i class="typcn typcn-chat"></i></div>
                <div class="subadmin-kicker">Chats Last Hour</div>
                <p class="subadmin-value">{{ (int) ($realtime_chat_count ?? 0) }}</p>
                <div class="subadmin-meta">Private chat activity</div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="subadmin-feed-grid subadmin-dashboard-section">
            <div class="subadmin-feed-card">
                <div class="subadmin-feed-head">
                    <h4><i class="typcn typcn-message mr-2"></i>Live Comments</h4>
                </div>
                <div class="subadmin-feed-search">
                    <input type="text" placeholder="Search comments..." id="searchComment">
                </div>
                <div class="chat-list" id="comment_list"><div class="feed-empty">Loading comments...</div></div>
            </div>
            <div class="subadmin-feed-card">
                <div class="subadmin-feed-head">
                    <h4><i class="typcn typcn-chat mr-2"></i>Private Chat</h4>
                </div>
                <div class="subadmin-feed-search">
                    <input type="text" placeholder="Search chats..." id="searchChat">
                </div>
                <div class="chat-list" id="chat_list"><div class="feed-empty">Loading chats...</div></div>
            </div>
        </div>
    </div>
    @endif
    
      <div class="col-md-12">
                  <div class="card">
                      <div class="card-header d-flex align-items-center">
                          <h4> Pending List</h4>
                      </div>
                      <div class="table-responsive">
                  <table class="table display table-bordered table-striped table-hover basic">
                <thead>
                  <tr>
                   <th>Sl</th>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Image</th>
                    
                    <th>Active</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                  $i=0;
                  @endphp
                  @foreach($data as $item)
                 @php
                 $user=App\Models\User::find($item->user_id);
                
                 @endphp
                  <tr>
                    <td>{{ ++$i }}</td>
                    <td> @if($user) {{$user->id}} @else @endif </td>
                    <td> {{$item->name}}  </td>
                    <td> <img class="img-fluid thumbnail zoom" style="width: 73px;" src="{{URL::to($item->image)}}"></td>
                    <td>
                       <a href="{{URL::to('subadmin/sub_admin/profile_approved',$item->id)}}" class="btn btn-sm btn-success" ><span class="fa fa-check"></span> Approved</a>
                       <a href="{{URL::to('subadmin/sub_admin/profile_reject',$item->id)}}" class="btn btn-sm btn-danger" ><span class="fa fa-close"></span> Reject</a>
                      
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                  <tr>
                    <th>Sl</th>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Image</th>
                    
                    <th>Active</th>
                  </tr>
                </tfoot>
              </table>
            </div>
                  </div>
              </div>

</div>
</div>
<script>
  $(function () {
    function filterFeed(input, list) {
      var value = ($(input).val() || '').toLowerCase();
      $(list).find('[data-feed-item]').each(function () {
        var text = ($(this).data('search') || $(this).text()).toString().toLowerCase();
        $(this).toggle(text.indexOf(value) !== -1);
      });
    }
    function loadFeed(url, target, emptyText) {
      if (!$(target).length) return;
      $.get(url)
        .done(function (html) {
          $(target).html($.trim(html) ? html : '<div class="feed-empty">' + emptyText + '</div>');
        })
        .fail(function () {
          $(target).html('<div class="feed-empty">Feed unavailable</div>');
        });
    }
    function refreshDashboardFeeds() {
      if (!$('#comment_list').length && !$('#chat_list').length) return;
      loadFeed("{{ URL::to('subadmin/sub_admin/comment_data') }}", '#comment_list', 'No recent comments');
      loadFeed("{{ URL::to('subadmin/sub_admin/chat_data') }}", '#chat_list', 'No recent chats');
    }
    $('#searchComment').on('input', function () { filterFeed(this, '#comment_list'); });
    $('#searchChat').on('input', function () { filterFeed(this, '#chat_list'); });
    refreshDashboardFeeds();
    setInterval(refreshDashboardFeeds, 5000);
  });
</script>

@endsection
