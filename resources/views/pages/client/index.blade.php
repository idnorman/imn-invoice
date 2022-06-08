@extends('layouts.app')

@section('title', 'Data Klien')
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
                            <li class="breadcrumb-item"><a href="{{ url('klien') }}">Klien</a></li>
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
                                <button  data-toggle="modal" data-target="#modal-create" class="btn btn-primary">Tambah</button>
                            </div>
                            @endif
                            @if(auth()->user()->is_superadmin == 1)
                            <div class="card-header">
                                <div class="d-block">
                                    <label>Status Klien</label>
                                </div>
                                <div class="row">
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                        <form action="{{ route('clients.index') }}" method="get">
                                            <div class="input-group">
                                                <select name="status" id="client-status" class="form-control">
                                                    <option {{ ($clientStatus == 'semua') ? 'selected' : '' }} value="semua">Tampilkan Semua</option>
                                                    <option {{ ($clientStatus == 'aktif') ? 'selected' : '' }} value="aktif">Aktif</option>
                                                    <option {{ ($clientStatus == 'nonaktif') ? 'selected' : '' }} value="nonaktif">Non-aktif</option>
                                                    </select>
                                              <div class="input-group-append">
                                                <button class="btn btn-outline-primary" type="submit">Filter</button>
                                              </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col">
                                        <a class="btn btn-outline-warning" id="btn-pdf-export" href="" target="_blank">Cetak PDF</a>
                                        <a class="btn btn-outline-success" id="btn-excel-export" href="" target="_blank">Cetak Excel</a> 
                                    </div>
                                </div>
                            </div>
                            @endif
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Alamat</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($clients as $client)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $client->nama }}</td>
                                                <td>{{ $client->email }}</td>
                                                <td>{{ $client->alamat }}</td>

                                                <td>
                                                    <a href="" class="btn btn-sm btn-info"
                                                        data-toggle="modal"
                                                        data-target="#modal-detail" 
                                                        data-id="{{ $client->id }}"
                                                        data-nama="{{ $client->nama }}"
                                                        data-sapaan="{{ $client->sapaan }}"
                                                        data-alamat="{{ $client->alamat }}"
                                                        data-email="{{ $client->email }}"
                                                        data-telepon="{{ $client->telepon }}"
                                                        data-fax="{{ $client->fax }}"
                                                        >Detail
                                                    </a>
                                                    @if(auth()->user()->is_superadmin == 0)
                                                    <a href="" class="btn btn-sm btn-warning"
                                                        data-toggle="modal"
                                                        data-target="#modal-edit" 
                                                        data-id="{{ $client->id }}"
                                                        data-nama="{{ $client->nama }}"
                                                        data-sapaan="{{ $client->sapaan }}"
                                                        data-alamat="{{ $client->alamat }}"
                                                        data-email="{{ $client->email }}"
                                                        data-telepon="{{ $client->telepon }}"
                                                        data-fax="{{ $client->fax }}"
                                                        >Ubah
                                                    </a>
                                                    <a href="" class="btn btn-sm btn-danger" data-toggle="modal"
                                                        data-target="#modal-delete" data-id="{{ $client->id }}" data-name="{{ $client->name }}">Hapus</a>
                                                    @endif
                                                </td>

                                            </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Alamat</th>
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
                <h4 class="modal-detail-title">Detail Data Klien</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body modal-detail-body">
                <div class="form-group">
                    <label for="detail_nama">Klien</label>
                    <input type="text" name="detail_nama"
                    class="form-control" id="detail_nama"
                    value="" placeholder="" disabled>
                </div>
                <div class="form-group">
                    <label for="detail_sapaan">Penanggung Jawab
                        <span class="text-secondary" style="font-size: 12px">/Perorangan (sapaan/<i>salutation</i>, gelar)</span>
                    </label>
                    <input type="text" name="detail_sapaan"
                    class="form-control" id="detail_sapaan"
                    value="" placeholder="" disabled>
                </div>
                <div class="form-group">
                    <label for="detail_alamat">Alamat</label>
                    <input type="text" name="detail_alamat"
                    class="form-control" id="detail_alamat"
                    value="" placeholder="" disabled>
                </div>
                <div class="form-group">
                    <label for="detail_email">Email</label>
                    <input type="email" name="detail_email"
                    class="form-control" id="detail_email"
                    value="" placeholder="" disabled>
                </div>
                <div class="form-group">
                    <label for="detail_telepon">Telepon</label>
                    <input type="number" name="detail_telepon"
                    class="form-control" id="detail_telepon"
                    value="" placeholder="" disabled>
                </div>
                <div class="form-group">
                    <label for="detail_fax">Fax</label>
                    <input type="number" name="detail_fax"
                    class="form-control" id="detail_fax"
                    value="" placeholder="" disabled>
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->




@if(auth()->user()->is_superadmin == 0)
{{-- Create Modal --}}
<div class="modal fade" id="modal-create">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Klien</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('clients.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="_type" value="create">
                    <div class="form-group">
                        <label for="create_nama">Klien</label>
                        <input type="text" name="create_nama"
                        class="form-control @error('create_nama') is-invalid @enderror" id="create_nama"
                        value="{{ old('create_nama') }}" placeholder="PT. Abc Xyz">
                        @error('create_nama')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="create_sapaan">Penanggung Jawab</label>
                        <input type="text" name="create_sapaan"
                        class="form-control @error('create_sapaan') is-invalid @enderror" id="create_sapaan"
                        value="{{ old('create_sapaan') }}" placeholder="Kepala IT">
                        <span class="text-secondary" style="font-size: 12px">
                            Untuk perorangan, isi dengan sapaan <i>(salutation)</i> (misal: Bapak, YTH, dll)
                        </span>
                        @error('create_sapaan')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="create_alamat">Alamat</label>
                        <input type="text" name="create_alamat"
                        class="form-control @error('create_alamat') is-invalid @enderror" id="create_alamat"
                        value="{{ old('create_alamat') }}" placeholder="Jl. Soekarno-Hatta No. 02, Pekanbaru, Riau">
                        @error('create_alamat')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="create_email">Email</label>
                        <input type="email" name="create_email"
                        class="form-control @error('create_email') is-invalid @enderror" id="create_email"
                        value="{{ old('create_email') }}" placeholder="it@abc.xyz">
                        @error('create_email')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="create_telepon">Telepon</label>
                        <input type="number" name="create_telepon"
                        class="form-control @error('create_telepon') is-invalid @enderror" id="create_telepon"
                        value="{{ old('create_telepon') }}" placeholder="+628110000000">
                        @error('create_telepon')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="create_fax">Fax</label>
                        <input type="number" name="create_fax"
                        class="form-control @error('create_fax') is-invalid @enderror" id="create_fax"
                        value="{{ old('create_fax') }}" placeholder="(0761) 0000 00">
                        @error('create_fax')
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
                <h4 class="modal-title">Ubah Data Klien</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body modal-edit-body">
                <form action="{{ route('clients.update') }}" method="POST">
                    @csrf
                    @method('put')
                    <input type="hidden" name="_type" value="edit">
                    <input type="hidden" name="_edit_id" value="">
                    <div class="form-group">
                        <label for="edit_nama">Klien</label>
                        <input type="text" name="edit_nama"
                        class="form-control @error('edit_nama') is-invalid @enderror" id="edit_nama"
                        value="{{ old('edit_nama') }}" placeholder="Budi Utomo">
                        @error('edit_nama')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="edit_sapaan">Penanggung Jawab</label>
                        <input type="text" name="edit_sapaan"
                        class="form-control @error('edit_sapaan') is-invalid @enderror" id="edit_sapaan"
                        value="{{ old('edit_sapaan') }}" placeholder="Bapak">
                        <span class="text-secondary" style="font-size: 12px">
                            Untuk perorangan, isi dengan sapaan <i>(salutation)</i> (misal: Bapak, YTH, dll)
                        </span>
                        @error('edit_sapaan')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="edit_alamat">Alamat</label>
                        <input type="text" name="edit_alamat"
                        class="form-control @error('edit_alamat') is-invalid @enderror" id="edit_alamat"
                        value="{{ old('edit_alamat') }}" placeholder="Jl. Soekarno-Hatta No. 02, Pekanbaru, Riau">
                        @error('edit_alamat')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="edit_email">Email</label>
                        <input type="email" name="edit_email"
                        class="form-control @error('edit_email') is-invalid @enderror" id="edit_email"
                        value="{{ old('edit_email') }}" placeholder="budi@utomo.com">
                        @error('edit_email')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="edit_telepon">Telepon</label>
                        <input type="number" name="edit_telepon"
                        class="form-control @error('edit_telepon') is-invalid @enderror" id="edit_telepon"
                        value="{{ old('edit_telepon') }}" placeholder="+628110000000">
                        @error('edit_telepon')
                        <span class="invalid-feedback" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="edit_fax">Fax</label>
                        <input type="number" name="edit_fax"
                        class="form-control @error('edit_fax') is-invalid @enderror" id="edit_fax"
                        value="{{ old('edit_fax') }}" placeholder="(0761) 0000 00">
                        @error('edit_fax')
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
                    <h4 class="modal-title">Hapus Data Klien</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body modal-delete">
                    <p>Apakah anda yakin untuk mengapus data ini?</p>
                </div>
                <div class="modal-footer modal-delete justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <form action="{{ route('clients.delete') }}" method="POST">
                        @csrf
                        @method('delete')
                        <input type="hidden" name="_delete_id" value="" id="id">
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
    $('document').ready(function(){
        $("#client-status").on('change', function(){
            let status = $(this).val();
            exportBtn.set(status);
        });
        let status = $('#client-status').val();
        $('#btn-pdf-export').attr('href','{{ route('clients.pdf') }}' + '/?status=' + status);
        $('#btn-excel-export').attr('href', '{{ route('clients.excel') }}' + '/?status=' + status);
    });

    const exportBtn = {
        set: function(val){
            $('#btn-pdf-export').attr('href','{{ route('clients.pdf') }}' + '/?status=' + val);
            $('#btn-excel-export').attr('href', '{{ route('clients.excel') }}' + '/?status=' + val);
        }
    }
    @endif
    
    @if(auth()->user()->is_superadmin == 0)
        @if($errors->any())
            @if(old('_type') == 'create')
                $(window).on('load', function() {
                    $('#modal-create').modal('show');
                    $('#create_nama').attr('value', '{{ old('create_nama') }}');
                    $('#create_sapaan').attr('value', '{{ old('create_sapaan') }}');
                    $('#create_alamat').attr('value', '{{ old('create_alamat') }}');
                    $('#create_email').attr('value', '{{ old('create_email') }}');
                    $('#create_telepon').attr('value', '{{ old('create_telepon') }}');
                    $('#create_fax').attr('value', '{{ old('create_fax') }}');
                });
            @endif
            @if(old('_type') == 'edit')
                $(window).on('load', function() {
                    $('#modal-edit').modal('show');
                    $('#edit_nama').attr('value', '{{ old('edit_nama') }}');
                    $('#edit_sapaan').attr('value', '{{ old('edit_sapaan') }}');
                    $('#edit_alamat').attr('value', '{{ old('edit_alamat') }}');
                    $('#edit_email').attr('value', '{{ old('edit_email') }}');
                    $('#edit_telepon').attr('value', '{{ old('edit_telepon') }}');
                    $('#edit_fax').attr('value', '{{ old('edit_fax') }}');
                });
            @endif
        @endif
    @endif
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
        "search": "Cari: "
    },

    });
    });


    //triggered when modal is about to be shown
    $('#modal-detail').on('show.bs.modal', function(e) {

        //get data-id attribute of the clicked element
        var id      = $(e.relatedTarget).data('id');
        var nama    = $(e.relatedTarget).data('nama');
        var sapaan = $(e.relatedTarget).data('sapaan');
        var alamat  = $(e.relatedTarget).data('alamat');
        var email   = $(e.relatedTarget).data('email');
        var telepon = $(e.relatedTarget).data('telepon');
        var fax     = $(e.relatedTarget).data('fax');

        //populate the textbox
        $('#detail_nama').attr('placeholder', nama);
        $('#detail_nama').attr('value', nama);
        $('#detail_sapaan').attr('placeholder', sapaan);
        $('#detail_sapaan').attr('value', sapaan);
        $('#detail_alamat').attr('placeholder', alamat);
        $('#detail_alamat').attr('value', alamat);
        $('#detail_email').attr('placeholder', email);
        $('#detail_email').attr('value', email);
        $('#detail_telepon').attr('placeholder', telepon);
        $('#detail_telepon').attr('value', telepon);
        $('#detail_fax').attr('placeholder', fax);
        $('#detail_fax').attr('value', fax);

    });



    @if(auth()->user()->is_superadmin == 0)
    //triggered when modal is about to be shown
    $('#modal-edit').on('show.bs.modal', function(e) {

        //get data-id attribute of the clicked element
        var id      = $(e.relatedTarget).data('id');
        var nama    = $(e.relatedTarget).data('nama');
        var sapaan = $(e.relatedTarget).data('sapaan');
        var alamat  = $(e.relatedTarget).data('alamat');
        var email   = $(e.relatedTarget).data('email');
        var telepon = $(e.relatedTarget).data('telepon');
        var fax     = $(e.relatedTarget).data('fax');

        //populate the textbox
        $(e.currentTarget).find('input[name="_edit_id"]').val(id);
        $('#edit_nama').attr('placeholder', nama);
        $('#edit_nama').attr('value', nama);
        $('#edit_sapaan').attr('placeholder', sapaan);
        $('#edit_sapaan').attr('value', sapaan);
        $('#edit_alamat').attr('placeholder', alamat);
        $('#edit_alamat').attr('value', alamat);
        $('#edit_email').attr('placeholder', email);
        $('#edit_email').attr('value', email);
        $('#edit_telepon').attr('placeholder', telepon);
        $('#edit_telepon').attr('value', telepon);
        $('#edit_fax').attr('placeholder', fax);
        $('#edit_fax').attr('value', fax);

    });

    //triggered when modal is about to be shown
    $('#modal-delete').on('show.bs.modal', function(e) {

        //get data-id attribute of the clicked element
        var id = $(e.relatedTarget).data('id');
        var name = 'Hapus ' + $(e.relatedTarget).data('name');

        $(e.currentTarget).find('input[name="_delete_id"]').val(id);

    });
    @endif
    $(document).ready(function() {
        setTimeout(function() {
        $(".alert").alert('close');
        }, 3000);
    });
@endsection
@endsection
