@extends('layouts.app')

@section('title', 'Edit Invoice')
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
                        <li class="breadcrumb-item active">Edit Invoice</li>
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
                                        <h4 class="m-0">Edit Invoice</h4>
                                    </div>
                                    <div class="card-body">
                                        <!-- form start -->
                                        <form action="{{ route('invoices.update') }}" method="POST">
                                            @csrf
                                            @method('put')
                                            <input type="hidden" name="id" value="{{ $invoice->id }}">
                                            <div class="form-group">
                                                <label>Tanggal Invoice</label>
                                                <div class="input-group date" id="tanggalInvoice"
                                                    data-target-input="nearest">
                                                    <div class="input-group-prepend"
                                                        data-target="#tanggalInvoice"
                                                        data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i
                                                        class="fa fa-calendar"></i></div>
                                                    </div>
                                                    <input type="text" id="tanggalInvoiceInput" name="tanggal_invoice"
                                                    class="form-control datetimepicker-input"
                                                    data-target="#tanggalInvoice"
                                                    data-toggle="datetimepicker"
                                                    autocomplete="off"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="nomorInvoice">Nomor Invoice</label>
                                                <input type="text" id="nomorInvoice" name="nomor_invoice" class="form-control @error('nomor_invoice') is-invalid @enderror" placeholder="John Doe" />
                                                @error('nomor_invoice')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label>Klien</label>
                                                <select name="klien" class="form-control select2 select2-klien select2-primary @error('klien') is-invalid  @enderror" data-dropdown-css-class="select2-primary" style="width: 100%;">
                                                    <option selected="selected" disabled>Pilih Klien</option>
                                                    @foreach ($clients as $client)
                                                    <option value="{{ $client->id }}" {{ ($client->id == $invoice->client->id) ? "selected" : "" }}>{{ $client->nama }} &mdash; {{ $client->alamat }}</option>
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
                                                    <option value="{{ $serviceCategory->id }}" {{ old('kategori') ? ((old('kategori') == $serviceCategory->id) ? 'selected' : '' ) : (($serviceCategory->id == $invoice->service->service_category->id) ? 'selected' : '') }}>{{ $serviceCategory->nama }}</option>
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
                                                    @foreach ($services as $service)
                                                    <option value="{{ $service->id }}" data-harga="{{$service->harga}}" {{ old('layanan') ? ((old('layanan') == $service->id) ? 'selected' : '' ) : (($service->id == $invoice->service->id) ? 'selected' : '') }}>{{ $service->nama }}</option>
                                                    @endforeach
                                                </select>
                                                @error('layanan')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label>Masa Aktif Layanan</label>
                                                <div class="input-group mb-3">
                                                    
                                                    <input type="number" name="masa_aktif" id="periode" class="form-control minOne" value="{{ old('masa_aktif') ? old('masa_aktif') : $invoice->masa_aktif }}" min="1">
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
                                                <label>Tanggal Jatuh Tempo</label>
                                                <div class="input-group date" id="jatuhTempo"
                                                    data-target-input="nearest">
                                                    <div class="input-group-prepend"
                                                        data-target="#jatuhTempo"
                                                        data-toggle="datetimepicker">
                                                        <div class="input-group-text"><i
                                                        class="fa fa-calendar"></i></div>
                                                    </div>
                                                    <input type="text" id="jatuhTempoInput"  name="jatuh_tempo"
                                                    class="form-control datetimepicker-input"
                                                    data-target="#jatuhTempo"
                                                    data-toggle="datetimepicker"
                                                    autocomplete="off"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="totalHarga">Total Harga</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend"
                                                        data-target="#totalHarga">
                                                        <div class="input-group-text">Rp.</div>
                                                    </div>
                                                    <input type="number" id="totalHarga" name="total_harga" class="form-control @error('total_harga') is-invalid @enderror" value="{{ old('total_harga') ? old('total_harga') : $invoice->total_harga }}" placeholder="123.456"/>
                                                    @error('total_harga')
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
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
        tanggalInvoice.init();
        nomorInvoice.init();
        tanggalMulai.init();
        tanggalSelesai.set();
        jatuhTempo.init();


        $('.select2-klien').select2();
        $('.select2-kategori').select2();
        $('.select2-layanan').select2();

        @if($errors->any())
                $.ajax({
                    url: "get-services-error/" + {{old('kategori')}},
                    method: 'GET',
                    success: function(data) {
                        $('#layanan').html(data.html);
                    }
                });
                $("#layanan").select2().select2('val',{{old('layanan')}});
        @endif

    });

    $('#tanggalInvoice').on('input',function(){
        nomorInvoice.set(tanggalInvoice.get());         
    });

    const tanggalInvoice = {
        init: function(){
            $('#tanggalInvoice').datetimepicker({
                format: 'DD-MM-YYYY',
                @if(old('tanggal_invoice'))
                    date: new Date('{{ formatDate(old('tanggal_invoice'), 'm/d/Y') }}')
                @else
                    date: new Date('{{ formatDate($invoice->tanggal_invoice, 'm/d/Y') }}')
                @endif
            });
        },
        get: function(format){
            return moment($('#tanggalInvoiceInput').val(), 'DD-MM-YYYY').format('MM/DD/YYYY');
        }
    }

    const nomorInvoice = {
        init: function(){
            // let month = toRoman(new Date().getMonth()+1);
            // let year  = new Date().getFullYear();
            // let user  = '{{ auth()->user()->inisial }}';
            // let type  = 'INV-IMN';
            // let text  = 'XX/INV-IMN/'+user+'/'+month+'/'+year;
            let text = '{{ (old('nomor_invoice')) ? old('nomor_invoice') : $invoice->nomor_invoice }}'

            $('#nomorInvoice').val(text);
        },
        set: function(date){
            let d     = new Date(date);
            let month = toRoman(d.getMonth()+1);
            let year  = d.getFullYear();
            let user  = '{{ auth()->user()->inisial }}';
            let type  = 'INV-IMN';
            @php
                $arr = explode('/', $invoice->nomor_invoice);
            @endphp

            @if(old('nomor_invoice'))
                @php
                    $arr = explode('/', old('nomor_invoice'));
                @endphp
            @endif

            let reff = {{ $arr[0] }};
            let text  = reff+'/INV-IMN/'+user+'/'+month+'/'+year;
            $('#nomorInvoice').val(text);
        }
    }

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

    const tanggalMulai = {
        init: function(){
            $('#tanggalMulai').datetimepicker({
                format: 'DD-MM-YYYY',
                @if(old('tanggal_mulai'))
                    date: new Date('{{ formatDate(old('tanggal_mulai'), 'm/d/Y') }}')
                @else
                    date: new Date('{{ formatDate($invoice->tanggal_mulai, 'm/d/Y') }}')
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

    const jatuhTempo = {
        init: function(){
            let tglMulai = tanggalMulai.get();
            let tglJatuhTempo = moment(tglMulai, 'MM/DD/YYYY').add(10, 'days').format('YYYY-MM-DD');
            $('#jatuhTempo').datetimepicker({
                format: 'DD-MM-YYYY',
                @if(old('jatuh_tempo'))
                    date: new Date('{{ formatDate(old('jatuh_tempo'), 'm/d/Y') }}')
                @else
                    date: new Date('{{ formatDate($invoice->jatuh_tempo, 'm/d/Y') }}')
                @endif
            });
        },
        set: function(){
            let tglMulai = tanggalMulai.get();
            let tglJatuhTempo = moment(tglMulai, 'MM/DD/YYYY').add(10, 'days').format('DD-MM-YYYY');
            $('#jatuhTempoInput').val(tglJatuhTempo);
        }
    }

    $('#tanggalMulai').on('change.datetimepicker', function(){
        tanggalSelesai.set();
        jatuhTempo.set();
    });

    $('#periode').on('change', function(){
        tanggalSelesai.set();
        totalHarga.set();
    });

    //Harga

    const totalHarga = {
        set: function(){
            let price = $(".select2-layanan").find(":selected").data("harga");
            let periode = $('#periode').val();
            let temp = Number(periode) * Number(price);
            $('#totalHarga').val(temp);
        }
    }

    $(".select2-layanan").on("select2:select", function(e){
        totalHarga.set();
    });

    function toRoman(num){
        if(num < 1){ return "";}
        if(num >= 10){ return "X" + toRoman(num - 10);}
        if(num >= 9){ return "IX" + toRoman(num - 9);}
        if(num >= 5){ return "V" + toRoman(num - 5);}
        if(num >= 4){ return "IV" + toRoman(num - 4);}
        if(num >= 1){ return "I" + toRoman(num - 1);} 
    }

@endsection
@endsection
