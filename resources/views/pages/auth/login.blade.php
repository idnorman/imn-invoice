@extends('layouts.skeleton')

@section('app')

<body class="hold-transition login-page accent-primary">
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a class="h3"><b>Instanet Media Nusantara</b></a>
      </div>
      <div class="card-body">
        {{-- <p class="login-box-msg">Masuk untuk menggunakan aplikasi</p> --}}
        @if(session()->has('success'))

        <div class="text-success text-center text-bold mb-3"> {{ session('success') }}</div>

        @endif

        @if(session()->has('warning'))

        <div class="text-warning text-center text-bold mb-3"> {{ session('warning') }}</div>
        @endif

        @if(session()->has('error'))

        <div class="text-danger text-center text-bold mb-3"> {{ session('error') }}</div>
        @endif
        @error('error')
          <!-- <div class="alert alert-warning text-center"> -->
          <div class="text-danger text-center text-bold mb-3">{{ $message }}</div>
          <!-- </div> -->
        @enderror

        
        @if(app('request')->input('error'))
              <div class="text-danger text-center text-bold mb-4"> {{ app('request')->input('error') }}</div>
          @endif

        <form action="{{ route('login_process') }}" method="post">
          @csrf
          <div class="input-group mb-3">

            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="email@insta.net.id" value="{{ old('email') ? old('email') : ''}}">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
            @error('email')
            <span class="invalid-feedback" role="alert">
              {{ $message }}
            </span>
            @enderror

          </div>
          <div class="input-group mb-3">
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Sandi">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
            @error('password')
            <span class="invalid-feedback" role="alert">
              {{ $message }}
            </span>
            @enderror
          </div>
          
<!--           <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">
                  Ingat saya
                </label>
              </div>
            </div>

          </div> -->
          <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-sign-in-alt mr-1"></i>Masuk</button>

        </form>


        <!-- /.social-auth-links -->

        <p class="mb-1 mt-1">
          <a href="{{ route('forget_password') }}">Lupa password?</a>
        </p>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->

  @endsection