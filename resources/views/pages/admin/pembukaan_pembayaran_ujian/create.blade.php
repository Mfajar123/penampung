@extends ('template')

@section ('main')
	<style>.table{margin-bottom:0px;}</style>

	<section class="content-header">
		<h1>Tambah Pembukaan Pembayaran Ujian</h1>

		<ol class="breadcrumb">
			<li><a href="#">Home</a></li>
			<li>Tambah Pembukaan Pembayaran Ujian</li>
		</ol>
	</section>

	<section class="content">
		<div class="box box-default">
			<div class="box-header with-border">
				<h4 class="box-title">Form Tambah</h4>
			</div>
			<div class="box-body">
				{!! Form::open(['method' => 'POST', 'route' => 'admin.setting.pembukaan_pembayaran_ujian.simpan']) !!}
					@include ('pages.admin.pembukaan_pembayaran_ujian.form', ['btn_submit_text' => 'Simpan'])
				{!! Form::close() !!}
			</div>
		</div>
	</section>
@stop