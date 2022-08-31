@extends('layouts.template')

@section('title')
     {{$job->title}} 
@endsection



@section('content')
    @component('fixed.header-section')
        @slot('headerTitle')
             {{$job->title}} 
        @endslot
        @slot('additionalNav')
            <a href="{{route("company-details",$job->company->id)}}">{{$job->company->name}}</a> <span class="mx-2 slash">/</span>
        @endslot
    @endcomponent

    <section class="site-section">
        <div class="container">
          <div class="row align-items-center mb-5">
            <div class="col-lg-8 mb-4 mb-lg-0">
              <div class="d-flex align-items-center">
                <div class="border p-2 d-inline-block mr-3 rounded">
                  <a href="{{route("company-details",$job->company->id)}}"><img src="{{url($job->company->logoImage[0]->src)}}" alt="Image"></a>
                </div>
                <div>
                  <h2>{{$job->title}}</h2>
                  <div>
                    <span class="ml-0 mr-2 mb-2"><span class="icon-briefcase mr-2"></span>{{$job->company->name}}</span>
                    <span class="m-2"><span class="icon-room mr-2"></span>{{$job->city->name}}</span>
                    <span class="m-2"><span class="icon-clock-o mr-2"></span><span class="text-primary">{{$emp_status[$job->employment_status]}}</span></span>
                  </div>
                  <div class="my-2">
                    Company rating: 
                    @component('components.star-rating',["companyVote" => $job->company->vote])
                        
                    @endcomponent
                    ({{$job->company->vote}})
                  </div>
                  <div>
                    @foreach ($job->technologies as $t)
                      <span class="badge badge-info">{{$t->name}}</span>
                    @endforeach
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-4">
                <div class="row">
                    <div class="col-6">
                      @if (session()->has("user"))
                        @csrf
                        <input type="hidden" value="{{session("user")->id}}" id="userId">
                        <input type="hidden" id="jobId" value="{{$job->id}}">
                        <button href="#" id="saveJob" class="btn btn-block btn-light btn-md"><span  class="@if($saved_job) icon-heart @else icon-heart-o @endif  mr-2 text-danger"></span>Save Job</button>
                      @endif
                    </div>
                  @if (($job->deadline-time()) > 0)
                    @if(session()->has("user"))
                      <div class="col-6">
                        <a href="#" class="btn btn-block btn-primary btn-md {{($job_applied) ? 'disabled' : ''}}" data-toggle="modal" data-target="#application-form" >Apply Now</a>
                      </div>
                    @else
                    <div class="alert alert-info" role="alert">
                      You must be logged to apply for this job.
                    </div>
                    @endif
                  @else
                    <div class="alert alert-danger" role="alert">
                      This job has expired.
                    </div>
                  @endif
                </div>
                @if ($job_applied)
                  <div class="row">
                    <div class="col-md-12 mt-3">
                      <div class="alert alert-warning" role="alert">
                        You have already applied for this job.
                      </div>
                    </div>
                  </div>
                @endif
            </div>
          </div>
          <div class="row">
            <div class="col-lg-8">
              <div class="mb-5">
                <h3 class="h5 d-flex align-items-center mb-4 text-primary"><span class="icon-align-left mr-3"></span>Job Description</h3>
                <ul class="list-unstyled m-0 p-0">
                  @foreach ($description_array as $jd)
                    <li class="d-flex align-items-start mb-2"><span class="icon-check_circle mr-2 text-muted"></span><span>{{$jd}}</span></li>
                  @endforeach
                </ul>
                  
              </div>
              @if ($job->responsibilities)
                <div class="mb-5">
                  <h3 class="h5 d-flex align-items-center mb-4 text-primary"><span class="icon-rocket mr-3"></span>Requirements</h3>
                  <ul class="list-unstyled m-0 p-0">
                    @foreach ($responsibilities_array as $res)
                      <li class="d-flex align-items-start mb-2"><span class="icon-check_circle mr-2 text-muted"></span><span>{{$res}}</span></li>
                    @endforeach
                  </ul>
                </div>
              @endif
              
              @if ($job->education_experience)
                <div class="mb-5">
                  <h3 class="h5 d-flex align-items-center mb-4 text-primary"><span class="icon-book mr-3"></span>Education + Experience</h3>
                  <ul class="list-unstyled m-0 p-0">
                    @foreach ($education as $edu)
                      <li class="d-flex align-items-start mb-2"><span class="icon-check_circle mr-2 text-muted"></span><span>{{$edu}}</span></li>
                    @endforeach
                  </ul>
                </div>
              @endif
              
              @if ($job->other_benefits)
                <div class="mb-5">
                  <h3 class="h5 d-flex align-items-center mb-4 text-primary"><span class="icon-turned_in mr-3"></span>Other Benifits</h3>
                  <ul class="list-unstyled m-0 p-0">
                    @foreach ($other_benefits as $ob)
                      <li class="d-flex align-items-start mb-2"><span class="icon-check_circle mr-2 text-muted"></span><span>{{$ob}}</span></li>
                    @endforeach
                    
                  </ul>
                </div>
              @endif
              
  
              <div class="row mb-5">
                @if (session()->has("user"))
                <div class="col-6">
                  <button  class="btn btn-block btn-primary btn-md {{($job_applied) ? 'disabled ' : ''}}" data-toggle="modal" data-target="{{($job_applied) ? '' : '#application-form'}} " >Apply Now</button>
                </div>
                @else
                  <div class="alert alert-info" role="alert">
                    You must be logged to apply for this job.
                  </div>
                @endif
                
              </div>
  
            </div>
            <div class="col-lg-4">
              <div class="bg-light p-3 border rounded mb-4">
                <h3 class="text-primary  mt-3 h5 pl-3 mb-3 ">Job Summary</h3>
                <ul class="list-unstyled pl-3 mb-0">
                  <li class="mb-2"><strong class="text-black">Published on:</strong> {{date("F d, Y",strtotime($job->created_at))}}</li>
                  <li class="mb-2"><strong class="text-black">Vacancy:</strong> {{$job->vacancy}}</li>
                  <li class="mb-2"><strong class="text-black">Employment Status:</strong> {{$emp_status[$job->employment_status]}}</li>
                  <li class="mb-2"><strong class="text-black">Job Location:</strong> {{$job->city->name}}</li>
                  <li class="mb-2"><strong class="text-black">Seniority:</strong> {{$seniority[$job->seniority]}}</li>
                  <li class="mb-2"><strong class="text-black">Application Deadline:</strong> {{date("F d, Y",$job->deadline)}}</li>
                </ul>
              </div>
  
              <div class="bg-light p-3 border rounded">
                <h3 class="text-primary  mt-3 h5 pl-3 mb-3 ">Share</h3>
                <div class="px-3">
                  <a href="#" class="pt-3 pb-3 pr-3 pl-0"><span class="icon-facebook"></span></a>
                  <a href="#" class="pt-3 pb-3 pr-3 pl-0"><span class="icon-twitter"></span></a>
                  <a href="#" class="pt-3 pb-3 pr-3 pl-0"><span class="icon-linkedin"></span></a>
                  <a href="#" class="pt-3 pb-3 pr-3 pl-0"><span class="icon-pinterest"></span></a>
                </div>
              </div>
  
            </div>
          </div>
        </div>
    </section>
    
  @if (session()->has("user"))
    <div class="form-hidden">
      <div class="modal fade " id="application-form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog " role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Your application</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
              <form action="{{route("job-apply")}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="jobId" value="{{$job->id}}">
                @if (session()->has("user"))
                  <input type="hidden" name="userId" value="{{session("user")->id}}">
                @endif
                <div class="row form-group mt-3">
                  <div class="col-md-6  mb-md-0">
                    <label class="text-black" for="fname">First Name</label>
                    <input type="text" id="tbFname" name="first-name" class="form-control" value="{{session("user")->first_name}}" disabled>
                  </div>
                  <div class="col-md-6  mb-md-0">
                    <label class="text-black" for="lname">Last Name</label>
                    <input type="text" id="tbLname" name="last-name" class="form-control" value="{{session("user")->last_name}}" disabled>
                  </div>
                </div>
                <div class="row form-group ">
                  <div class="col-md-12 mb-3 mb-md-0">
                    <label class="text-black" for="tbEmail">Email</label>
                    <input type="email" id="tbEmail" name="email" class="form-control" value="{{session("user")->email}}" disabled>
                  </div>
                </div>
                <div class="row form-group ">
                  <div class="col-md-12 mb-3 mb-md-0">
                    <label class="text-black" for="tbEmail">Phone</label>
                    <input type="text" id="tbPhone" name="phone" class="form-control" value="{{session("user")->phone}}" disabled>
                  </div>
                </div>
                <div class="row form-group ">
                  <div class="col-md-12 mb-3 mb-md-0">
                    <label class="text-black" for="tbEmail">Info links</label>
                    @if(session("user")->linkedin)
                      <div class="col-md-12  mb-md-0">
                        <label class="text-black" for="tbLinkedin">Linkedin</label>
                        <input type="text" id="tbLinkedin" name="linkedin" class="form-control" value="{{session("user")->linkedin}}" disabled>
                      </div>
                    @endif
                    @if(session("user")->github)
                      <div class="col-md-12 mt-2 mb-md-0">
                        <label class="text-black" for="tbGithub">Github</label>
                        <input type="text" id="tbGithub" name="github" class="form-control" value="{{session("user")->github}}" disabled>
                      </div>
                    @endif
                    @if(session("user")->portfolio_link)
                      <div class="col-md-12 mt-2 mb-md-0">
                        <label class="text-black" for="tbPortfolio">Portfolio website</label>
                        <input type="text" id="tbPortfolio" name="portfolio-website" class="form-control" value="{{session("user")->portfolio_link}}" disabled>
                      </div>
                    @endif
                  </div>
                </div>
                <div class="row form-group">
                  <div class="col-md-12 mb-md-0">
                    @if (session()->has("user") && session("user")->user_main_cv)
                      <label for="cv-apply">Applay with:</label>
                      <input type="checkbox" id="cv-apply" name="cv-apply" checked>
                      <select name="user-cvs" id="user-cvs" class="form-control w-75 @if($errors->has("user-cvs")) is-invalid @endif">
                        @foreach (session("user")->user_cvs as $doc)
                            <option value="{{$doc->id}}" @if($doc->main) selected @endif>{{$doc->name}}</option>
                        @endforeach
                      </select>
                      
                      <div class="invalid-feedback">
                        @if($errors->has("user-cvs"))
                          @foreach ($errors->get("user-cvs") as $msg)
                              {{$msg}}
                          @endforeach
                        @endif
                      </div>
                    @endif
                  </div>
                </div>
                <div class="row form-group ">
                  <div class="col-md-6 mb-3 mb-md-0">
                      <label class="text-black" for="CV">Upload CV</label><br/>
                      <input type="file" name="cv" id="cv" aria-describedby="CVHelp" class="" >
                      <small id="CVHelp" class="form-text ">File must be in pdf,docx or doc format.</small>
                  </div>
                  <div class="col-md-6 mb-md-0">
                    @if($errors->has("cv"))
                          <div class="alert alert-danger" role="alert">
                            @foreach ($errors->get("cv") as $msg)
                                {{$msg}}
                            @endforeach
                          </div>
                        @endif
                  </div>
              </div>
              <div class="row form-group ">
                <div class="col-md-12 mb-3 mb-md-0">
                  <label class="text-black" for="summernote">Your message</label>
                  <textarea rows="7" id="summernote" name="message" class="form-control @if($errors->has("message")) is-invalid @endif">{{old("message")}}</textarea>
                  <div class="invalid-feedback">
                    @if($errors->has("message"))
                      @foreach ($errors->get("message") as $msg)
                          {{$msg}}
                      @endforeach
                    @endif
                  </div>
                </div>
              </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <input type="submit" class="btn btn-primary" value="Send message">
            </div>
          </form>
          </div>
        </div>
      </div>
    </div>
  @endif
@endsection

@section('styles')
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endsection
@section('scripts')
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
  <script>
    $(document).ready(function() {
        $('#summernote').summernote();
    });
  </script>
  @if (!$errors->isEmpty())
      <script>
        $("#application-form").modal("show");
      </script>
  @endif
@endsection
