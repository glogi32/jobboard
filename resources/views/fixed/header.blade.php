<header class="site-navbar mt-3">
    <div class="container-fluid">
      <div class="row align-items-center">
        <div class="site-logo col-6"><a href="{{route("/")}}">JobBoard</a></div>

        <nav class="mx-auto site-navigation">
          <ul class="site-menu js-clone-nav d-none d-xl-block ml-0 pl-0">
            <li><a href="{{route("/")}}" class="nav-link {{ (request()->is('home') || request()->is('/')) ? 'active' : '' }}">Home</a></li>
            <li><a href="{{url("/jobs")}}" class="nav-link {{ (request()->is('jobs') ) ? 'active' : '' }}">Jobs</a></li>
            <li><a href="{{url("/companies")}}" class="nav-link {{ (request()->is('companies') ) ? 'active' : '' }}">Companies</a></li>
            {{-- <li><a href="/">About</a></li> --}}
            <li><a href="{{url("/about-us")}}" class="{{ (request()->is('about-us') ) ? 'active' : '' }}">About us</a></li>
            @if (session()->has('user') && session('user')->role_id == 1)
              <li><a href="{{url("/admin/users")}}" class="nav-link ">Admin</a></li>
            @endif
          </ul>
        </nav>
        
        <div class="right-cta-menu text-right d-flex aligin-items-center col-6">
          <div class="ml-auto">
            @if (session()->has("user"))
              <nav class="navbar navbar-dark navbar-expand-sm mt-4">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-list-4" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbar-list-4">
                  <ul class="navbar-nav">
                      <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="{{url(session("user")->image->src)}}" width="60" height="60" class="rounded-circle">
                      </a>
                      <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="{{route("user-edit")}}">Options</a>
                        <a class="dropdown-item" href="{{route("logout")}}">Log Out</a>
                      </div>
                    </li>   
                  </ul>
                </div>
              </nav>
            @else
              <a href="{{route("login-page")}}" class="btn btn-primary border-width-2 d-none d-lg-inline-block">
              <i class="fa fa-user mr-2"></i>
                Login
              </a>
              <a href="{{route("sign-up")}}" class="btn btn-info border-width-2 d-none d-lg-inline-block">
                <i class="fa fa-user-plus mr-2"></i>
                Sign up
              </a>
            @endif
          </div>
          <a href="#" class="site-menu-toggle js-menu-toggle d-inline-block d-xl-none mt-lg-2 ml-3"><span class="icon-menu h3 m-0 p-0 mt-2"></span></a>
        </div>

      </div>
    </div>
  </header>