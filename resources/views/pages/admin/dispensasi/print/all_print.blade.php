<html>
	<head>
		<title>Dispensasi</title>
		<link rel="stylesheet" href="{{ asset('plugins/assets/css/bootstrap.min.css') }}">
		<link rel="stylesheet" href="{{ asset('css/model.css') }}">
	</head>
	<body>
		<div>
			<div class="row" >
				<div class="col-md-2 col-xs-2"></div>
			 	<div class="konten col-md-8 col-xs-8" style="padding:0px 0px; ">
	                <span><img src="{{asset('images/logo/stie-logo.png')}}"  alt="Logo STIE PPI" class="img-responsive"  title="Logo STIE PPI" style="width: 10%; margin: 0px; margin-left: 20px; " class="img-responsive"></span>
	                <div class="bisa" >
	                    <h4 style="color: black; text-align: center; margin-top: 5px; ">Sekolah Tinggi Ilmu Ekonomi Putra Perdana Indonesia</h4>
	                    
	                    <p style="text-align: center; color: black; padding-top: 10px;">Jl. Citra Raya Utama Barat, Griya Harsa II Blok i 10 no. 29, <br> Cikupa 15710 - Tangerang.</p>
	               
	                    <h4 style="color: black; text-align: center; margin-left: 50px; ">Daftar Mahasiswa Dispensasi Pembayaran</h4>
	                </div> 
	            </div>
	        </div><br><br>
			<div class="table-responsive">
				<table width="100%" cellspacing="0" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>No</th>

	                        <th>Nama</th>

	                        <th>Jenis Pembayaran</th>

	                        <th>Tanggal Akan Bayar</th>

	                        <th>Nominal Akan Bayar</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 1 ; ?>
						@foreach( $dispensasi as $d )
						<tr>
							<td>{{ $no++ }}</td>

							<td>{{ $d->nama }}</td>

							<td>{{ $d->jenis_pembayaran }}</td>

							<td>{{ date('d-M-Y', strtotime($d->tanggal_akan_bayar)) }}</td>

							<td>{{ $d->nominal_akan_bayar }}</td>
						@endforeach
						</tr>
					</tbody>
                 
                </table>
			</div><br><br>
		</div>
	</body>
	<style>
		.table>tbody>tr>th {
			padding: 2px;
			font-size: 13px;
		}
		
		.table>tbody>tr>td {
			padding: 2px;
			font-size: 13px;
		}
	
		.kolom>tbody>tr>th,td {
			padding: 2px; 
			font-size: 13px;
			
		}
	</style>
</html>
