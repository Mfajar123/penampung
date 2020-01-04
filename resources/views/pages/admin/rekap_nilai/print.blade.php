<html>
	<head>
		<title>Form Peserta Ujian</title>
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
           	</div><br>
        	<div class="container">
				<table class="kolom" width="100%" cellspacing="0">
					<tr>
						<td>Dosen</td>
						<td>: {{ @$jadwal->gelar_depan }} {{ @$jadwal->nama }} {{ @$jadwal->gelar_belakang }}  </td>
						<td></td>

						<td>Program Studi</td>
						<td>: {{ $jadwal->nama_prodi }}  </td>
					</tr>
					<tr>
						<td>Waktu Kuliah</td>
						<td style="text-transform: capitalize;">: {{ $jadwal->nama_waktu_kuliah }} </td>
						<td></td>

						<td>Matkul</td>
						<td>: {{@$jadwal->kode_matkul}} - {{@$jadwal->nama_matkul}} </td>
					</tr>
					<tr>
						<td>Tahun Akademik</td>
						<td style="text-transform: capitalize;">: {{ $jadwal->keterangan }} </td>
						<td></td>

						<td>Kelas</td>
						<td>: {{@$jadwal->nama_kelas}} </td>
					</tr>
				</table>
			</div><br>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th class="text-center">No.</th>
						<th class="text-center">NIM</th>
						<th class="text-center">Nama Mahasiswa</th>
						<th class="text-center">Kehadiran</th>
						<th class="text-center">Nilai Tugas</th>
						<th class="text-center">Nilai UTS</th>
						<th class="text-center">Nilai UAS</th>
						<th class="text-center">Total</th>
						<th class="text-center">Bobot</th>
						<th class="text-center">Grade</th>
					</tr>
				</thead>
				<tbody>
					<?php $no = 1; ?>
					@foreach ($list_nilai as $list)
						<tr>
							<td>{{ $no++ }}</td>
							<td>{{ $list['nim'] }}</td>
							<td>{{ $list['nama'] }}</td>
							<td class="text-right">{{ $list['hadir'] }} - {{ $list['jumlah_hadir'] }} Hadir</td>
							<td class="text-right">{{ $list['tugas'] }}</td>
							<td class="text-right">{{ $list['uts'] }}</td>
							<td class="text-right">{{ $list['uas'] }}</td>
							<td class="text-right">{{ $list['total'] }}</td>
							<td class="text-right">{{ $list['bobot'] }}</td>
							<td class="text-right">{{ $list['grade'] }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<div style="width: 100%; display: block; text-align: right">
			<div style="width: 150px; margin-right: 50px; display: inline-block; text-align: center;">
				<br>
				<p style="font-size: 12pt">Dosen Pengampu</p>
				<br>
				<br>
				<br>
				<br>
				<p>(___________________)</p>
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
		
		.table-bordered td, .table-bordered th{
            border: 1px black dotted !important;
            
        }       
</style>
</html>
