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
      {{-- <div class="modal-content ">
        <div class="modal-header">
          <h5 class="modal-title" id="application-modalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <h4 class="text-center">User info</h4>
          <div class="row">
            <div class="col-md-5">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex flex-column align-items-center text-center">
                    <img src="{{url("img/person_3.jpg")}}" alt="user" class="rounded-circle" width="150">
                    <div class="mt-3">
                      <h4>Nemanja Glogovac</h4>
                      <p class="text-secondary mb-1">Candidate</p>
                      <button class="btn btn-primary">See profile</button>
                      <button class="btn btn-outline-primary">Message</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-7">
              <div class="card mb-3">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Full Name</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      Nemanja Glogovac
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Email</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      nemanja@gmail.com
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Phone</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      065 8548 778
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Linkedin</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      www.linkedin.com
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Github</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      gihub.com
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Portfolio website</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      portfolio.nemanja-glogovac.in.rs
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                      <div class="col-sm-12">
                      <a class="btn btn-info" href="#" download>Download CV</a>
                      </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card mb-3">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12">
                      <h5 class="text-center">Candidate message</h5>
                    </div>
                  </div>
                  <hr>
                  <div class="row p-3">
                    <p>Poštovani,</p><p>
                      Ovim pismom želim da se prijavim za radno mesto Junior PHP Developer povodom Vašeg oglasa
                      objavljenog na sajtu www.helloworld.rs.
                      Verujem da iskustvo koje sam stekao pri radu na projektima rađenim u različitim jezicima i
                      arhitekturama odgovaraju zahtevima za poziciju koju nudite. Kao što možete videti u mojoj
                      biografiji veoma sam motivisan i željan za učenjem i novim dokazivanjem. Do sada imam više od
                      dvanaest urađenih projekata na kojima sam postepeno učio i usavršavao se. Svaki od projekata
                      je predstavljao poseban izazov ali i motivaciju da nastavim dalje svoj razvoj i napredovanje.
                      Pisanje čistog, modularnog i sigurnog koda su veštine koje sam stekao vremenom i radom na
                      zahtevnijim projektima. Do sada sam imao iskustva u svakom od sgmenata razvojnog ciklusa
                      softvera, od projektovanja same aplikacije, pisanje use-case i klasnih dijagrama, projektovanja
                      baze podataka, pisanje klijentskog i serverskog dela koda do samog deployment-a.
                      Rad na novim projektima i rad u timu kao i izazovi koji uz to dolaze je nešto što me posbno
                      motiviše da se prijavim na ovaj oglas. Verujem da bih se sa svojim znanjem, energijom i
                      predanošću uklopio u vaš tim i doprineo razvoju novih projekata.
                      Nadam se da ćete razmotriti moju prijavu i unapred se radujem vašem pozivu, kako bismo
                      prodiskutovali o detaljima za ovo radno mesto.</p><p><span style="font-size: 1rem;">Unapred se zahvaljujem na izdovjenom vremenu
                      koje ste posvetili mojoj prijavi.</span></p><p><span style="font-size: 1rem;">
                      S poštovanjem,
                      Nemanja Glogovac</span></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <hr />
          <h4 class="text-center">Application info</h4>
          <div class="row mt-3">
            <div class="col-md-6">
              <div class="card mb-3">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-4">
                      <h6 class="mb-0">Job title</h6>
                    </div>
                    <div class="col-sm-8 text-secondary">
                      <a href="#" class="text-secondary">Developer</a>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-4">
                      <h6 class="mb-0">Company</h6>
                    </div>
                    <div class="col-sm-8 text-secondary">
                      <a href="#" class="text-secondary">nemanja@gmail.com</a>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-4">
                      <h6 class="mb-0">Seniority and city</h6>
                    </div>
                    <div class="col-sm-8 text-secondary">
                      Junior, Belgrade
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-4">
                      <h6 class="mb-0">Applied at</h6>
                    </div>
                    <div class="col-sm-8 text-secondary">
                      14-4-2001
                    </div>
                  </div>
                  <hr>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              
              <div class="card mb-3">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-4">
                      <h6 class="mb-0">Status</h6>
                    </div>
                    <div class="col-sm-8 text-secondary">
                      <select class="form-control" name="changeStatus" id="changeStatus">
                        <option value="">test</option>
                        <option value="">2</option>
                        <option value="">3</option>
                        <option value="">4</option>
                        <option value="">5</option>
                      </select>
                    </div>
                  </div>
                  <hr>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div> --}}
     
    </div>
    
</div>
@endsection

