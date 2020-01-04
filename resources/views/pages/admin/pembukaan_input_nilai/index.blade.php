@extends ('template')

@section ('main')
	<section class="content-header">
		<h1>Setting Pembukaan Nilai</h1>
	</section>

	<section class="content">
		@include ('_partials.flash_message')
		<div class="box box-default">
			<div class="box-header with-border">
				<h4 class="box-title">Form</h4>
			</div>
			<div class="box-body">
				{!! Form::model($pembukaan_input_nilai, ['method' => 'POST', 'route' => 'admin.setting.pembukaan_input_nilai.store']) !!}
					@include ('pages.admin.pembukaan_input_nilai.form', ['btn_submit_text' => 'Update'])
				{!! Form::close() !!}
			</div>
		</div>
	</section>
@stop