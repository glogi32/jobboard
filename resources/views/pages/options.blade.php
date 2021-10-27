@extends('layouts.template')

@section('title')
    Options
@endsection

@section('content')
    @component('fixed.header-section')
        @slot('headerTitle')
            Options
        @endslot
        @slot('additionalNav')
            
        @endslot
    @endcomponent
    <section class="site-section block__18514" id="next-section">
        <div class="container">
          <div class="row">
            <div class="col-lg-3 mr-auto">
              <div class="border p-4 rounded">
                  
                
                  <a class="dropdown-item {{ ("/".request()->path() == "/options/user-edit") ? "active" : "" }}" href="{{route('user-edit')}}">Profile</a>
                  <a class="dropdown-item {{ ("/".request()->path() == "/options/saved-jobs") ? "active" : "" }}" href="{{route('saved-jobs')}}">Saved jobs</a>
                  <a class="dropdown-item {{ ("/".request()->path() == "/options/user-applications") ? "active" : "" }}" href="{{route('user-applications')}}">Applications</a>

                  @if (session("user")->role->name == "Employer")
                    <a class="dropdown-item {{ ("/".request()->path() == "/options/user-companies") ? "active" : "" }}" href="{{route('user-companies')}}">Companies</a>
                    <a class="dropdown-item {{ ("/".request()->path() == "/options/user-jobs") ? "active" : "" }}" href="{{route('user-jobs')}}">Jobs</a>
                  @endif
                  
              </div>
            </div>

            @switch($page)
                @case("user-edit")
                    @include('partials.options.user-edit')
                    @break
                @case("companies")
                    @include('partials.options.companies.companies')
                    @break
                @case("companyAdd")
                    @include('partials.options.companies.companyAdd')
                    @break
                @case("companyEdit")
                    @include('partials.options.companies.companyEdit')
                    @break
                @case("jobAdd")
                    @include('partials.options.jobs.jobAdd')
                    @break
                @case("jobs")
                    @include('partials.options.jobs.jobs')
                    @break
                @case("saved-jobs")
                    @include('partials.options.jobs.saved-jobs')
                    @break
                @case("applications")
                    @include("partials.options.applications")
                    @break
                @default
                
                    
            @endswitch
          </div>
        </div>
      </section>
    @yield('modal')
@endsection

