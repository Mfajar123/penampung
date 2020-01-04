@extends('template')

@section('style')
	<style type="text/css">
		.table {
			margin-bottom: 0;
		}
	</style>
@stop

@section('main')
	<section class="content-header">
		<h1><i class="fa fa-calendar"></i> Jadwal Ujian</h1>
	</section>

	<section class="content">
		<div class="box box-primary">
			<div class="box-header with-border">
				{!! Form::open(['method' => 'GET', 'class' => 'form-inline']) !!}
					<div class="form-group">
						{!! Form::select('tahun_akademik', $list_tahun_akademik, null, ['placeholder' => '- Pilih Tahun Akademik -', 'class' => 'form-control']) !!}
					</div>
					<div class="form-group">
						{!! Form::select('jenis_ujian', $list_jenis_ujian, null, ['placeholder' => '- Pilih Jenis Ujian -', 'class' => 'form-control']) !!}
					</div>
					<div class="form-group">
						{!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
					</div>
				{!! Form::close() !!}
			</div>
			@if (! empty($cetak_jadwal_ujian))
				<div class="box-body">
					@if ($cetak_jadwal_ujian['status'] === 'error')
						<h3 class="text-center">{{ $cetak_jadwal_ujian['message'] }}</h3>
					@else
						<div class="table-responsive">
							<table class="table table-stripe table-bordered">
								<thead>
									<tr>
										<th>Mata Kuliah</th>
										<th>Kelas</th>
										<th>Tanggal</th>
										<th>Jam</th>
										<th>Ruang</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($cetak_jadwal_ujian['jadwal_ujian'] as $list)
										<tr>
											<td>{{ $list->kode_matkul }} - {{ $list->nama_matkul }}</td>
											<td>{{ $list->kode_kelas }}</td>
											<td>{{ $cetak_jadwal_ujian['list_hari'][date('N', strtotime($list->tanggal))] }}, {{ date('j M Y', strtotime($list->tanggal)) }}</td>
											<td>{{ $list->jam_mulai }} - {{ $list->jam_selesai }}</td>
											<td>{{ $list->kode_ruang }} - {{ $list->nama_ruang }}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					@endif
				</div>
			@endif
		</div>
	</section>
@stop