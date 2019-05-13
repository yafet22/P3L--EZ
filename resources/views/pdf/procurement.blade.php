<!DOCTYPE html>
<html>
<head>
	<title>Struk Pengadaan Sparepart</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
	<style>
	.container {
		width: 600px;
		margin: 0 auto;
		padding: 5px 10px;
	}

	.header-section .image {
		float: left;
		height: 125px;
	}

	.header-section .title {
		text-align: center;
		line-height: 20px;
	}

	.description-section h3 {
		text-align: center;
	}

	.description-section .date-section {
		float: right;
	}

	.description-section .date-section tbody tr {
		text-align: left;
	}

	.description-section .consignee-section {
		border: 1px dashed black;
		line-height: 20px;
		padding: 5px 0px 5px 10px;
		width: 250px;
	}

	.table-section table {
		width: 100%;
		text-align: left;
		border: 1px solid black;
		border-collapse: collapse;
	}

	.table-section table thead tr th {
		border: 1px solid black;
	}

	.table-section table tbody tr td {
		border: 1px solid black;
	}

	.signature-section {
		float: right;
		margin-top: 10px;
		line-height: 100px;
	}
	</style>
</head>
<body>
	<div class="container">
		<div class="header-section">
			<div class="image">
				<img src="https://s3.us-east-2.amazonaws.com/pilatix-api-clubs/AtmaAutoLogo.png" alt="">
			</div>
			<div class="title">
				<div><h1>ATMA AUTO</h1></div>
				<div>MOTORCYCLE SPAREPARTS AND SERVICES</div>
				<div>
					Jl. Babarsari No.43 Yogyakarta 552181 <br>
					Telp. (0274) 487711 <br>
					http://www.atmaauto.com
				</div>
			</div>
		</div>

		<hr>

		<div class="description-section">
			<h3>SURAT PEMESANAN</h3>
			<div class="date-section">
				<table>
					<tbody>
						<tr>
							<th>No:</th>
							<td></td>
						</tr>
						<tr>
							<th>Tanggal:</th>
							<td>{{ $date }}</td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="consignee-section">
				Kepada Yth:
				<div>{{ $procurement->sales->suppliers->supplier_name }}</div>
				<div>{{ $procurement->sales->suppliers->supplier_address }}</div>
				<div>{{ $procurement->sales->suppliers->supplier_phone_number }}</div>
			</div>
		</div>

		<div class="table-section">
			<h4>Mohon disediakan barang - barang berikut:</h4>
			<table>
				<thead>
					<tr>
						<th>No</th>
						<th>Nama Barang</th>
						<th>Merk</th>
						<th>Tipe Barang</th>
						<th>Satuan</th>
						<th>Jumlah</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($procurement->procurementdetails as $item)
					<tr>
						<td>{{ $no++ }}</td>
						<td>{{ $item->spareparts->sparepart_name }}</td>
						<td>{{ $item->spareparts->merk }}</td>
						<td>{{ $item->spareparts->sparepart_types->sparepart_type_name }}</td>
						<td>{{ $item->spareparts->purchase_price }}</td>
						<td>{{ $item->amount }}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>

		<div class="signature-section">
			<div>
				Hormat Kami,
			</div>
			<div>
				(Philips Purnomo)
			</div>
		</div>
	</div>
</body>
</html>