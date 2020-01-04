<html>
	<head>
		<title>Kwitansi</title>
		<link rel="stylesheet" href="{{ asset('plugins/assets/css/bootstrap.min.css') }}">
		<link rel="stylesheet" href="{{ asset('css/model.css') }}">
	</head>
	<body>
		<div>
			<div class="row">
				<div class="col-md-4 col-xs-2"></div>
			 	<div class="konten col-md-4 col-xs-8" style="padding:0px 0px; ">
	                <span><img src="{{asset('images/logo/ppi.png')}}"  alt="Logo STIE PPI" class="img-responsive"  title="Logo STIE PPI" style="width: 20%; margin: 0px;"></span>
	                <div class="bisa">
	                    <h4 style="color: black; text-align: center; margin-top: 5px; ">Sekolah Tinggi Ilmu Ekonomi Putra Perdana Indonesia</h4>
	                    <h4 style="color: black; text-align: center;">Kwitansi Pembayaran</h4>
	                    <p style="text-align: center; color: black; padding-top: 10px;">Jl. Citra Raya Utama Barat, Griya Harsa II Blok i 10 no. 29, <br> Cikupa 15710 - Tangerang.</p>
	                </div> 
	            </div>
           		<div class="col-md-4 col-xs-2"></div>
	        </div>
           		<div class="col-md-12" style="border-bottom: 1px solid black; margin: 15px 0px;"></div>
				<table class="kolom" width="100%" cellspacing="0">
					<tr>
						<th>No.Pendaftaran</th>
						<td>: {{$daftar->id_daftar}}</td>
					</tr>
					<tr>
						<th>Nama Pendaftar</th>
						<td>: {{$daftar->nama}}</td>
					</tr>
					<tr>
						<th>Alamat</th>
						<td>: {{$daftar->alamat}}</td>
					</tr>
					<tr>
						<th>Program Studi</th>
						<td>: {{@$daftar->Prodi->nama_prodi}}</td>
					</tr>
			</table>
			<br>
			<div class="table-responsive">
				<table id="tabel-data" class="table table-striped table-bordered " width="100%" cellspacing="0">
						<tr>
							<th>Jenis Biaya</th>
							<th>Kewajiban Membayar</th>	
							<th>Besar Biaya</th>
						</tr>
						<tr>
							<td>Biaya Pendaftaran Mahasiswa Baru</td>
							<td>Rp. {{$daftar->bayar}}</td>
							<td>Rp. {{$daftar->bayar}}</td>
						</tr>
						<tr>
							<td align="right">Total</td>
							<td>Rp. {{$daftar->bayar}}</td>
							<td>Rp. {{$daftar->bayar}}</td>
						</tr>
				</table>
			</div>

			<div class="row">
				<div class="col-md-1 col-xs-1"></div>
				<div class="col-md-5 col-xs-5">
					<p style="text-transform: capitalize;">Terbilang : {{$bilangan_bayar}} Rupiah</p>
				</div>
				<div class="col-md-5 col-xs-5" >
				
				</div>
				<div class="col-md-1 col-xs-1"></div>
			</div><br>

			<div class="row">
				<div class="col-md-1 col-xs-1">
					
				</div>
				<div class="col-md-4 col-xs-4 " style="">
					<p >Penyetor</p>
					<br><br>
					<span >( {{ $daftar->nama }} )</span>
				</div>
				<div class="col-md-4 col-xs-4 ">
					
				</div>
				
				<div class="col-md-3 col-xs-3" >
					<p style="padding: 0px; margin: 0px;">Tangerang,<?php echo date("d-M-Y ")  ?> </p>
					<p >Petugas Keuangan</p>
					<br><br>
					<span>( {{ $petugas }} )</span>
				</div>	
			</div>
		</div>
	</body>
	<style>
		.table>tbody>tr>th {
			padding: 2px;
		}
		
		.table>tbody>tr>td {
			padding: 2px;
		}
	
		.kolom>tbody>tr>th,td {
			padding: 2px; 
			
		}
	</style>
</html>
