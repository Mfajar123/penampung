@extends ('template')

@section ('main')
<style>
	.table {
		border: 1px solid #ccc;
	}
	.table-bordered>thead>tr>th {
		border: 1px solid #ccc;
		text-align: center;
		vertical-align: middle;
	}

	.table-bordered>tbody>tr>td {
		border: 1px solid #ccc;
	}
</style>

<section class="content-header">
	<h1>{{ $title }}</h1>
	<ol class="breadcrumb">
		<li>Home</li>
		<li class="active">{{ $title }}</li>
	</ol>
</section>

<section class="content">
	<div class="box box-default">
		<div class="box-header with-border">
			<h4 class="box-title">Data</h4>
		</div>
		<div class="box-body">
			{!! Form::open(['method' => 'GET']) !!}
				<div class="row">
					<div class="col-md-4">
						{!! Form::label('tahun_akademik', 'Tahun Akademik', ['control-label']) !!}
						{!! Form::select('tahun_akademik', $list_tahun_akademik, null, ['placeholder' => '- Pilih Semua -', 'class' => 'form-control select-custom']) !!}			
					</div>
					<div class="col-md-4">
						{!! Form::label('id_semester', 'Semester', ['control-label']) !!}
						{!! Form::select('id_semester', $list_semester, null, ['placeholder' => '- Pilih Semua -', 'class' => 'form-control select-custom']) !!}			
					</div>
					<div class="col-md-4">
						<label class="control-label btn-block">&nbsp;</label>
						{!! Form::submit('Filter', ['name' => 'filter', 'class' => 'btn btn-primary']) !!}
						{!! Form::submit('Export to Excel', ['name' => 'export_to_excel', 'class' => 'btn btn-default']) !!}
					</div>
				</div>
			{!! Form::close() !!}
			<br>
			<table class="table table-striped table-bordered table-hover datatable">
				<thead>
					<tr>
						<th width="30">No.</th>
						@if (! in_array($title, ['Sarana Prasarana', 'Pengembangan Soft Skill Mahasiswa']))
							<th width="50">NIP</th>
							<th width="250">Nama Dosen</th>
							<th width="300">Mata Kuliah</th>
							<th width="300">Kelas</th>
						@endif
						<th>Jawaban</th>
				</thead>
				<tbody>
					<?php $no = 1; ?>
					@foreach ($data as $list)
						<tr>
							<td>{{ $no++ }}</td>
							@if (! in_array($title, ['Sarana Prasarana', 'Pengembangan Soft Skill Mahasiswa']))						
								<td>{{ $list->nip }}</td>
								<td>{{ $list->gelar_depan }}{{ $list->nama }}{{ $list->gelar_belakang }}</td>
								<td>{{ $list->kode_matkul }} - {{ $list->nama_matkul }}</td>
								<td>{{ $list->nama_kelas }}</td>
							@endif
							<td>{{ $list->jawaban }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</section>
@stop