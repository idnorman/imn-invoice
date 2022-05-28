@extends('layouts.app')

@section('title', 'Buat Layanan')
@section('custom-import-css')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('/jenis-surat') }}">Layanan</a></li>
                            <li class="breadcrumb-item active">Buat Layanan</li>
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
                                <h4 class="m-0">Buat Layanan</h4>
                            </div>
                            <div class="card-body">
                                <!-- form start -->
                                <form action="{{ route('services.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">Nama Layanan</label>
                                        <input type="text" name="name"
                                            class="form-control @error('name') is-invalid @enderror" id="name"
                                            value="{{ old('name') }}" placeholder="Cth: Hosting Small">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror

                                    </div>

                                    <div class="form-group">
                                        <label>Jenis Layanan</label>
                                        <select name="category_id" class="form-control select2 select2-primary @error('category_id') is-invalid  @enderror" data-dropdown-css-class="select2-primary" style="width: 100%;">
                                          <option selected="selected" disabled>Pilih Jenis Layanan</option>
                                          @foreach ($serviceCategories as $serviceCategory)
                                            <option value="{{ $serviceCategory->id }}">{{ $serviceCategory->name }} &mdash; {{ $serviceCategory->code }}</option>    
                                          @endforeach
                                        </select>
                                        @error('category_id')
                                            <span class="invalid-feedback" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="price">Harga</label>
                                        <input type="number" name="price"
                                            class="form-control @error('price') is-invalid @enderror" id="price"
                                            value="{{ old('price') }}" placeholder="Cth: 500000">
                                        @error('price')
                                            <span class="invalid-feedback" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="d-block">Siklus Pembayaran</label>
                                        <div class="form-check-inline">
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio" id="customRadio1" value="monthly" name="cycle" checked>
                                            <label for="customRadio1" class="custom-control-label mr-2">Bulanan</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio" id="customRadio2" value="yearly" name="cycle">
                                            <label for="customRadio2" class="custom-control-label">Tahunan</label>
                                        </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <input type="submit" class="form-control btn btn-primary" value="Tambah">
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
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
@endsection
@section('custom-js')

    $(document).ready(function() {
        setTimeout(function() {
        $(".alert").alert('close');
        }, 3000);
    });

@endsection
@endsection
