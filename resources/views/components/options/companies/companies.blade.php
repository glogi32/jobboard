<div class="col-md-9 site-section services-section bg-light block__62849 p-5">

    <div class="container">
            @csrf
            <input type="hidden" id="userId" name="userId" value="{{session("user")->id}}">
        <div id="companies" class="row d-flex justify-content-around">
            
            {{-- @if(!$companies)
                <h2>You doesn't have any companies assigned.</h2>
            @else
                @foreach ($companies as $c)
               
                    <div class="card col-md-5 col-lg-5 col-sm-12 mt-4" style="width: 18rem;">
                        <img class="card-img-top" src="{{url($c->logoImage[0]->src)}}" height="200" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">{{$c->name}}</h5>
                            <p class="card-text mb-0">Email: {{$c->email}}</p>
                            <a href="http://www.google.com" target="_blank" class="card-link mb-5">Website: www.google.com</a>

                            <a href="{{route("company-details",$c->id)}}" class="btn btn-info mt-3 text-white">See details</a>
                            <a href="{{route("companies.edit", $c->id)}}"  class="btn btn-info mt-3 text-white">Edit</a>
                            <button  data-id="{{$c->id}}" class="btn btn-danger mt-3 btn-companyDelete">Delete</button>
                        </div>
                    </div>
                
                @endforeach
            @endif --}}
            
            

        </div>

        <a href="{{route("companies.create")}}" class="btn btn-danger float-right mt-5">Add new comapny</a>
    </div>
  
</div>