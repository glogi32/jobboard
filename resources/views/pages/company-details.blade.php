@extends('layouts.template')

@section('title')
    {{$company->name}}
@endsection

@section('content')
    @component('fixed.header-section')
        @slot('headerTitle')
            {{$company->name}}
        @endslot
        @slot('additionalNav')
          @if(session()->has("user"))
            @if (session("user")->role->name == "Employer")
              <a href="{{route("user-companies")}}">Options</a> <span class="mx-2 slash">/</span>
            @endif
          @endif
        @endslot
    @endcomponent

    <section class="site-section pb-0 portfolio-single" id="next-section">

        <div class="container">
          
          <div class="row mb-5 mt-5">

            <div class="col-lg-8 col-md-8">

                <h1 class="text-center mb-4">About Us</h1>
                {!!$company->about_us!!}
                
                <div class="container mt-4">

                    <h3 class="font-weight-light text-center text-lg-left mt-4 mb-0">Gallery</h3>
                    
                    <hr class="mt-2 mb-5">
                
                    <div class="row text-center text-lg-left">

                        @foreach ($company->companyImages as $img)
                            <div class="col-lg-4 col-md-4 col-6">
                                <figure>
                                    <a href="{{url($img->src)}}" class="d-block mb-4 h-100" data-fancybox="gallery">
                                        <img class="img-fluid img-thumbnail" src="{{url($img->src)}}" alt="{{$img->alt}}">
                                    </a>
                                </figure>
                            </div>
                        @endforeach 

                    </div>

                    <div class="pt-5">
                        <h3 class="mb-2" id="comment-count">{{count($company->comments)}} Comments</h3>
                        <hr class="mb-5">
                        <ul class="comment-list" id="comment-list">
                          @foreach ($company_comments as $c)
                            <li class="comment">
                              <div class="vcard bio">
                                <img src="{{url($c->user->image->src)}}" alt="{{$c->user->image->src}}">
                              </div>
                              <div class="comment-body">
                                <h3><a class="text-black" href="{{route("user-profile",$c->user->id)}}">{{$c->user->first_name}} {{$c->user->last_name}}</a></h3>
                                <div class="meta">{{date("F j, Y \a\\t H:m",strtotime($c->created_at))}}</div>
                                <p>{{$c->text}}</p>
                              </div>
                            </li>
                          @endforeach

                          
                        </ul>
                        
                        <div id="load-more">
                          
                            <a href="#" id="loadMore" class="text-center @if(!(count($company->comments) > count($company_comments))) d-none @endif" data-skip="{{session("skip")}}" data-take="{{session("take")}}">Load More</a>
                           
                        </div>
                        
                        <!-- END comment-list -->
                        
                        <div class="comment-form-wrap pt-5">
                          <input type="hidden" id="companyId" value="{{$company->id}}">
                          @if (session()->has("user"))
                            <h3 class="mb-5">Leave a comment</h3>
                            <form action="#" class="comment-form">
                              @csrf
                              <input type="hidden" id="userId" name="user" value="@if(session()->has("user")){{session("user")->id}}@endif">
                              
                              <div class="form-group">
                                <label for="message">Message</label>
                                <textarea name="message" id="message" cols="20" rows="7" class="form-control"></textarea>
                              </div>
                              <div class="form-group">
                                <input type="button" id="btnComment" value="Post Comment" class="btn btn-primary btn-md">
                              </div>
            
                            </form>
                            @else
                            <h3>U must be logged in to post comments.</h3>
                          @endif
                          


                        </div>
                      </div>
                
                </div>
            </div>
  
            <div class="col-lg-4 ml-auto h-100 jm-sticky-top">
             
  
              <div class="mb-4">
                <h3 class="mb-4 h4 border-bottom">Informations</h3>
                <img class="img-fluid img-thumbnail" src="{{url($company->logoImage[0]->src)}}" alt="{{$company->logoImage[0]->alt}}" />
              </div>
  
              <div class="row mb-4">

                <div class="col-sm-6 col-md-12 mb-4 col-lg-6">
                  <strong class="d-block text-black">Head office:</strong>
                  {{$company->city->name}}
                </div>

  
                <div class="col-sm-6 col-md-12 mb-4 col-lg-6">
                  <strong class="d-block text-black">Email:</strong>
                  {{$company->email}}
                </div>
                @if ($company->phone)
                    <div class="col-sm-12 col-md-12 mb-4 col-lg-6">

                        <strong class="d-block text-black">Phone</strong>
                        {{$company->phone}}
                  </div>
                @endif
                
                @if ($company->website)
                    <div class="col-sm-12 col-md-12 mb-4 col-lg-6">
                        <strong class="d-block text-black mb-3">Website URL</strong>
                        <a target="_blank" href="{{$company->website}}" class="btn btn-outline-primary border-width-2">Visit Website</a>
                    </div>
                @endif
                
              </div>
  
              <div class="block__87154 mb-0">
                <blockquote>
                  <p>{{strlen($company->user->about_me) > 257 ? substr($company->user->about_me,0,257)."..." : $company->user->about_me,0,257 }}</p>
                </blockquote>
                <div class="block__91147 d-flex align-items-center">
                  <figure class="mr-4"><img src="{{url($company->user->image->src)}}" alt="{{$company->user->image->alt}}" class="img-fluid"></figure>
                  <div>
                    <h3>{{$company->user->first_name}} {{$company->user->last_name}}</h3>
                    <span class="position">{{$company->user->role->name}}</span>
                  </div>
                </div>
              </div>
  
            </div>
          </div>
  
          
  
          
        </div>
      </section>

      <section class="site-section bg-light">
        <div class="container">
          <div class="row mb-5">
            <div class="col-md-12 text-center" data-aos="fade">
              <h2 class="section-title mb-3">Active jobs</h2>
            </div>
          </div>
          <div class="row">
          
            @if (!$company->jobs->isEmpty())
              @foreach ($company->jobs as $job)
                <div class="col-lg-6 col-md-6 job-listing d-block d-sm-flex pb-3 pb-sm-0 p-4 align-items-center">
                  <div class="row bg-white w-100">

                      <div class="col-md-12  d-sm-flex custom-width mt-3 justify-content-between">

                          <div class="job-listing-position custom-width w-100 mb-3 mb-sm-0">
                            <a href="{{route("job-details",$job->id)}}"> 
                            <h4> {{$job->title}} </h4> 
                            </a>
                            <strong>{{$company->name}}</strong> <span> / </span> <span class="icon-room"></span> {{$job->city->name}}
                          </div>
                          <div class="job-listing-location mb-3 mb-sm-0 custom-width">
                            
                          </div>
                          <div class="job-listing-meta ">
                            <span class="badge badge-danger">{{$emp_status[$job->employment_status]}}</span>
                          </div>

                      </div>
                      <div class="col-md-12 d-flex justify-content-between ">
                        <div class="tags">
                          
                          @foreach ($job->technologies as $t)
                            <span class="badge badge-info">{{$t->name}}</span>
                          @endforeach

                        </div>
                          
                        <div class="expire-date ml-4">
                          <p>Days left: {{ceil(($job->deadline-time())/60/60/24)}}</p>
                        </div>
                      </div>

                  </div>
                  
                </div>
              @endforeach
            @else
                <h3 class="mx-auto">There is no active jobs for this company.</h3>
            @endif
          
  
          </div>
        </div>
      </section>
@endsection