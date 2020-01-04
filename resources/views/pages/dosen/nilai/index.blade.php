@extends ('template')

@section ('main')
	<style>
		.table, .table thead tr th, .table tbody tr th, .table tbody tr td {border:1px solid #ccc}
	</style>
	<section class="content-header">
		<h1>Nilai Mahasiswa</h1>
		<ol class="breadcrumb">
			<li>Home</li>
			<li class="active">Nilai Mahasiswa</li>
		</ol>
	</section>

	<section class="content">
		@include ('_partials.flash_message')
		<div class="box box-default">
			<div class="box-header with-border">
				<h4 class="box-title">Data</h4>
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
					<div class="">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th width="30" class="text-center">No.</th>
									<th width="100" class="text-center">Kelas</th>
									<th nowrap class="text-center">Mata Kuliah</th>
									<th width="200" class="text-center">Aksi</th>
								</tr>
							</thead>
							<tbody>
								@if (! empty($list_kelas))
									<?php $no = 1; ?>
									@foreach ($list_kelas as $kelas)
										<tr>
											<td>{{ $no++ }}</td>
											<td class="text-center">{{ $kelas->id_prodi }} - {{ $kelas->kode_kelas }}</td>
											<td>{{ $kelas->kode_matkul }} - {{ $kelas->nama_matkul }} ({{ $kelas->sks }} sks)</td>
											<td>
												@if ($pembukaan_input_nilai > 0)
													<a href="{{ route('dosen.nilai.input', [$kelas->tahun_akademik, $kelas->id_kelas, $kelas->kode_matkul]) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Input Nilai</a>
												@endif
												<a href="{{ route('dosen.rekap_nilai.print', ['id_matkul' => $kelas->id_matkul, 'id_dosen' => Auth::guard('dosen')->user()->id_dosen, 'tahun_akademik' => $kelas->tahun_akademik, 'id_semester' => $kelas->id_semester, 'id_kelas' => $kelas->id_kelas]) }}" target="_blank" class="btn btn-default btn-sm"><i class="fa fa-print"></i> Print</a>
											</td>
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