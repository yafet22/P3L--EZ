<!DOCTYPE html>
<html>
<head>
    <!-- <title>SP-TESTED-01</title> -->
    <title>{{ $transaction->id_transaction }}</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
	<style>
	.container {
		width: 600px;
		margin: 0 auto;
		padding: 5px 10px;
        /* font-size: 14px; */
	}

    .text-xs-center {
        text-align: center;
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

    .general-section {
        width: 100%;
    }

    .general-section .box {
        width: 100%;
        text-align: left;
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

    .sparepart-details {
        width: 100%;
        text-align: left;
    }

    .sparepart-details tbody tr {
        width: 100%;
    }

    .service-details {
        width: 100%;
        text-align: left;
    }

    .service-details tbody tr {
        width: 100%;
    }
    .sub-title{
        font-weight: bold !important;
    }
    .border_bottom_upper{
        border-bottom:1pt solid black;
        border-top:1pt solid black;
        
    }
    .col-1{
        width: 20%;
    }
    .col-2{
        width: 20%;
    }
    .col-3{
        width: 20%;
    }
    .col-4{
        width: 15%;
    }
    .col-5{
        width: 8%;
    }
    .col-6{
        width: 17%;
    }
    .motorcycle-details {
        margin: 10px 0;
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
            NOTA LUNAS 
        </div>
        <hr>
        
		<div class="description-section">
			<div class="date-section">

                <div>{{ $date }}</div>
			</div>
        </div>
        
        <div>

            <h3>{{ $transaction->id_transaction }}</h3>

        </div>

        <div class="general-section">
            <table class="box">
                <tbody>
                    <tr>
                        <th>Cust</th>
    
                        <td>{{ $transaction->customers->customer_name }}</td>
                        <th>CS</th>
        
                        @foreach ($transaction->employees as $item)
                            @if ($item->id_role === 2 || $item->id_role ===1  )
                                <td>{{ $item->name }}</td>
                                @break
                            @endif
                        @endforeach
                    </tr>
                    <tr>
                        <th>Telepon</th>

                        <td>{{ $transaction->customers->customer_phone_number }}</td>

                        <th>Montir</th>
                        <td>
                        @foreach ($mechanics as $item)
                            <li style="list-style: none;">{{ $item }}</li>
                        @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        @if (substr($transaction->id_transaction,0,2)=='SS' || substr($transaction->id_transaction,0,2)=='SP')
        <br>
        <hr>
        <div class="text-xs-center sub-title">
            SPAREPART   
        </div>
        <hr>
        <div class="motorcycle-details">
            @foreach ($sparepartmotorcycles as $item)
            <div>{{ $item }}</div>
            @endforeach
        </div>
        <br>                       
        <div>
            <table class="sparepart-details border_bottom_upper">
                <thead>
                    <tr >
                        <th class="col-1">Kode</th>
                        <th class="col-2">Nama</th>
                        <th class="col-3">Merk</th>
                        <th style="text-align:left;" class="col-4">Harga</th>
                        <th style="text-align:right;" class="col-5">Jumlah</th>
                        <th style="text-align:right;" class="col-6">Subtotal</th>

                    </tr>
                </thead>
                <tbody>
                

                    @foreach ($transaction->detail_spareparts as $item)
                        <tr>
                            <td>{{ $item->id_sparepart }}</td>
                            <td>{{ $item->spareparts->sparepart_name }}</td>
                            <td>{{ $item->spareparts->merk }}</td>
                            <td style="text-align:right;">Rp. {{ $item->detail_sparepart_price }}</td>
                            <td style="text-align:right;">{{ $item->detail_sparepart_amount }}</td>
                            <td style="text-align:right;">Rp. {{ $item->detail_sparepart_subtotal }}</td>
     
                        </tr>
                    @endforeach
              
                </tbody>
            </table>
        </div>
        <div>
                <table class="sparepart-details border_bottom_upper">
                        <thead>
                            <tr >
                                <th class="col-1"></th>
                                <th class="col-2"></th>
                                <th class="col-3"></th>
                                <th class="col-4"></th>
                                <th class="col-5"></th>
                                <th class="col-6"></th>
        
                            </tr>
                        </thead>
                        <tbody>
                           
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                  
                                <td style="text-align:right;">{{$transaction->detail_spareparts->sum('detail_sparepart_subtotal')}}</td>

                                
                            </tr>
                      
                        </tbody>
                    </table>
        </div>
        @endif
        @if (substr($transaction->id_transaction,0,2)=='SS' || substr($transaction->id_transaction,0,2)=='SV')
        <hr>
        <div class="text-xs-center sub-title">
            SERVICE
        </div>
        <hr>
        <div class="motorcycle-details">
            @foreach ($servicemotorcycles as $item)
            <div>{{ $item }}</div>
            @endforeach
        </div>

        <br>                    
        <div>
            <table class="service-details border_bottom_upper">
                <thead>
                    <tr>
                        <th class="col-1">Kode</th>
                        <th class="col-2">Nama</th>
                        <th class="col-3"></th>
                        <th style="text-align:left;" class="col-4">Harga</th>
                        <th style="text-align:right;" class="col-5">Jumlah</th>
                        <th style="text-align:right;" class="col-6">Subtotal</th>
 
                    </tr>
                </thead>
                <tbody>

                    @foreach ($transaction->detail_services as $item)
                        <tr>
                            <td>{{ $item->id_service }}</td>
                            <td>{{ $item->services->service_name }}</td>
                            <td></td>
                            <td style="text-align:right;">Rp. {{ $item->detail_service_price }}</td>
                            <td style="text-align:right;">{{ $item->detail_service_amount }}</td>
                            <td style="text-align:right;">{{ $item->detail_service_subtotal }}</td>
                           
                        </tr>
                    @endforeach
           
                </tbody>
            </table>
        </div>
        <div>
            <table class="service-details border_bottom_upper">
                <thead>
                    <tr>
                            <th class="col-1"></th>
                            <th class="col-2"></th>
                            <th class="col-3"></th>
                            <th class="col-4"></th>
                            <th class="col-5"></th>
                            <th class="col-6"></th>
    
                    </tr>
                </thead>
                <tbody>
                    
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
    
                        <td style="text-align:right;">{{$transaction->detail_services->sum('detail_service_subtotal')}}</td>

                    </tr>
            
                </tbody>
            </table>
        </div>
        @endif
        <br>
        <div>
            <table class="service-details">
                <thead>
                    <tr>
                            <th class="col-1"></th>
                            <th class="col-2"></th>
                            <th class="col-3"></th>
                            <th class="col-4"></th>
                            <th class="col-5"></th>
                            <th class="col-6"></th>
    
                    </tr>
                </thead>
                <tbody>
                    
                    <tr>
                        <td>Cust</td>
                        <td></td>
                        <td>Kasir</td>
                        <td></td>
                        <td style="text-align:left;">Subtotal</td>

                        <td style="text-align:right;">
                        {{
                            $transaction->detail_spareparts->sum('detail_sparepart_subtotal') +
                            $transaction->detail_services->sum('detail_service_subtotal') 
                        }}
                        </td>

                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="text-align:left;">Diskon</td>
  
                        <td style="text-align:right;">{{ $transaction->transaction_discount}}</td>

                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="text-align:left;">TOTAL</td>
  
                        <td style="text-align:right; font-weight: bold; font-size: 18px;">
                        {{
                            ($transaction->detail_spareparts->sum('detail_sparepart_subtotal') 
                            +
                            $transaction->detail_services->sum('detail_service_subtotal') ) 
                            - 
                            $transaction->transaction_discount
                        }}
                        </td>

                    </tr>
                    <tr>

                        <td>({{$transaction->customers->customer_name}})</td>

                        <td></td>

                        @foreach ($transaction->employees as $item)
                            @if ($item->id_role === 3 )
                                <td>{{ $item->name }}</td>
                                @break
                            @endif
                        @endforeach
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>

            
                </tbody>
            </table>
        </div>
	</div>
</body>
</html>