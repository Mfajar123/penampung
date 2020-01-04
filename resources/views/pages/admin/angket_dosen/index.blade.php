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
	<h1>Hasil Angket Dosen</h1>
	<ol class="breadcrumb">
		<li>Home</li>
		<li class="active">Hasil Angket Dosen</li>
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
						<th width="50">NIP</th>
						<th>Nama Dosen</th>
						<th>Mata Kuliah</th>
						<th>Kelas</th>
						<th width="150">Aksi</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($data as $list)
						<tr>
							<td>{{ $list->nip }}</td>
							<td>{{ $list->gelar_depan }}{{ $list->nama }}{{ $list->gelar_belakang }}</td>
							<td>{{ $list->kode_matkul }} - {{ $list->nama_matkul }}</td>
							<td>{{ $list->nama_kelas }}</td>
							<td>
								<a href="{{ route('admin.evaluasi.hasil_angket_dosen.detail', [$list->id_dosen, $list->id_matkul, $list->tahun_akademik, $list->id_semester]) }}" class="btn btn-primary btn-sm"><i class="fa fa-search"></i> Detail</a>
								<a href="{{ route('admin.evaluasi.hasil_angket_dosen.print', [$list->id_dosen, $list->id_matkul, $list->tahun_akademik, $list->id_semester]) }}" target="_blank" class="btn btn-default btn-sm"><i class="fa fa-print"></i> Cetak</a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</section>
@stop