<div class="col-md-8">
    <h2 class="text-center">Edit company info</h2>
    
    <div class="col-md-12 order-lg-1 mt-5 personal-info">
      <form role="form" method="POST" action="{{route("companies.update",$company->id)}}" enctype="multipart/form-data">
        @csrf
        {{ method_field('PATCH') }}
        <div class="row form-group mb-4">
          <div class="col-md-12 mb-1 mb-md-0">
            <label class="text-black" for="tbName">Company name</label>
            <input type="text" id="tbName" name="name" class="form-control @if($errors->has("name")) is-invalid @endif" value="{{$company->name}}">
            <div class="invalid-feedback">
              @if($errors->has("name"))
                @foreach ($errors->get("name") as $msg)
                    {{$msg}}
                @endforeach
              @endif
            </div>
          </div>
        </div>

        <div class="row form-group mb-4">
          <div class="col-md-12 mb-1 mb-md-0">
            <label class="text-black" for="tbEmail">Email</label>
            <input type="email" id="tbEmail" name="email" class="form-control @if($errors->has("email")) is-invalid @endif" value="{{$company->email}}">
            <div class="invalid-feedback">
              @if($errors->has("email"))
                @foreach ($errors->get("email") as $msg)
                    {{$msg}}
                @endforeach
              @endif
            </div>
          </div>
        </div>
        <div class="row form-group mb-4">
          <div class="col-md-12 mb-1 mb-md-0">
            <label class="text-black" for="tbPhone">Phone</label>
            <input type="text" id="tbPhone" name="phone" aria-describedby="phone" class="form-control @if($errors->has("phone")) is-invalid @endif" value="{{$company->phone}}" >
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
        <label class="text-black h5 mt-2">Info:</label>
        <div class="row form-group mb-1 ">
            <div class="col-md-6 mb-1 mb-md-0">
                <label class="text-black" for="tbLinkedin">Website</label>
                <input type="text" id="tbWebsite" name="website" class="form-control @if($errors->has("website")) is-invalid @endif"  placeholder="http://..." value="{{$company->website}}">
                <div class="invalid-feedback">
                  @if($errors->has("website"))
                    @foreach ($errors->get("website") as $msg)
                        {{$msg}}
                    @endforeach
                  @endif
                </div>
            </div>
            <div class="col-md-6 mb-1 mb-md-0">
                <label class="text-black" for="ddlCity">City</label>
                <select class="form-control @if($errors->has("city")) is-invalid @endif" id="ddlCity" name="city" >
                  <option value="0" selected>Choose...</option>
                  @foreach ($cities as $c)
                      <option value="{{$c->id}}" @if($c->id == $company->city_id) selected @endif>{{$c->name}}</option>
                  @endforeach
                </select>

                <div class="invalid-feedback">
                  @if($errors->has("city"))
                  
                    @foreach ($errors->get("city") as $msg)
                        {{$msg}}
                    @endforeach
                  @endif
                </div>
            </div>
        </div>
        <div class="row form-group my-4">
            <div class="col-md-12 mb-1 mb-md-0">
                <label class="text-black" for="tbPhone">About us</label>
                <textarea rows="20" id="summernote" name="about-us" class="form-control @if($errors->has("about-us")) is-invalid @endif" placeholder="Tell us something about you...">{{$company->about_us}}</textarea> 
                <div class="invalid-feedback">
                  @if($errors->has("about-us"))
                    @foreach ($errors->get("about-us") as $msg)
                        {{$msg}}
                    @endforeach
                  @endif 
                </div>
            </div>
        </div>
  
        
        <div class="row form-group md-2 pl-4">
          <div class="col-md-6  mb-3 mb-md-0 ">
            <label class="text-black" for="tbLogo">Change Logo</label><br/>
            <input type="file" name="logo" id="tbLogo" class="@if($errors->has("logo")) is-invalid @endif">
          </div>
          <div class="col-md-6 mb-md-0">
            @if($errors->has("logo"))
                  <div class="alert alert-danger" role="alert">
                    @foreach ($errors->get("logo") as $msg)
                        {{$msg}}
                    @endforeach
                  </div>
                @endif
          </div>

          <div class="col-md-6  mb-3 mb-md-0">
            <label class="text-black" for="tbImage">Change description images:</label><br/>
            <input type="file" name="images[]" id="tbImage" class="@if($errors->has("images.*")) is-invalid @endif" multiple>
          </div>
          <div class="col-md-6 mb-md-0">
            @if($errors->has("images"))
              <div class="alert alert-danger" role="alert">
                @foreach ($errors->get("images") as $msg)
                    {{$msg}}
                @endforeach
              </div>
            @endif
            @if($errors->has("images.*"))

            

              <div class="alert alert-danger" role="alert">
                 @foreach ($errors->get("images.*") as $msg)
                  {{$msg[0]}}
                    
                @endforeach 
              </div>
            @endif
          </div>
        </div>
          <div class="form-group row">
              <div class="col-lg-9 ml-auto text-right">
                  <input type="reset" class="btn btn-outline-secondary" value="Reset" />
                  <input type="submit" class="btn btn-primary" value="Edit company" />
              </div>
          </div>
      </form>
  </div>
  </div>

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
@endsection