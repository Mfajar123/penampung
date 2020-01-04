<html>
	<head>
		<title>Jadwal Dosen Mengajar</title>
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
	                    <h4 style="color: black; text-align: center;">Jadwal Dosen Mengajar </h4>
	                    <p style="text-align: center; color: black; padding-top: 10px;">Jl. Citra Raya Utama Barat, Griya Harsa II Blok i 10 no. 29, <br> Cikupa 15710 - Tangerang.</p>
	                </div> 
	            </div>
           		<div class="col-md-4 col-xs-2"></div>
	        </div>
	        <div class="row">
           		<div class="col-md-12" style="border-bottom: 1px solid black; margin: 15px 0px;"></div>
           		<h4 style="text-align: center; margin: 5px;">Jadwal Dosen Mengajar(Tanggal Cetak : <?php echo date("d-M-Y ")  ?>	)</h4>
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
						<th>Status Dosen</th>
						<td>: @if($dsn->status_dosen == 1)Dosen Tetap @else Dosen Luar @endif</td>
					</tr>
					<tr>
						<th>Nama</th>
						<td>: {{@$dsn->nama}}</td>
						<td></td>
						<th>Program Studi</th>
						<td>: {{@$dsn->prodi->nama_prodi}}</td>
					</tr>
				</table><br>
		@endforeach

				<div class="table-responsive">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th width="30" class="text-center">No.</th>
									<th width="120" class="text-center">Jam</th>
									<th width="100" class="text-center">Ruang</th>
									<th width="100" class="text-center">Kelas</th>
									<th nowrap class="text-center">Nama Mata Kuliah</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($list_hari as $hari)
									@if ($list_jadwal->where('hari', $hari)->count() > 0)
										<tr>
											<th colspan="6">{{ $hari }}</th>
											<?php $no = 1; ?>
											@foreach ($list_jadwal->where('hari', $hari) as $jadwal)
												<tr>
													<td class="text-center">{{ $no++ }}</td>
													<td class="text-center">{{ (! empty($jadwal->jam_mulai) ? date('H:i', strtotime($jadwal->jam_mulai)) : '-').' '.(! empty($jadwal->jam_selesai) ? date('H:i', strtotime($jadwal->jam_selesai)) : '-') }}</td>
													<td class="text-center">{{ ! empty($jadwal->ruang->kode_ruang) ? $jadwal->ruang->kode_ruang : '-' }}</td>
													<td class="text-center">
														{{ ! empty($jadwal->kelas->id_prodi) ? $jadwal->kelas->id_prodi : '-' }} -
														{{ ! empty($jadwal->kelas->kode_kelas) ? $jadwal->kelas->kode_kelas : '-' }}
													</td>
													<td class="text-center" >
														{{ ! empty($jadwal->matkul->kode_matkul) ? $jadwal->matkul->kode_matkul : '-' }} -
														{{ ! empty($jadwal->matkul->nama_matkul) ? $jadwal->matkul->nama_matkul : '-' }} <br>
														({{ ! empty($jadwal->matkul->sks) ? $jadwal->matkul->sks : '-' }} sks)
													</td>
												</tr>
											@endforeach
										</tr>
						 				
									@endif
								@endforeach
							</tbody>
						</table>
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
