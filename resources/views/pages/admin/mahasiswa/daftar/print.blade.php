<html>
	<head>
		<title>Kwitansi</title>
		<link rel="stylesheet" href="{{ asset('plugins/assets/css/bootstrap.min.css') }}">
		<link rel="stylesheet" href="{{ asset('css/model.css') }}">
	</head>
	<body>
		<div>
			<div class="row" >
				<div class="col-md-2 col-xs-2"></div>
			 	<div class="konten col-md-8 col-xs-8" style="padding:0px 0px; ">
	                <span><img src="{{asset('images/logo/stie-logo.png')}}"  alt="Logo STIE PPI" class="img-responsive"  title="Logo STIE PPI" style="width: 10%; margin: 0px; margin-left: 20px; " class="img-responsive"></span>
	                <div class="bisa">
	                    <h4 style="color: black; text-align: center; margin-top: 5px; ">Sekolah Tinggi Ilmu Ekonomi Putra Perdana Indonesia</h4>
	                    
	                    <p style="text-align: center; color: black; padding-top: 10px; font-size:11px; ">Jl. Citra Raya Utama Barat, Griya Harsa II Blok i 10 no. 29, Cikupa 15710 - Tangerang.</p>
	               
	                    <h5 style="color: black; text-align: center; margin-left: 50px;">Kwitansi Registrasi Mahasiswa Baru</h5>
	                </div> 
	            </div>
           	
	        </div>
	        <br>
			<div class="table-responsive ">	
				 <table class="kolom" width="100%" cellspacing="0">
                  <tr>
                    <th>No.Pendaftaran</th>
                    <td>: {{$daftar->id_daftar}}</td>
                    <th>Waktu Kuliah</th>
                    <td>: {{$daftar->nama_waktu_kuliah}}</td>
                  </tr>
                  <tr>
                    <th>Nama Pendaftar</th>
                    <td>: {{$daftar->nama}}</td>
                    <th>Program Studi</th>
                    <td>: {{$daftar->Prodi->nama_prodi}}</td>
                  </tr>
                  <tr>
                    <th>Status</th>
                    <td>: {{$daftar->nama_status}}</td>
                    <th>Kategori</th>
                    <td>: {{$kategori}}</td>
                  </tr>
                </table>
			</div>
			<div class="col-md-12" style="border-bottom: 1px solid black; margin: 15px 0px;"></div>
			<div class="table-responsive">
				<table width="100%" cellspacing="0">
					<tr>
						<td>Biaya Kelulusan</td>
						<td style="text-align:right;">: Rp. {{ number_format($daftar->biaya) }}</td>
					</tr>
					<tr>
						<td>Potongan</td>
						<td style="text-align:right;">: Rp. {{ number_format($daftar->potongan) }}</td>	
					</tr>
					<tr>
						<td>Promo</td>
						<td style="border-bottom: 1px solid black; text-align: right; ">: Rp. {{ number_format($diskon_promo) }}</td>	
					</tr>
					<tr>
						<td style="text-align: right;">Biaya Harus Dibayar</td>
						<td style="text-align: right; font-weight: bold;">: Rp. {{ number_format($biaya) }}</td>
					</tr>
				
                  <tr>
                    <th  style=" font-weight: bold; "><u>Pembayaran : </u></th>
                    <th></th>
                  </tr>
                 
                @foreach($detail as $dtl)
                  <tr>
                    <td> Ke -{{ $dtl->pembayaran_ke }} &nbsp; &nbsp; &nbsp; {{ date("d-M-Y", strtotime($dtl->tanggal_pembayaran)) }} </td>
                    <td style="text-align:right; ">: Rp. {{ number_format($dtl->bayar_kelulusan) }}</td>
                  </tr>
                @endforeach
                  <!--<tr>-->
                  <!--   <td style="text-align:right; "> Jumlah </td>-->
                    <!--<td style="text-align:right; font-weight:bold; border-bottom: 1px solid black; text-align: right;    ">: </td> -->
                  <!--</tr>-->
                  <tr>
                  	<td style="text-align: right;">Sisa Harus Dibayar</td>
                  	<td style="text-align: right; font-weight: bold;">: Rp. {{ number_format( $biaya - $jmlh ) }}</td>
                  </tr>
                 
                </table>
			</div><br>

			<div class="row">
				<div class="col-md-1 col-xs-1">
					
				</div>
				<div class="col-md-4 col-xs-4">
					<p >Penyetor</p><br><br><br>


					<span>( {{ $daftar->nama }} )</span>
				</div>
				<div class="col-md-4 col-xs-4 ">
					
				</div>
				<div class="col-md-3 col-xs-3" >
					<p style="padding: 0px; margin: 0px;">Tangerang,<?php echo date("d-M-Y ")  ?> </p>
					<p >Petugas Keuangan</p><br><br>


					<span>( {{ $petugas }} )</span>
				</div>
				<div class="col-md-1 col-xs-1">
					
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
