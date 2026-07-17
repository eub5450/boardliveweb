<ul class="sidenav-inner py-1">
  <!-- Dashboards -->
  <li class="sidenav-item active open">
    <a href="{{URL::to('dashboard')}}" class="sidenav-link ">
      <i class="sidenav-icon feather icon-home"></i>
      <div>Dashboards</div>
    </a>
  </li>
  <li class="sidenav-item " style="">
    <a href="javascript:" class="sidenav-link sidenav-toggle">
      <i class="sidenav-icon feather icon-layers"></i>
      <div>Host</div>
      <div class="pl-1 ml-auto">
        <div class="badge badge-primary">0</div>
      </div>
    </a>
    <ul class="sidenav-menu">
      <li class="sidenav-item">
        <a href="{{route('country.author.host-add')}}" class="sidenav-link">
          <div>Add Host</div>
        </a>
      </li>
      <li class="sidenav-item">
        <a href="{{route('country.author.host-list')}}" class="sidenav-link">
          <div>Host List</div>
        </a>
      </li>
      <li class="sidenav-item">
        <a href="{{route('country.author.host-pending')}}" class="sidenav-link">
          <div>Pending Host</div>
        </a>
      </li>
      <li class="sidenav-item">
        <a href="{{route('country.author.host-transfer')}}" class="sidenav-link">
          <div>Transfer Host</div>
        </a>
      </li>
    </ul>
  </li>
  <li class="sidenav-item " style="">
    <a href="javascript:" class="sidenav-link sidenav-toggle">
      <i class="sidenav-icon feather icon-layers"></i>
      <div>Agency</div>
      <div class="pl-1 ml-auto">
        <div class="badge badge-primary">0</div>
      </div>
    </a>
    <ul class="sidenav-menu">
      <li class="sidenav-item">
        <a href="{{route('country.author.agency-add')}}" class="sidenav-link">
          <div>Add Agency</div>
        </a>
      </li>
      <li class="sidenav-item">
        <a href="{{route('country.author.agency-list')}}" class="sidenav-link">
          <div>Agency List</div>
        </a>
      </li>
      
    </ul>
  </li>  
  <li class="sidenav-item " style="">
    <a href="javascript:" class="sidenav-link sidenav-toggle">
      <i class="sidenav-icon feather icon-layers"></i>
      <div>Protal</div>
      <div class="pl-1 ml-auto">
        <div class="badge badge-primary">0</div>
      </div>
    </a>
    <ul class="sidenav-menu">
      <li class="sidenav-item">
        <a href="{{route('country.author.protal')}}" class="sidenav-link">
          <div>Protal</div>
        </a>
      </li>
      
      <li class="sidenav-item">
        <a href="{{route('country.author.protal-list')}}" class="sidenav-link">
          <div>Protal List</div>
        </a>
      </li>
      
    </ul>
  </li>
</ul>