@extends ('template')

@section ('main')
	<section class="content-header">
		<h1>Kehadiran</h1>

		<ol class="breadcrumb">
			<li><a href="#">Home</a></li>
			<li class="active">Kehadiran</li>
		</ol>
	</section>

	<section class="content">
		<div class="box box-default">
			<div class="box-header with-border">
				{!! Form::open(['method' => 'POST', 'route' => 'mahasiswa.absensi.tampilkan', 'class' => 'form-inline']) !!}
					{!! Form::select('tahun_akademik', $list_tahun_akademik, null, ['placeholder' => '- Pilih Tahun Akademik -', 'class' => 'form-control', 'required']) !!}
					{!! Form::submit('Tampilkan', ['class' => 'btn btn-default']) !!}
				{!! Form::close() !!}
			</div>
			@if (Request::isMethod('POST'))
				<div class="box-body">
					<div class="table-responsive">
						<table class="table table-bordered table-striped jadwal">
							<thead>
								<tr>
									<th>No</th>
									<th>Hari/Jam</th>
									<th>Ruang</th>
									<th>Kelas</th>
									<th>Matkul</th>
									<th>Dosen</th>
									<th>Jumlah Pertemuan</th>
									<th>Kehadiran</th>
									<th>Absen</th>
								</tr>
							</thead>
							<tbody>
								@if(count($krs))
									<?php $no = 1; ?>
									@foreach($krs->krs_item()->get() as $krs)
										<?php
											$jadwal = $jadwal->where('id_matkul', $krs->id_matkul)->first();
											$absensi = DB::table('t_absensi AS ta')
												->where([
													'nim' => Auth::guard('mahasiswa')->user()->nim,
													'id_matkul' => $krs->id_matkul,
												])
												->get();
										?>
										<tr>
											<td>{{$no++}}</td>
											<td>
												{{ ! empty($jadwal->hari) ? $jadwal->hari : '-' }}<br>
												{{ ! empty($jadwal->jam_mulai) ? date('H:i', strtotime($jadwal->jam_mulai)) : '-' }} - {{ ! empty($jadwal->jam_selesai) ? date('H:i', strtotime($jadwal->jam_selesai)) : '-' }}
											</td>
											<td>{{ ! empty($jadwal->ruang->kode_ruang) ? $jadwal->ruang->kode_ruang : '-' }}</td>
											<td>{{ ! empty($jadwal->kelas->kode_kelas) ? $jadwal->kelas->kode_kelas : '-' }} - {{ ! empty($jadwal->kelas->nama_kelas) ? $jadwal->kelas->nama_kelas : '-' }}</td>
											<td>{{ ! empty($jadwal->matkul->kode_matkul) ? $jadwal->matkul->kode_matkul : '-' }} - {{ ! empty($jadwal->matkul->nama_matkul) ? $jadwal->matkul->nama_matkul : '-' }}</td>
											<td>{{ ! empty($jadwal->dosen->nama) ? $jadwal->dosen->nama : '-' }}</td>
											<td>{{ $absensi->count() }}</td>
											<td>{{ $absensi->where('keterangan', 'Hadir')->count() }}</td>
											<td>{{ $absensi->where('keterangan', '!=', 'Hadir')->count() }}</td>
										</tr>
									@endforeach
								@else
									<tr>
										<td colspan="6">Tidak ada data</td>
									</tr>
								@endif
							</tbody>
						</table>
					</div>
				</div>
			@endif
		</div>
	</section>
@stop