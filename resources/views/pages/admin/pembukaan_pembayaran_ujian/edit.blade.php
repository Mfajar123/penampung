@extends ('template')

@section ('main')
	<style>.table{margin-bottom:0px;}</style>

	<section class="content-header">
		<h1>Edit Pembukaan Pembayaran Ujian</h1>

		<ol class="breadcrumb">
			<li><a href="#">Home</a></li>
			<li>Edit Pembukaan Pembayaran Ujian</li>
		</ol>
	</section>

	<section class="content">
		<div class="box box-default">
			<div class="box-header with-border">
				<h4 class="box-title">Form Edit</h4>
			</div>
			<div class="box-body">
				{!! Form::model($pembukaan_pembayaran_ujian, ['method' => 'PATCH', 'route' => ['admin.setting.pembukaan_pembayaran_ujian.perbarui', $pembukaan_pembayaran_ujian->id_pembukaan_pembayaran_ujian]]) !!}
					@include ('pages.admin.pembukaan_pembayaran_ujian.form', ['btn_submit_text' => 'Perbarui'])
				{!! Form::close() !!}
			</div>
		</div>
	</section>
@stop