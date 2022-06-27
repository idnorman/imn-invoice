@extends('layouts.app')

@section('title', 'Data Transaksi')
@section('custom-import-css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
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
                            <li class="breadcrumb-item"><a href="{{ url('transaksi') }}">Transaksi</a></li>
                            <li class="breadcrumb-item"></li>
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
                        @if (session()->has('success'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert"
                                    aria-hidden="true">&times;</button>
                                    <h5 class="mb-0">{{ session()->get('success') }}</h5>
                            </div>
                        @endif
                        <div class="card">
                            @if(auth()->user()->is_superadmin == 0)
                            <div class="card-header">
                                <a href="" class="btn btn-primary" data-toggle="modal" data-target="#modal-create">Tambah</a>
                            </div>
                            @endif
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th width="7%">No</th>
                                            <th>Tanggal</th>
                                            <th>Klien</th>
                                            <th>Layanan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($transactions as $transaction)

                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ formatDate($transaction->date) }}</td>

                                                <td>{{ $transaction->client->nama }}</td>
                                                <td>{{ $transaction->service->nama }}</td>
                                                
                                                <td>
                                                    <a href="{{ route('transactions.show', $transaction->id) }}" class="btn btn-xs btn-info font-weight-bold">Detail</a>
                                                    @if(auth()->user()->is_superadmin == 0)
                                                    <a href="" class="btn btn-xs btn-danger font-weight-bold" data-toggle="modal"
                                                        data-target="#modal-default" data-id="{{ $transaction->id }}">Hapus</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Klien</th>
                                            <th>Layanan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
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


    {{-- Delete Modal --}}
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Hapus data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin untuk mengapus data ini?</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <form action="{{ route('transactions.delete') }}" method="POST">
                        @csrf
                        @method('delete')
                        <input type="hidden" name="id" value="" id="id">
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->


@section('custom-import-js')
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
@endsection
@section('custom-js')
    $(function () {
    $("#example1").DataTable({
    "responsive": true, "lengthChange": true, "autoWidth": true,
    "language": {
        "zeroRecords": "Data kosong",
        "info": "Menampilkan _START_ - _END_ dari _TOTAL_ data",
        "infoEmpty": "Menampilkan 0 dari 0 data",
        "lengthMenu": "Menampilkan _MENU_ data",
        "paginate": {
            "previous": "Sebelumnya",
            "next": "Selanjutnya"
        },
        "search": "Cari: ",
        "buttons": {
            "copy": "Salin",
            "colvis": "Filter Kolom"
        }
    },
    {{-- "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"] --}}
    {{-- "buttons": [
        {
            extend: 'copyHtml5',
            exportOptions: {
                columns: [0,2,3,4]
            }
        },
        {
            extend: 'csvHtml5',
            exportOptions: {
                columns: [0,2,3,4]
            }
        },
        {
            extend: 'excelHtml5',
            exportOptions: {
                columns: [0,2,3,4]
            }
        },
        {
            extend: 'pdfHtml5',
            exportOptions: {
                columns: [0,2,3,4]
            }
        },
        {
            extend: 'print',
            exportOptions: {
                columns: [0,2,3,4]
            }
        },
        {
            extend: 'colvis'
        }
    ] --}}
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });

    $('#modal-detail').on('show.bs.modal', function(e) {

        //get data-id attribute of the clicked element
        var nama = $(e.relatedTarget).data('nama');
        var inisial = $(e.relatedTarget).data('inisial');
        var email = $(e.relatedTarget).data('email');
        var telepon = $(e.relatedTarget).data('telepon');
        var jabatan = $(e.relatedTarget).data('jabatan');

        $(e.currentTarget).find('.modal-detail-title').text('Detail ' + nama);

        $(e.currentTarget).find('input[name="detail_nama"]').val(nama);
        $(e.currentTarget).find('input[name="detail_inisial"]').val(inisial);
        $(e.currentTarget).find('input[name="detail_email"]').val(email);
        $(e.currentTarget).find('input[name="detail_telepon"]').val(telepon);
        $(e.currentTarget).find('input[name="detail_jabatan"]').val(jabatan);

        $(e.currentTarget).find('input[name="detail_nama"]').attr('placeholder', nama);
        $(e.currentTarget).find('input[name="detail_inisial"]').attr('placeholder', inisial);
        $(e.currentTarget).find('input[name="detail_email"]').attr('placeholder', email);
        $(e.currentTarget).find('input[name="detail_telepon"]').attr('placeholder', telepon);
        $(e.currentTarget).find('input[name="detail_jabatan"]').attr('placeholder', jabatan);

    });

    //triggered when modal is about to be shown
    $('#modal-default').on('show.bs.modal', function(e) {

        //get data-id attribute of the clicked element
        var id = $(e.relatedTarget).data('id');

        $(e.currentTarget).find('input[name="id"]').val(id);

    });



    $(document).ready(function() {

        $('.select2-klien').select2();
        $('.select2-kategori').select2();
        $('.select2-layanan').select2();

        setTimeout(function() {
        $(".alert").alert('close');
        }, 3000);
    });

    $("#kategori").on('click', function(){
            $.ajax({
                url: "transaksi/get-services/" + $(this).val(),
                method: 'GET',
                success: function(data) {
                    $('#layanan').html(data.html);
                }
            });
    });

    $("#kategori").on('change', function(){
            $.ajax({
                url: "transaksi/get-services/" + $(this).val(),
                method: 'GET',
                success: function(data) {
                    $('#layanan').html(data.html);
                }
            });
    });

@endsection
@endsection
