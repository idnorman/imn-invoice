@extends('layouts.app')

@section('title', 'Data Invoice')
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
                            <li class="breadcrumb-item"><a href="{{ url('invoice') }}">Invoice</a></li>
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
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th width="7%">No</th>
                                            <th>Klien</th>
                                            <th>Layanan</th>
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
                                            <td>{{ $tagihan->transaction->client->nama }}</td>
                                            <td>{{ $tagihan->transaction->service->nama }}</td>
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
                                            <th>Klien</th>
                                            <th>Layanan</th>
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
                    <form action="{{ route('invoices.delete') }}" method="POST">
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
    "buttons": [
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
    ]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });

    //triggered when modal is about to be shown
    $('#modal-default').on('show.bs.modal', function(e) {

        //get data-id attribute of the clicked element
        var id = $(e.relatedTarget).data('id');
        //populate the textbox
        $(e.currentTarget).find('input[name="id"]').val(id);

    });

    $(document).ready(function() {
        setTimeout(function() {
        $(".alert").alert('close');
        }, 3000);
    });
@endsection
@endsection
