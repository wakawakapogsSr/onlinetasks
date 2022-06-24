@extends('layouts.app')

@section('content')
<!-- page start-->
<div class="container d-flex flex-column">
    <div class="row h-100">
        <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
            <div class="d-table-cell align-middle">
                <div class="text-center mt-4">
                    <p class="lead">Sign in to your account to continue</p>
                </div>
                <div class="card">
                  <div class="card-body">
                    <div class="m-sm-4">
                      <div class="text-center">
                          <img src="img/avatars/avatar-tmp-user.png" class="img-fluid rounded-circle" width="132" height="132" />
                      </div>
                      <form method="GET" action="{{ url('testlogin') }}" class="form-signin">
                        @csrf
                        <div class="mb-3">
                          <label class="form-label" for="email">Email</label>
                          <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">
                          @error('email')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>
                        <div class="mb-3">
                          <label class="form-label" for="password">Password</label>
                          <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                          @error('password')
                            <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                        </div>
                        <div>
                          <div class="form-check align-items-center">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label text-small" for="remember">Remember me next time</label>
                          </div>
                        </div>
                        <div class="text-center mt-3">
                          <button class="btn btn-lg btn-primary" type="submit">Sign in</button>
                        </div>
                        <div class="text-center mt-3">
                          Dont have an account yet? <a href="{{ url('user_register') }}"> Sign Up! </a> 
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- page end-->
@endsection

<script>
  document.addEventListener("DOMContentLoaded", function() {
    @if( isset($message) )
      var message = "{{ $message }}";
      var type = "success";
      var duration = "5000";
      var ripple = true;
      var dismissible = false;
      var positionX = "right";
      var positionY = "top";
      window.notyf.open({
        type,
        message,
        duration,
        ripple,
        dismissible,
        position: {
          x: positionX,
          y: positionY
        }
      });
    @endif 
  });
</script>

