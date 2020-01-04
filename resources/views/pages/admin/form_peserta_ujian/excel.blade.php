<?php

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=summary.xls");
?>

<html>
	<head>
		<title>Absensi Mahasiswa</title>
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
	                    <p style="text-align: center; color: black; padding-top: 10px;">Jl. Citra Raya Utama Barat, Griya Harsa II Blok i 10 no. 29, <br> Cikupa 15710 - Tangerang.</p>
	                </div> 
	            </div>
           		<div class="col-md-4 col-xs-2"></div>
	        </div>
	        <div class="row">
           		<div class="col-md-12" style="border-bottom: 1px solid black; margin: 15px 0px;"></div>
           		<h4 style="text-align: center; margin: 5px;">Absensi (Tanggal Cetak : <?php echo date("d-M-Y ")  ?>	)</h4>
           		<div class="col-md-5 col-xs-4" ></div>
           		<div class="col-md-2 col-xs-4" style="border-top: 1px solid black; text-align: center;"></div>
           		<div class="col-md-5 col-xs-4" ></div>
           	</div><br>
        @foreach($dosen as $dsn)
				<table class="kolom" width="100%" cellspacing="0">
					<tr>
						<th>NIP</th>
						<td>: {{@$dsn->nip}} </td>
						<td></td>
						<th>Status Dosen </th>
						<td>: @if($dsn->status_dosen == 1)Dosen Tetap @else Dosen Luar @endif</td>
					</tr>
					<tr>
						<th>Nama</th>
						<td>: {{@$dsn->nama}}</td>
						<td></td>
						<th>Program Studi</th>
						<td>:  Pendidikan {{@$dsn->prodi->nama_prodi}}</td>
					</tr>
					<tr>
						<th>Mata Kuliah</th>
						<td style="text-transform: capitalize;">: {{ ! empty($matkul->nama_matkul) ? $matkul->nama_matkul : '-' }}</td>
						<td></td>
						<th>Kelas</th>
						<td>: {{ ! empty($kelas->id_prodi) ? $kelas->id_prodi : '-' }} - {{ ! empty($kelas->kode_kelas) ? $kelas->kode_kelas : '-' }}</td>
					</tr>
					<tr>
						<th>Waktu Kuliah</th>
						<td style="text-transform: capitalize;">: {{ ! empty($dsn->nama_waktu_kuliah) ? $dsn->nama_waktu_kuliah : '-' }}</td>
						<td></td>
						<th>Jam</th>
						<td>: {{ ! empty($dsn->jam_mulai) ? $dsn->jam_mulai : '-' }} - {{ ! empty($dsn->jam_selesai) ? $dsn->jam_selesai : '-' }}</td>
					</tr>
				</table><br>
		@endforeach
				<div class="table-responsive">
					<table class="table table-striped table-bordered">
						<thead>
							<tr align="center">
								<td width="30" rowspan="2">No.</td>
								<td width="150" rowspan="2">NIM</td>
								<td width="200" rowspan="2">Nama Mahasiswa</td>
								<td colspan="14" >Tanggal Paraf Mahasiswa</td>
								<td width="10" rowspan="2">Ket</td>
							</tr>
							<tr align="center">
						<?php 
						for ($no=1; $no<=7; $no++) { ?>
								<td colspan="1" >{{ }}</td>
						<?php	} ?>
							</tr>
						</thead>
						<tbody>
							@if (count($mahasiswa) > 0)
								<?php $no = 1; ?>
								@foreach ($mahasiswa as $mahasiswas)
									<tr align="center">
										<td>{{ $no++ }}</td>
										<td>{{ $mahasiswas->nim }}</td>		
										<td>{{ $mahasiswas->nama }}</td>
										@for($i = 1; $i <= 7; $i++)
											<td > </td>
											
										@endfor
									</tr>
									</tr>
								@endforeach
							@else
								<tr>
									<td colspan="17">Tidak ada data.</td>
								</tr>
							@endif
						</tbody>
		
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
