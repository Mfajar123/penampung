@extends('template')

@section('main')
	<section class="content-header">
		<h1><i class="fa fa-print"></i> Cetak Jadwal Ujian</h1>
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
						<a href="#" class="btn btn-success" target="_blank"><i class="fa fa-print"></i> Cetak Kartu Ujian</a>
					@endif
				</div>
			@endif
		</div>
	</section>
@stop