<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Daftar Layanan PT. Instanet Media Nusantara</title>
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
		</style>
		
	</head>
	<body>
		<table class="tg">
			<thead>
				<tr>
					<th class="tg-baqh" colspan="5">PT. Instanet Media Nusantara</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="px-2 bold no-border arial" colspan="5">Daftar Layanan {{ ($kategori != 'null') ? $kategori : ''}} PT. Instanet Media Nusantara</td>
				</tr>
				
				<tr>
					<th class="border bold ta-center va-middle" width="7%">No</th>
					<th class="border va-middle">Kategori</th>
					<th class="border va-middle">Layanan</th>
					<th class="border va-middle">Harga (per bulan)</th>
					<th class="border va-middle ta-center">Total transaksi</th>
				</tr>
				
				@forelse($services as $service)
				<tr>
					<td class="border ta-center va-middle">{{ $loop->iteration }}</td>
					<td class="border va-middle">{{ $service->service_category->nama }}</td>
					<td class="border va-middle">{{ $service->nama }}</td>
					<td class="border va-middle">Rp. {{ formatPrice($service->harga) }}</td>
					<td class="border va-middle ta-center">{{ $service->invoice_count }}</td>
				</tr>
				@empty
				<tr>
					<td class="border ta-center va-middle" colspan="5">Data Kosong</td>
				</tr>
				@endforelse
					
				
			</tbody>
		</table>
	</body>
</html>