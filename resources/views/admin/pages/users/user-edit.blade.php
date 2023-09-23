@extends("admin.layout.admin-template")

@section("title")
  Admin | Users Edit
@endsection

@section("scripts")
  <script src="{{asset('js/admin/moment/moment.min.js')}}"></script>
  
  <script src="{{asset('js/admin/mainAdmin.js')}}"></script>
@endsection


@section("content")
<div class="p-3">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>User Edit</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Project Edit</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-8">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">General</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
            <div class="col-md-12">
              <div class="col-md-6 offset-3">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex flex-column align-items-center text-center">
                      <img src="{{url($user->image->src)}}" alt="{{url($user->image->alt)}}" class="rounded-circle" width="150">
                      <div class="mt-3">
                        <h4>{{$user->first_name}} {{$user->last_name}}</h4>
                        <p class="text-secondary mb-1">{{$user->role->name}}</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="col-md-12 order-lg-1 mt-5 personal-info">
                <form role="form" method="POST" action="{{route("users-api.update",$user->id)}}" enctype="multipart/form-data">
                  @csrf
                  {{ method_field('PUT') }}
                  <div class="row form-group">
                    <div class="col-md-6 mb-1 mb-md-0">
                      <label class="text-black" for="fname">First Name</label>
                      <input type="text" id="tbFname" name="first-name" class="form-control @if($errors->has("first-name")) is-invalid @endif" value="{{$user->first_name}}">
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
                      <input type="text" id="tbLname" name="last-name" class="form-control @if($errors->has("last-name")) is-invalid @endif" value="{{$user->last_name}}">
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
                      <input type="email" id="tbEmail" name="email" class="form-control @if($errors->has("email")) is-invalid @endif" value="{{old('email') ? old('email') : $user->email}}">
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
                      <input type="text" id="tbPhone" name="phone" aria-describedby="phone" class="form-control @if($errors->has("phone")) is-invalid @endif" value="{{$user->phone}}">
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
                          <input type="text" id="tbLinkedin" name="linkedin" class="form-control @if($errors->has("linkedin")) is-invalid @endif" value="{{$user->linkedin}}" placeholder="http://...">
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
                          <input type="text" id="tbGithub" name="github" class="form-control @if($errors->has("github")) is-invalid @endif" value="{{$user->github}}" placeholder="http://...">
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
                          <input type="text" id="tbPortfolio" name="portfolio-website" class="form-control @if($errors->has("portfolio-website")) is-invalid @endif" value="{{$user->portfolio_link}}" placeholder="http://...">
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
                          <textarea rows="4" id="tbAbout" name="about-u" class="form-control @if($errors->has("about-u")) is-invalid @endif" placeholder="Tell us something about you...">{{$user->about_me}}</textarea>
                          <div class="invalid-feedback">
                            @if($errors->has("about-u"))
                              @foreach ($errors->get("about-u") as $msg)
                                  {{$msg}}
                              @endforeach
                            @endif
                          </div>
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
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <div class="col-md-4">
        <!-- /.card -->
        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title">Files</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="card-body p-0">
            <table class="table">
              <thead>
                <tr>
                  <th>File Name</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @if ($user->user_main_cv)
                  <tr id="{{$user->user_main_cv->id}}">
                    <td>{{explode('.', $user->user_main_cv->name)[0]}}</td>
                    <td class="text-right py-0 align-middle">
                      <div class="btn-group btn-group-sm">
                        <a href="{{url($user->user_main_cv->src)}}" target="_blank" class="btn btn-info"><i class="fas fa-eye"></i></a>
                        <a href="#" class="btn btn-danger delete-docs" data-toggle="modal" data-target="#confirm-delete" data-id={{$user->user_main_cv->id}}><i class="fas fa-trash"></i></a>
                      </div>
                    </td>
                  </tr>
                @endif
                @if(!empty($user->user_other_docs))
                  @foreach ($user->user_other_docs as $userDocs)  
                    <tr id="{{$userDocs->id}}">
                      <td>{{explode('.',$userDocs->name)[0]}}</td>
                      <td class="text-right py-0 align-middle">
                        <div class="btn-group btn-group-sm">
                          <a href="{{url($userDocs->src)}}" target="_blank" class="btn btn-info"><i class="fas fa-eye"></i></a>
                          <a href="#" class="btn btn-danger delete-docs" data-toggle="modal" data-target="#confirm-delete" data-id={{$userDocs->id}}><i class="fas fa-trash"></i></a>
                        </div>
                      </td>
                    </tr>
                  @endforeach
                @endif
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>
<div class="modal fade " id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="h-100 d-flex">
    <div class="modal-dialog " style="margin: auto;">
      <div class="modal-content">
          <div class="modal-header">
              Delete document  
          </div>
          <div class="modal-body text-bold text-center">
            Are you sure you want to delete selected document?
          </div>
          <div class="modal-footer">
              <input type="hidden" name="id" id="id" value="" >
              @csrf
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              <button id="btn-confirm-delete" type="button" class="btn btn-danger btn-ok" >Delete</button>
          </div>
      </div>
    </div>
  </div>
</div>
@endsection