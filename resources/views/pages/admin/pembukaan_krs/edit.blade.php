@extends ('template')

@section ('main')
	<style>.table{margin-bottom:0px;}</style>

	<section class="content-header">
		<h1>Edit Pembukaan KRS</h1>

		<ol class="breadcrumb">
			<li><a href="#">Home</a></li>
			<li>Edit Pembukaan KRS</li>
		</ol>
	</section>

	<section class="content">
		<div class="box box-default">
			<div class="box-header with-border">
				<h4 class="box-title">Form Edit</h4>
			</div>
			<div class="box-body">
				{!! Form::model($pembukaan_krs, ['method' => 'PATCH', 'route' => ['admin.setting.pembukaan_krs.perbarui', $pembukaan_krs->id_pembukaan_krs]]) !!}
					@include ('pages.admin.pembukaan_krs.form', ['btn_submit_text' => 'Perbarui'])
				{!! Form::close() !!}
			</div>
		</div>
	</section>
@stop