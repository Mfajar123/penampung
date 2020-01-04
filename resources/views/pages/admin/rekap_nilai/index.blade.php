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
	<h1>Rekapitulasi Nilai</h1>
	<ol class="breadcrumb">
		<li>Home</li>
		<li class="active">Rekapitulasi Nilai</li>
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
					{{-- <div class="col-md-3">
						{!! Form::label('id_matkul', 'Mata Kuliah', ['control-label']) !!}
						{!! Form::select('id_matkul', $list_matkul, null, ['placeholder' => '- Pilih Semua -', 'class' => 'form-control select-custom']) !!}			
					</div>
					<div class="col-md-3">
						{!! Form::label('id_dosen', 'Dosen', ['control-label']) !!}
						{!! Form::select('id_dosen', $list_dosen, null, ['placeholder' => '- Pilih Semua -', 'class' => 'form-control select-custom']) !!}			
					</div> --}}
					<div class="col-md-3">
						{!! Form::label('tahun_akademik', 'Tahun Akademik', ['control-label']) !!}
						{!! Form::select('tahun_akademik', $list_tahun_akademik, null, ['placeholder' => '- Pilih Semua -', 'class' => 'form-control select-custom']) !!}			
					</div>
					<div class="col-md-3">
						{!! Form::label('id_semester', 'Semester', ['control-label']) !!}
						{!! Form::select('id_semester', $list_semester, null, ['placeholder' => '- Pilih Semua -', 'class' => 'form-control select-custom']) !!}			
					</div>
					<div class="col-md-3">
						{!! Form::label('id_prodi', 'Program Studi', ['control-label']) !!}
						{!! Form::select('id_prodi', $list_prodi, null, ['placeholder' => '- Pilih Semua -', 'class' => 'form-control select-custom']) !!}			
					</div>
					<div class="col-md-3">
						<label class="control-label btn-block">&nbsp;</label>
						{!! Form::submit('Filter', ['class' => 'btn btn-primary']) !!}
					</div>
				</div>
			{!! Form::close() !!}
			<br>
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-hover datatable" width="100%">
					<thead>
						<tr>
							<th>No.</th>
							<th width="200">Tahun Akademik</th>
							<th>Dosen</th>
							<th>Kelas</th>
							<th>Mata Kuliah</th>
							<th>Status</th>
							<th>Aksi</th>
					</thead>
					<tbody>
						<?php $no = 1; ?>
						@foreach ($data as $list)
							<tr>
								<td>{{ $no++ }}</td>
								<td>{{ $list->keterangan }}</td>
								<td>{{ $list->nip }} - {{ $list->gelar_depan }}{{ $list->nama }}{{ $list->gelar_belakang }}</td>
								<td>{{ $list->nama_kelas }}</td>
								<td>{{ $list->kode_matkul }} - {{ $list->nama_matkul }}</td>
								<td><strong class="text-{{ $list->status == 'WAITING' ? 'danger' : 'success' }}">{{ $list->status }}</strong></td>
								<td>
									@if ($list->status == 'DONE')
										<a href="{{ route('admin.rekap_nilai.print', ['id_matkul' => $list->id_matkul, 'id_dosen' => $list->id_dosen, 'tahun_akademik' => $list->tahun_akademik, 'id_semester' => $list->id_semester, 'id_kelas' => $list->id_kelas]) }}" target="_blank" class="btn btn-default btn-sm"><i class="fa fa-print"></i>&nbsp; Print</a>
									@endif
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</section>
@stop