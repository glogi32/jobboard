@extends('layouts.template')

@section('title')
    login
@endsection

@section('content')
    @component('fixed.header-section')
        @slot('headerTitle')
            Login
        @endslot
        @slot('additionalNav')
            
        @endslot
    @endcomponent

    <section class="site-section">
        <div class="container">
          <div class="row">
            <div class="col-md-6 offset-3">
              <h2 class="mb-4 text-center">Log In To JobBoard</h2>
              <form action="{{ route("login") }}" method="POST" class="p-4 border rounded">
                @csrf
                <div class="row form-group mb-4">
                  <div class="col-md-12 mb-3 mb-md-0">
                    <label class="text-black" for="tbEmail">Email</label>
                    <input type="email" id="tbEmail" name="email" class="form-control" value="{{old("email")}}">
                  </div>
                </div>
                <div class="row form-group">
                  <div class="col-md-12 mb-3 mb-md-0">
                    <label class="text-black" for="tbPass">Password</label>
                    <input type="password" id="tbPass" name="password" class="form-control">
                  </div>
                  <div class="col-md-12 mb-3 mt-2 mb-md-0">
                    <label class="text-black" for="chbShowPass">Show Password</label>
                    <input type="checkbox" name="chbShowPass"  id="chbShowPass">
                  </div>
                </div>
                
                @if (session()->has('verificationError'))
                  <div class="alert alert-danger" role="alert">
                      {{ session("verificationError") }}
                  </div>
                @endif
                

                <div class="row form-group">
                  <div class="col-md-12 text-center">
                    <input type="submit" value="Log In" class="btn px-4 btn-primary text-white">
                  </div>
                </div>
  
              </form>
            </div>
          </div>
        </div>
      </section>
@endsection