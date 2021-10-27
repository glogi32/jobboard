<div class="col-md-9 site-section services-section bg-light block__62849 p-5">

    <div class="container">
       
        <div id="jobs" class="row d-flex ">
            @if ($jobs->isEmpty())
                <h2 class="mx-auto">You don't have any saved jobs</h2>
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
                                    <p>Days left: {{ceil(($job->deadline-time())/60/60/24) <= 0 ? "Expired" : ceil(($job->deadline-time())/60/60/24) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
  
</div>