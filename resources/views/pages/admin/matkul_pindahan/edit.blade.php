@extends ('template')

@section ('main')
	<section class="content-header">
		<h1>Edit Matkul Pindahan</h1>
	</section>

	<section class="content">
		<div class="box box-default">
			<div class="box-header with-border">
				<h4 class="box-title">Form</h4>
			</div>
			<div class="box-body">
				{!! Form::model($matkul_pindahan, ['method' => 'POST', 'route' => ['admin.matkul_pindahan.perbarui', $imp, $idmp, $nim], 'files' => 'true']) !!}
					@include ('pages.admin.matkul_pindahan.form', ['btn_submit_text' => 'Simpan'])
				{!! Form::close() !!}
			</div>
		</div>
	</section>
@stop