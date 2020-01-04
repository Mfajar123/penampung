@extends ('template')

@section ('main')
	<section class="content-header">
		<h1>Absensi Mahasiswa</h1>
		<ol class="breadcrumb">
			<li>Home</li>
			<li class="active">Absensi Mahasiswa</li>
		</ol>
	</section>

	<section class="content">
		<div class="box box-default">
			<div class="box-header with-border">
				<h4 class="box-title">Form Absensi</h4>
			</div>
			<div class="box-body">
				{!! Form::open(['method' => 'GET']) !!}
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('id_tahun_akademik', 'Tahun Akademik', ['class' => 'control-label']) !!}
								{!! Form::select('id_tahun_akademik', $list_tahun_akademik, null, ['placeholder' => '- Pilih Tahun Akademik -', 'class' => 'form-control']) !!}
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('id_prodi', 'Program Studi', ['class' => 'control-label']) !!}
								{!! Form::select('id_prodi', $list_prodi, null, ['placeholder' => '- Pilih Program Studi -', 'class' => 'form-control']) !!}
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('id_waktu_kuliah', 'Waktu Kuliah', ['class' => 'control-label']) !!}
								{!! Form::select('id_waktu_kuliah', $list_waktu_kuliah, null, ['placeholder' => '- Pilih Waktu Kuliah -', 'class' => 'form-control']) !!}
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('id_semester', 'Semester', ['class' => 'control-label']) !!}
								{!! Form::select('id_semester', $list_semester, null, ['placeholder' => '- Pilih Semester -', 'class' => 'form-control']) !!}
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('id_matkul', 'Mata Kuliah', [ 'class' => 'control-label']) !!}
								{!! Form::select('id_matkul', $list_matkul, null, ['placeholder' => '- Pilih Mata Kuliah -', 'class' => 'form-control']) !!}
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('id_kelas', 'Kelas', [ 'class' => 'control-label']) !!}
								{!! Form::select('id_kelas', $list_kelas, null, ['placeholder' => '- Pilih Kelas -', 'class' => 'form-control']) !!}
							</div>
						</div>
					</div>
					{!! Form::submit('Tampilkan', ['class' => 'btn btn-default']) !!}
				{!! Form::close() !!}
				<br>
				{!! Form::open(['method' => 'POST', 'route' => 'dosen.absensi.submit']) !!}

				{!! Form::hidden('id_tahun_akademk', @$_GET['id_tahun_akademik']) !!}
				{!! Form::hidden('id_prodi', @$_GET['id_prodi']) !!}
				{!! Form::hidden('id_matkul', @$_GET['id_matkul']) !!}
				{!! Form::hidden('id_kelas', @$_GET['id_kelas']) !!}

				<div class="table-responsive">
					<table class="table table-striped table-bordered">
						<thead>
							<tr>
								<th width="30">No.</th>
								<th nowrap>NPM</th>
								<th nowrap>Nama Mahasiswa</th>
								<th nowrap>Absensi</th>
							</tr>
						</thead>
						<tbody>
							@if (count($list_mahasiswa) > 0)
								<?php $no = 1; ?>
								@foreach ($list_mahasiswa as $mahasiswa)
									<tr>
										<td>{{ $no++ }}</td>
										<td>{{ $mahasiswa->nim }}</td>
										<td>{{ $mahasiswa->nama }}</td>
										<td>{{ Form::checkbox('nim[]', $mahasiswa->nim, true) }}</td>
									</tr>
								@endforeach
							@else
								<tr>
									<td colspan="4">Tidak ada data.</td>
								</tr>
							@endif
						</tbody>
					</table>
				</div>
				@if (count($list_mahasiswa) > 0)
					{!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
				@endif
				{!! Form::close() !!}
			</div>
		</div>
	</section>
@stop