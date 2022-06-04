@extends('layouts.app')

@section('title', 'Data Pengguna')
@section('custom-import-css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
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
                            <li class="breadcrumb-item"><a href="{{ url('pengguna') }}">Pengguna</a></li>
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
                            <div class="card-header">
                                <a href="{{ route('users.create') }}" class="btn btn-primary">Tambah</a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th width="7%">No</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $user->nama }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>
                                                    <a href="" class="btn btn-sm btn-info" data-toggle="modal"
                                                        data-target="#modal-detail" data-nama="{{ $user->nama }}" data-email="{{ $user->email }}" data-inisial="{{ $user->inisial }}" data-telepon="{{ $user->telepon }}" data-jabatan="{{ $user->jabatan }}">Detail</a>
                                                    <a href="{{ route('users.edit', $user->id) }}"
                                                        class="btn btn-sm btn-warning">Edit</a>
                                                    <a href="" class="btn btn-sm btn-danger" data-toggle="modal"
                                                        data-target="#modal-default" data-id="{{ $user->id }}">Hapus</a>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Email</th>
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

    {{-- Detail Modal --}}
    <div class="modal fade" id="modal-detail">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title modal-detail-title">Tambah Kategori</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="detail_nama">Nama</label>
                        <input type="text" name="detail_nama"
                        class="form-control" id="detail_nama"
                        value="" placeholder="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="detail_inisial">Inisial</label>
                        <input type="text" name="detail_inisial"
                        class="form-control" id="detail_inisial"
                        value="" placeholder="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="detail_email">Email</label>
                        <input type="text" name="detail_email"
                        class="form-control" id="detail_email"
                        value="" placeholder="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="detail_telepon">No. HP</label>
                        <input type="text" name="detail_telepon"
                        class="form-control" id="detail_telepon"
                        value="" placeholder="" disabled>
                    </div>
                    <div class="form-group">
                        <label for="detail_jabatan">Jabatan</label>
                        <input type="text" name="detail_jabatan"
                        class="form-control" id="detail_jabatan"
                        value="" placeholder="" disabled>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
    <!-- /.modal -->

    {{-- Modal --}}
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
                    <form action="{{ route('users.delete') }}" method="POST">
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
        setTimeout(function() {
        $(".alert").alert('close');
        }, 3000);
    });
@endsection
@endsection
