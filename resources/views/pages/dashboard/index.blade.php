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
									<div class="small-box-footer"></div>
									<!-- <a href="#" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a> -->
								</div>
							</div>
							<div class="col-lg-3 col-6">
								<div class="small-box bg-success">
									<div class="inner">
										<h3>{{ $total['active_client'] }}</h3>
										<p>Klien Aktif</p>
									</div>
									<div class="icon">
										<i class="ion ion-stats-bars"></i>
									</div>
									<div class="small-box-footer"></div>
									<!-- <a href="#" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a> -->
								</div>
							</div>
							<div class="col-lg-3 col-6">
								<div class="small-box bg-warning">
									<div class="inner">
										<h3>{{ $total['service'] }}</h3>
										<p>Layanan</p>
									</div>
									<div class="icon">
										<i class="ion ion-person-add"></i>
									</div>
									<div class="small-box-footer"></div>
									<!-- <a href="#" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a> -->
								</div>
							</div>
							<div class="col-lg-3 col-6">
								<div class="small-box bg-danger">
									<div class="inner">
										<h3>{{ $total['invoice'] }}</h3>
										<p>Invoice</p>
									</div>
									<div class="icon">
										<i class="ion ion-pie-graph"></i>
									</div>
									
									<div class="small-box-footer"></div>
									<!-- <a href="#" class="small-box-footer">Selengkapnya <i class="fas fa-arrow-circle-right"></i></a> -->
								</div>
							</div>
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
				@endsection
				@section('custom-js')
				
				$(document).ready(function() {
				setTimeout(function() {
				$(".alert").alert('close');
				}, 3000);
				});
				@endsection
				@endsection