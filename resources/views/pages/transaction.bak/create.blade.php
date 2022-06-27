@extends('layouts.app')

@section('title', 'Tambah Invoice')
@section('custom-import-css')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
@endsection
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ url('invoice') }}">Invoice</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
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
                                        <h4 class="m-0">Tambah Transaksi</h4>
                                    </div>
                                    <div class="card-body">
                                        <!-- form start -->
                                        <form action="{{ route('transactions.store') }}" method="POST">
                                            @csrf

                                            <div class="form-group">
                                                <label>Klien</label>
                                                <select name="klien" class="form-control select2 select2-klien select2-primary @error('klien') is-invalid  @enderror" data-dropdown-css-class="select2-primary" style="width: 100%;">
                                                    <option selected="selected" disabled>Pilih Klien</option>
                                                    @foreach ($clients as $client)
                                                    <option value="{{ $client->id }}">{{ $client->nama }} &mdash; {{ $client->alamat }}</option>
                                                    @endforeach
                                                </select>
                                                @error('klien')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label>Kategori Layanan</label>
                                                <select name="kategori" id="kategori" class="form-control select2 select2-kategori select2-primary @error('kategori') is-invalid  @enderror" data-dropdown-css-class="select2-primary" style="width: 100%;">
                                                    <option selected="selected" disabled>Pilih Kategori</option>
                                                    @foreach ($serviceCategories as $serviceCategory)
                                                    <option value="{{ $serviceCategory->id }}">{{ $serviceCategory->nama }}</option>
                                                    @endforeach
                                                </select>
                                                @error('kategori')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label>Layanan</label>
                                                <select name="layanan" id="layanan" class="form-control select2 select2-layanan select2-primary @error('layanan') is-invalid  @enderror" data-dropdown-css-class="select2-primary" style="width: 100%;">
                                                    <option selected="selected" disabled>Pilih Layanan</option>
                                                </select>
                                                @error('layanan')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                                @enderror
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


{{-- Create Modal --}}
<div class="modal fade" id="modal-create">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Transaksi</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                                                        <!-- form start -->
                                        <form action="{{ route('transactions.store') }}" method="POST">
                                            @csrf

                                            <div class="form-group">
                                                <label>Klien</label>
                                                <select name="klien" class="form-control select2 select2-klien select2-primary @error('klien') is-invalid  @enderror" data-dropdown-css-class="select2-primary" style="width: 100%;">
                                                    <option selected="selected" disabled>Pilih Klien</option>
                                                    @foreach ($clients as $client)
                                                    <option value="{{ $client->id }}">{{ $client->nama }} &mdash; {{ $client->alamat }}</option>
                                                    @endforeach
                                                </select>
                                                @error('klien')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label>Kategori Layanan</label>
                                                <select name="kategori" id="kategori" class="form-control select2 select2-kategori select2-primary @error('kategori') is-invalid  @enderror" data-dropdown-css-class="select2-primary" style="width: 100%;">
                                                    <option selected="selected" disabled>Pilih Kategori</option>
                                                    @foreach ($serviceCategories as $serviceCategory)
                                                    <option value="{{ $serviceCategory->id }}">{{ $serviceCategory->nama }}</option>
                                                    @endforeach
                                                </select>
                                                @error('kategori')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label>Layanan</label>
                                                <select name="layanan" id="layanan" class="form-control select2 select2-layanan select2-primary @error('layanan') is-invalid  @enderror" data-dropdown-css-class="select2-primary" style="width: 100%;">
                                                    <option selected="selected" disabled>Pilih Layanan</option>
                                                </select>
                                                @error('layanan')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>

                <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


@section('custom-import-js')
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
@endsection
@section('custom-js')

    $(document).ready(function() {
        setTimeout(function() {
        $(".alert").alert('close');
        }, 3000);


        $('.select2-klien').select2();
        $('.select2-kategori').select2();
        $('.select2-layanan').select2();

    });

    

    $("#kategori").on('click', function(){
            $.ajax({
                url: "get-services/" + $(this).val(),
                method: 'GET',
                success: function(data) {
                    $('#layanan').html(data.html);
                }
            });
    });

    $("#kategori").on('change', function(){
            $.ajax({
                url: "get-services/" + $(this).val(),
                method: 'GET',
                success: function(data) {
                    $('#layanan').html(data.html);
                }
            });
    });


@endsection
@endsection
