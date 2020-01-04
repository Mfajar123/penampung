@extends ('template')

@section ('main')
	<style>
		.table, .table thead tr th, .table tbody tr th, .table tbody tr td {border:1px solid #ccc}
	</style>
	<section class="content-header">
		<h1>Kehadiran <= 3</h1>
		<ol class="breadcrumb">
			<li>Home</li>
			<li class="active">Kehadiran <= 3</li>
		</ol>
	</section>

	<section class="content">
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs">
				<li><a href="{{ route('admin.cetak_absen') }}">Form Absensi</a></li>
				<li><a href="{{ route('admin.cetak_absen.kehadiran') }}">Cek Kehadiran</a></li>
				<li class="active"><a href="{{ route('admin.cetak_absen.alpha') }}">Kehadiran <= 3</a></li>
			</ul>
			<div class="tab-content">
				{!! Form::open(['method' => 'GET']) !!}
				
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								{!! Form::label('tahun_akademik', 'Tahun Akademik', ['class' => 'control-label']) !!}
								{!! Form::select('tahun_akademik', $list_tahun_akademik, null, ['placeholder' => '- Pilih Semester -', 'class' => 'form-control select-custom', 'required']) !!}
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								{!! Form::label('id_semester', 'Semester', ['class' => 'control-label']) !!}
								{!! Form::select('id_semester', $list_semester, null, ['placeholder' => '- Pilih Semester -', 'class' => 'form-control select-custom', 'required']) !!}
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								{!! Form::label('id_prodi', 'Prodi', ['class' => 'control-label']) !!}
								{!! Form::select('id_prodi', $list_prodi, null, ['placeholder' => '- Pilih Prodi -', 'class' => 'form-control ', 'required']) !!}
							</div>
						</div>
					</div>

					{!! Form::submit('Tampilkan', ['class' => 'btn btn-default']) !!}
				{!! Form::close() !!}
				@if (Request::isMethod('get'))
					<br>
					<div class="table-responsive">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th class="text-center" width="50">No.</th>
									<th class="text-center">NIM</th>
									<th class="text-center">Nama Mahasiswa</th>
									<th class="text-center">Kelas</th>
									<th class="text-center">Mata Kuliah</th>
									<th class="text-center">Kehadiran</th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 1; ?>
								@foreach ($list_absensi as $list)
									<tr>
										<td>{{ $no++ }}</td>
										<td>{{ $list->nim }}</td>
										<td>{{ $mahasiswa[$list->nim] }}</td>
										<td>{{ $list->id_prodi }}{{ $list->kode_kelas }}</td>
										<td>{{ $list->kode_matkul }} - {{ $list->nama_matkul }}</td>
										<td>{{ $list->kehadiran }}</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				@endif
			</div>
		</div>
	</section>
@stop