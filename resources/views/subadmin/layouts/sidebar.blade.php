  @php
  $image_pending=App\Models\ProfilePending::count();
  $luck_star_pending=App\Models\luckyStar::where('status',0)->count();
  @endphp
<nav class="sidebar sidebar-bunker">
    <div class="sidebar-header">
     <a href="{{URL::to('/dashboard')}}" class="logo"><img src="" alt=""></a> 
 </div><!--/.sidebar header-->
 <form class="search sidebar-form" action="{{URL::to('subadmin/sub_admin/profile_search/view/')}}" method="get" >
    @csrf
    <div class="search__inner">
        <input type="number" name="id" class="search__text" placeholder="Search..." >
        <i class="typcn typcn-zoom-outline search__helper" data-sa-action="search-close"></i>
    </div>
</form><!--/.search-->
<div class="sidebar-body">
    <nav class="sidebar-nav">
        <ul class="metismenu">
            <li class="nav-label">Main Menu</li>
            <li><a href="{{URL::to('/dashboard')}}"><i class="typcn typcn-home-outline mr-2"></i>Dashboard</a></li>
            
            <li>
                <a class="has-arrow material-ripple" href="#">
                    <i class="typcn typcn-book mr-2"></i>
                    Host
                </a>
                <ul class="nav-second-level">
                    <li><a href="{{URL::to('subadmin/sub_admin/add-host')}}">Add Host</a></li>
                    <li><a href="{{URL::to('subadmin/sub_admin/pending_host')}}">Pending Host</a></li>
                    
                </ul>
            </li> 
             <li>
                <a class="has-arrow material-ripple" href="#">
                    <i class="typcn typcn-book mr-2"></i>
                    Agency 
                </a>
                <ul class="nav-second-level">
                    
                    <li><a href="{{URL::to('subadmin/sub_admin/agency_create')}}">Create Agency</a></li>
                    <li><a href="{{URL::to('subadmin/sub_admin/agency_list')}}">Agency List</a></li>
                </ul>
            </li> 
            
             <li>
                <a class="has-arrow material-ripple" href="#">
                    <i class="typcn typcn-book mr-2"></i>
                    Profile Pending @if($image_pending>0)<span class="badge badge-danger" >{{ $image_pending }}</span> @endif
                </a>
                <ul class="nav-second-level">
                    
                    <li><a href="{{URL::to('subadmin/sub_admin/profile_pending')}}">Pending</a></li>
                </ul>
            </li>
            @if(Auth::id()!=22224)
            <li>
                <a class="has-arrow material-ripple" href="#">
                    <i class="typcn typcn-book mr-2"></i>
                   Ranking
                </a>
                <ul class="nav-second-level">
                    
                    <li><a href="{{URL::to('subadmin/sub_admin/ranking')}}">Ranking</a></li>
                </ul>
            </li> 
            @endif

            <li>
                <a class="has-arrow material-ripple" href="#">
                    <i class="typcn typcn-book mr-2"></i>
                    Ban ID 
                </a>
                <ul class="nav-second-level">
                    
                    <li><a href="{{URL::to('subadmin/sub_admin/ban_id')}}">Ban</a></li>
                </ul>
            </li> 
            <li>
                <a class="has-arrow material-ripple" href="#">
                    <i class="typcn typcn-book mr-2"></i>
                    Live
                </a>
                <ul class="nav-second-level">
                    
                    <li><a href="{{URL::to('subadmin/sub_admin/live-list')}}"> Live List</a></li>                        
                </ul>
            </li> 
        </nav>
    </div><!-- sidebar-body -->
</nav>