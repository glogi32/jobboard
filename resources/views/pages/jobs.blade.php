@extends('layouts.template')

@section('title')
    Jobs
@endsection



@section('content')
  @component('fixed.header-section')
      @slot('headerTitle')
          Jobs
      @endslot
      @slot('additionalNav')
      
      @endslot
  @endcomponent
  
  <section class="site-section">
    <div class="container ">

      <div class="row mb-5 justify-content-center">
        <div class="col-md-7 text-center">
          <h2 id="totalJobsTitle" class="section-title mb-2">43,167 Job Listed</h2>
        </div>
      </div>
      <div class="row mb-3">
        <input type="hidden" value="jobs" name="pageType" id="pageType"> 
        <div class="col-md-12 d-flex">
          <input type="text" name="" id="keyword" class="form-control  w-75" placeholder="Search by job title, company or area">
          <button class="btn btn-success text-white w-25" id="btnSearch">Search</button>
        </div>
      </div>
      <div class="row d-flex justify-content-around">
        <div class="col-md-2 p-2">
          <label for="ddlArea">Areas:</label>
          <select class="my-select w-100" id="ddlArea"  multiple>
            @foreach ($areas as $a)
              <option value="{{$a->id}}">{{$a->name}}</option>
            @endforeach
            
          </select>
        </div>
        <div class="col-md-2 p-2">
          <label for="ddlTech">Technologies:</label>
          <select class="my-select  w-100" id="ddlTech"  multiple>
            @foreach ($tech as $t)
              <option value="{{$t->id}}">{{$t->name}}</option>
            @endforeach            
          </select>
        </div>
        <div class="col-md-2 p-2">
          <label for="ddlCity">City:</label>
          <select class="my-select w-100" id="ddlCity"  multiple>
            @foreach ($cities as $c)
              <option value="{{$c->id}}">{{$c->name}}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-2 p-2">
          <label for="ddlSeniority">Seniority:</label>
          <select class="my-select w-100" id="ddlSeniority"  multiple>
            @foreach ($seniorities as $key => $value)
              <option value="{{$key}}">{{$value}}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-2 p-2">
          <label for="ddlSort">Sort:</label>
          <select class="form-control" id="ddlSort"  >
            <option value="">Choose...</option>
            <option value="deadline-ASC">Date expiring ascending</option>
            <option value="deadline-DESC">Date expiring descending</option>
          </select>
        </div>
      </div>
      <div class="row p-2">
        <div class="col-md-2 mt-3">
          <label for="" >Per page</label>
          <select id="ddlPerPage" class="form-control">
            <option value="5">5</option>
            <option value="7" selected>7</option>
            <option value="10">10</option>
            <option value="15">15</option>
          </select>
        </div>
      </div>
      <hr />
          
      <ul class="job-listings mb-5" id="jobs">
        {{-- <li class="job-listing d-block d-sm-flex pb-3 pb-sm-0 align-items-center row">
          <a href="job-single.html"></a>
          <div class="job-listing-logo col-md-3">
            <img src="{{asset("img/home/job_logo_1.jpg")}}" alt="Free Website Template by Free-Template.co" class="img-fluid">
          </div>

          <div class="col-md-9">

            <div class="col-md-12  d-sm-flex custom-width mt-3 justify-content-between">

                <div class="job-listing-position custom-width w-75 mb-3 mb-sm-0">
                  <h2> Senior Software Development Engineer in Test </h2>
                  <strong>Company123</strong> <span> / </span> <span class="icon-room"></span> Belgrade
                </div>
                <div class="job-listing-location mb-3 mb-sm-0 custom-width">
                  
                </div>
                <div class="job-listing-meta ">
                  <span class="badge badge-danger">Full Time</span>
                </div>

            </div>
            <div class="col-md-12 d-flex justify-content-between">
              <div class="tags">
                <span class="badge badge-info">Info</span>
                <span class="badge badge-info">Info</span>
                <span class="badge badge-info">Info</span>
                <span class="badge badge-info">Info</span>
                <span class="badge badge-info">Info</span>
                <span class="badge badge-info">Info</span>
                <span class="badge badge-info">Info</span>
                <span class="badge badge-info">Info</span>
                <span class="badge badge-info">Info</span>
                <span class="badge badge-info">Info</span>
                <span class="badge badge-info">Info</span>
                <span class="badge badge-info">Info</span>

              </div>
                
              <div class="expire-date ml-4">
                <p>Days left: 45</p>
              </div>
            </div>

          </div>
           
        </li> --}}
      </ul>

      <div class="row pagination-wrap">
        <div class="col-md-6 text-center text-md-left mb-4 mb-md-0">
          <span id="paginationInfo"></span>
          
        </div>
        <div class="col-md-6 text-center text-md-right">
          <div class="custom-pagination ml-auto">
            <div class="d-inline-block" id="jobsPagination">
              <a href="#" id="prevPage" class="prev jobPage btn-link">Prev</a>
              <a href="#" class="active">1</a>
              <a href="#">2</a>
              <a href="#">3</a>
              <a href="#">4</a>
              <a href="#" id="nextPage" class="next jobPage btn-link">Next</a>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>

@endsection