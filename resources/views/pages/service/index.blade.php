@extends('layouts.app')

@section('title', 'Layanan')
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
                            <li class="breadcrumb-item"><a href="{{ url('layanan') }}">Layanan</a></li>
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
                            <div class="card-header">
                                
                                <form action="{{ route('services.index') }}" method="get">
                                    <div class="row">

                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="d-block">
                                                <label>Kategori</label>
                                            </div>
                                            <div class="form-group">
                                                <select name="kategori" id="kategori" class="form-control">
                                                    <option {{ ($kategori == null) ? 'selected' : '' }} value="">---</option>
                                                    @foreach($serviceCategories as $serviceCategory)
                                                        <option {{ ($kategori == $serviceCategory->id) ? 'selected' : '' }} value="{{ $serviceCategory->id }}">{{ $serviceCategory->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="d-block">
                                                <label>&nbsp;</label>
                                            </div>
                                            <button class="btn btn-outline-primary" type="submit">Filter</button>
                                            <a class="btn btn-outline-warning" id="btn-pdf-export" href="" target="_blank">Cetak PDF</a>
                                            <a class="btn btn-outline-success" id="btn-excel-export" href="" target="_blank">Cetak Excel</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="service-categories-table" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kategori</th>
                                            <th>Nama</th>
                                            <th>Harga(per bulan)</th>
                                            @if(auth()->user()->is_superadmin == 1)
                                            <th>Total Transaksi</th>
                                            @endif
                                            @if(auth()->user()->is_superadmin == 0)
                                            <th>Aksi</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($services as $service)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $service->service_category->nama }}</td>
                                                <td>{{ $service->nama }}</td>
                                                <td>Rp. {{ formatPrice($service->harga) }}</td>
                                                @if(auth()->user()->is_superadmin == 1)
                                                <td>{{ $service->invoice_count }}</td>
                                                @endif
                                                @if(auth()->user()->is_superadmin == 0)
                                                <td>
                                                    <a href="" class="btn btn-sm btn-warning" data-toggle="modal"
                                                        data-target="#modal-edit" data-id="{{ $service->id }}" data-nama="{{ $service->nama }}" data-harga="{{ $service->harga }}" data-kategori="{{ $service->kategori }}">Ubah</a>
                                                    <a href="" class="btn btn-sm btn-danger" data-toggle="modal"
                                                        data-target="#modal-delete" data-id="{{ $service->id }}" data-nama="{{ $service->nama }}">Hapus</a>
                                                </td>
                                                @endif
                                            </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Kategori</th>
                                            <th>Nama</th>
                                            <th>Harga(per bulan)</th>
                                            @if(auth()->user()->is_superadmin == 1)
                                            <th>Total Transaksi</th>
                                            @endif
                                            @if(auth()->user()->is_superadmin == 0)
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
                    <h4 class="modal-title">Tambah Layanan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('services.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="_type" value="create">
                        <div class="form-group">
                            <label for="create_nama">Nama Layanan</label>
                            <input type="text" name="create_nama"
                            class="form-control @error('create_nama') is-invalid @enderror" id="create_nama"
                            value="{{ old('create_nama') }}" placeholder="Hosting SG 2GB">
                            @error('create_nama')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Kategori Layanan</label>
                            <select name="create_kategori" class="form-control select2 select2-create-kategori  select2-primary @error('create_kategori') is-invalid  @enderror" id="create_kategori" data-dropdown-css-class="select2-primary" style="width: 100%;">
                                <option selected="selected" disabled>Pilih Kategori Layanan</option>
                                @foreach ($serviceCategories as $serviceCategory)
                                <option value="{{ $serviceCategory->id }}">{{ $serviceCategory->nama }}</option>
                                @endforeach
                            </select>
                            @error('create_kategori')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="create_harga">Harga (per bulan)</label>
                            <div class="input-group">
                                <div class="input-group-prepend"
                                                        data-target="#totalHarga">
                                                        <div class="input-group-text">Rp.</div>
                                                    </div>
                                <input type="number" name="create_harga"
                                class="form-control @error('create_harga') is-invalid @enderror" id="create_harga"
                                value="{{ old('create_harga') }}" placeholder="120000">
                                @error('create_harga')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
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
                    <h4 class="modal-title">Ubah Layanan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('services.update') }}" method="POST">
                        @csrf
                        @method('put')
                        <input type="hidden" name="_edit_id" value="">
                        <input type="hidden" name="_type" value="edit">
                        <div class="form-group">
                            <label for="edit_nama">Nama Layanan</label>
                            <input type="text" name="edit_nama"
                            class="form-control @error('edit_nama') is-invalid @enderror" id="edit_nama"
                            value="{{ old('edit_nama') }}" placeholder="Cth: Hosting Small">
                            @error('edit_nama')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Kategori Layanan</label>
                            <select name="edit_kategori" class="form-control select2 select2-edit-kategori select2-primary @error('edit_kategori') is-invalid  @enderror" id="edit_kategori" data-dropdown-css-class="select2-primary" style="width: 100%;">
                                <option disabled>Pilih Kategori Layanan</option>
                                @foreach ($serviceCategories as $serviceCategory)
                                <option value="{{ $serviceCategory->id }}">{{ $serviceCategory->nama }}</option>
                                @endforeach
                            </select>
                            @error('edit_kategori')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="edit_harga">Harga (per bulan)</label>
                            <div class="input-group">
                                <div class="input-group-prepend"
                                                        data-target="#totalHarga">
                                                        <div class="input-group-text">Rp.</div>
                                                    </div>
                            
                            <input type="number" name="edit_harga"
                            class="form-control @error('edit_harga') is-invalid @enderror" id="edit_harga"
                            value="{{ old('edit_harga') }}" placeholder="">
                            
                            @error('edit_harga')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                            </div>
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


    {{-- Modal Delete--}}
    <div class="modal fade" id="modal-delete">
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
                    <form action="{{ route('services.delete') }}" method="POST">
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

    $('document').ready(function(){
        $("#kategori").on('change', function(){
            let kategori = $(this).val();
            exportBtn.set(kategori);
        });
        let kategori = $('#kategori').val();
        $('#btn-pdf-export').attr('href','{{ route('services.pdf') }}' + '/?kategori=' + kategori);
        $('#btn-excel-export').attr('href', '{{ route('services.excel') }}' + '/?kategori=' + kategori);
    });

    const exportBtn = {
        set: function(val){
            $('#btn-pdf-export').attr('href','{{ route('services.pdf') }}' + '/?kategori=' + val);
            $('#btn-excel-export').attr('href', '{{ route('services.excel') }}' + '/?kategori=' + val);
        }
    }

    @if(auth()->user()->is_superadmin == 1)
    $(function () {
        $('.select2-create-kategori').select2();
        $('.select2-edit-kategori').select2();
    });

    @if($errors->any())
        @if(old('_type') == 'create')
            $(window).on('load', function() {
                $('#modal-create').modal('show');
                $('#create_nama').attr('value', '{{ old('create_nama') }}');
                $("#create_kategori").val({{ old('create_kategori') }}).trigger('change');
                $('#create_harga').attr('value', {{ old('create_harga') }});
            });
        @endif
        @if(old('_type') == 'edit')
            $(window).on('load', function() {
                $('#modal-edit').modal('show');
                $('#edit_nama').attr('value', '{{ old('edit_nama') }}');
                $("#edit_kategori").val({{ old('edit_kategori') }}).trigger('change');
                $('#edit_harga').attr('value', {{ old('edit_harga') }});
            });
        @endif
    @endif
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
    { "width": "5%", "targets": 0 },
    { "width": "20%", "targets": 1 },
    { "width": "30%", "targets": 2 }
  	],
    {{-- "buttons": [
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
    ] --}}
    }).buttons().container().appendTo('#service-categories-table_wrapper .col-md-6:eq(0)');
    
    });
    @if(auth()->user()->is_superadmin == 1)
    //triggered when modal is about to be shown
    $('#modal-edit').on('show.bs.modal', function(e) {

        //get data-id attribute of the clicked element
        var id      = $(e.relatedTarget).data('id');
        var nama    = $(e.relatedTarget).data('nama');
        var harga   = $(e.relatedTarget).data('harga');
        var kategori  = $(e.relatedTarget).data('kategori');

        //populate the textbox
        $(e.currentTarget).find('input[name="_edit_id"]').val(id);
        $('#edit_nama').attr('placeholder', nama);
        $('#edit_nama').attr('value', nama);
        $('#edit_harga').attr('placeholder', harga);
        $('#edit_harga').attr('value', harga);
        $("#edit_kategori").val(kategori).trigger('change');

    });

    //triggered when modal is about to be shown
    $('#modal-delete').on('show.bs.modal', function(e) {

        //get data-id attribute of the clicked element
        var id = $(e.relatedTarget).data('id');
        //var name = 'Hapus ' + $(e.relatedTarget).data('name');

        //populate the textbox
        //$(e.currentTarget).find('.modal-title').text(name);
        $(e.currentTarget).find('input[name="_id"]').val(id);

    });

    $(document).ready(function() {
        setTimeout(function() {
        $(".alert").alert('close');
        }, 3000);
    });
    @endif
@endsection
@endsection
