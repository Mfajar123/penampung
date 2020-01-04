<html>
<head>
	<title>Cetak Absensi Mahasiswa</title>
	<link rel="stylesheet" href="{{ asset('plugins/assets/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/model.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('plugins/font-awesome/font-awesome.min.css') }}">
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
	<script>window.print();</script>
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
					<td>: {{@$dosen->gelar_depan}} {{@$dosen->nama}} {{@$dosen->gelar_belakang}} </td>
					<td></td>
					<td>Mata Kuliah</td>
					<td>: {{ $matkul->kode_matkul }} - {{ $matkul->nama_matkul }} </td>
				</tr>
				<tr>
					<td>Kelas</td>
					<td>: {{@$kelas->nama_kelas}} </td>
					<td></td>
					<td>Waktu Kuliah</td>
					<td style="text-transform: capitalize;">: {{ $kelas->waktu_kuliah->nama_waktu_kuliah }} </td>
				</tr>
				<tr>
					<td>Program Studi</td>
					<td>: {{ $kelas->prodi->nama_prodi }}  </td>
					<td></td>
					<td>Tahun Akademik</td>
					<td>: {{ $tahun_akademik }}</td>
				</tr>
			</table>
		</div><br>
		<table class="table table-bordered">
			<tr>
				<td style="text-align: center;" width="5%" rowspan="2">No.</td>
				<td style="text-align: center;" width="10%" rowspan="2">NIM</td>
				<td style="text-align: center;" width="35%" rowspan="2">Nama Mahasiswa</td>
				@for ($i = 0; $i <= 15; $i++)
					<td class="text-center">{{ $i + 1 }}</td>
				@endfor
			</tr>
			<tbody>
				@if (count($list_kehadiran) > 0)
					<?php $no = 1; ?>
					@foreach ($list_kehadiran as $kehadiran)
						<tr align="center">
							<td>{{ $no++ }}</td>
							<td>{{ $kehadiran->nim }}</td>
							<td>{{ $kehadiran->nama }}</td>
							@for ($i = 0; $i <= 15; $i++)
								@if (empty($pertemuan[$i]->tanggal))
									<td></td>
								@else
									<td class="text-center">
										<i data-toggle="tooltip" data-placement="top" title="{{ @$kehadiran->kehadiran[$pertemuan[$i]->tanggal.'.'.$pertemuan[$i]->pertemuan_ke]->notes }}" class="fa {{ @$kehadiran->kehadiran[$pertemuan[$i]->tanggal.'.'.$pertemuan[$i]->pertemuan_ke]->keterangan }}"></i>
									</td>
								@endif
							@endfor
						</tr>
					@endforeach
				@else
					<tr>
						<td colspan="18">Tidak ada data.</td>
					</tr>
				@endif
			</tbody>
		</table>
	</div>
</body>
</html>
