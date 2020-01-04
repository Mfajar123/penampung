@extends ('template')

@section ('main')
	<style>.table-spp{margin-bottom:0px}</style>

	<section class="content-header">
		<h1>Pembayaran SPP</h1>
	</section>

	<section class="content">
		<div class="box box-default">
			<div class="box-header with-border">
				<div class="form-inline">
					<div class="form-group">
						{!! Form::select('id_tahun_akademik', $list_tahun_akademik, null, ['id' => 'select_tahun_akademik', 'placeholder' => '- Pilih Tahun Akademik -', 'class' => 'form-control select-custom']) !!}
					</div>
				</div>
			</div>
			<div class="box-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-spp">
						<thead>
							<tr>
								<th width="30">No.</th>
								<th nowrap>Bulan</th>
								<th nowrap>Status</th>
								<th nowrap>Bayar</th>
								<th nowrap>Tanggal bayar</th>
								<th nowrap>Keterangan</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
		</div>
	</section>
@stop

@section ('script')
	<script type="text/javascript">
		function view_pembayaran() {
			var id_tahun_akademik = $("#select_tahun_akademik").val();
			var table = $(".table-spp").find("tbody");

			table.html("");
			table.append("<tr><td colspan='7'>Loading...</td></tr>")

			$.ajax({
				url: "{{ route('mahasiswa.pembayaran_spp') }}/"+id_tahun_akademik+"/get_pembayaran_spp",
				type: "GET",
				dataType: "json",
				success: function (data) {
					if (data.status == 'success') {
						table.html("");

						$.each (data.pembayaran_spp, function (key, val) {
							table.append("<tr>\
								<td>"+val.no+"</td>\
								<td>"+val.bulan+"</td>\
								<td>"+val.status+"</td>\
								<td>"+val.bayar+"</td>\
								<td>"+val.tanggal+"</td>\
								<td>"+val.keterangan+"</td>\
							</tr>");
						});
					}
				}
			});
		}

		$(document).ready(function () {
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			$("#select_tahun_akademik").change(function (e) {
				view_pembayaran();

				e.preventDefault();
			});
		});
	</script>
@stop