@extends('layouts.app')

@section('title', 'Ubah Data ' . $user->name )

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ url('pengguna') }}">Pengguna</a></li>
                        <li class="breadcrumb-item active">Ubah Data</li>
                    </ol>
                    </div><!-- /.col -->
                    </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->
                <!-- Main content -->
                <div class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                @if(session()->has('success'))
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert"
                                    aria-hidden="true">&times;</button>
                                    {{ session()->get('success') }}
                                </div>
                                @endif
                                <div class="card card-primary card-outline">
                                    <div class="card-header">
                                        <h4 class="m-0">Ubah Data {{ $user->nama }}</h4>
                                    </div>
                                    <div class="card-body">
                                        <!-- form start -->
                                        <form action="{{ route('users.update') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('put')
                                            <input type="hidden" name="id" value="{{ $user->id }}">
                                            <div class="form-group">
                                                
                                                <label for="nama">Nama</label>
                                                <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') ? old('nama') : $user->nama }}" placeholder="{{ $user->nama }}" />
                                                @error('nama')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                
                                                <label for="inisial">Inisial</label>
                                                <input type="text" id="inisial" name="inisial" class="form-control @error('inisial') is-invalid @enderror" value="{{ old('inisial') ? old('inisial') : $user->inisial }}" placeholder="{{ $user->inisial }}" />
                                                @error('inisial')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') ? old('email') : $user->email }}" placeholder="{{ $user->email }}" />
                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                
                                                <label for="telepon">No. HP</label>
                                                <input type="number" id="telepon" name="telepon" class="form-control @error('telepon') is-invalid @enderror" value="{{ old('telepon') ? old('telepon') : $user->telepon }}" placeholder="{{ $user->telepon }}" />
                                                @error('telepon')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                
                                                <label for="jabatan">Jabatan</label>
                                                <input type="text" id="jabatan" name="jabatan" class="form-control @error('jabatan') is-invalid @enderror" value="{{ old('jabatan') ? old('jabatan') : $user->jabatan }}" placeholder="{{ $user->jabatan }}" />
                                                @error('jabatan')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </div>


                                            <div class="form-group">
                                                <label>Level Pengguna</label>
                                                <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" id="customRadio1" name="is_superadmin" value="1" {{ (old('is_superadmin') == '1') ? 'checked' : (old('is_superadmin') == '0' ? '' : (($user->is_superadmin == '1') ? 'checked' : '' )) }}>
                                                <label for="customRadio1" class="custom-control-label">Superadmin</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                <input class="custom-control-input" type="radio" id="customRadio2" name="is_superadmin" value="0" {{ (old('is_superadmin') == '0') ? 'checked' : (old('is_superadmin') == '1' ? '' : (($user->is_superadmin == '0') ? 'checked' : '' )) }}>
                                                <label for="customRadio2" class="custom-control-label">Admin</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" placeholder="Password" />
                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="password_confirmation">Konfirmasi Password</label>
                                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control  @error('password_confirmation') is-invalid @enderror" value="{{ old('password_confirmation') }}" placeholder="Konfirmasi Passowrd" />
                                                @error('password_confirmation')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </div>
                                           
                                            <div class="form-group">
                                                <input type="submit" class="form-control btn btn-primary" value="Simpan">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- /.col-12 -->
                        </div>
                        <!-- /.row -->
                        </div><!-- /.container-fluid -->
                    </div>
                    <!-- /.content -->
                </div>
                <!-- /.content-wrapper -->


@section('custom-import-js')
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
@endsection
@section('custom-js')
    $(function () {
        bsCustomFileInput.init();
    });
    $(document).ready(function() {
        setTimeout(function() {
        $(".alert").alert('close');
        }, 3000);
    });
    signature.onchange = evt => {
        const [file] = signature.files;
        if (file) {
            imagePreview.style.display = "block";
            imagePreview.src = URL.createObjectURL(file);
        }
    }
@endsection
@endsection
