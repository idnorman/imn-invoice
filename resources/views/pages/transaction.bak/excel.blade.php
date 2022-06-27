<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Datatara</title>
		<style type="text/css">
		@page{
        	margin: 0.5in 0.7in 0in 0.7in;
      	}
		.tg {border-collapse:collapse;border-spacing:0; width: 100%;}
		.tg .border{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
		overflow:hidden;padding:10px 5px;word-break:normal;}
		.tg th{font-family:Arial, sans-serif;font-size:18px;
		font-weight:bold;overflow:hidden;padding:10px 5px;word-break:normal;}

		.bold{
			font-weight: bold;
		}
		.px-2{
			padding-top: 20px;
			padding-bottom: 20px;
		}

		.pb-2{
			padding-bottom: 20px;
		}
		.no-border{
			border: 0;
			border-width: 0;
			border-style: none;
		}
		.arial{
			font-family:Arial, sans-serif;
		}
		.ta-center{
			text-align: center;
		}
		.va-middle{
			vertical-align: middle;
		}

		.fs-16{
			font-size: 16px;
		}

		.fs-14{
			font-size: 14px;
		}
		</style>
		
	</head>
	<body>
		<table class="tg">
			<thead>
				<tr>
					<th class="tg-baqh fs-16 ta-center va-middle" colspan="5" align="center" valign="middle">PT. Instanet Media Nusantara</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="px-2 bold no-border arial fs-14" colspan="5">Daftar Transaksi PT. Instanet Media Nusantara</td>
				</tr>
				@if($klien != null)
				<tr>
					<td class="{{ ($layanan == null) ? 'pb-2' : '' }} bold no-border arial fs-14" colspan="5">Klien: {{ $klien }} </td>
				</tr>
				@endif
				@if($layanan != null)
				<tr>
					<td class="pb-2 bold no-border arial fs-14" colspan="5">Layanan : {{ $layanan }}</td>
				</tr>
				@endif
				<tr>
					<th class="border bold ta-center va-middle" width="3%" align="center">No</th>
					<th class="border va-middle">Klien</th>
					<th class="border va-middle" width="25%">Layanan &mdash; Harga/Bulan</th>
					<th class="border va-middle" width="25%">Periode Layanan</th>
					<th class="border va-middle">Total Pembayaran</th>
				</tr>
				
				@forelse($invoices as $invoice)
				<tr>
					<td class="border ta-center va-middle" align="center">{{ $loop->iteration }}</td>
					<td class="border va-middle">{{ $invoice->client->nama }}</td>
					<td class="border va-middle">{{ $invoice->service->nama }} &mdash; Rp. {{ formatPrice($invoice->service->harga) }}</td>
					<td class="border va-middle">{{ idnDate(formatDate($invoice->tanggal_mulai)) }} &mdash; {{ idnDate(formatDate($invoice->tanggal_selesai)) }}</td>
					<td class="border va-middle">Rp. {{ formatPrice(getTotal($invoice->total_harga)) }}</td>
				</tr>
				@empty
				<tr>
					<td class="border ta-center va-middle" colspan="5" align="center" valign="middle">Data Kosong</td>
				</tr>
				@endforelse
					
				
			</tbody>
		</table>
	</body>
</html>