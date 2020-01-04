@extends ('template')

@section ('main')
	<style>
		.table, .table thead tr th, .table tbody tr th, .table tbody tr td {border:1px solid #ccc}
	</style>
	<section class="content-header">
		<h1>Jadwal Kuliah</h1>
		<ol class="breadcrumb">
			<li>Home</li>
			<li class="active">Jadwal Kuliah</li>
		</ol>
	</section>

	<section class="content">
		<div class="box box-default">
			<div class="box-header with-border">
				<h4 class="box-title">Form Jadwal</h4>
			</div>
			<div class="box-body">
				{!! Form::open(['method' => 'GET']) !!}
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								{!! Form::label('tahun_akademik', 'Tahun Akademik', ['class' => 'control-label']) !!}
								{!! Form::select('tahun_akademik', $list_tahun_akademik, null, ['placeholder' => '- Pilih Tahun Akademik -', 'class' => 'form-control', 'required']) !!}
							</div>
						</div>
					</div>
					{!! Form::submit('Tampilkan', ['class' => 'btn btn-default']) !!}
				{!! Form::close() !!}
				@if (Request::isMethod('get') && Request::get('tahun_akademik'))
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
												</tr>
											@endforeach
											
										</tr>
									@endif
								@endforeach
							</tbody>
						</table>
						<a href="{{ route('dosen.jadwal.print', $jadwal->tahun_akademik) }}"  class="btn btn-default" target="_blank" style="text-align: right;"><i class="fa fa-print"></i>Print</a>
					</div>
				@endif
			</div>
		</div>
	</section>
@stop