@extends('layouts.template')

@section('title')
    Sign up
@endsection

@section('content')
    @component('fixed.header-section')
        @slot('headerTitle')
            Sign up
        @endslot
        @slot('additionalNav')
            
        @endslot
    @endcomponent

    <section class="site-section">
        <div class="container">
          <div class="row">
            <div class="col-lg-6 offset-3 mb-3">
              <h2 class="mb-4 text-center">Sign Up To JobBoard</h2>
              <form action="{{route("sign-up")}}" method="POST" enctype="multipart/form-data" class="p-4 border rounded">
                  @csrf
                <div class="row form-group">
                  <div class="col-md-6 mb-3 mb-md-0">
                    <label class="text-black" for="fname">First Name</label>
                    <input type="text" id="tbFname" name="first-name" class="form-control @if($errors->has("first-name")) is-invalid @endif" value="{{old("first-name")}}">
                    <div class="invalid-feedback">

                      @if($errors->has("first-name"))
                        @foreach ($errors->get("first-name") as $msg)
                            {{$msg}}
                        @endforeach
                      @endif

                    </div>
                  </div>
                  <div class="col-md-6 mb-3 mb-md-0">
                    <label class="text-black" for="lname">Last Name</label>
                    <input type="text" id="tbLname" name="last-name" class="form-control @if($errors->has("last-name")) is-invalid @endif" value="{{old("last-name")}}">
                    <div class="invalid-feedback">

                      @if($errors->has("last-name"))
                        @foreach ($errors->get("last-name") as $msg)
                            {{$msg}}
                        @endforeach
                      @endif

                    </div>
                  </div>
                </div>
                <div class="row form-group mb-4">
                  <div class="col-md-12 mb-3 mb-md-0">
                    <label class="text-black" for="tbEmail">Email</label>
                    <input type="email" id="tbEmail" name="email" class="form-control @if($errors->has("email")) is-invalid @endif" value="{{old("email")}}">
                    <div class="invalid-feedback">
                      @if($errors->has("email"))
                        @foreach ($errors->get("email") as $msg)
                            {{$msg}}
                        @endforeach
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row form-group">
                  <div class="col-md-12 mb-3 mb-md-0">
                    <label class="text-black" for="tbPass">Password</label>
                    <input type="password" id="tbPass" name="password" aria-describedby="pass" class="form-control  @if($errors->has("password")) is-invalid @endif" value="{{old("password")}}">
                    <small id="pass" class="form-text ">The password must contain at least one uppercase, one lowercase letter, one number and must be min 8 characters.</small>
                    <div class="invalid-feedback">
                      @if($errors->has("password"))
                        @foreach ($errors->get("password") as $msg)
                            {{$msg}}
                        @endforeach
                      @endif
                    </div>
                  </div>
                  <div class="col-md-12 mb-3 mt-2 mb-md-0">
                    <label class="text-black" for="chbShowPass">Show Password</label>
                    <input type="checkbox" name="chbShowPass"  id="chbShowPass">
                  </div>
                </div>
                <div class="row form-group mb-4">
                  <div class="col-md-12 mb-3 mb-md-0">
                    <label class="text-black" for="tbPhone">Phone</label>
                    <input type="text" id="tbPhone" name="phone" aria-describedby="phone" class="form-control @if($errors->has("phone")) is-invalid @endif" value="{{old("phone")}}">
                    <small id="phone" class="form-text ">Phone numbers can be seperated with - or space.</small>
                    <div class="invalid-feedback">
                      @if($errors->has("phone"))
                        @foreach ($errors->get("phone") as $msg)
                            {{$msg}}
                        @endforeach
                      @endif
                    </div>
                  </div>
                </div>
                <label class="text-black h5 mt-2">Info links:</label>
                <div class="row form-group mb-4 ">
                    <div class="col-md-4 mb-3 mb-md-0">
                        <label class="text-black" for="tbLinkedin">Linkedin</label>
                        <input type="text" id="tbLinkedin" name="linkedin" class="form-control @if($errors->has("linkedin")) is-invalid @endif" value="{{old("linkedin")}}" placeholder="http://...">
                        <div class="invalid-feedback">
                          @if($errors->has("linkedin"))
                            @foreach ($errors->get("linkedin") as $msg)
                                {{$msg}}
                            @endforeach
                          @endif
                        </div>
                    </div>
                    <div class="col-md-4 mb-3 mb-md-0">
                        <label class="text-black" for="tbGithub">Github</label>
                        <input type="text" id="tbGithub" name="github" class="form-control @if($errors->has("github")) is-invalid @endif" value="{{old("github")}}" placeholder="http://...">
                        <div class="invalid-feedback">
                          @if($errors->has("github"))
                            @foreach ($errors->get("github") as $msg)
                                {{$msg}}
                            @endforeach
                          @endif
                        </div>
                    </div>
                    <div class="col-md-4 mb-3 mb-md-0">
                        <label class="text-black" for="tbPortfolio">Portfolio website</label>
                        <input type="text" id="tbPortfolio" name="portfolio-website" class="form-control @if($errors->has("portfolio-website")) is-invalid @endif" value="{{old("portfolio-website")}}" placeholder="http://...">
                        <div class="invalid-feedback">
                          @if($errors->has("portfolio-website"))
                            @foreach ($errors->get("portfolio-website") as $msg)
                                {{$msg}}
                            @endforeach
                          @endif
                        </div>
                    </div>
                </div>
                <div class="row form-group mb-4">
                    <div class="col-md-12 mb-3 mb-md-0">
                        <label class="text-black" for="tbPhone">About you</label>
                        <textarea rows="4" id="tbAbout" name="about-u" class="form-control @if($errors->has("about-u")) is-invalid @endif" placeholder="Tell us something about you...">{{old("about-u")}}</textarea>
                        <div class="invalid-feedback">
                          @if($errors->has("about-u"))
                            @foreach ($errors->get("about-u") as $msg)
                                {{$msg}}
                            @endforeach
                          @endif
                        </div>
                    </div>
                </div>
                <div class="row form-group mb-4">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <label class="text-black" for="CV">Main CV</label><br/>
                        <input type="file" name="cv" id="CV" aria-describedby="CVHelp" class="">
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
                <div class="row form-group mb-4">
                  <div class="col-md-6 mb-3 mb-md-0">
                      <label class="text-black" for="otherDocs">Other Documents</label><br/>
                      <input type="file" name="otherDocs[]" id="otherDocs" aria-describedby="CVHelp" class="" multiple>
                      <small id="OtherCVHelp" class="form-text ">File must be in pdf,docx or doc format.</small>
                  </div>
                  <div class="col-md-6 mb-md-0">
                    @if($errors->has("otherDocs"))
                          <div class="alert alert-danger" role="alert">
                            @foreach ($errors->get("otherDocs") as $msg)
                                {{$msg}}
                            @endforeach
                          </div>
                        @endif
                  </div>
              </div>
                <div class="row form-group md-4">
                  <div class="col-md-6  mb-3 mb-md-0">
                    <label class="text-black" for="tbImage">Profile image</label><br/>
                    <input type="file" name="image" id="tbImage">
                  </div>
                  <div class="col-md-6 mb-md-0">
                    @if($errors->has("image"))
                          <div class="alert alert-danger" role="alert">
                            @foreach ($errors->get("image") as $msg)
                                {{$msg}}
                            @endforeach
                          </div>
                        @endif
                  </div>
                </div>
  
                <div class="row form-group ">
                  <div class="col-md-12">
                    <input type="submit" value="Sign Up" class="btn px-4 btn-primary text-white">
                    <input type="reset" class="btn btn-outline-secondary" value="Cancel" />
                  </div>
                </div>
  
              </form>
            </div>
          </div>
        </div>
      </section>
      
@endsection




