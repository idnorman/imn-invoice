@extends('layouts.app')

@section('title', 'Data Transaksi')
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
                            <li class="breadcrumb-item"><a href="{{ url('') }}">Beranda</a></li>
                            <li class="breadcrumb-item active">Data Transaksi</li>
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
                                <form action="{{ route('transactions.index') }}" method="get">
                                    <div class="row">

                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="d-block">
                                                <label>Klien</label>
                                            </div>
                                            <div class="form-group">
                                                <select name="klien" id="klien" class="form-control">
                                                    <option {{ ($klien == 'null') ? 'selected' : '' }} value="">---</option>
                                                    @foreach($clients as $client)
                                                        <option {{ ($klien == $client->id) ? 'selected' : '' }} value="{{ $client->id }}">{{ $client->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <div class="d-block">
                                                <label>Layanan</label>
                                            </div>
                                            <div class="form-group">
                                                <select name="layanan" id="layanan" class="form-control">
                                                    <option {{ ($layanan == 'null') ? 'selected' : '' }} value="">---</option>
                                                    @foreach($services as $service)
                                                        <option {{ ($layanan == $service->id) ? 'selected' : '' }} value="{{ $service->id }}">{{ $service->nama }}</option>
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
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Klien</th>
                                            <th>Layanan &mdash; Harga/Bulan</th>
                                            <th>Periode Layanan</th>
                                            <th>Total Pembayaran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($invoices as $invoice)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $invoice->client->nama }}</td>
                                                <td>{{ $invoice->service->nama }} &mdash; {{ formatPrice($invoice->service->harga) }}</td>
                                                <td>{{ idnDate(formatDate($invoice->tanggal_mulai)) }} &mdash; {{ idnDate(formatDate($invoice->tanggal_selesai)) }}</td>

                                                <td>{{ formatPrice(getTotal($invoice->total_harga)) }}</td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Klien</th>
                                            <th>Layanan &mdash; Harga/Bulan</th>
                                            <th>Periode Layanan</th>
                                            <th>Total Pembayaran</th>
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

    $('document').ready(function(){
        $("#klien").on('change', function(){
            let klien = $(this).val();
            let layanan = $('#layanan').val();
            exportBtn.set(klien, layanan);
        });
        
        $("#layanan").on('change', function(){
            let klien = $('#klien').val();
            let layanan = $(this).val();
            exportBtn.set(klien, layanan);
        });

        let klien = $('#klien').val();
        let layanan = $('#layanan').val();

        $('#btn-pdf-export').attr('href','{{ route('transactions.pdf') }}' + '/?klien=' + klien + '&layanan=' + layanan );
        $('#btn-excel-export').attr('href', '{{ route('transactions.excel') }}' + '/?klien=' + klien + '&layanan=' + layanan );
    });

    const exportBtn = {
        set: function(klien, layanan){
            $('#btn-pdf-export').attr('href','{{ route('transactions.pdf') }}' + '/?klien=' + klien + '&layanan=' + layanan );
            $('#btn-excel-export').attr('href', '{{ route('transactions.excel') }}' + '/?klien=' + klien + '&layanan=' + layanan );
        }
    }

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

    $(document).ready(function() {
        setTimeout(function() {
        $(".alert").alert('close');
        }, 3000);
    });
@endsection
@endsection
