@extends('layouts.app')

@section('title', 'Kategori')
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
                            <li class="breadcrumb-item"><a href="{{ url('/layanan') }}">Layanan</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('/layanan/kategori') }}">Kategori</a></li>
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

                            @if(auth()->user()->is_superadmin == 1)
                            <div class="card-header">
                                <a href="" class="btn btn-primary" data-toggle="modal" data-target="#modal-create">Tambah</a>
                            </div>
                            @endif
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="service-categories-table" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>

                                            @if(auth()->user()->is_superadmin == 1)
                                            <th>Aksi</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($serviceCategories as $serviceCategory)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                
                                                <td>{{ $serviceCategory->nama }}</td>

                                                @if(auth()->user()->is_superadmin == 1)
                                                <td>
                                                    <a href="" class="btn btn-sm btn-warning" data-toggle="modal"
                                                        data-target="#modal-edit" data-id="{{ $serviceCategory->id }}" data-nama="{{ $serviceCategory->nama }}">Ubah</a>
                                                    <a href="" class="btn btn-sm btn-danger" data-toggle="modal"
                                                        data-target="#modal-delete" data-id="{{ $serviceCategory->id }}" data-nama="{{ $serviceCategory->nama }}">Hapus</a>
                                                </td>
                                                @endif
                                            </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>

                                            @if(auth()->user()->is_superadmin == 1)
                                            <th>Aksi</th>
                                            @endif
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
@if(auth()->user()->is_superadmin == 1)
{{-- Create Modal --}}
<div class="modal fade" id="modal-create">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Kategori</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('service_categories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="create_nama">Nama Kategori</label>
                        <input type="text" name="create_nama"
                        class="form-control @error('create_nama') is-invalid @enderror" id="create_nama"
                        value="{{ old('create_nama') }}" placeholder="Hosting">
                        @error('create_nama')
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

{{-- Edit Modal --}}
<div class="modal fade" id="modal-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ubah Kategori</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('service_categories.update') }}" method="POST">
                        @csrf
                        @method('put')
                        <input type="hidden" name="_edit_id" value="">
                    <div class="form-group">
                        <label for="edit_nama">Nama Kategori</label>
                        <input type="text" name="edit_nama"
                        class="form-control @error('edit_nama') is-invalid @enderror" id="edit_nama"
                        value="{{ old('edit_nama') }}" placeholder="">
                        @error('edit_nama')
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


     {{-- Modal delete--}}
    <div class="modal fade" id="modal-delete">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title modal-delete-title">Hapus Kategori</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin untuk mengapus kategori ini?</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <form action="{{ route('service_categories.delete') }}" method="POST">
                        @csrf
                        @method('delete')
                        <input type="hidden" name="_id" value="" id="id">
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@endif

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
    @if(auth()->user()->is_superadmin == 1)
    @error('create_name')
        $(window).on('load', function() {
            $('#modal-create').modal('show');
        });
    @enderror

    @error('edit_name')
        $(window).on('load', function() {
            $('#modal-edit').modal('show');
        });
    @enderror
    @endif
    $(function () {
    $("#service-categories-table").DataTable({
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
    "columnDefs": [
    { "width": "5%", "targets": 0 }
  	],
    "buttons": [
        {
            extend: 'copyHtml5',
            exportOptions: {
                columns: [1,2]
            }
        },
        {
            extend: 'csvHtml5',
            exportOptions: {
                columns: [1,2]
            }
        },
        {
            extend: 'excelHtml5',
            exportOptions: {
                columns: [1,2]
            }
        },
        {
            extend: 'pdfHtml5',
            exportOptions: {
                columns: [1,2]
            }
        },
        {
            extend: 'print',
            exportOptions: {
                columns: [1,2]
            }
        },
        {
            extend: 'colvis'
        }
    ]
    }).buttons().container().appendTo('#service-categories-table_wrapper .col-md-6:eq(0)');
    
    });
    @if(auth()->user()->is_superadmin == 1)
    //triggered when modal is about to be shown
    $('#modal-delete').on('show.bs.modal', function(e) {

        //get data-id attribute of the clicked element
        var id = $(e.relatedTarget).data('id');
        //var nama = 'Hapus ' + $(e.relatedTarget).data('nama');

        //populate the textbox
        //$(e.currentTarget).find('.modal-delete-title').text(nama);
        $(e.currentTarget).find('input[name="_id"]').val(id);

    });

    //triggered when modal is about to be shown
    $('#modal-edit').on('show.bs.modal', function(e) {

        //get data-id attribute of the clicked element
        var id = $(e.relatedTarget).data('id');
        var nama = $(e.relatedTarget).data('nama');

        //populate the textbox
        //$(e.currentTarget).find('.modal-edit-title').text('Hapus ' + nama);
        $(e.currentTarget).find('input[name="_edit_id"]').val(id);
        $('#edit_nama').attr('placeholder', nama);
        $('#edit_nama').attr('value', nama);

    });

    $(document).ready(function() {
        setTimeout(function() {
        $(".alert").alert('close');
        }, 3000);
    });
    @endif
@endsection
@endsection
