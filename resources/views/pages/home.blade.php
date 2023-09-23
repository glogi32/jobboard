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
          </div>
         
            <div class="row mb-5 d-flex justify-content-center">
              
              <div class="col-12 col-sm-6 col-md-6 col-lg-3 mb-4 mb-lg-0">
                <a href="{{route("jobs")}}" class="btn btn-primary btn-lg btn-block text-white btn-search"><span class="icon-search icon mr-2"></span>Search Job</a>
              </div>
            </div>
            <div class="row ">
              <div class="col-md-12 popular-keywords d-flex justify-content-center">
                <h3>Trending Tags:</h3>
                <ul class="keywords list-unstyled m-0 p-0">
                  
                  @foreach ($tags as $t)
                    <li><a href="#" class="">{{$t->name}}</a></li>
                  @endforeach
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
        </div>
      </div>
      <div class="row pb-0 block__19738 section-counter">

        <div class="col-6 col-md-6 col-lg-3 mb-5 mb-lg-0">
          <div class="d-flex align-items-center justify-content-center mb-2">
            <strong class="number" data-number="{{$candidates}}">0</strong>
          </div>
          <span class="caption">Candidates</span>
        </div>

        <div class="col-6 col-md-6 col-lg-3 mb-5 mb-lg-0">
          <div class="d-flex align-items-center justify-content-center mb-2">
            <strong class="number" data-number="{{$jobsPosted}}">0</strong>
          </div>
          <span class="caption">Jobs Posted</span>
        </div>

        <div class="col-6 col-md-6 col-lg-3 mb-5 mb-lg-0">
          <div class="d-flex align-items-center justify-content-center mb-2">
            <strong class="number" data-number="{{$jobsFilled}}">0</strong>
          </div>
          <span class="caption">Jobs Filled</span>
        </div>

        <div class="col-6 col-md-6 col-lg-3 mb-5 mb-lg-0">
          <div class="d-flex align-items-center justify-content-center mb-2">
            <strong class="number" data-number="{{$companies}}">0</strong>
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
          <h2 class="section-title mb-2">Featured Jobs</h2>
        </div>
      </div>
      
      <ul class="job-listings mb-5">
        @foreach ($featuredJobs as $j)
          <li class="job-listing d-block d-sm-flex pb-3 pb-sm-0 align-items-center row">
            <a href="job-single.html"></a>
            
            <div class="job-listing-logo col-md-3">
              <a href="{{$j->company_details}}" target="_blank" rel="noopener noreferrer">
                <img src="{{$j->companyLogo}}" alt="{{$j->company->logoImage[0]->alt}}" class="img-fluid">
              </a>
            </div>
           
            

            <div class="col-md-9">

              <div class="col-md-12  d-sm-flex custom-width mt-3 justify-content-between">

                  <div class="job-listing-position custom-width w-75 mb-3 mb-sm-0">
                    <h2> <a href="{{$j->job_details}}" class="text-black">{{$j->title}}</a> </h2>
                    <strong><a href="{{$j->company_details}}" class="text-secondary mt-4">{{$j->company->name}}</a></strong> <span> / </span> <span class="icon-room"></span> {{$j->city->name}}
                  </div>
                  <div class="job-listing-location mb-3 mb-sm-0 custom-width">
                    
                  </div>
                  <div class="job-listing-meta ">
                    <span class="badge badge-danger">{{$j->emp_status}}</span>
                  </div>

              </div>
              <div class="col-md-12 d-flex justify-content-between">
                <div class="tags">
                  @if (count($j->technologies) > 0)
                      @foreach ($j->technologies as $t)
                        <span class="badge badge-info mx-1">{{$t->name}}</span>
                      @endforeach
                  @endif
                </div>

                <div class="expire-date ml-3 ">
                  <p>Days left: {{$j->deadline_formated}}</p>
                </div>
              </div>
            </div>
          </li>
        @endforeach
        
      </ul>

    </div>
  </section>

  <section class="py-5 bg-image overlay-primary fixed overlay"  id="banner-signup">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-8">
          <h2 class="text-white">Looking For A Job?</h2>
          <p class="mb-0 text-white lead">JobBoard is place for you, join us.</p>
        </div>
        <div class="col-md-3 ml-auto">
          <a href="{{route('sign-up-page')}}" class="btn btn-warning btn-block btn-lg">Sign Up</a>
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
              {{-- <p class="lead">Porro error reiciendis commodi beatae omnis similique voluptate rerum ipsam fugit mollitia ipsum facilis expedita tempora suscipit iste</p> --}}
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


     
@endsection