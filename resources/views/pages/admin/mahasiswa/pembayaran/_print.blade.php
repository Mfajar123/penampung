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
	                    <h4 style="color: black; text-align: center;">Kwitansi Registrasi Mahasiswa Baru</h4>
	                    <p style="text-align: center; color: black; padding-top: 10px;">Jl. Citra Raya Utama Barat, Griya Harsa II Blok i 10 no. 29, <br> Cikupa 15710 - Tangerang.</p>
	                </div> 
	            </div>
           		<div class="col-md-4 col-xs-2"></div>
	        </div>
			<div class="col-md-12" style="border-bottom: 1px solid black; margin: 15px 0px;"></div>
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
                    <th>Alamat</th>
                    <td>: {{$daftar->alamat}}</td>
                    <th>Status</th>
                    <td>: {{$kategori}}</td>
                  </tr>
                </table>
			</div>
			<br>
			<div class="table-responsive">
				<table id="tabel-data" class="table table-striped table-bordered" width="100%" cellspacing="0">
					<tr>
                    	<th colspan="2" style="text-align: center;">Biaya Registrasi Mahasiswa Baru</th>   
                  	</tr>
					<tr>
						<th>Jenis Biaya</th>
						<th>Besar Biaya</th>
					</tr>
						
					<tr>
						<td>Total</td>
						<td>Rp. {{ number_format($daftar->biaya) }}</td>
					</tr>
					<tr>
						<td>Potongan</td>
						<td>Rp. {{ number_format($daftar->potongan) }}</td>	
					</tr>
					<tr>
						<td>Promo</td>
						<td>Rp. {{ number_format($daftar->promo->diskon) }}</td>	
					</tr>
					<tr>
						<td>Biaya Harus Dibayar</td>
						<td>Rp. {{ number_format($biaya) }}</td>
					</tr>
				</table>

				<table id="tabel-data" class="table table-striped table-bordered" width="100%" cellspacing="0">
                  <tr>
                    <th colspan="2" style="text-align: center;">Transaksi Pembayaran</th>
                  
                  </tr>
                  <tr>
                    <th>Pembayaran Kelulusan</th>
                    <th>Pembayaran Ke</th>
                  </tr>
                  @foreach($detail as $dtl)
                  <tr>
                    <td>Rp. {{ number_format($dtl->bayar_kelulusan) }}</td>
                    <td>{{ $dtl->pembayaran_ke }}</td>
                    
                  </tr>
                  @endforeach
                  <tr>
                  	<th>Sisa Yang Harus Dibayar</th>
                  	<td>Rp. {{ number_format( $biaya - $jmlh ) }}</td>
                  </tr>
                </table>
			</div>

			<div class="row">
					<div class="col-md-1 col-xs-1"></div>
					<div class="col-md-5 col-xs-5">
						<p>Status Pembayaran : {{$daftar->status_pembayaran}}</p>
					</div>
					<div class="col-md-5 col-xs-5" >
						
					</div>
					<div class="col-md-1 col-xs-1"></div>
			</div><br>

			<div class="row">
				<div class="col-md-1 col-xs-1">
					
				</div>
				<div class="col-md-4 col-xs-4">
					<p >Penyetor</p>
					<br>
					<span>( {{ $daftar->nama }} )</span>
				</div>
				<div class="col-md-4 col-xs-4 ">
					
				</div>
				<div class="col-md-3 col-xs-3" >
					<p style="padding: 0px; margin: 0px;">Tangerang,<?php echo date("d-M-Y ")  ?> </p>
					<p >Petugas Keuangan</p>
					<br>
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
