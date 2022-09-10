@extends("admin.layout.admin-template")

@section("title")
  Admin | Users
@endsection

@section("styles")
  <link rel="stylesheet" href="{{asset('css/admin/select2/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/admin/daterangepicker/daterangepicker.css')}}">
  <style>
    .select2-selection__choice{
      background-color: #007bff !important;
    }
  </style>
@endsection

@section("scripts")
  <script src="{{asset('js/admin/select2/select2.full.min.js')}}"></script>
  <script src="{{asset('js/admin/moment/moment.min.js')}}"></script>
  <script src="{{asset('js/admin/daterangepicker/daterangepicker.js')}}"></script>
  <script>
    $(function () {
      $('.select2').select2();
      
    });
  </script>
  <script src="{{asset('js/admin/mainAdmin.js')}}"></script>

@endsection

@section("content")
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                  <h1 class="m-0">Users</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Users</li>
                </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            
            <div class="card-header">
              <h3 class="card-title">Bordered Table</h3>
              <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 100%;">
                  <input type="text" id="keyword" name="table_search" class="form-control float-right" placeholder="Search">

                  <div class="input-group-append">
                    <button type="button" class="btn btn-default">
                      <i class="fas fa-search"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-10 offset-md-1">
                <div class="row">
                  <div class="col-4">
                    <div class="form-group">
                        <label>Role</label>
                        <select class="select2" id="ddlRole" style="width: 100%;">
                            <option value="">Choose...</option>
                            @foreach ($roles as $role)
                              <option value="{{$role->id}}">{{$role->name}}</option>    
                            @endforeach
                        </select>
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="form-group">
                        <label>Status</label>
                        <select class="select2" id="ddlStatus" style="width: 100%;">
                          <option value="">Choose...</option>
                          <option>Active</option>
                          <option>Pending</option>
                          <option>Deleted</option>
                        </select>
                    </div>
                  </div>
                  <div class="col-4">
                      <div class="form-group">
                          <label>Sort By:</label>
                          <select class="select2" id="ddlSort"  style="width: 100%;">
                            <option value="">Choose...</option>
                            <option value="created_at-ASC">Create date ascending</option>
                            <option value="created_at-DESC">Create date descending</option>
                            <option value="verified-ASC">Verification date ascending</option>
                            <option value="verified-DESC">Verification date descending</option>
                            <option value="first_name-ASC">Name ascending</option>
                            <option value="first_name-DESC">Name descending</option>
                          </select>
                      </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-4">
                    <div class="form-group">
                        <label>Verification date</label>
                        <input type="text" class="form-control float-right rangedatetime" id="verification-range">
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="form-group">
                        <label>Created at date</label>
                        <input type="text" class="form-control float-right rangedatetime" id="create-range">
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="form-group">
                        <label>Updated at date</label>
                        <input type="text" class="form-control float-right rangedatetime" id="update-range">
                    </div>
                  </div>
                </div>
                {{-- <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <div class="input-group input-group-lg">
                          <input type="search" class="form-control form-control-lg" placeholder="Type your keywords here" value="Lorem ipsum">
                          <div class="input-group-append">
                              <button type="submit" class="btn btn-lg btn-default">
                                  <i class="fa fa-search"></i>
                              </button>
                          </div>
                      </div>
                    </div>
                  </div>
                </div> --}}
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table class="table table-bordered table-striped table-hover ">
                <thead>
                  <tr>
                    <th style="width: 3%">#</th>
                    <th>Full name</th>
                    <th style="width: 15%">Email</th>
                    <th>Role</th>
                    <th>Verified at</th>
                    <th style="text-align: center;">Status</th>
                    <th>Created at</th>
                    <th>Updated at</th>
                    <th>Actions</th>
                  </tr> 
                </thead>
                <tbody id="table-users">
                  
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer  clearfix">
              
              <div class="form-group" style="display: inline;">
                <span id="paginationInfo" class="mr-4"></span>
                <label>Per page:</label>
                <select id="ddlPerPage" class="select2" data-placeholder="Any" style="width: 6%;">
                    <option>5</option>
                    <option selected>7</option>
                    <option>10</option>
                    <option>15</option>
                    <option>All</option>
                </select>
              </div>

              <ul id="usersPagination" class="pagination pagination-sm m-0 float-right">

              </ul>
            </div>
          </div>
          <!-- /.card -->

        </div>
       
      </div>
      <!-- /.row -->
      
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
@endsection
