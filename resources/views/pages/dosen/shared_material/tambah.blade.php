@extends ('template')

@section ('main')
	<section class="content-header">
		<h1>Tambah File Materi</h1>
	</section>

	<section class="content">
		<div class="box box-default">
			<div class="box-header with-border">
				<h4 class="box-title">Form</h4>
			</div>
			<div class="box-body">
				{!! Form::open(['method' => 'POST', 'route' => 'dosen.shared_material.simpan', 'files' => true]) !!}
					@include ('pages.dosen.shared_material.form', ['btn_submit_text' => 'Simpan'])
				{!! Form::close() !!}
			</div>
		</div>
	</section>
@stop