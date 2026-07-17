  @php
  $adminCan=function($key,$default=false){ return \App\Models\AdminParmisiton::allowed(Auth::id(),$key,$default); };
  $adminAny=function($keys) use ($adminCan){ foreach($keys as $key){ if($adminCan($key)){ return true; } } return false; };
  $profileSearchKeys=['profile_search','profile_balance','profile_email_info','profile_phone_info','profile_sensitive_info','profile_other_ids','profile_power_buttons','profile_vip_frames_edit','profile_password_daytime'];

  $hostItems=[
    ['key'=>'sidebar_host_add','url'=>'add-host','label'=>'Register Host'],
    ['key'=>'sidebar_host_active','url'=>'active_host','label'=>'Active Hosts'],
    ['key'=>'sidebar_host_pending','url'=>'pending_host','label'=>'Pending Hosts'],
    ['key'=>'sidebar_host_transfer','url'=>'transfer_host','label'=>'Host Transfer'],
  ];
  $agencyItems=[
    ['key'=>'sidebar_agency_create','url'=>'agency_create','label'=>'Create Agency'],
    ['key'=>'sidebar_agency_list','url'=>'agency_list','label'=>'Agency Directory'],
  ];
  $protalItems=[
    ['key'=>'sidebar_protal_create','url'=>'protal_create','label'=>'Create Portal'],
    ['key'=>'sidebar_protal_list','url'=>'protal_list','label'=>'Portal Accounts'],
    ['key'=>'sidebar_protal_recall_create','url'=>'master-protal-recall-create','label'=>'Portal Recall Setup'],
    ['key'=>'sidebar_protal_recall_history','url'=>'master-protal-recall','label'=>'Portal Recall History'],
    ['key'=>'sidebar_protal_recharge','url'=>'recharge_otp','label'=>'Recharge Approval'],
    ['key'=>'sidebar_protal_recharge_list','url'=>'recharge-list','label'=>'Recharge Records'],
    ['key'=>'sidebar_protal_new_recall','url'=>'recall','label'=>'Create Recall'],
    ['key'=>'sidebar_protal_recall_list','url'=>'recall-list','label'=>'Recall History'],
  ];
  $supportItems=[
    ['key'=>'sidebar_support_index','url'=>'support','label'=>'Support Tickets'],
  ];
  $rankingItems=[
    ['key'=>'sidebar_ranking_list','url'=>'rankingList','label'=>'Rankings'],
  ];
  $userBalanceItems=[
    ['key'=>'sidebar_user_balance_wallet','url'=>'user_have_balance','label'=>'User Wallets'],
  ];
  $coinGenerateItems=[
    ['key'=>'sidebar_coin_generate_generate','url'=>'admin-coin-generate','label'=>'Coin Generation'],
  ];
  $banItems=[
    ['key'=>'sidebar_ban_id','url'=>'ban_id','label'=>'User Ban Control'],
  ];
  $liveItems=[
    ['key'=>'sidebar_live_list','url'=>'live-list','label'=>'Live Sessions'],
  ];
  $gameItems=[
    ['key'=>'sidebar_game_fruits_detail','url'=>'admin/fruts-game-detail','label'=>'Fruit Game Results'],
    ['key'=>'sidebar_game_fruits_lock','url'=>'admin/fruts-game-lock-list','label'=>'Fruit Game Locks'],
    ['key'=>'sidebar_game_teenpatti_detail','url'=>'admin/teen-patti-game-detail','label'=>'Teen Patti Results'],
    ['key'=>'sidebar_game_teenpatti_detail','url'=>'admin/thomas-game-lobby','label'=>'Thomas Game Lobby'],
    ['key'=>'sidebar_game_greedy_detail','url'=>'admin/grady-game-detail','label'=>'Greedy Game Results'],
    ['key'=>'sidebar_game_fruits_pattern','url'=>'admin/fruts-game-pattarn','label'=>'Fruit Pattern Control'],
  ];
  $settingItems=[
    ['key'=>'sidebar_setting_banner','url'=>'admin-slider','label'=>'Banner Management'],
    ['key'=>'sidebar_setting_country','url'=>'admin-country','label'=>'Country Management'],
    ['key'=>'sidebar_setting_gift_data','url'=>'admin-gift-data','label'=>'Gift Catalog'],
    ['key'=>'sidebar_setting_agora','url'=>'admin-agora_account_setting','label'=>'Agora Configuration'],
    ['key'=>'sidebar_setting_email_change','url'=>'admin-user-emailchange','label'=>'User Email Change'],
    ['key'=>'sidebar_setting_admin','url'=>'setting/system-setting','label'=>'System Settings'],
    ['key'=>'sidebar_setting_admin','url'=>'setting/admin','label'=>'Admin Users'],
    ['key'=>'sidebar_setting_audio_background','url'=>'admin-audio-brd-background','label'=>'Audio Room Backgrounds'],
    ['key'=>'sidebar_setting_store','url'=>'admin-store','label'=>'Store Management'],
  ];
  @endphp
@if($adminCan('sidebar_access'))
<nav class="sidebar sidebar-bunker">
    <div class="sidebar-header">
     <a href="{{URL::to('/dashboard')}}" class="logo"><img src="" alt=""></a>
 </div><!--/.sidebar header-->
 @if($adminAny($profileSearchKeys))
 <form class="search sidebar-form" action="{{URL::to('id_search')}}" method="get" >
    @csrf
    <div class="search__inner">
        <input type="number" name="id" class="search__text" placeholder="Search user ID..." >
        <i class="typcn typcn-zoom-outline search__helper" data-sa-action="search-close"></i>
    </div>
</form><!--/.search-->
@endif
<div class="sidebar-body">
    <nav class="sidebar-nav">
        <ul class="metismenu">
            <li class="nav-label">Operations</li>
            @if($adminCan('sidebar_menu_dashboard'))
            <li><a href="{{URL::to('/dashboard')}}"><i class="typcn typcn-home-outline mr-2"></i>Dashboard</a></li>
            @endif

            @if($adminCan('sidebar_menu_host') && $adminAny(array_column($hostItems,'key')))
            <li>
                <a class="has-arrow material-ripple" href="#">
                    <i class="typcn typcn-group-outline mr-2"></i>
                    Host Management
                </a>
                <ul class="nav-second-level">
                    @foreach($hostItems as $item)
                      @if($adminCan($item['key']))<li><a href="{{URL::to($item['url'])}}">{{$item['label']}}</a></li>@endif
                    @endforeach
                </ul>
            </li>
            @endif

            @if($adminCan('sidebar_menu_agency') && $adminAny(array_column($agencyItems,'key')))
            <li>
                <a class="has-arrow material-ripple" href="#">
                    <i class="typcn typcn-briefcase mr-2"></i>
                    Agency Management
                </a>
                <ul class="nav-second-level">
                    @foreach($agencyItems as $item)
                      @if($adminCan($item['key']))<li><a href="{{URL::to($item['url'])}}">{{$item['label']}}</a></li>@endif
                    @endforeach
                </ul>
            </li>
            @endif

            @if($adminCan('sidebar_menu_protal') && $adminAny(array_column($protalItems,'key')))
            <li>
                <a class="has-arrow material-ripple" href="#">
                    <i class="typcn typcn-credit-card mr-2"></i>
                    Portal & Recharge
                </a>
                <ul class="nav-second-level">
                    @foreach($protalItems as $item)
                      @if($adminCan($item['key']))<li><a href="{{URL::to($item['url'])}}">{{$item['label']}}</a></li>@endif
                    @endforeach
                </ul>
            </li>
            @endif

            @if($adminCan('sidebar_menu_support') && $adminAny(array_column($supportItems,'key')))
            <li>
                <a class="has-arrow material-ripple" href="#">
                    <i class="typcn typcn-support mr-2"></i>
                   Support Center
                </a>
                <ul class="nav-second-level">
                    @foreach($supportItems as $item)
                      @if($adminCan($item['key']))<li><a href="{{URL::to($item['url'])}}">{{$item['label']}}</a></li>@endif
                    @endforeach
                </ul>
            </li>
            @endif

            @if($adminCan('sidebar_menu_ranking') && $adminAny(array_column($rankingItems,'key')))
            <li>
                <a class="has-arrow material-ripple" href="#">
                    <i class="typcn typcn-chart-bar mr-2"></i>
                   Reports & Rankings
                </a>
                <ul class="nav-second-level">
                    @foreach($rankingItems as $item)
                      @if($adminCan($item['key']))<li><a href="{{URL::to($item['url'])}}">{{$item['label']}}</a></li>@endif
                    @endforeach
                </ul>
            </li>
            @endif

            @if($adminCan('sidebar_menu_user_balance') && $adminAny(array_column($userBalanceItems,'key')))
            <li>
                <a class="has-arrow material-ripple" href="#">
                    <i class="typcn typcn-wallet mr-2"></i>
                    Wallet Control
                </a>
                <ul class="nav-second-level">
                    @foreach($userBalanceItems as $item)
                      @if($adminCan($item['key']))<li><a href="{{URL::to($item['url'])}}">{{$item['label']}}</a></li>@endif
                    @endforeach
                </ul>
            </li>
            @endif

            @if($adminCan('sidebar_menu_coin_generate') && $adminAny(array_column($coinGenerateItems,'key')))
            <li>
                <a class="has-arrow material-ripple" href="#">
                    <i class="typcn typcn-plus-outline mr-2"></i>
                    Coin Operations
                </a>
                <ul class="nav-second-level">
                    @foreach($coinGenerateItems as $item)
                      @if($adminCan($item['key']))<li><a href="{{URL::to($item['url'])}}">{{$item['label']}}</a></li>@endif
                    @endforeach
                </ul>
            </li>
            @endif

            @if($adminCan('sidebar_menu_ban') && $adminAny(array_column($banItems,'key')))
            <li>
                <a class="has-arrow material-ripple" href="#">
                    <i class="typcn typcn-warning-outline mr-2"></i>
                    Moderation
                </a>
                <ul class="nav-second-level">
                    @foreach($banItems as $item)
                      @if($adminCan($item['key']))<li><a href="{{URL::to($item['url'])}}">{{$item['label']}}</a></li>@endif
                    @endforeach
                </ul>
            </li>
            @endif

            @if($adminCan('sidebar_menu_live') && $adminAny(array_column($liveItems,'key')))
            <li>
                <a class="has-arrow material-ripple" href="#">
                    <i class="typcn typcn-video-outline mr-2"></i>
                    Live Monitoring
                </a>
                <ul class="nav-second-level">
                    @foreach($liveItems as $item)
                      @if($adminCan($item['key']))<li><a href="{{URL::to($item['url'])}}">{{$item['label']}}</a></li>@endif
                    @endforeach
                </ul>
            </li>
            @endif

            @if($adminCan('sidebar_menu_game_control') && $adminAny(array_column($gameItems,'key')))
            <li>
                <a class="has-arrow material-ripple" href="#">
                    <i class="typcn typcn-device-gamepad mr-2"></i>
                    Game Operations
                </a>
                <ul class="nav-second-level">
                    @foreach($gameItems as $item)
                      @if($adminCan($item['key']))<li><a href="{{URL::to($item['url'])}}">{{$item['label']}}</a></li>@endif
                    @endforeach
                </ul>
            </li>
            @endif

            @if($adminCan('sidebar_menu_setting') && $adminAny(array_column($settingItems,'key')))
            <li>
                <a class="has-arrow material-ripple" href="#">
                    <i class="typcn typcn-cog-outline mr-2"></i>
                   System Settings
                </a>
                <ul class="nav-second-level">
                    @foreach($settingItems as $item)
                      @if($adminCan($item['key']))<li><a href="{{URL::to($item['url'])}}">{{$item['label']}}</a></li>@endif
                    @endforeach
                </ul>
            </li>
            @endif
        </ul>
        </nav>
    </div><!-- sidebar-body -->
</nav>
@endif
