@extends("admin.layout.admin-template")

@section("title")
  Admin | Companies
@endsection

@section("styles")
  <link rel="stylesheet" href="{{asset('css/admin/select2/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/admin/daterangepicker/daterangepicker.css')}}">
  <style>
    .select2-selection__choice{
      background-color: #007bff !important;
    }
    .star-color{
      color: #ea0;
    }
  </style>
@endsection

@section("scripts")
  <script src="{{asset('js/admin/select2/select2.full.min.js')}}"></script>
  <script src="{{asset('js/admin/moment/moment.min.js')}}"></script>
  <script src="{{asset('js/admin/daterangepicker/daterangepicker.js')}}"></script>
  <script src="{{asset('js/admin/charts/Chart.min.js')}}"></script>
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
                  <h1 class="m-0">Companies</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Companies</li>
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
              <h3 class="card-title">List of companies</h3>
              <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 100%;">
                  <input type="text" id="keyword" name="table_search" class="form-control float-right" placeholder="Search">
                  <input type="hidden" name="pageType" id="pageType" value="adminCompanies">
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
                  <div class="col-4">
                    <div class="form-group">
                      <label>Sort By:</label>
                      <select class="select2" id="ddlSort"  style="width: 100%;">
                        <option value="">Choose...</option>
                        <option value="created_at-ASC">Create date ascending</option>
                        <option value="created_at-DESC">Create date descending</option>
                        <option value="vote-ASC">Vote ascending</option>
                        <option value="vote-DESC">Vote descending</option>
                        <option value="name-ASC">Name ascending</option>
                        <option value="name-DESC">Name descending</option>
                        <option value="statistics-ASC">Statistics ascending</option>
                        <option value="statistics-DESC">Statistics descending</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row mt-3">
                  <div class="col-3 ">
                    <div class="form-group">
                      <label>City</label>
                      <select class="select2" multiple="multiple" id="ddlCity" style="width: 100%;">
                          @foreach ($cities as $city)
                            <option value="{{$city->id}}">{{$city->name}}</option>    
                          @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-3">
                    <div class="form-group">
                      <label>Status</label>
                      <select class="select2" id="ddlStatus" style="width: 100%;">
                        <option value="">Choose...</option>
                        <option value="Active">Active</option>
                        <option value="Deleted">Deleted</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-2 text-center">
                    <div class="form-group">
                      <label>Cancel all filters</label>
                      <div class="text-center" id="cancelFilters" style="cursor: pointer;">
                        <i class="far fa-times-circle h3 text-center text-danger" ></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table class="table table-bordered table-striped table-hover text-center">
                <thead>
                  <tr>
                    <th style="width: 3%">#</th>
                    <th>Company Name</th>
                    <th style="width: 15%">Email</th>
                    <th>Employer</th>
                    <th class="text-center">Rating</th>
                    <th style="text-align: center;">Status</th>
                    <th>Statistics</th>
                    <th>Created at</th>
                    <th>Updated at</th>
                    <th>Actions</th>
                  </tr> 
                </thead>
                <tbody id="table-companies">
                  
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
              
              <div class="form-group" style="display: inline;">
                <span id="paginationInfo" class="mr-4"></span>
                <label>Per page:</label>
                <select id="ddlPerPage" class="select2" data-placeholder="Any" style="width: 6%;">
                    <option value="5">5</option>
                    <option value="7" selected>7</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="">All</option>
                </select>
              </div>

              <ul id="companiesPagination" class="pagination pagination-sm m-0 float-right">

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
  <div class="modal fade " id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="h-100 d-flex">
      <div class="modal-dialog " style="margin: auto;">
        <div class="modal-content">
            <div class="modal-header">
                Delete city  
            </div>
            <div class="modal-body text-bold text-center">
              Are you sure you want to delete selected city?
            </div>
            <div class="modal-footer">
                <input type="hidden" name="id" id="id" value="" >
                @csrf
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button id="btn-confirm-delete" type="button" class="btn btn-danger btn-ok" >Save</button>
            </div>
        </div>
      </div>
    </div>
  </div>
@endsection
