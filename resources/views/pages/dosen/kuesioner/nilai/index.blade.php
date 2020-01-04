@extends ('template')

@section ('main')
	<style>
		.table {margin-bottom: 0;}
		.table, .table thead tr th, .table tbody tr th, .table tbody tr td {border:1px solid #ccc; vertical-align: middle}
	</style>
	<section class="content-header">
		<h1>Nilai Kuesioner</h1>
		<ol class="breadcrumb">
			<li>Home</li>
			<li class="active">Nilai Kuesioner</li>
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
					<table class="table table-bordered">
						<thead>
							<tr>
								<th width="30" rowspan="2" class="text-center">No.</th>
								<th width="400" rowspan="2" class="text-center">Mata Kuliah</th>
								<th nowrap colspan="4" class="text-center">Rekapitulasi</th>
								<th width="100" rowspan="2" class="text-center">Total Nilai</th>
							</tr>
							<tr>
								<th class="text-center">Pedagogik</th>
								<th class="text-center">Profesional</th>
								<th class="text-center">Kepribadian</th>
								<th class="text-center">Sosial</th>
							</tr>
						</thead>
						<tbody>
							@if (empty($data))
								<tr>
									<td colspan="7">Tidak ada data.</td>
								</tr>
							@else
								@foreach ($data as $list)
									<tr>
										<td class="text-center">{{ $list->no }}</td>
										<td>{{ $list->kode_matkul }} - {{ $list->nama_matkul }}</td>
										<td class="text-center">{{ $list->total_pedagogik }}</td>
										<td class="text-center">{{ $list->total_profesional }}</td>
										<td class="text-center">{{ $list->total_kepribadian }}</td>
										<td class="text-center">{{ $list->total_sosial }}</td>
										<td class="text-center">{{ number_format(($list->total_pedagogik + $list->total_profesional + $list->total_kepribadian + $list->total_sosial) / 4, 2) }}</td>
									</tr>
								@endforeach
							@endif
						</tbody>
					</table>
					<h4><strong>Skor Penilaian:</strong></h4>
					<p style="margin-bottom: 15px">
						1 = sangat tidak baik/sangat rendah/tidak pernah<br>
						2 = tidak baik/rendah/jarang<br>
						3 = biasa/cukup/kadang-kadang<br>
						4 = baik/tinggi/sering<br>
						5 = sangat baik/sangat tinggi/selalu
					</p>
				@endif
			</div>
		</div>
	</section>
@stop