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
	<h1>Rekapitulasi Nilai Angket Dosen</h1>
	<ol class="breadcrumb">
		<li>Home</li>
		<li class="active">Rekapitulasi Nilai Angket Dosen</li>
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
						{!! Form::submit('Filter', ['class' => 'btn btn-primary']) !!}
					</div>
				</div>
			{!! Form::close() !!}
			<br>
			<table class="table table-striped table-bordered table-hover datatable">
				<thead>
					<tr>
						<th rowspan="2">NIP</th>
						<th rowspan="2">Nama Dosen</th>
						<th rowspan="2">Mata Kuliah</th>
						<th colspan="4">Rekapitulasi</th>
						<th rowspan="2">Total Nilai</th>
					</tr>
					<tr>
						<th>Pedagogik</th>
						<th>Profesional</th>
						<th>Kepribadian</th>
						<th>Sosial</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($list_rekapitulasi as $list)
						<tr>
							<td>{{ $list->nip }}</td>
							<td>{{ $list->gelar_depan }}{{ $list->nama }}{{ $list->gelar_belakang }}</td>
							<td>{{ $list->kode_matkul }} - {{ $list->nama_matkul }}</td>
							<td class="text-center">{{ number_format(($list->sumPedagogik / $count_pedagogik), 2) }}</td>
							<td class="text-center">{{ number_format(($list->sumProfesional / $count_profesional), 2) }}</td>
							<td class="text-center">{{ number_format(($list->sumKepribadian / $count_kepribadian), 2) }}</td>
							<td class="text-center">{{ number_format(($list->sumSosial / $count_sosial), 2) }}</td>
							<td class="text-center">{{ number_format((($list->sumPedagogik / $count_pedagogik) + ($list->sumProfesional / $count_profesional) + ($list->sumKepribadian / $count_kepribadian) + ($list->sumSosial / $count_sosial)) / 4, 2) }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</section>
@stop