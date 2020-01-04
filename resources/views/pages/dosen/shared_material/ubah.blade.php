@extends ('template')

@section ('main')
	<section class="content-header">
		<h1>Ubah File Materi</h1>
	</section>

	<section class="content">
		<div class="box box-default">
			<div class="box-header with-border">
				<h4 class="box-title">Form</h4>
			</div>
			<div class="box-body">
				{!! Form::model($shared_material, ['method' => 'PATCH', 'route' => ['dosen.shared_material.perbarui', $shared_material->id_shared_material], 'files' => true]) !!}
					@include ('pages.dosen.shared_material.form', ['btn_submit_text' => 'Perbarui'])
				{!! Form::close() !!}
			</div>
		</div>
	</section>
@stop