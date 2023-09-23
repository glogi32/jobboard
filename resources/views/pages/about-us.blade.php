@extends('layouts.template')

@section('title')
    About us
@endsection

@section('content')
    @component('fixed.header-section')
        @slot('headerTitle')
            About us
        @endslot
        @slot('additionalNav')
      
      @endslot
    @endcomponent
    
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

    <section class="site-section pb-0">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <img src="{{asset('img/sq_img_6.jpg')}}" alt="Image" class="img-fluid img-shadow">
            </div>
            <div class="col-lg-5 ml-auto">
              <h2 class="section-title mb-3">JobBoard For Freelancers, Web Developers</h2>
              <p class="lead">
                Welcome to Jobboard - your destination for finding the perfect job and building the career of
                 your dreams!</p>
                <p> Our platform is designed to make your journey towards achieving your professional ambitions as smooth as possible.
                Our vision is straightforward - connecting talented individuals with outstanding employers. Regardless of your experience, skills,
                  or career goals, our platform provides you access to a wide range of job opportunities across various industries and sectors.
              </p>
            </div>
          </div>
        </div>
    </section>

    <section class="site-section pt-0 mt-5">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0 order-md-2">
                <img src="{{asset("img/sq_img_4.jpg")}}" alt="Image" class="img-fluid img-shadow">
            </div>
            <div class="col-lg-5 mr-auto order-md-1  mb-5 mb-lg-0">
              <h2 class="section-title mb-3">JobBoard For Companies</h2>
              <p class="lead">Welcome to Jobboard - your go-to platform for reaching top talent and finding the perfect candidates for your job openings.</p>
              <p> Our platform is designed to streamline your hiring process and connect you with skilled professionals who can help your organization thrive.
                At Jobboard, we understand that hiring the right talent is essential for your organization's success. Our platform is here to make your recruitment journey as efficient and effective as possible.
                Don't miss out on the opportunity to connect with top-notch professionals who can drive your company's growth. Join Jobboard today and start posting your job openings to find your next great hire.
                Your future team members are just a click away. Let us help you build a stronger workforce!
                
                </p>
            </div>
          </div>
        </div>
    </section>
@endsection