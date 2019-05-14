
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
		text-decoration: none;
		line-height: 20px;
	}

	.description-section h3 {
		text-align: center;
	}

	.description-section .date-section {
		/* float: left; */
	}

	.description-section .date-section tbody tr {
		text-align: left;
	}

	.consignee-section {
		border: 1px dashed black;
		line-height: 20px;
		padding: 5px 0px 5px 10px;
		width: 250px;
	}

	.table-section table {
		width: 100%;
		/* text-align: center; */
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
	.text-xs-center {
        text-align: center;
    }
	.sub-title{
        font-weight: bold !important;
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
		<div class="text-xs-center sub-title">
			LAPORAN PENJUALAN JASA
        </div>
		<div class="description-section">
			
			<div class="date-section">
				<table>
					<tbody>
						<tr>
                            <th>Tahun:</th>
							<td>{{ $year }}</td>
     
                        </tr>
                        <tr>
                            <th>Bulan:</th>
							<td>{{ $monthName }}</td>
                            
		
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<br>

		<div class="table-section">
			<table>
				<thead>
					<tr style="text-align:center;">
						<th>No</th>
						<th>Merk</th>
						<th>Tipe Motor</th>
						<th>Nama Service</th>
						<th>Jumlah Penjualan</th>
				
					</tr>
				</thead>
				<tbody>
                    


       
					@foreach ($report as $item)
					<tr>
						<td style="text-align:center;">{{ $no++ }}</td>
						<td>{{ $item->motorcycle_brand_name }}</td>
						<td style="text-align:left;">{{ $item->motorcycle_type_name }}</td>
                        <td style="text-align:left;">{{ $item->service_name }}</td>
                        <td style="text-align:right;">{{ $item->jumlah_jasa }}</td>
					</tr>
                    @endforeach
				</tbody>
            </table>
            
        </div>
        

		<div class="signature-section">
			<div>
                dicetak tanggal {{$date}}
			</div>
		</div>
	</div>
</body>
</html>