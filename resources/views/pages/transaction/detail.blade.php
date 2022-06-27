@extends('layouts.app')

@section('title', 'Data Transaksi')
@section('custom-import-css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
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
                            {{-- <div class="card-header">
                                <a href="" class="btn btn-primary" data-toggle="modal" data-target="#modal-create">Tambah</a>
                            </div> --}}
                            <!-- /.card-header -->
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                        <div class="card">
                                            <div class="card-header h5">Klien</div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <dl class="row">
                                                            <dt class="col-sm-3">Nama</dt>
                                                            <dd class="col-sm-9">: {{ $transaction->client->nama }}</dd>
                                                            <dt class="col-sm-3">Alamat</dt>
                                                            <dd class="col-sm-9">: {{ $transaction->client->alamat }}</dd>
                                                        </dl>
                                                    </div>
                                                    <div class="col-6">
                                                        <dl class="row">
                                                            <dt class="col-sm-3">Email</dt>
                                                            <dd class="col-sm-9">: {{ $transaction->client->email }}</dd>
                                                            <dt class="col-sm-3">Telepon</dt>
                                                            <dd class="col-sm-9">: {{ $transaction->client->telepon }}</dd>
                                                        </dl>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                        <div class="card">
                                            <div class="card-header h5">Layanan</div>
                                            <div class="card-body">
                                                <dl class="row">
                                                    <dt class="col-sm-5">Layanan</dt>
                                                    <dd class="col-sm-7">: {{ $transaction->service->nama }}</dd>
                                                    <dt class="col-sm-5">Harga/bulan</dt>
                                                    <dd class="col-sm-7">: Rp. {{ formatPrice($transaction->service->harga) }}</dd>
                                                </dl>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if(auth()->user()->is_superadmin == 0)
                                <div class="row">
                                    <div class="col">
                                        <div class="card">
                                            <div class="card-body">
                                                <a href="" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-create">Buat Tagihan</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th width="7%">No</th>
                                            <th>Tanggal Mulai &mdash; Selesai</th>
                                            <th>Pembayaran</th>
                                            @if(auth()->user()->is_superadmin == 0)
                                            <th>Aksi</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($tagihans as $tagihan)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ formatDate($tagihan->start_date, 'd-m-Y') }} &mdash; {{ formatDate($tagihan->end_date, 'd-m-Y') }}</td>
                                            <td>Rp. {{ formatPrice(getTotal($tagihan->total_harga))}} &mdash;
                                                <span class="
                                                    {{ ($tagihan->is_paid == 0) ? 'badge badge-secondary' : 'badge badge-success' }}
                                                ">
                                                    {{ ($tagihan->is_paid == 0) ? 'Belum dibayar' : 'Telah dibayar' }}
                                                </span>
                                            </td>
                                            @if(auth()->user()->is_superadmin == 0)
                                            <td>
                                                <a href="{{ route('transactions.paidOff', $tagihan->id) }}" class="btn btn-sm btn-success {{ $tagihan->is_paid == 1 ? 'disabled' : '' }}">Lunas</a>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown">
                                                        Unduh
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item small" target="_blank" href="{{ route('transactions.download', $tagihan->id) }}">Tagihan</a>
                                                        {{-- <a class="dropdown-item small" target="_blank" href="{{ route('transactions.preview', $tagihan->id) }}">Pratinjau Tagihan</a> --}}
                                                        {{-- <div class="dropdown-divider"></div> --}}
                                                        <a class="dropdown-item small" target="_blank" href="{{ route('transactions.downloadSign', $tagihan->id) }}">Tagihan (Tanda tangan)</a>
                                                        {{-- <a class="dropdown-item small" target="_blank" href="{{ route('transactions.previewSign', $tagihan->id) }}">Pratinjau Tagihan (Tanda tangan)</a> --}}
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item small" target="_blank" href="{{ route('transactions.downloadProof', $tagihan->id) }}">Invoice Lunas</a>
                                                        <a class="dropdown-item small" target="_blank" href="{{ route('transactions.downloadProofSign', $tagihan->id) }}">Invoice Lunas (Tanda tangan)</a>
                                                        {{-- <a class="dropdown-item small" target="_blank" href="{{ route('transactions.previewProof', $tagihan->id) }}">Pratinjau Inv. Lunas</a> --}}
                                                    </div>
                                                </div>

                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-warning dropdown-toggle" data-toggle="dropdown">
                                                        Kirim
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item small {{ $tagihan->is_paid == 1 ? 'disabled' : '' }} {{ $tagihan->is_sent == 1 ? 'disabled' : '' }}" href="{{ route('transactions.sendInvoice', $tagihan->id) }}">Tagihan</a>
                                                        <a class="dropdown-item small" href="{{ route('transactions.sendProof', $tagihan->id) }}">Bukti Lunas</a>
                                                    </div>
                                                </div>
                                            </td>
                                            @endif
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal Mulai &mdash; Selesai</th>
                                            <th>Pembayaran</th>
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

{{-- Send Email Modal --}}
<div class="modal fade" id="modal-create">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail Invoice</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- form start -->
                <form action="{{ route('transactions.create-invoice') }}" method="POST">
                    @csrf
                    <input type="hidden" name="transaction_id" value="{{ $transaction->id }}">
                    <div class="form-group">
                        <label for="reff">Nomor Invoice</label>
                        <div class="input-group">
                            <input type="text" id="reff" name="reff" class="form-control" placeholder="001">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Masa Aktif Layanan</label>
                        <div class="input-group mb-3">
                            <input type="number" name="masa_aktif" id="periode" class="form-control minOne" value="1" min="1">
                            <div class="input-group-append">
                                <label class="input-group-text" id="periodeText" for="inputGroupPeriod">Bulan</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Mulai Aktif Layanan</label>
                        <div class="input-group date" id="tanggalMulai"
                            data-target-input="nearest">
                            <div class="input-group-prepend"
                                data-target="#tanggalMulai"
                                data-toggle="datetimepicker">
                                <div class="input-group-text"><i
                                class="fa fa-calendar"></i></div>
                            </div>
                            <input type="text" id="tanggalMulaiInput" name="tanggal_mulai"
                            class="form-control datetimepicker-input"
                            data-target="#tanggalMulai"
                            data-toggle="datetimepicker"
                            autocomplete="off"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Berakhir</label>
                        <div class="input-group" id="tanggalSelesai"
                            data-target-input="nearest">
                            <div class="input-group-prepend"
                                data-target="#tanggalSelesai">
                                <div class="input-group-text"><i
                                class="fa fa-calendar"></i></div>
                            </div>
                            <input type="text" id="tanggalSelesaiInput"  name="tanggal_selesai"
                            class="form-control disabled-date"
                            data-target="#tanggalSelesai"
                            autocomplete="off" readonly/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="totalHarga">Total Harga</label>
                        <div class="input-group">
                            <div class="input-group-prepend"
                                data-target="#totalHarga">
                                <div class="input-group-text">Rp.</div>
                            </div>
                            <input type="number" id="totalHarga" name="total_harga" class="form-control @error('total_harga') is-invalid @enderror" value="{{ old('total_harga') }}" placeholder="123.456"/>
                            @error('total_harga')
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
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
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


    //triggered when modal is about to be shown
    $('#modal-default').on('show.bs.modal', function(e) {

        //get data-id attribute of the clicked element
        var id = $(e.relatedTarget).data('id');

        $(e.currentTarget).find('input[name="id"]').val(id);

    });



    $(document).ready(function() {
        tanggalMulai.init();
        tanggalSelesai.set();
        totalHarga.set();
        setTimeout(function() {
        $(".alert").alert('close');
        }, 3000);
    });


    const tanggalMulai = {
        init: function(){
            $('#tanggalMulai').datetimepicker({
                format: 'DD-MM-YYYY',
                @if(old('tanggal_mulai'))
                    date: new Date('{{ formatDate(old('tanggal_mulai'), 'm/d/Y') }}')
                @elseif($endDate)
                    date: new Date('{{ formatDate($endDate, 'm/d/Y') }}')
                @else
                    date: new Date()
                @endif
            });
        },
        get: function(format){
            return moment($('#tanggalMulaiInput').val(), 'DD-MM-YYYY').format('MM/DD/YYYY');
        }
    }

    const tanggalSelesai = {
        set: function(){
            let periode = $('#periode').val();
            let tglMulai = tanggalMulai.get();
            let tglSelesai = moment(tglMulai, 'MM/DD/YYYY').add(periode, 'months').subtract(1, 'days').format('DD-MM-YYYY');
            $('#tanggalSelesaiInput').val(tglSelesai);
        },
        get: function(format){
            return moment($('#tanggalSelesaiInput').val(), 'DD-MM-YYYY').format('MM/DD/YYYY');
        }
    }

    $('#tanggalMulai').on('change.datetimepicker', function(){
        tanggalSelesai.set();
    });

    $('#periode').on('change', function(){
        tanggalSelesai.set();
        totalHarga.set();
    });

    const totalHarga = {
        set: function(){
            let price = '{{$transaction->service->harga}}';
            let periode = $('#periode').val();
            let temp = Number(periode) * Number(price);
            $('#totalHarga').val(temp);
        }
    }


@endsection
@endsection
