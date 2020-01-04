@extends ('template')

@section ('main')
	<style>
		.table, .table thead tr th, .table tbody tr th, .table tbody tr td {border:1px solid #ccc}
	</style>
	<section class="content-header">
		<h1>Absensi Mahasiswa</h1>
		<ol class="breadcrumb">
			<li>Home</li>
			<li class="active">Absensi Mahasiswa</li>
		</ol>
	</section>

	<section class="content">
		@include ('_partials.flash_message')
		<div class="box box-default">
			<div class="box-header with-border">
				<h4 class="box-title">Form Absensi</h4>
			</div>
			<div class="box-body">
				{!! Form::open(['method' => 'POST']) !!}
					<div class="row">
					    <div class="col-md-12">
							<div class="form-group">
								{!! Form::label('prodi', 'Prodi', ['class' => 'control-label']) !!}
								{!! Form::select('prodi', $prodi, null, ['placeholder' => '- Pilih Prodi -', 'class' => 'form-control ', 'required']) !!}
							</div>
							<div class="form-group">
								{!! Form::label('tahun_akademik', 'Tahun Akademik', ['class' => 'control-label']) !!}
								{!! Form::select('tahun_akademik', $list_tahun_akademik, null, ['placeholder' => '- Pilih Tahun Akademik -', 'class' => 'form-control select-custom', 'required']) !!}
							</div>
							<div class="form-group">
								{!! Form::label('list_hari', 'Hari', ['class' => 'control-label']) !!}
								{!! Form::select('list_hari', $list_hari, null, ['placeholder' => '- Pilih Hari -', 'class' => 'form-control select-custom', 'required']) !!}
							</div>
						</div>
					</div>
					{!! Form::submit('Tampilkan', ['class' => 'btn btn-default']) !!}
				{!! Form::close() !!}
				@if (Request::isMethod('post'))
					<br>
					<div class="table-responsive">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th width="30" class="text-center">No.</th>
									<th width="120" class="text-center">Jam</th>
									<th width="100" class="text-center">Ruang</th>
									<th width="100" class="text-center">Kelas</th>
									<th nowrap class="text-center">Nama Mata Kuliah</th>
									<th width="350" class="text-center">Aksi</th>
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
													<td>
														{{ ! empty($jadwal->matkul->kode_matkul) ? $jadwal->matkul->kode_matkul : '-' }} -
														{{ ! empty($jadwal->matkul->nama_matkul) ? $jadwal->matkul->nama_matkul : '-' }} <br>
														({{ ! empty($jadwal->matkul->sks) ? $jadwal->matkul->sks : '-' }} sks)
													</td>
													<td class="text-center">
														<a href="{{ route('admin.absensi.detail', [$jadwal->id_kelas, $jadwal->id_matkul, $jadwal->id_dosen, $jadwal->id_jadwal]) }}" class="btn btn-default"><i class="fa fa-check-square-o"></i> Absen</a>
														<a href="{{ route('admin.absensi.kehadiran', [$jadwal->id_kelas, $jadwal->id_matkul, $jadwal->id_dosen]) }}" class="btn btn-default"><i class="fa fa-check-square-o"></i> Cek Kehadiran</a>
														<a href="{{ route('admin.rekap_absen.print', [$jadwal->id_kelas, $jadwal->id_matkul, $jadwal->id_semester, $jadwal->id_dosen]) }}" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Cetak</a>
													</td>
												</tr>
											@endforeach
										</tr>
									@endif
								@endforeach
							</tbody>
						</table>
					</div>
				@endif
			</div>
		</div>
	</section>
@stop