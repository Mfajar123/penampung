<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Jadwal Ujian Detail</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<div class="container mt-5">
		<h3>JADWAL UJIAN {{ strtoupper($jenis_ujian) }} {{ strtoupper($waktu) }}</h3>
		<h5 class="mb-3">SEMESTER {{ $tahun_akademik }}</h5>
		@foreach ($data as $tanggal => $jadwal)
			<div class="card mb-3">
				<div class="card-header">{{ date('l, d M Y', strtotime($tanggal)) }}</div>
				<div class="table-responsive">
					<table class="table table-striped table-hover table-sm mb-0">
						<thead>
							<tr>
								<th class="text-center">HARI / JAM</th>
								<th class="text-center">RUANG</th>
								<th class="text-center">KODE MK</th>
								<th class="text-center">MATA KULIAH</th>
								<th class="text-center">SKS</th>
								<th class="text-center">KELAS</th>
								<th class="text-center">SMTR</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($jadwal as $ujian)
								<tr>
									<td class="text-center">{{ $ujian['jam_mulai'] }} - {{ $ujian['jam_selesai'] }}</td>
									<td class="text-center">{{ $ujian->ruang->kode_ruang }}</td>
									<td class="text-center">{{ $ujian->matkul->kode_matkul }}</td>
									<td>{{ $ujian->matkul->nama_matkul }}</td>
									<td class="text-center">{{ $ujian->matkul->sks }}</td>
									<td class="text-center">
										@foreach ($ujian->jadwal_ujian_detail_kelas()->get() as $kelas)
											<span class="badge badge-primary">{{ $kelas->kelas->id_prodi.$kelas->kelas->kode_kelas }}</span>
										@endforeach
									</td>
									<td class="text-center">{{ $ujian->matkul->id_semester }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		@endforeach
	</div>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>