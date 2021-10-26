<div class="col-md-8">
  <div class="col-md-6 offset-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex flex-column align-items-center text-center">
          <img src="{{url(session('user')->image->src)}}" alt="{{url(session('user')->image->alt)}}" class="rounded-circle" width="150">
          <div class="mt-3">
            <h4>{{session('user')->first_name}} {{session('user')->last_name}}</h4>
            <p class="text-secondary mb-1">{{session('user')->role->name}}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="col-md-12 order-lg-1 mt-5 personal-info">
    <form role="form" method="POST" action="{{route("users.update",session("user")->id)}}" enctype="multipart/form-data">
      @csrf
      {{ method_field('PUT') }}
      <div class="row form-group">
        <div class="col-md-6 mb-1 mb-md-0">
          <label class="text-black" for="fname">First Name</label>
          <input type="text" id="tbFname" name="first-name" class="form-control @if($errors->has("first-name")) is-invalid @endif" value="{{session('user')->first_name}}">
          <div class="invalid-feedback">

            @if($errors->has("first-name"))
              @foreach ($errors->get("first-name") as $msg)
                  {{$msg}}
              @endforeach
            @endif

          </div>
        </div>
        <div class="col-md-6 mb-1 mb-md-0">
          <label class="text-black" for="lname">Last Name</label>
          <input type="text" id="tbLname" name="last-name" class="form-control @if($errors->has("last-name")) is-invalid @endif" value="{{session('user')->last_name}}">
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
        <div class="col-md-12 mb-1 mb-md-0">
          <label class="text-black" for="tbEmail">Email</label>
          <input type="email" id="tbEmail" name="email" class="form-control @if($errors->has("email")) is-invalid @endif" value="{{session('user')->email}}">
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
        <div class="col-md-12 mb-1 mb-md-0">
          <label class="text-black" for="tbPass">Password</label>
          <input type="password" id="tbPass" name="password" aria-describedby="pass" class="form-control  @if($errors->has("password")) is-invalid @endif" ">
          <small id="pass" class="form-text ">The password must contain at least one uppercase, one lowercase letter, one number and must be min 8 characters.</small>
          <div class="invalid-feedback">
            @if($errors->has("password"))
              @foreach ($errors->get("password") as $msg)
                  {{$msg}}
              @endforeach
            @endif
          </div>
        </div>
        <div class="col-md-12 mb-1 mt-2 mb-md-0">
          <label class="text-black" for="chbShowPass">Show Password</label>
          <input type="checkbox" name="chbShowPass"  id="chbShowPass">
        </div>
      </div>
      <div class="row form-group mb-4">
        <div class="col-md-12 mb-1 mb-md-0">
          <label class="text-black" for="tbPhone">Phone</label>
          <input type="text" id="tbPhone" name="phone" aria-describedby="phone" class="form-control @if($errors->has("phone")) is-invalid @endif" value="{{session('user')->phone}}">
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
      <div class="row form-group mb-1 ">
          <div class="col-md-4 mb-1 mb-md-0">
              <label class="text-black" for="tbLinkedin">Linkedin</label>
              <input type="text" id="tbLinkedin" name="linkedin" class="form-control @if($errors->has("linkedin")) is-invalid @endif" value="{{session('user')->linkedin}}" placeholder="http://...">
              <div class="invalid-feedback">
                @if($errors->has("linkedin"))
                  @foreach ($errors->get("linkedin") as $msg)
                      {{$msg}}
                  @endforeach
                @endif
              </div>
          </div>
          <div class="col-md-4 mb-1 mb-md-0">
              <label class="text-black" for="tbGithub">Github</label>
              <input type="text" id="tbGithub" name="github" class="form-control @if($errors->has("github")) is-invalid @endif" value="{{session('user')->github}}" placeholder="http://...">
              <div class="invalid-feedback">
                @if($errors->has("github"))
                  @foreach ($errors->get("github") as $msg)
                      {{$msg}}
                  @endforeach
                @endif
              </div>
          </div>
          <div class="col-md-4 mb-1 mb-md-0">
              <label class="text-black" for="tbPortfolio">Portfolio website</label>
              <input type="text" id="tbPortfolio" name="portfolio-website" class="form-control @if($errors->has("portfolio-website")) is-invalid @endif" value="{{session('user')->portfolio_link}}" placeholder="http://...">
              <div class="invalid-feedback">
                @if($errors->has("portfolio-website"))
                  @foreach ($errors->get("portfolio-website") as $msg)
                      {{$msg}}
                  @endforeach
                @endif
              </div>
          </div>
      </div>
      <div class="row form-group mb-2">
          <div class="col-md-12 mb-1 mb-md-0">
              <label class="text-black" for="tbPhone">About you</label>
              <textarea rows="4" id="tbAbout" name="about-u" class="form-control @if($errors->has("about-u")) is-invalid @endif" placeholder="Tell us something about you...">{{session('user')->about_me}}</textarea>
              <div class="invalid-feedback">
                @if($errors->has("about-u"))
                  @foreach ($errors->get("about-u") as $msg)
                      {{$msg}}
                  @endforeach
                @endif
              </div>
          </div>
      </div>

      <div class="row form-group mb-2">
          <div class="col-md-12 my-3">
            <label class="d-inline">Main CV:
            @if ($user_main_cv)
               {{session("user")->user_main_cv->name}}</label> 
              <a class="btn btn-info mb-3 d-inline" href="{{url(session("user")->user_main_cv->src)}}" download>Download CV</a>
              <a class="btn btn-info mb-3 d-inline btn-remove-docs text-white" data-id="{{$user_main_cv->id}}">Remove CV</a>
            @else
              There is no cv assigned.</label>
            @endif
          </div>
          <div class="col-md-6 mb-3 mb-md-0">
              <label class="text-black" for="CV">Change CV</label><br/>
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
      
      <div class="row form-group mb-2">
        <div class="col-md-12 my-3">
          <label class="d-inline">Other documents: </label> 

            @if (!$user_other_docs->isEmpty())
              <ul>
                @foreach ($user_other_docs as $docs)
                  <li class="my-2">
                    <label>{{$docs->name}}</label>
                    <a class="btn btn-info mb-3 d-inline" href="{{$docs->src}}" download>Download Document</a>
                    <a class="btn btn-info mb-3 d-inline btn-remove-docs text-white" data-id="{{$docs->id}}">Remove Document</a>
                  </li>
                @endforeach
              </ul>
            @else
              <p>There is no documents assigned.</p>
            @endif

        </div>
        <div class="col-md-6 mb-3 mb-md-0">
            <label class="text-black" for="other-docs">Change Documents</label><br/>
            <input type="file" name="other-docs[]" id="other-docs" aria-describedby="other-docsHelp" multiple>
            <small id="other-docsHelp" class="form-text ">File must be in pdf,docx or doc format.</small>
        </div>
        <div class="col-md-6 mb-md-0">
          @if($errors->has("other-docs"))
                <div class="alert alert-danger" role="alert">
                  @foreach ($errors->get("other-docs") as $msg)
                      {{$msg}}
                  @endforeach
                </div>
              @endif
          </div>
      </div>
      
      <div class="row form-group md-2">
        <div class="col-md-6  mb-3 mb-md-0">
          <label class="text-black" for="tbImage">Change Image</label><br/>
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
        <div class="form-group row">
            <div class="col-lg-9 ml-auto text-right">
                <input type="reset" class="btn btn-outline-secondary" value="Cancel" />
                <input type="submit" class="btn btn-primary" value="Save Changes" />
            </div>
        </div>
    </form>
</div>
</div>