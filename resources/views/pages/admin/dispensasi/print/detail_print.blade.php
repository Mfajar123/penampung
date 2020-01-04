<html>
	<head>
		<title>Kwitansi</title>
		<link rel="stylesheet" href="{{ asset('plugins/assets/css/bootstrap.min.css') }}">
		<link rel="stylesheet" href="{{ asset('css/model.css') }}">
	</head>
	<body>
		<div class="container">
			<div class="row" >
				<div class="col-md-2 col-xs-2"></div>
			 	<div class="konten col-md-8 col-xs-8" style="padding:0px 0px; ">
	                <span><img src="{{asset('images/logo/stie-logo.png')}}"  alt="Logo STIE PPI" class="img-responsive"  title="Logo STIE PPI" style="width: 10%; margin: 0px; margin-left: 20px; " class="img-responsive"></span>
	                <div class="bisa">
	                    <h4 style="color: black; text-align: center; margin-top: 5px; ">Sekolah Tinggi Ilmu Ekonomi Putra Perdana Indonesia</h4>
	                    
	                    <p style="text-align: center; color: black; padding-top: 10px;">Jl. Citra Raya Utama Barat, Griya Harsa II Blok i 10 no. 29, <br> Cikupa 15710 - Tangerang.</p>
	               
	                </div> 
	            </div>
	        </div>
			<div class="col-md-12" style="border-bottom: 1px solid black; margin: 15px 0px;"></div>
				<div class="container" style="color: black;">
	            	<h4 style="color: black; text-align: center; margin-left: 50px;">Surat Pernyataan</h4><br><br>
	            	<p style="margin-bottom: 20px;">Saya yang bertanda tangan dibawah ini,</p>
	            	<div class="container" style="margin-left: 20px;">
		            	<table style="color: black;" >
		            		<tr>
		            			<td><p style="margin: 0px 50px 0px 0px">Nama</p></td>
		            			<td>: {{ $dispensasi->nama }}</td>
		            		</tr>
		            		<tr>
		            			<td><p style="margin: 0px 50px 0px 0px">ID Daftar/NIM</p></td>
		            			<td>: {{ $dispensasi->id_daftar }}</td>
		            		</tr>
		            		<tr>
		            			<td><p style="margin: 0px 50px 0px 0px">Program Studi</p></td>
		            			<td>: {{ $dispensasi->nama_prodi }}</td>
		            		</tr>
		            	</table>
		            </div>
					<br>
	            	<p>Menyatakan bahwa saya bersedia untuk melunasi sisa tunggakan biaya kuliah sebesar Rp.{{ $dispensasi->nominal_akan_bayar }} pada tanggal {{ date('d M Y', strtotime($dispensasi->tanggal_akan_bayar)) }}. <br><br>
					Demikian surat pernayataan ini saya buat dengan sebenarnya untuk dipergunakan dengan sebagaimana mestinya.
					</p>

					<div class="row">
						<div class="col-md-4 col-xs-4">
							<p></p>
							<p style="text-align: center;">Menyetujui,</p>
							<br><br><br>
							<p style="text-align: center;" >( {{ $petugas }} )</p>
						</div>
						<div class="col-md-3 col-xs-3 ">
							
						</div>
						<div class="col-md-4 col-xs-4" >
							<p style="padding: 0px; margin: 0px; text-align: center;">Tangerang,<?php echo date("d-M-Y ")  ?> </p>
							<br>
							<p style="text-align: center;">materi 6000</p>
							<br><br>
							<p style="text-align: center;">( {{ $dispensasi->nama }} )</p>
						</div>
						<div class="col-md-1 col-xs-1">
							
						</div>
					</div>
	        	</div>


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
