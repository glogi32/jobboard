<div class="col-md-9 site-section services-section bg-light block__62849 p-5">

    <div class="container">
        @csrf
        <input type="hidden" id="userId" name="userId" value="{{session("user")->id}}">
        <div id="companies" class="row d-flex justify-content-around">
            
           
        </div>

        <a href="{{route("companies.create")}}" class="btn btn-danger float-right mt-5">Add new comapny</a>
    </div>
  
</div>