@extends ('template')

@section ('main')
	<section class="content-header">
		<h1>Atur Persentase Nilai</h1>
	</section>

	<section class="content">
		@include ('_partials.flash_message')
		<div class="box box-default">
			<div class="box-header with-border">
				<h4 class="box-title">Form</h4>
			</div>
			<div class="box-body">
			{!! Form::model($persentase_nilai, ['method' => 'POST', 'route' => 'dosen.nilai.persentase.perbarui']) !!}
				<div class="row">
					<div class="col-md-3">
						<div class="form-group">
							{!! Form::label('kehadiran', 'Kehadiran', ['class' => 'control-label']) !!}
							<div class="input-group">
								{!! Form::number('kehadiran', null, ['class' => 'form-control']) !!}
								<div class="input-group-addon"><i class="fa fa-percent"></i></div>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							{!! Form::label('tugas', 'Tugas', ['class' => 'control-label']) !!}
							<div class="input-group">
								{!! Form::number('tugas', null, ['class' => 'form-control']) !!}
								<div class="input-group-addon"><i class="fa fa-percent"></i></div>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							{!! Form::label('uts', 'UTS', ['class' => 'control-label']) !!}
							<div class="input-group">
								{!! Form::number('uts', null, ['class' => 'form-control']) !!}
								<div class="input-group-addon"><i class="fa fa-percent"></i></div>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							{!! Form::label('uas', 'UAS', ['class' => 'control-label']) !!}
							<div class="input-group">
								{!! Form::number('uas', null, ['class' => 'form-control']) !!}
								<div class="input-group-addon"><i class="fa fa-percent"></i></div>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						{!! Form::submit('Simpan Perubahan', ['class' => 'btn btn-primary']) !!}
					</div>
				</div>
			</div>
			{!! Form::close() !!}
		</div>
	</section>
@endsection