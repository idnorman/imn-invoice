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
                <p class="login-box-msg">Lupa password? Dapatkan link untuk reset password melalui email anda</p>
                @if(session()->has('success'))

                    <div class="text-success text-center text-bold mb-3"> {{ session('success') }}</div>

                    @endif

                    @if(session()->has('warning'))

                    <div class="text-warning text-center text-bold mb-3"> {{ session('warning') }}</div>
                    @endif

                    @if(session()->has('error'))

                    <div class="text-danger text-center text-bold mb-3"> {{ session('error') }}</div>
                    @endif
                <form action="{{ route('forget_password_process') }}" method="post">
                    {{ @csrf_field() }}
                    <div class="input-group mb-3">
                        <input type="text" name="email" class="form-control  @error('email') is-invalid @enderror" placeholder="Email">
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
                    
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Dapatkan password baru</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <p class="mt-3 mb-1">
                    <a href="{{ route('login') }}">Masuk</a>
                </p>
            </div>

            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    @endsection