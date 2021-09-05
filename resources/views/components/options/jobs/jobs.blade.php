<div class="col-md-9 site-section services-section bg-light block__62849 p-5">

    <div class="container">
        @csrf
        <input type="hidden" value="user-jobs" id="pageType">
        @if (session()->has("user"))
            <input type="hidden" id="userId" value="{{session("user")->id}}">            
        @endif
       <div class="row">
           <div class="col-md-3">
               <label for="ddlCompanies">Filter by companies</label>
               <select id="ddlCompanies" class="form-control">
                   <option value="">All</option>
                   @if($companies)
                    @foreach ($companies as $c)
                        <option value="{{$c->id}}">{{$c->name}}</option>
                    @endforeach
                   @endif
               </select>
           </div>
           <div class="col-md-3">
                <label for="ddlSort">Sort</label>
                <select id="ddlSort" class="form-control">
                    <option value="">Choose...</option>
                    <option value="deadline-ASC">Date expiring ascending</option>
                    <option value="deadline-DESC">Date expiring descending</option>
                    <option value="created_at-ASC">Date created ascending</option>
                    <option value="created_at-DESC">Date created descending</option>
                </select>
           </div>
           <div class="col-md-4">
               <label for="keyword">Search</label>
               <input type="text" id="keyword" placeholder="Search by title or area" class="form-control">
           </div>
       </div>
       <hr />
        <div id="jobs" class="row d-flex ">
            {{-- @if ($jobs->isEmpty())
                <h2 class="mx-auto">You don't have any jobs</h2>
            @else
                @foreach ($jobs as $job)
                    <div class="col-lg-12 col-md-12 job-listing d-block d-sm-flex pb-3 pb-sm-0 p-4 align-items-center">

                        <div class="row w-100 bg-white">

                            <div class="col-md-12  d-sm-flex custom-width mt-3 justify-content-between">

                                <div class="job-listing-position custom-width w-100 mb-3 mb-sm-0">
                                    <a href="{{route("job-details",$job->id)}}"> 
                                        <h4> {{$job->title}} </h4> 
                                    </a>
                                    <strong>{{$job->company->name}}</strong> <span> / </span> <span class="icon-room"></span> {{$job->city->name}}
                                </div>
                                <div class="job-listing-location mb-3 mb-sm-0 custom-width">
                                
                                </div>
                                <div class="job-listing-meta ">
                                    <span class="badge badge-danger">{{$emp_status[$job->employment_status]}}</span>
                                </div>

                            </div>
                            <div class="col-md-12 d-flex justify-content-between ">
                            <div class="tags">
                                
                                @foreach ($job->technologies as $t)
                                    <span class="badge badge-info">{{$t->name}}</span>
                                @endforeach

                            </div>
                                
                            <div class="expire-date ml-4">
                                <p>Days left: {{ceil(($job->deadline-time())/60/60/24) < 0 ? "Expired" : ceil(($job->deadline-time())/60/60/24) }}</p>
                            </div>
                            </div>

                        </div>
                        
                    </div>
                @endforeach
            @endif --}}
        </div>
        <a href="{{route("jobs.create")}}" class="btn btn-danger float-right mt-5">Add new job</a>
    </div>
  
</div>