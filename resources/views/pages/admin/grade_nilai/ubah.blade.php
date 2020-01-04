@extends ('template')

@section ('main')
	<section class="content-header">
		<h1>Ubah Grade Nilai</h1>

		<ol class="breadcrumb">
			<li><a href="#">Home</a></li>
			<li class="active">Grade Nilai</li>
		</ol>
	</section>

	<section class="content">
		<div class="box box-default">
			<div class="box-header with-border">
				<h4 class="box-title">Form</h4>
			</div>
			<div class="box-body">
				{!! Form::open(['method' => 'PATCH', 'route' => ['admin.grade_nilai.perbarui', $tahun_akademik]]) !!}
					@include ('pages.admin.grade_nilai.form', ['btn_submit_text' => 'Perbarui'])
				{!! Form::close() !!}
			</div>
		</div>
	</section>
@stop