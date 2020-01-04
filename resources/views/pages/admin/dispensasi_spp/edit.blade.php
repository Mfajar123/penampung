@extends('template')

@section('main')
	<section class="content-header">
		<h1>Edit Dispensasi SPP</h1>
	</section>

	<section class="content">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h4 class="box-title">Form</h4>
			</div>
			<div class="box-body">
				{!! Form::model($dispensasi, ['method' => 'PATCH', 'route' => ['admin.dispensasi_spp.perbarui', $dispensasi->id_dispensasi]]) !!}
					@include('pages.admin.dispensasi_spp.form', ['btnSubmitText' => 'Perbarui'])
				{!! Form::close() !!}
			</div>
		</div>
	</section>
@stop