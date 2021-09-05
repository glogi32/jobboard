@extends('layouts.template')

@section('title')
    Home
@endsection



@section('content')
<section class="home-section section-hero overlay bg-image" id="home-section">

    <div class="container">
      <div class="row align-items-center justify-content-center">
        <div class="col-md-12">
          <div class="mb-5 text-center">
            <h1 class="text-white font-weight-bold">The Easiest Way To Get Your Dream Job</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cupiditate est, consequuntur perferendis.</p>
          </div>
         
            <div class="row mb-5 d-flex justify-content-center">
              
              <div class="col-12 col-sm-6 col-md-6 col-lg-3 mb-4 mb-lg-0">
                <button type="submit" class="btn btn-primary btn-lg btn-block text-white btn-search"><span class="icon-search icon mr-2"></span>Search Job</button>
              </div>
            </div>
            <div class="row ">
              <div class="col-md-12 popular-keywords d-flex justify-content-center">
                <h3>Trending Keywords:</h3>
                <ul class="keywords list-unstyled m-0 p-0">
                  <li><a href="#" class="">UI Designer</a></li>
                  <li><a href="#" class="">Python</a></li>
                  <li><a href="#" class="">Developer</a></li>
                </ul>
              </div>
            </div>
        </div>
      </div>
    </div>

    <a href="#next" class="scroll-button smoothscroll">
      <span class=" icon-keyboard_arrow_down"></span>
    </a>

  </section>
  
  <section class="py-5 bg-image overlay-primary fixed overlay" id="next" style="">
    <div class="container">
      <div class="row mb-5 justify-content-center">
        <div class="col-md-7 text-center">
          <h2 class="section-title mb-2 text-white">JobBoard Site Stats</h2>
          <p class="lead text-white">Lorem ipsum dolor sit amet consectetur adipisicing elit. Expedita unde officiis recusandae sequi excepturi corrupti.</p>
        </div>
      </div>
      <div class="row pb-0 block__19738 section-counter">

        <div class="col-6 col-md-6 col-lg-3 mb-5 mb-lg-0">
          <div class="d-flex align-items-center justify-content-center mb-2">
            <strong class="number" data-number="1930">0</strong>
          </div>
          <span class="caption">Candidates</span>
        </div>

        <div class="col-6 col-md-6 col-lg-3 mb-5 mb-lg-0">
          <div class="d-flex align-items-center justify-content-center mb-2">
            <strong class="number" data-number="54">0</strong>
          </div>
          <span class="caption">Jobs Posted</span>
        </div>

        <div class="col-6 col-md-6 col-lg-3 mb-5 mb-lg-0">
          <div class="d-flex align-items-center justify-content-center mb-2">
            <strong class="number" data-number="120">0</strong>
          </div>
          <span class="caption">Jobs Filled</span>
        </div>

        <div class="col-6 col-md-6 col-lg-3 mb-5 mb-lg-0">
          <div class="d-flex align-items-center justify-content-center mb-2">
            <strong class="number" data-number="550">0</strong>
          </div>
          <span class="caption">Companies</span>
        </div>

          
      </div>
    </div>
  </section>

  

  <section class="site-section">
    <div class="container">

      <div class="row mb-5 justify-content-center">
        <div class="col-md-7 text-center">
          <h2 class="section-title mb-2">43,167 Job Listed</h2>
        </div>
      </div>
      
      <ul class="job-listings mb-5">
        <li class="job-listing d-block d-sm-flex pb-3 pb-sm-0 align-items-center row">
          <a href="job-single.html"></a>
          <div class="job-listing-logo col-md-3">
            <img src="{{asset("img/home/job_logo_1.jpg")}}" alt="Free Website Template by Free-Template.co" class="img-fluid">
          </div>

          <div class="col-md-9">

            <div class="col-md-12  d-sm-flex custom-width mt-3 justify-content-between">

                <div class="job-listing-position custom-width w-50 mb-3 mb-sm-0">
                  <h2>Product Designer</h2>
                  <strong>Adidas</strong>
                </div>
                <div class="job-listing-location mb-3 mb-sm-0 custom-width w-25">
                  <span class="icon-room"></span> New York
                </div>
                <div class="job-listing-meta ">
                  <span class="badge badge-danger">Part Time</span>
                </div>

            </div>
            <div class="col-md-12">

                <span class="badge badge-info">Info</span>
                <span class="badge badge-info">Info</span>
                <span class="badge badge-info">Info</span>
              
            </div>

          </div>
           
        </li>
        <li class="job-listing d-block d-sm-flex pb-3 pb-sm-0 align-items-center row">
          <a href="job-single.html"></a>
          <div class="job-listing-logo col-md-3">
            <img src="{{asset("img/home/job_logo_1.jpg")}}" alt="Free Website Template by Free-Template.co" class="img-fluid">
          </div>

          <div class="col-md-9">

            <div class="col-md-12  d-sm-flex custom-width mt-3 justify-content-between">

                <div class="job-listing-position custom-width w-50 mb-3 mb-sm-0">
                  <h2>Product Designer</h2>
                  <strong>Adidas</strong>
                </div>
                <div class="job-listing-location mb-3 mb-sm-0 custom-width w-25">
                  <span class="icon-room"></span> New York
                </div>
                <div class="job-listing-meta ">
                  <span class="badge badge-danger">Part Time</span>
                </div>

            </div>
            <div class="col-md-12">

                <span class="badge badge-info">Info</span>
                <span class="badge badge-info">Info</span>
                <span class="badge badge-info">Info</span>
              
            </div>

          </div>
           
        </li>
        <li class="job-listing d-block d-sm-flex pb-3 pb-sm-0 align-items-center row">
          <a href="job-single.html"></a>
          <div class="job-listing-logo col-md-3">
            <img src="{{asset("img/home/job_logo_1.jpg")}}" alt="Free Website Template by Free-Template.co" class="img-fluid">
          </div>

          <div class="col-md-9">

            <div class="col-md-12  d-sm-flex custom-width mt-3 justify-content-between">

                <div class="job-listing-position custom-width w-75 mb-3 mb-sm-0">
                  <h2> Senior Software Development Engineer in Test </h2>
                  <strong>Company123</strong> <span> / </span> <span class="icon-room"></span> Belgrade
                </div>
                <div class="job-listing-location mb-3 mb-sm-0 custom-width">
                  
                </div>
                <div class="job-listing-meta ">
                  <span class="badge badge-danger">Full Time</span>
                </div>

            </div>
            <div class="col-md-12 d-flex justify-content-between">
              <div class="tags">
                <span class="badge badge-info">Info</span>
                <span class="badge badge-info">Info</span>
                <span class="badge badge-info">Info</span>
                <span class="badge badge-info">Info</span>
                <span class="badge badge-info">Info</span>
                <span class="badge badge-info">Info</span>
                <span class="badge badge-info">Info</span>
                <span class="badge badge-info">Info</span>
                <span class="badge badge-info">Info</span>
                <span class="badge badge-info">Info</span>
                <span class="badge badge-info">Info</span>
                <span class="badge badge-info">Info</span>

              </div>
                
              <div class="expire-date ml-4">
                <p>Days left: 45</p>
              </div>
            </div>

          </div>
           
        </li>
      </ul>

      <div class="row pagination-wrap">
        <div class="col-md-6 text-center text-md-left mb-4 mb-md-0">
          <span>Showing 1-7 Of 43,167 Jobs</span>
        </div>
        <div class="col-md-6 text-center text-md-right">
          <div class="custom-pagination ml-auto">
            <a href="#" class="prev">Prev</a>
            <div class="d-inline-block">
            <a href="#" class="active">1</a>
            <a href="#">2</a>
            <a href="#">3</a>
            <a href="#">4</a>
            </div>
            <a href="#" class="next">Next</a>
          </div>
        </div>
      </div>

    </div>
  </section>

  <section class="py-5 bg-image overlay-primary fixed overlay"  id="banner-signup">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-8">
          <h2 class="text-white">Looking For A Job?</h2>
          <p class="mb-0 text-white lead">Lorem ipsum dolor sit amet consectetur adipisicing elit tempora adipisci impedit.</p>
        </div>
        <div class="col-md-3 ml-auto">
          <a href="#" class="btn btn-warning btn-block btn-lg">Sign Up</a>
        </div>
      </div>
    </div>
  </section>

  
  <section class="site-section py-4">
    <div class="container">

      <div class="row align-items-center">
        <div class="col-12 text-center mt-4 mb-5">
          <div class="row justify-content-center">
            <div class="col-md-7">
              <h2 class="section-title mb-2">Company We've Helped</h2>
              <p class="lead">Porro error reiciendis commodi beatae omnis similique voluptate rerum ipsam fugit mollitia ipsum facilis expedita tempora suscipit iste</p>
            </div>
          </div>
          
        </div>
        <div class="col-6 col-lg-3 col-md-6 text-center">
          <img src="{{asset("img/home/logo_mailchimp.svg")}}" alt="Image" class="img-fluid logo-1">
        </div>
        <div class="col-6 col-lg-3 col-md-6 text-center">
          <img src="{{asset("img/home/logo_paypal.svg")}}" alt="Image" class="img-fluid logo-2">
        </div>
        <div class="col-6 col-lg-3 col-md-6 text-center">
          <img src="{{asset("img/home/logo_stripe.svg")}}" alt="Image" class="img-fluid logo-3">
        </div>
        <div class="col-6 col-lg-3 col-md-6 text-center">
          <img src="{{asset("img/home/logo_visa.svg")}}" alt="Image" class="img-fluid logo-4">
        </div>

        <div class="col-6 col-lg-3 col-md-6 text-center">
          <img src="{{asset("img/home/logo_apple.svg")}}" alt="Image" class="img-fluid logo-5">
        </div>
        <div class="col-6 col-lg-3 col-md-6 text-center">
          <img src="{{asset("img/home/logo_tinder.svg")}}" alt="Image" class="img-fluid logo-6">
        </div>
        <div class="col-6 col-lg-3 col-md-6 text-center">
          <img src="{{asset("img/home/logo_sony.svg")}}" alt="Image" class="img-fluid logo-7">
        </div>
        <div class="col-6 col-lg-3 col-md-6 text-center">
          <img src="{{asset("img/home/logo_airbnb.svg")}}" alt="Image" class="img-fluid logo-8">
        </div>
      </div>
    </div>
  </section>


  <section class="bg-light pt-5 testimony-full">
      
      <div class="owl-carousel single-carousel">

      
        <div class="container">
          <div class="row">
            <div class="col-lg-6 align-self-center text-center text-lg-left">
              <blockquote>
                <p>&ldquo;Soluta quasi cum delectus eum facilis recusandae nesciunt molestias accusantium libero dolores repellat id in dolorem laborum ad modi qui at quas dolorum voluptatem voluptatum repudiandae.&rdquo;</p>
                <p><cite> &mdash; Corey Woods, @Dribbble</cite></p>
              </blockquote>
            </div>
            <div class="col-lg-6 align-self-end text-center text-lg-right">
              <img src="{{asset("img/home/person_transparent_2.png")}}" alt="Image" class="img-fluid mb-0">
            </div>
          </div>
        </div>

        <div class="container">
          <div class="row">
            <div class="col-lg-6 align-self-center text-center text-lg-left">
              <blockquote>
                <p>&ldquo;Soluta quasi cum delectus eum facilis recusandae nesciunt molestias accusantium libero dolores repellat id in dolorem laborum ad modi qui at quas dolorum voluptatem voluptatum repudiandae.&rdquo;</p>
                <p><cite> &mdash; Chris Peters, @Google</cite></p>
              </blockquote>
            </div>
            <div class="col-lg-6 align-self-end text-center text-lg-right">
              <img src="{{asset("img/home/person_transparent.png")}}" alt="Image" class="img-fluid mb-0">
            </div>
          </div>
        </div>

    </div>

  </section>

  <section class="pt-5 bg-image overlay-primary fixed overlay" id="banner-app">
    <div class="container">
      <div class="row">
        <div class="col-md-6 align-self-center text-center text-md-left mb-5 mb-md-0">
          <h2 class="text-white">Get The Mobile Apps</h2>
          <p class="mb-5 lead text-white">Lorem ipsum dolor sit amet consectetur adipisicing elit tempora adipisci impedit.</p>
          <p class="mb-0">
            <a href="#" class="btn btn-dark btn-md px-4 border-width-2"><span class="icon-apple mr-3"></span>App Store</a>
            <a href="#" class="btn btn-dark btn-md px-4 border-width-2"><span class="icon-android mr-3"></span>Play Store</a>
          </p>
        </div>
        <div class="col-md-6 ml-auto align-self-end">
          <img src="{{asset("img/apps.png")}}" alt="Free Website Template by Free-Template.co" class="img-fluid">
        </div>
      </div>
    </div>
  </section>    
@endsection