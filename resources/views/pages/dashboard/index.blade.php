@extends('layouts.app')
@section('title', 'Dashboard')
@section('custom-import-css')

@endsection
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					@if(app('request')->input('error'))
              	<div class="alert alert-warning alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert"
                                    aria-hidden="true">&times;</button>
                    <h5 class="mb-0">{{ app('request')->input('error') }}</h5>
                </div>
          		@endif
					</div><!-- /.col -->
					</div><!-- /.row -->
					</div><!-- /.container-fluid -->
				</div>
				<!-- /.content-header -->
				<!-- Main content -->
				
				<div class="content">
					<div class="container-fluid">
						<div class="row">
							<div class="col-lg-3 col-6">
								<div class="small-box bg-info">
									<div class="inner">
										<h3>{{ $total['client'] }}</h3>
										<p>Klien</p>
									</div>
									<div class="icon">
										<i class="fas fa-handshake"></i>
									</div>
									<div class="small-box-footer">
										<a href="{{ route('clients.index') }}" class="small-box-footer text-white">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
									</div>
									
								</div>
							</div>
							<div class="col-lg-3 col-6">
								<div class="small-box bg-success">
									<div class="inner">
										<h3>{{ $total['active_client'] }}</h3>
										<p>Klien Aktif</p>
									</div>
									<div class="icon">
										<i class="fas fa-hands-helping"></i>
									</div>
									<div class="small-box-footer">
										<a href="{{ route('clients.index') }}/?status=aktif" class="small-box-footer text-white">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
									</div>
								</div>
							</div>
							<div class="col-lg-3 col-6">
								<div class="small-box bg-warning">
									<div class="inner">
										<h3>{{ $total['service'] }}</h3>
										<p>Layanan</p>
									</div>
									<div class="icon">
										<i class="fas fa-cogs"></i>
									</div>
									<div class="small-box-footer">
										<a href="{{ route('services.index') }}" class="small-box-footer text-white">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
									</div>
								</div>
							</div>
							<div class="col-lg-3 col-6">
								<div class="small-box bg-danger">
									<div class="inner">
										<h3>{{ $total['invoice'] }}</h3>
										<p>Invoice</p>
									</div>
									<div class="icon">
										<i class="fas fa-receipt"></i>
									</div>
									
									<div class="small-box-footer">
										<a href="{{ route('invoices.index') }}" class="small-box-footer text-white">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-12">
								<div class="card">
									<div class="card-header border-0">
										<div class="d-flex justify-content-between">
											<h3 class="card-title">Penjualan Bulan Ini & Bulan lalu</h3>
											<!-- <a href="javascript:void(0);">View Report</a> -->
										</div>
									</div>
									<div class="card-body">
										<div class="d-flex">
											<p class="d-flex flex-column">
												<span class="text-bold text-lg">Rp. {{ formatPrice($currMonthTotal) }}</span>
												<span class="text-secondary text-sm">Bulan lalu: Rp. {{ formatPrice($lastMonthTotal) }}</span>
												<span>Total</span>
											</p>
											<p class="ml-auto d-flex flex-column text-right">
												@if($diff == 0)
													<span class="text-dark">
													<i class="fas fa-equals"></i> {{ $diff }}%
													</span>
													<span class="text-muted">Dibandingkan bulan lalu</span>
												@elseif($diff > 0)
													<span class="text-success">
														<i class="fas fa-arrow-up"></i> {{$diff}}%
													</span>
													<span class="text-muted">Dibandingkan bulan lalu</span>
												@else
												<span class="text-danger">
													<i class="fas fa-arrow-down"></i> {{$diff}}%
												</span>
												<span class="text-muted">Dibandingkan bulan lalu</span>
												@endif

											</p>
										</div>
										<div class="position-relative mb-4">
											<canvas id="sales-chart" height="200"></canvas>
										</div>
										<div class="d-flex flex-row justify-content-end">
											<span class="mr-2">
												<i class="fas fa-square text-primary"></i> Bulan ini
											</span>
											<span>
												<i class="fas fa-square text-gray"></i> Bulan lalu
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
												<div class="row">
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
								<div class="card">
									<div class="card-header font-weight-bold">Transaksi 7 Hari yang lalu</div>
									<div class="card-body">
										<div class="">
											<div class="timeline">
												@foreach($lastweek as $lw)
												<div class="time-label">
													<span class="bg-primary">&nbsp;{{ formatDate($lw->first()->tanggal_invoice, 'd M Y') }}&nbsp;</span>
												</div>
													@foreach($lw as $d)
														<div>
															<i class="fas fa-receipt bg-blue"></i>
															<div class="timeline-item">
																<!-- <span class="time"><i class="fas fa-clock"></i> 12:05</span> -->
																<!-- <h3 class="timeline-header"><a href="#">{{ $d->nomor_invoice }}</a> sent you an email</h3> -->
																<div class="timeline-body">
																	Transaksi layanan <b>{{ $d->service->nama }}</b> oleh <b>{{ $d->client->nama }}</b> senilai <b> Rp. {{ formatPrice(getTotal($d->total_harga)) }}</b>. Invoice dibuat oleh <b>{{ $d->_user->nama }}</b>
																</div>
																<!-- <div class="timeline-footer">
																	<a class="btn btn-primary btn-sm">Read more</a>
																	<a class="btn btn-danger btn-sm">Delete</a>
																</div> -->
															</div>
														</div>
													@endforeach
												@endforeach
												
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>					
						<!-- /.row -->
						</div><!-- /.container-fluid -->
					</div>
					<!-- /.content -->
				</div>
				<!-- /.content-wrapper -->

				@section('custom-import-js')
				<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
				@endsection
				@section('custom-js')
				var ticksStyle={fontColor:'#495057',fontStyle:'bold'}
				var mode='index';
				var intersect=true;



				var $visitorsChart = $('#sales-chart')
var visitorsChart = new Chart($visitorsChart, {
data: {
	labels: [
		@foreach($currMonthData as $cmd)
			{!! "'" . $cmd->nama . "'," !!}
		@endforeach
	],
	datasets: [{
		type: 'line',
		data: [
					@foreach($currMonthData as $cmd)
		    			{!! "'" . getTotal($cmd->invoice_count) . "'," !!}
		    		@endforeach
		    ],
		backgroundColor: 'transparent',
		borderColor: '#007bff',
		pointBorderColor: '#007bff',
		pointBackgroundColor: '#007bff',
		fill: false
	}, {
		type: 'line',
		data: [
				@foreach($lastMonthData as $lmd)
		    			{!! "'" . getTotal($lmd->invoice_count) . "'," !!}
		    	@endforeach
			],
		backgroundColor: 'tansparent',
		borderColor: '#ced4da',
		pointBorderColor: '#ced4da',
		pointBackgroundColor: '#ced4da',
		fill: false
	}]
},
options: {
	maintainAspectRatio: false,
	tooltips: {
		mode: mode,
		intersect: intersect
	},
	hover: {
		mode: mode,
		intersect: intersect
	},
	legend: {
		display: false
	},
	scales: {
		yAxes: [{
			gridLines: {
				display: true,
				lineWidth: '4px',
				color: 'rgba(0, 0, 0, .2)',
				zeroLineColor: 'transparent'
			},
			ticks: $.extend({
				beginAtZero: true,
				suggestedMax: 200
			}, ticksStyle)
		}],
		xAxes: [{
			display: true,
			gridLines: {
				display: false
			},
			ticks: ticksStyle
		}]
	}
}
})


				$(document).ready(function() {
				setTimeout(function() {
				$(".alert").alert('close');
				}, 3000);
				});
				@endsection
				@endsection