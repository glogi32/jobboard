<header class="site-navbar mt-3">
    <div class="container-fluid">
      <div class="row align-items-center">
        <div class="site-logo col-6"><a href="{{route("/")}}">JobBoard</a></div>

        <nav class="mx-auto site-navigation">
          <ul class="site-menu js-clone-nav d-none d-xl-block ml-0 pl-0">
            <li><a href="index.html" class="nav-link">Home</a></li>
            <li><a href="about.html">About</a></li>
            <li class="has-children">
              <a href="job-listings.html">Job Listings</a>
              <ul class="dropdown">
                <li><a href="job-single.html">Job Single</a></li>
                <li><a href="post-job.html">Post a Job</a></li>
              </ul>
            </li>
            <li class="has-children">
              <a href="services.html">Pages</a>
              <ul class="dropdown">
                <li><a href="services.html">Services</a></li>
                <li><a href="service-single.html">Service Single</a></li>
                <li><a href="blog-single.html">Blog Single</a></li>
                <li><a href="portfolio.html">Portfolio</a></li>
                <li><a href="portfolio-single.html">Portfolio Single</a></li>
                <li><a href="testimonials.html">Testimonials</a></li>
                <li><a href="faq.html">Frequently Ask Questions</a></li>
                <li><a href="gallery.html">Gallery</a></li>
              </ul>
            </li>
            <li><a href="blog.html">Blog</a></li>
            <li><a href="contact.html" class="active">Contact</a></li>
            <li class="d-lg-none"><a href="post-job.html"><span class="mr-2">+</span> Post a Job</a></li>
            <li class="d-lg-none"><a href="login.html">Log In</a></li>
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
              <a href="post-job.html" class="btn btn-outline-white border-width-2 d-none d-lg-inline-block"><span class="mr-2 icon-add"></span>Post a Job</a>
              <a href="{{route("login")}}" class="btn btn-primary border-width-2 d-none d-lg-inline-block"><span class="mr-2 icon-lock_outline"></span>Log In</a>
            @endif
          </div>
          <a href="#" class="site-menu-toggle js-menu-toggle d-inline-block d-xl-none mt-lg-2 ml-3"><span class="icon-menu h3 m-0 p-0 mt-2"></span></a>
        </div>

      </div>
    </div>
  </header>