@extends('template')

@section('main')
	<section class="content-header">
		<h1>Edit Batas Pembayaran Ujian</h1>
	</section>

	<section class="content">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h4 class="box-title">Form</h4>
			</div>
			<div class="box-body">
				{!! Form::model($batas_pembayaran, ['method' => 'PATCH', 'route' => ['admin.batas_pembayaran.ujian.perbarui', $batas_pembayaran->id]]) !!}
					@include('pages.admin.batas_pembayaran.ujian.form', ['btn_submit_text' => 'Perbarui'])
				{!! Form::close() !!}
			</div>
		</div>
	</section>
@stop