@extends ('template')

@section ('main')
	<section class="content-header">
		<h1>Tambah Dosen Penasihat Akademik</h1>

		<ol class="breadcrumb">
			<li><a href="#">Home</a></li>
			<li class="active">Tambah Dosen Penasihat</li>
		</ol>
	</section>

	<section class="content">
		<div class="box box-default">
			<div class="box-header with-border">
				<h4 class="box-title">Form</h4>
			</div>
			<div class="box-body">
				{!! Form::open(['method' => 'POST', 'route' => 'admin.dosen.pa.simpan']) !!}
					@include ('pages.admin.dosen_pa.form', ['btn_submit_text' => 'Simpan'])
				{!! Form::close() !!}
			</div>
		</div>
	</section>
@stop