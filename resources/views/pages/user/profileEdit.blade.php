@extends('layouts.app')

@section('title', 'Profil ' . $user->nama )

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ url('') }}">Edit Profil</a></li>
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
                                        <h4 class="m-0">Edit Profil {{ $user->nama }}</h4>
                                    </div>
                                    <div class="card-body">
                                        <!-- form start -->
                                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('put')
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
                                                <label for="tanda_tangan">Tanda tangan</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" name="tanda_tangan"
                                                        class="custom-file-input form-control @error('tanda_tangan') is-invalid @enderror"
                                                        id="tanda_tangan">
                                                        <label class="custom-file-label" for="tanda_tangan">Pilih Gambar</label>
                                                    </div>
                                                </div>
                                                @error('tanda_tangan')
                                                <span class="text-danger text-sm" style="font-size: 80% !important" role="alert">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                                <div class="d-flex justify-content-start">
                                                    <img id="imagePreview" class="mt-3" width="200" src="{{ $user->tanda_tangan ? asset('_images/tanda_tangan/' . $user->tanda_tangan) : '#' }}" alt="Image Preview" style="{{ $user->tanda_tangan == null ? 'display: none' : 'display: block' }} "/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" placeholder="Password" />
                                                <span class="small text-secondary font-italic">
                                                    Kosongkan jika tidak mengubah password
                                                </span>
                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="password_confirmation">Konfirmasi Password</label>
                                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control  @error('password_confirmation') is-invalid @enderror" value="{{ old('password_confirmation') }}" placeholder="Konfirmasi Passowrd" />
                                                <span class="small text-secondary font-italic">
                                                    Kosongkan jika tidak mengubah password
                                                </span>
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
    tanda_tangan.onchange = evt => {
        const [file] = tanda_tangan.files;
        if (file) {
            imagePreview.style.display = "block";
            imagePreview.src = URL.createObjectURL(file);
        }
    }
@endsection
@endsection
