<div class="col-md-8">
    <h2 class="text-center">Post new job</h2>
    @if (count($companies) == 0)
        <div class="col-md-12 mt-5">
            <h3 class="text-center">U don't have any companeies assigned to your account. Add company so u can post jobs.</h3>
            <a href="{{route("companies.create")}}" class="btn btn-danger float-right mt-5">Add new comapny</a>
        </div>
    @else
    <div class="col-md-12 order-lg-1 mt-5 personal-info">
        <form role="form" method="POST" action="{{route("jobs.store")}}" enctype="multipart/form-data">
          @csrf

          <div class="row form-group mb-4">
            <div class="col-md-12 mb-1 mb-md-0">
                <label class="text-black" for="ddlCompanies">Selected company</label>
                <select class="form-control @if($errors->has("company")) is-invalid @endif" id="ddlCompanies" name="company" >
                  @foreach ($companies as $c)
                      <option value="{{$c->id}}">{{$c->name}}</option>
                  @endforeach
                </select>

                <div class="invalid-feedback">
                  @if($errors->has("company"))
                  
                    @foreach ($errors->get("company") as $msg)
                        {{$msg}}
                    @endforeach
                  @endif
                </div>
            </div>
          </div>

          <div class="row form-group mb-4">
            <div class="col-md-12 mb-1 mb-md-0">
              <label class="text-black" for="tbTitle">Job title</label>
              <input type="text" id="tbTitle" name="title" class="form-control @if($errors->has("title")) is-invalid @endif" value="{{old("title")}}">
              <div class="invalid-feedback">
                @if($errors->has("title"))
                  @foreach ($errors->get("title") as $msg)
                      {{$msg}}
                  @endforeach
                @endif
              </div>
            </div>
          </div>
  
          

          <div class="row form-group mb-4">
            <div class="col-md-6 mb-1 mb-md-0">
              <label class="text-black" for="nunVacancy">Vacancy</label>
              <input type="number" id="nunVacancy" name="vacancy" class="form-control @if($errors->has("vacancy")) is-invalid @endif" value="{{old("vacancy")}}">
              <div class="invalid-feedback">
                @if($errors->has("vacancy"))
                  @foreach ($errors->get("vacancy") as $msg)
                      {{$msg}}
                  @endforeach
                @endif
              </div>
            </div>

            <div class="col-md-6 mb-1 mb-md-0">
              <label class="text-black" for="tbPhone">Job Deadline</label>
              <input type="date" id="dateDeadline" name="deadline" aria-describedby="phone" class="form-control @if($errors->has("deadline")) is-invalid @endif" value="{{old("deadline")}}" >
              <div class="invalid-feedback">
                @if($errors->has("deadline"))
                  @foreach ($errors->get("deadline") as $msg)
                      {{$msg}}
                  @endforeach
                @endif
              </div>
            </div>
          </div>

          <div class="row form-group my-4">
            <div class="col-md-3 mb-1 mb-md-0">
              <label class="text-black" for="ddlCity">City</label>
              <select class="form-control @if($errors->has("city")) is-invalid @endif" id="ddlCity" name="city" >
                <option value="0" selected>Choose...</option>
                @foreach ($cities as $c)
                    <option value="{{$c->id}}">{{$c->name}}</option>
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

            <div class="col-md-3 mb-1 mb-md-0">
              <label class="text-black" for="ddlSeniority">Seniority</label>
              <select class="form-control @if($errors->has("seniority")) is-invalid @endif" id="ddlSeniority" name="seniority" >
                <option value="" selected>Choose...</option>
                @foreach ($seniorities as $key => $value)
                  <option value="{{$value}}">{{$key}}</option>
                @endforeach
              </select>

              <div class="invalid-feedback">
                @if($errors->has("seniority"))
                
                  @foreach ($errors->get("seniority") as $msg)
                      {{$msg}}
                  @endforeach
                @endif
              </div>
            </div>

            <div class="col-md-3 mb-1 mb-md-0">
              <label class="text-black" for="ddlEmpStatus">Employemnt status</label>
              <select class="form-control @if($errors->has("empStatus")) is-invalid @endif" id="ddlEmpStatus" name="empStatus" >
                <option value="" selected>Choose...</option>
                @foreach ($emp_status as $key => $value)
                  <option value="{{$value}}">{{$key}}</option>
                @endforeach
              </select>

              <div class="invalid-feedback">
                @if($errors->has("empStatus"))
                
                  @foreach ($errors->get("empStatus") as $msg)
                      {{$msg}}
                  @endforeach
                @endif
              </div>
            </div>

            <div class="col-md-3 mb-1 mb-md-0">
              <label class="text-black" for="ddlArea">Area</label>
              <select class="form-control @if($errors->has("area")) is-invalid @endif" id="ddlArea" name="area" >
                <option value="" selected>Choose...</option>
                @foreach ($areas as $a)
                  <option value="{{$a->id}}">{{$a->name}}</option>
                @endforeach
              </select>

              <div class="invalid-feedback">
                @if($errors->has("area"))
                
                  @foreach ($errors->get("area") as $msg)
                      {{$msg}}
                  @endforeach
                @endif
              </div>
            </div>
          </div>

          <div class="row form-group my-4">
            <div class="col-md-6 mb-1 mb-md-0">
              <label class="text-black" for="tech">Required Technologies</label>
              <select class="w-100 chosen-select my-select @if($errors->has("tech")) is-invalid @endif" id="ddlTech"  name="tech[]"  multiple="multiple">
                @foreach ($technologies as $t)
                  <option value="{{$t->id}}">{{$t->name}}</option>
                @endforeach
              </select>

              
                
                @if($errors->has("tech"))
                <div class="alert alert-danger">
                  @foreach ($errors->get("tech") as $msg)
                      {{$msg}}
                  @endforeach
                </div>
                @endif
             

            </div>
          </div>
          
          <div class="row form-group my-4">
            <div class="col-md-12 mb-1 mb-md-0">
              <label class="text-black" for="description">Job Description</label>
              <textarea rows="6" name="description" class="form-control @if($errors->has("description")) is-invalid @endif" placeholder="Describe the job briefly...">{{old("description")}}</textarea>
              <div class="invalid-feedback">
                @if($errors->has("description"))
                  @foreach ($errors->get("description") as $msg)
                      {{$msg}}
                  @endforeach
                @endif 
              </div>
            </div>
          </div>
          <div class="row form-group my-4">
              <div class="col-md-12 mb-1 mb-md-0">
                  <label class="text-black" for="responsibilities">Responsibilities</label>
                  <textarea rows="6" name="responsibilities" class="form-control @if($errors->has("responsibilities")) is-invalid @endif" placeholder="Write required responibilities...">{{old("responsibilities")}}</textarea> 
                  <small id="phone" class="form-text ">Use / to seperate each one</small>
                  <div class="invalid-feedback">
                    @if($errors->has("responsibilities"))
                      @foreach ($errors->get("responsibilities") as $msg)
                          {{$msg}}
                      @endforeach
                    @endif 
                  </div>
              </div>
          </div>
          <div class="row form-group my-4">
            <div class="col-md-12 mb-1 mb-md-0">
                <label class="text-black" for="education">Education + experience</label>
                <textarea rows="6" name="education" class="form-control @if($errors->has("education")) is-invalid @endif" placeholder="Write required education and experience...">{{old("education")}}</textarea> 
                <small id="education" class="form-text ">Use / to seperate each one</small>
                <div class="invalid-feedback">
                  @if($errors->has("education"))
                    @foreach ($errors->get("education") as $msg)
                        {{$msg}}
                    @endforeach
                  @endif 
                </div>
            </div>
          </div>
          <div class="row form-group my-4">
            <div class="col-md-12 mb-1 mb-md-0">
                <label class="text-black" for="benefits">Other benefits</label>
                <textarea rows="6" name="benefits" class="form-control @if($errors->has("benefits")) is-invalid @endif" placeholder="Write down the benefits that your company offers...">{{old("benefits")}}</textarea> 
                <small id="benefits" class="form-text ">Use / to seperate each one</small>
                <div class="invalid-feedback">
                  @if($errors->has("benefits"))
                    @foreach ($errors->get("benefits") as $msg)
                        {{$msg}}
                    @endforeach
                  @endif 
                </div>
            </div>
          </div>
          
          
            
         
            <div class="form-group row">
                <div class="col-lg-9 ml-auto text-right">
                    <input type="reset" class="btn btn-outline-secondary" value="Reset" />
                    <input type="submit" class="btn btn-primary" value="Insert job" />
                </div>
            </div>
        </form>
      </div>
    @endif
    
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