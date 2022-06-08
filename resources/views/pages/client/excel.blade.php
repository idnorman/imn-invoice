<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Data Klien PT. IMN</title>
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
					<th class="tg-baqh bold" align="center" valign="middle" colspan="6">PT. Instanet Media Nusantara</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="px-2 bold no-border arial" colspan="6">Daftar Klien {{ ($clientStatus == 'aktif') ? 'Aktif ' : (($clientStatus == 'semua' or $clientStatus == 'unknown') ? '' : 'Nonaktif ' ) }}PT. Instanet Media Nusantara</td>
				</tr>
				
				<tr>
					<th class="border bold ta-center va-middle">No</th>
					<th class="border va-middle">Nama</th>
					<th class="border va-middle">Alamat</th>
					<th class="border va-middle">Email</th>
					<th class="border va-middle">Telepon</th>
					<th class="border va-middle">Fax</th>
				</tr>
				
				@forelse($clients as $client)
				<tr>
					<td class="border ta-center va-middle">{{ $loop->iteration }}</td>
					<td class="border va-middle">{{ $client->nama }}</td>
					<td class="border va-middle">{{ $client->alamat }}</td>
					<td class="border va-middle">{{ $client->email }}</td>
					<td class="border va-middle">{{ $client->telepon }}</td>
					<td class="border va-middle" align="left">{{ $client->fax }}</td>
				</tr>
				@empty
				<tr>
					<td class="ta-center va-middle" colspan="6">Data Kosong</td>
				</tr>
				@endforelse
					
				
			</tbody>
		</table>
	</body>
</html>