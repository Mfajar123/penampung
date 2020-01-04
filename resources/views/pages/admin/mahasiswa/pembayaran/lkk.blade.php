@extends('template')

@section('style')
	<style>
		.dt-buttons {
			float: left;
			margin-left: 10px;
		}
	</style>
@stop

@section('main')
	<section class="content-header">
		<h1>Laporan</h1>

		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li><a href="#">Pembayaran</a></li>
			<li class="active">Laporan Keuangan Kelulusan </li>
		</ol>
	</section>

	<section class="content">
		<div class="box box-default">
			<div class="box-header with-border">
				<h4 class="box-title">
					Laporan Keuangan Kelulusan
<!-- 					@if (! empty(Request::get('awal')) && ! empty(Request::get('akhir')))
						(Periode {{ date('M-d-Y', strtotime(Request::get('awal'))) }} s/d {{ date('M-d-Y', strtotime(Request::get('akhir'))) }})
					@endif
 -->				</h4>
			</div>
			<div class="box-body">
				{!! Form::model(Request::all(), ['method' => 'GET']) !!}
					<div class="row">
<!-- 						<div class="col-md-3">
							<div class="form-group">
								{!! Form::label('awal', 'Dari Tanggal', ['class' => 'control-label']) !!}
								{!! Form::date('awal', null, ['class' => 'form-control']) !!}
							</div>
						</div>-->
						<div class="col-md-3">
							<div class="form-group">
								{!! Form::label('tahun_akademik', 'Tahun Akademik', ['class' => 'control-label']) !!}
								{!! Form::select('tahun_akademik', $list_tahun_akademik, null, ['placeholder' => '- Semua -', 'class' => 'form-control']) !!}
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								{!! Form::label('id_prodi', 'Program Studi', ['class' => 'control-label']) !!}
								{!! Form::select('id_prodi', $list_prodi, null, ['placeholder' => '- Semua -', 'class' => 'form-control']) !!}
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								{!! Form::label('status', 'Status', ['class' => 'control-label']) !!}
								{!! Form::select('status', $list_status, null, ['placeholder' => '- Semua -', 'class' => 'form-control']) !!}
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								{!! Form::label('tahun', 'Angkatan', ['class' => 'control-label']) !!}
								<?php
									$now=date('Y');
									echo "<select class='form-control' name='angkatan'>";
									echo "<option value>- semua -</option>";
									for ($a=2018;$a<=$now;$a++)
									{
										if($list_angkatan == $a){
									     echo "<option value='$a' selected>$a</option>";
										}else{
									     echo "<option value='$a'>$a</option>";
										}
									}
									echo "</select>";
								?>
							</div>
						</div> 
						<div class="col-md-3">
							<div class="form-group form-group form-group-action">
								<label style="display: block">&nbsp;</label>
								{!! Form::submit('Tampilkan', ['class' => 'btn btn-default pull-left']) !!}
							</div>
						</div>
					</div>
				{!! Form::close() !!}
					<table class="table table-striped table-bordered datatable-custom">
						<thead>
							<tr>
								<th>No</th>
								<th>ID Daftar</th>
								<th>NIM</th>
								<th>Nama Calon Mahasiswa</th>
								<th>Prodi</th>
								<th>Diskon Promo</th>
								<th>Bayar</th>
								<th>Sisa</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$no = 1;
								$total_bayar = 0;
							?>
							@if (! empty($pembayaran))
								@foreach ($pembayaran as $bayar)
									<tr>
										<td></td>
										<td>{{ $bayar->id_daftar }}</td>
										<td>{{ $bayar->nim }}</td>
										<td>{{ $bayar->nama }}</td>
										<td>{{ $bayar->nama_prodi }}</td>
										<td align="right">{{ number_format($bayar->diskon) }}</td>
										<td align="right">{{ number_format($bayar->jum_bayar) }}</td>
										<td align="right">{{ number_format($bayar->sisa) }}</td>
										<td>{{ $bayar->status_pembayaran }}</td>
									</tr>
									<?php $total_bayar += @$bayar->bayar_kelulusan; ?>
								@endforeach
							@elseif (! empty(@$pembayaran_pindahan))
								@foreach($pembayaran_pindahan as $bayar)
									<tr>
										<td></td>
										<td>{{ $bayar->id_daftar }}</td>
										<td>{{ $bayar->nim }}</td>
										<td>{{ $bayar->nama }}</td>
										<td>{{ $bayar->nama_prodi }}</td>
										<td> - </td>
										<td align="right">{{ number_format($bayar->bayar_masuk) }}</td>
										<td align="right">{{ number_format($bayar->sisa) }}</td>
										<td>{{ $bayar->status_pembayaran }}</td>
									</tr>
									<?php $total_bayar += @$bayar->bayar_masuk; ?>
								@endforeach
							@endif
						</tbody>
<!-- 						<tfoot>
							<tr bgcolor="#CCC">
								<th colspan="6" class="text-right">Total</th>
								<th></th>
								<th></th>
								<th></th>
							</tr>
						</tfoot>
 -->					</table>
			</div>
		</div>
	</section>
@stop

@section('script')
	<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>

	<script type="text/javascript">
		var datatableCustom = $('.datatable-custom').DataTable({
			'columnDefs': [{
				'searchable': false,
				'orderable': false,
				'targets': 0
			}],
			'order': [[ 1, 'asc' ]],
			'footerCallback': function ( row, data, start, end, display ) {
				var api = this.api(), data;
	
				var intVal = function (i) {
					return typeof i === 'string' ?
						i.replace(/[\$,]/g, '')*1 :
						typeof i === 'number' ?
							i : 0;
				};

				// pageTotal = api
				// 	.column(6, { page: 'current'} )
				// 	.data()
				// 	.reduce(function (a, b) {
				// 		return intVal(a) + intVal(b);
				// 	}, 0);
	
				// $(api.column(6).footer()).html(pageTotal);

				// pageSisa = api
				// 	.column(7, { page: 'current'} )
				// 	.data()
				// 	.reduce(function (a, b) {
				// 		return intVal(a) + intVal(b);
				// 	}, 0);
	
				// $(api.column(7).footer()).html(pageSisa);
			}
		});
		
		datatableCustom.on('order.dt search.dt', function () {
			datatableCustom.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
				cell.innerHTML = i+1;
			});
		}).draw();

		var buttons = new $.fn.dataTable.Buttons(datatableCustom, {
				buttons: [
					{
						extend: 'excel',
						text: 'Export to Excel',
						className: 'btn btn-default'
					}
				]
			}).container().appendTo($('.form-group-action'));
	</script>
@stop
