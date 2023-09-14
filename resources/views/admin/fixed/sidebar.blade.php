<aside class="main-sidebar sidebar-dark-primary elevation-4">
    {{-- <!-- Brand Logo --><div class="site-logo col-6"><a href="{{route("/")}}">JobBoard</a></div> --}}
    <a href="{{url("/admin/users")}}" class="brand-link text-center ">
      {{-- <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
      <span class="brand-text font-weight-light">JobBoard</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset(session('user')->image->src)}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="{{url("user-profile/" . session('user')->id)}}" target="_blank" class="d-block">{{session('user')->first_name}} {{session('user')->last_name}}</a>
        </div>
      </div>
      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{url("/admin/users")}}" class="nav-link {{ (request()->is('admin/users') ) ? 'active' : '' }}">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Users
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url("/admin/jobs")}}" class="nav-link {{ (request()->is('admin/jobs') ) ? 'active' : '' }}">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Jobs
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url("/admin/companies")}}" class="nav-link {{ (request()->is('admin/companies') ) ? 'active' : '' }}">
              <i class="nav-icon fas fa-building"></i>
              <p>
                Companies
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url("/admin/cities")}}" class="nav-link {{ (request()->is('admin/cities') ) ? 'active' : '' }}">
              <i class="nav-icon fas fa-city"></i>
              <p>
                Cities
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url("/admin/technologies")}}" class="nav-link {{ (request()->is('admin/technologies') ) ? 'active' : '' }}">
              <i class="nav-icon fa fa-code"></i>
              <p>
                Technologies
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url("/admin/areas")}}" class="nav-link {{ (request()->is('admin/areas') ) ? 'active' : '' }}">
              <i class="nav-icon fa fa-file"></i>
              <p>
                Areas
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>