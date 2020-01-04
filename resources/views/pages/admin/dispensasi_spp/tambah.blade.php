@extends('template')

@section('main')
	<section class="content-header">
		<h1>Tambah Dispensasi SPP</h1>
	</section>

	<section class="content">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h4 class="box-title">Form</h4>
			</div>
			<div class="box-body">
				{!! Form::open(['method' => 'POST', 'route' => 'admin.dispensasi_spp.simpan']) !!}
					@include('pages.admin.dispensasi_spp.form', ['btnSubmitText' => 'Simpan'])
				{!! Form::close() !!}
			</div>
		</div>
	</section>
@stop