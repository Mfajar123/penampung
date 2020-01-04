@extends ('template')

@section ('main')	
	<section class="content-header">
		<h1>Pembayaran SPP</h1>
	</section>

	<section class="content">
		@include('_partials.flash_message')
		<div class="box box-default">
			<div class="box-header with-border">
				<a href="{{ route('admin.pembayaran_spp.transaksi') }}" class="btn btn-primary">Transaksi Pembayaran SPP</a>
				<button type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" class="btn btn-primary"><i class="fa fa-filter"></i> Filter</button>
				<div class="collapse" id="collapseExample">
					<p>
						<div class="well">
							{!! Form::open(['method' => 'POST', 'id' => 'form_filter']) !!}
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											{!! Form::label('tahun_akademik', 'Tahun Akademik', ['class' => 'control-label']) !!}
											{!! Form::select('tahun_akademik', $list_tahun_akademik, null, ['class' => 'form-control select-custom', 'style' => 'width: 100%']) !!}
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										{!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
									</div>
								</div>
							{!! Form::close() !!}
						</div>
					</p>
				</div>
			</div>
			<div class="box-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-mahasiswa">
						<thead>
							<tr>
								<th width="5">No.</th>
								<th nowrap>Mahasiswa</th>
								<th nowrap>Aksi</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
		</div>
	</section>

	<div class="modal fade" id="modal-detail-pembayaran">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Detail Pembayaran SPP</h4>
				</div>
				<div class="modal-body">
					{!! Form::hidden('nim') !!}

					<div class="form-group">
						{!! Form::label('id_tahun_akademik', 'Tahun Akademik', ['class' => 'control-label']) !!}
						{!! Form::select('id_tahun_akademik', [], null, ['class' => 'form-control select-custom']) !!}
					</div>
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-detail-pembayaran">
							<thead>
								<tr>
									<th width="30">No.</th>
									<th nowrap>Bulan</th>
									<th nowrap>Status</th>
									<th nowrap>Bayar</th>
									<th nowrap>Tanggal Dispensasi</th>
									<th nowrap>Tanggal bayar</th>
									<th nowrap>Keterangan</th>
									<th width="100">Aksi</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal-bayar-2">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Pembayaran SPP</h4>
				</div>
				{!! Form::open(['method' => 'POST', 'id' => 'frm_pembayaran_spp', 'route' => 'admin.pembayaran_spp.simpan_index_page']) !!}
					<div class="modal-body">
						{!! Form::hidden('nim', null) !!}
						{!! Form::hidden('bulan', null, ['id' => 'bulan']) !!}
						{!! Form::hidden('id_tahun_akademik', null) !!}
	
						<div class="form-group">
							{!! Form::label('tanggal', 'Tanggal', ['class' => 'control-label']) !!}
							{!! Form::text('tanggal', date('d-M-Y', strtotime(\Carbon\Carbon::today())), ['class' => 'form-control datepicker'	]) !!}
						</div>
						<div class="form-group">
							{!! Form::label('bayar', 'Bayar', ['class' => 'control-label']) !!}
							{!! Form::number('bayar', null, ['id' => 'input_bayar', 'class' => 'form-control', 'required']) !!}
						</div>
						<div class="form-group">
							{!! Form::label('keterangan', 'Keterangan (optional)', ['class' => 'control-label']) !!}
							{!! Form::textarea('keterangan', null, ['id' => 'textarea_keterangan', 'rows' => 3, 'class' => 'form-control']) !!}
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary" data-loading-text="Loading..." id="btn_simpan_transaksi">Simpan Transaksi</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
@stop

@section ('script')
	<script type="text/javascript">
		function view_detail_pembayaran(nim) {
			var id_tahun_akademik = $("#modal-detail-pembayaran").find("select[name='id_tahun_akademik']").val();
			var table = $(".table-detail-pembayaran").find("tbody");

			table.html("");
			table.append("<tr><td colspan='3'>Loading...</td></tr>");

			$.ajax({
				url: "{{ route('admin.pembayaran_spp') }}/"+nim+"/"+id_tahun_akademik+"/get_pembayaran_spp",
				type: "GET",
				dataType: "json",
				success: function (data) {
					if (data.status == 'success') {
						table.html("");

						$("#modal-bayar-2").find("input[type='hidden'][name='nim']").val(nim);

						$.each (data.pembayaran_spp, function (key, val) {
							if (val.status == "<span class='text-danger'>Belum Bayar</span>") {
								var btn_bayar = "<a class='btn btn-primary btn-sm btn-bayar' data-bulan='"+val.key_bulan+"'>Bayar</a>";
							} else {
								// var btn_bayar = "Lunas";
								var btn_bayar = "<a href='{{ route('admin.pembayaran_spp') }}/"+val.id_pembayaran_spp+"/hapus_pembayaran_spp' class='btn btn-danger btn-sm'>Hapus</a>";
							}

							table.append("<tr>\
								<td>"+val.no+"</td>\
								<td>"+val.bulan+"</td>\
								<td>"+val.status+"</td>\
								<td>"+val.bayar+"</td>\
								<td>"+val.tanggal_dispensasi+"</td>\
								<td>"+val.tanggal+"</td>\
								<td>"+val.keterangan+"</td>\
								<td>"+btn_bayar+"</td>\
							</tr>");
						});
					}
				}
			});
		}

		$(document).ready(function () {
			$(".select-custom").select2({ width: '100%' });

			var table = $(".table-mahasiswa").DataTable({
				processing: true,
				serverSide: true,
				ajax: "{{ route('admin.pembayaran_spp.datatable') }}",
				columns: [
					{'data': 'no'},
					{'data': 'nim_nama'},
					{'data': 'aksi'}
				],
			});

			$("#form_filter").on("submit", function (e) {
				e.preventDefault();

				var formData = $(this).serialize();

				table.ajax.url("{{ route('admin.pembayaran_spp.datatable') }}?" + formData).load();
			});

			$(".table-detail-pembayaran").on("click", ".btn-bayar", function (e) {
				e.preventDefault();

				$("#bulan").val(this.getAttribute('data-bulan'));
				$("input[type='hidden'][name='id_tahun_akademik']").val($("#modal-detail-pembayaran").find("select[name='id_tahun_akademik']").val());
				$("#input_bayar").val("");
				$("#textarea_keterangan").val("");

				$("#modal-bayar-2").modal("show");
			});

			$(".table-detail-pembayaran").on("click", ".btn-hapus", function (e) {
				e.preventDefault();

				$.ajax({
					url: "{{ route('admin.pembayaran_spp') }}"+"/hapus",
					type: "POST",
					success: function (data) {
						console.log(data);
					}
				});
			});

			$(".table-mahasiswa").on("click", ".btn-detail-pembayaran", function (e) {
				e.preventDefault();

				var nim = $("#modal-detail-pembayaran").find("input[name='nim'][type='hidden']").val($(this).val());
				var select_tahun_akademik = $("#modal-detail-pembayaran").find("select[name='id_tahun_akademik']");

				select_tahun_akademik.html("");

				$.ajax({
					url: "{{ route('admin.pembayaran_spp') }}/"+$(nim).val()+"/get_tahun_akademik",
					type: "GET",
					dataType: "json",
					success: function (data) {
						if (data.status == 'success') {
							$.each(data.tahun_akademik, function (key, val) {
								select_tahun_akademik.append("<option value='"+val.id_tahun_akademik+"'>"+val.keterangan+"</option>");
							});

							view_detail_pembayaran($(nim).val());
						}
					}
				});

				$("#modal-detail-pembayaran").modal("show");
			});

			$("#modal-detail-pembayaran").on("change", "select[name='id_tahun_akademik']", function (e) {
				e.preventDefault();

				var nim = $("#modal-detail-pembayaran").find("input[name='nim'][type='hidden']").val();

				view_detail_pembayaran(nim);
			});

		});
	</script>
@stop