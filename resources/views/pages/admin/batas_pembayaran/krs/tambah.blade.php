@extends('template')

@section('main')
	<section class="content-header">
		<h1>Tambah Batas Pembayaran KRS</h1>
	</section>

	<section class="content">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h4 class="box-title">Form</h4>
			</div>
			<div class="box-body">
				{!! Form::open(['method' => 'POST', 'route' => 'admin.batas_pembayaran.krs.simpan']) !!}
					@include('pages.admin.batas_pembayaran.krs.form', ['btn_submit_text' => 'Simpan'])
				{!! Form::close() !!}
			</div>
		</div>
	</section>
@stop