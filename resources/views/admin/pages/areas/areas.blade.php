@extends("admin.layout.admin-template")

@section("title")
  Admin | Areas
@endsection

@section("styles")
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
  <script src="{{asset('js/admin/mainAdmin.js')}}"></script>
@endsection

@section("content")
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                  <h1 class="m-0">Areas</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Areas</li>
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
              <h3 class="card-title">List of areas</h3>
              <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 100%;">
                  <button class="btn-primary btn mr-3 btn-sm"  data-toggle="modal" data-target="#area-add">Add</button>
                  <input type="text" id="keyword" name="table_search" class="form-control float-right" placeholder="Search">
                  <input type="hidden" name="pageType" id="pageType" value="adminAreas">
                  <div class="input-group-append">
                    <button type="button" class="btn btn-default">
                      <i class="fas fa-search"></i>
                    </button>
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
                    <th>Name</th>
                    <th>Created at</th>
                    <th>Updated at</th>
                    <th>Actions</th>
                  </tr> 
                </thead>
                <tbody id="table-areas">
                  
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
                    <option value="99999">All</option>
                </select>
              </div>

              <ul id="areasPagination" class="pagination pagination-sm m-0 float-right">

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
  {{-- <div class="modal fade" id="city-add" tabindex="-1" role="dialog" aria-labelledby="city-add" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle"> Add city </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{route("cities-api.store")}}" method="POST">
          <div class="modal-body">
            @csrf
            <label for="cityName">City name</label>
            <input type="text" name="cityName" id="cityName" class="form-control">
            <div class="invalid-feedback">
              @if($errors->has("cityName"))
                @foreach ($errors->get("cityName") as $msg)
                    {{$msg}}
                @endforeach
              @endif
            </div>
          </div>
          <div class="modal-footer">
            @csrf
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button type="submit" id="btn-confirm-add" type="button" class="btn btn-primary btn-ok" >Save</button>
          </div>
        </form>
      </div>
    </div>
  </div> --}}
@endsection
