<div class="col-md-9 site-section services-section bg-light block__62849 p-5 ">

    <div class="container">
        @csrf
        @if (session()->has("user"))
            <input type="hidden" id="role" name="role" value="{{session("user")->role->name}}">   
            <input type="hidden" id="userId" name="userId" value="{{session("user")->id}}">          
        @endif
       <div class="row position-sticky " style="top: 0px;">
          @if(session("user")->role->name == "Employer")
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
          @endif
           <div class="col-md-3">
                <label for="ddlSort">Sort</label>
                <select id="ddlSort" class="form-control">
                    <option value="" selected>Choose...</option>
                    <option value="created_at-ASC">Date created ascending</option>
                    <option value="created_at-DESC">Date created descending</option>
                    <option value="status-DESC">Status</option>
                </select>
           </div>
           <div class="col-md-4">
               <label for="keyword">Search</label>
               <input type="text" id="keyword" placeholder="Search by title or company" class="form-control">
           </div>
       </div>
       <hr />
        <div id="table-applications" class="row d-flex ">
            <table class="table table-hover mt-4 text-center">
                <thead class="thead-light position-sticky" style="top: 5rem;">
                  <tr>
                    <th scope="col" >#</th>
                    <th scope="col" class="w-25">Job title</th>
                    <th scope="col" class="w-25">Company</th>
                    <th scope="col" >Status</th>
                    <th scope="col" >Applied at</th>
                    <th scope="col">See details</th>
                  </tr>
                </thead>
                <tbody id="applications">

                </tbody>
              </table>
              <div id="load-more-app" class="text-center mt-4 w-100">
                          
                <a href="#" id="loadMoreApplications" class="text-center loadMore"  data-take="15">Load More</a>
               
              </div>
        </div>
    </div>
</div>

@section('modal')
<div class="modal fade" id="application-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div id="application-dialog" class="modal-dialog modal-lg" role="document">
     
    </div>
    
</div>
@endsection

