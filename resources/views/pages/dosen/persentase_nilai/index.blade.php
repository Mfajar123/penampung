@extends ('template')

@section ('main')
	<style>
		.table, .table thead tr th, .table tbody tr th, .table tbody tr td {border:1px solid #ccc}
	</style>
	<section class="content-header">
		<h1>Persentase Nilai Mata Kuliah</h1>
		<ol class="breadcrumb">
			<li>Home</li>
			<li class="active">Persentase Nilai Mata Kuliah</li>
		</ol>
	</section>

	<section class="content">
		<div class="box box-default">
			<div class="box-header with-border">
				<h4 class="box-title">Data</h4>
			</div>
			<div class="box-body">
				{!! Form::open(['method' => 'POST']) !!}
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
				@if (Request::isMethod('post'))
					<br>
					<div class="">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th width="30" class="text-center">No.</th>
									<th nowrap class="text-center">Nama Mata Kuliah</th>
									<th width="200" class="text-center">Aksi</th>
								</tr>
							</thead>
							<tbody>
								@if (! empty($list_jadwal))
									<?php $no = 1; ?>
									@foreach ($list_jadwal as $jadwal)
										<tr>
											<td class="text-center">{{ $no++ }}</td>
											<td>
												{{ $jadwal->kode_matkul }} - {{ $jadwal->nama_matkul }}<br>
												({{ $jadwal->sks }} sks)
											</td>
											<td><a href="{{ route('dosen.nilai.persentase.atur', [$jadwal->kode_matkul, $jadwal->tahun_akademik]) }}" class="btn btn-default">Atur Persentase Nilai</a></td>
										</tr>
									@endforeach
								@endif
							</tbody>
						</table>
					</div>
				@endif
			</div>
		</div>
	</section>
@stop