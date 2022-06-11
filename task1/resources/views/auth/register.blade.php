@extends('layouts.app')

@section('content')
  <div class="container d-flex flex-column">
    <div class="row h-100">
      <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
        <div class="d-table-cell align-middle">
          <div class="text-center mt-4">
            <h1 class="h2"> Register </h1>
            <p class="lead"> Create your account to continue </p>
          </div>
          <div class="card">
            <div class="card-body">
              <div class="m-sm-4">
                <form method="POST" action="{{ route('register') }}">
                  @csrf
                  <div class="mb-3">
                    <label class="form-label" for="name"> {{ __('Name') }}</label>
                    <input type="text" name="name" class="form-control form-control-lg @error('name') is-invalid @enderror" value="{{ old('name') }}" id="name" placeholder="Enter your name" required autofocus />
                    @error('name')
                      <span class="font-13 text-danger"> {{ $message }} </span>
                    @enderror
                  </div>
                  <div class="mb-3">
                    <label class="form-label" for="company"> {{ __('Company') }} </label>
                    <input type="text" name="company" class="form-control form-control-lg" id="company" value="{{ old('company') }}" id="company" placeholder="Enter your company name" required />
                    @error('company')
                      <span class="font-13 text-danger"> {{ $message }} </span>
                    @enderror
                  </div>
                  <div class="mb-3">
                    <label class="form-label" for="email"> {{ __('Email') }} </label>
                    <input type="email"name="email" class="form-control form-control-lg @error('email') is-invalid @enderror"  value="{{ old('email') }}" id="email" placeholder="Enter your email" required />
                    @error('email')
                      <span class="font-13 text-danger"> {{ $message }} </span>
                    @enderror
                  </div>
                  <div class="mb-3">
                    <label class="form-label" for="password"> {{ __('Password') }} </label>
                    <input type="password" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror" id="password" placeholder="Enter password" required />
                    @error('password')
                      <span class="font-13 text-danger"> {{ $message }} </span>
                    @enderror
                  </div>
                  <div class="mb-3">
                    <label class="form-label" for="password-confirm"> {{ __('Confirm Password') }} </label>
                    <input type="password" name="password_confirmation" class="form-control form-control-lg @error('password') is-invalid @enderror" id="password-confirm" placeholder="Confirm password" />
                  </div>
                  <div class="text-center mt-3" for="name">
                    <button type="submit" class="btn btn-lg btn-primary"> {{ __('Register') }} </button>
                  </div>
                  <div class="text-center mt-3">
                    Already have an Account ? <a href="{{ route('login') }}"> Sign In! </a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
