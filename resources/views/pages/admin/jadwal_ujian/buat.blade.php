@extends ('template')

@section ('main')
	<section class="content-header">
		<h1>Buat Jadwal Ujian</h1>
	</section>

	<section class="content">
		<div class="box box-default">
			<div class="box-header with-border">
				<h4 class="box-title">Form</h4>
			</div>
			<div class="box-body">
				{!! Form::open(['method' => 'POST', 'id' => 'frm_buat', 'files' => true]) !!}
					@include ('pages.admin.jadwal_ujian.form', ['btn_submit_text' => 'Simpan'])
				{!! Form::close() !!}
			</div>
		</div>
	</section>
@stop