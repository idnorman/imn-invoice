@extends('layouts.app')

@section('title', 'Ubah Layanan ' . $service->name )

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
                            <li class="breadcrumb-item active">Ubah Layanan {{ $service->name }}</li>
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
                                <h4 class="m-0">Ubah Layanan {{ $service->name }}</h4>
                            </div>
                            <div class="card-body">
                                <!-- form start -->
                                <form action="{{ route('services.update') }}" method="POST">
                        @csrf
                        @method('put')
                        <input type="hidden" name="id" value="{{ $service->id }}">
                        <div class="form-group">
                            
                                <label for="name">Nama Layanan</label>
                                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') ? old('name') : $service->name }}" placeholder="{{ $service->name }}" />
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
                                            <option value="{{ $serviceCategory->id }}" {{ ($serviceCategory->id == $service->category_id) ? 'selected' : '' }}>{{ $serviceCategory->name }} &mdash; {{ $serviceCategory->code }}</option>    
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
                                <input type="number" id="price" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') ? old('price') : $service->price }}" placeholder="{{ $service->price }}" />
                                @error('price')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                        </div>
                        
<!--                         
                        <div class="form-group">
                            <label class="d-block">Siklus Pembayaran</label>
                            <div class="form-check-inline">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="customRadio1" value="monthly" name="cycle" {{ ($service->cycle == 'monthly') ? 'checked' : '' }}>
                                <label for="customRadio1" class="custom-control-label mr-2">Bulanan</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="customRadio2" value="yearly" name="cycle" {{ ($service->cycle == 'yearly') ? 'checked' : '' }}>
                                <label for="customRadio2" class="custom-control-label">Tahunan</label>
                            </div>
                            </div>
                        </div> -->
                        
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
@endsection
@section('custom-js')

    $(document).ready(function() {
        setTimeout(function() {
        $(".alert").alert('close');
        }, 3000);
    });

@endsection
@endsection
