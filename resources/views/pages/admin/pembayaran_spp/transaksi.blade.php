@extends ('template')

@section ('main')	
	<section class="content-header">
		<h1>Transaksi Pembayaran SPP</h1>
	</section>

	<section class="content">
		@include ('_partials.flash_message')
		<div class="box box-default">
			<div class="box-header with-border">
				<h4 class="box-title">Form</h4>
			</div>
			<div class="box-body">
				@include ('pages.admin.pembayaran_spp.form', ['btn_submit_text' => 'Simpan Transaksi'])
			</div>
		</div>
	</section>
@stop