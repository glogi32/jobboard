@extends('layouts.template')

@section('title')
    Companies
@endsection



@section('content')
  @component('fixed.header-section')
      @slot('headerTitle')
          Companies
      @endslot
      @slot('additionalNav')
      
      @endslot
  @endcomponent
  
  <section class="site-section">
    <div class="container">

      <div class="row mb-5 justify-content-center">
        <div class="col-md-7 text-center">
          <h2 id="totalCompaniesTitle" class="section-title mb-2">0 Companies Listed</h2>
        </div>
      </div>
      <div class="row mb-3">
        <input type="hidden" value="jobs" name="pageType" id="pageType"> 
        <div class="col-md-12 d-flex">
          <input type="text" name="" id="keyword" class="form-control  w-75" placeholder="Search by company name or city">
          <button class="btn btn-success text-white w-25" id="btnSearch">Search</button>
        </div>
      </div>
      <div class="row d-flex justify-content-around">
        
        <div class="col-md-3 p-2">
          <label for="ddlCity">City:</label>
          <select class="my-select form-control" id="ddlCity"  multiple>
            @foreach ($cities as $c)
              <option value="{{$c->id}}">{{$c->name}}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-3 p-2">
          <label for="ddlRating">Rating:</label>
          <select class="form-control" id="ddlRating">
            <option value="">All</option>
            <option value="1">>1</option>
            <option value="2">>2</option>
            <option value="3">>3</option>
            <option value="4">>4</option>
          </select>
        </div>
        <div class="col-md-3 p-2">
          <label for="ddlSort">Sort:</label>
          <select class="form-control" id="ddlSort"  >
            <option value="">Choose...</option>
            <option value="comments_count-ASC">Comments ascending</option>
            <option value="comments_count-DESC">Comments descending</option>
            <option value="vote-ASC">Popularity ascending</option>
            <option value="vote-DESC">Popularity descending</option>
          </select>
        </div>
      </div>
      <div class="row p-2">
        <div class="col-md-2 mt-3">
          <label for="" >Per page</label>
          <select id="ddlPerPage" class="form-control">
            <option value="3">3</option>
            <option value="6" selected>6</option>
            <option value="12">12</option>
            <option value="15">15</option>
          </select>
        </div>
      </div>
      <hr />
          
      <div class="job-listings mb-5 row bg-light"  id="companies">

        {{-- <div class="col-md-4 p-1">
          
          <div class="card col-md-12">

            <div class="card-body p-1">
              <div class="d-flex justify-content-around">
                <div class="col-md-3 p-0">
                  <img class="card-img-top img-fluid" src="{{url("img/companies/logos/1632178907_job_logo_4.jpg")}}" alt="Card image cap">
                </div>
                <div class="col-md-9 d-flex align-items-center justify-content-center">
                  <h5 class="card-title ">Company1</h5>
                </div>
                
              </div>
              <p class="card-text my-2">Some quick example text to build on the card title and make up the bulk of the card's content.
                Some quick example text to build on the card title and make up the bulk of the card's content.
                Some quick example text to build on the card title and make up the bulk.
              </p>
            </div>
            <ul class="list-group list-group-flush company-info">
              <li class="list-group-item d-flex justify-content-between">
                <p class="m-0">
                  Rating: <i class="fas fa-star star-color" ></i><i class="fas fa-star star-color" ></i><i class="fas fa-star star-color" ></i><i class="fas fa-star star-color" ></i><i class="fas fa-star star-color" ></i> (3.57)
                </p>
                <p class="m-0">Comments: 40</p> 
              </li>
              <li class="list-group-item">Head office: Belgrade</li>
              <li class="list-group-item">Web: <a href="http://" target="_blank" rel="noopener noreferrer"></a></li>
            </ul>
            <div class="my-2 text-center">
              <a href="#" class="btn btn-info my-2 text-white">See details</a>
            </div>

          </div>
        </div> --}}


      </div>

      <div class="row pagination-wrap">
        <div class="col-md-6 text-center text-md-left mb-4 mb-md-0">
          <span id="paginationInfo"></span>
          
        </div>
        <div class="col-md-6 text-center text-md-right">
          <div class="custom-pagination ml-auto">
            <div class="d-inline-block" id="companiesPagination">
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