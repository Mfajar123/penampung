<div class="form-group">
	{!! Form::label('nim', 'Mahasiswa', ['class' => 'control-label']) !!}
	{!! Form::select('nim', $list_mahasiswa, null, ['id' => 'select_mahasiswa', 'placeholder' => '- Pilih Mahasiswa -', 'class' => 'form-control select-custom', 'required']) !!}
</div>

<div class="form-group">
	{!! Form::label('id_tahun_akademik', 'Tahun Akademik', ['class' => 'control-label']) !!}
	{!! Form::select('id_tahun_akademik', [], null, ['id' => 'select_tahun_akademik', 'placeholder' => '- Pilih Tahun Akademk -', 'class' => 'form-control select-custom', 'required']) !!}
</div>

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
				<th width="150">Aksi</th>
			</tr>
		</thead>
		<tbody></tbody>
	</table>
</div>

<a href="{{ route('admin.pembayaran_spp') }}" class="btn btn-default">Kembali</a>

<div class="modal fade" id="modal-bayar">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Pembayaran SPP</h4>
			</div>
			{!! Form::open(['method' => 'POST', 'id' => 'frm_pembayaran_spp']) !!}
				<div class="modal-body">
					{!! Form::hidden('bulan', null, ['id' => 'bulan']) !!}

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


@section ('script')
	<script type="text/javascript">
		function view_pembayaran() {
			var nim = $("#select_mahasiswa").val();
			var id_tahun_akademik = $("#select_tahun_akademik").val();
			var table = $(".table-spp").find("tbody");

			table.html("");
			table.append("<tr><td colspan='7'>Loading...</td></tr>")

			$.ajax({
				url: "{{ route('admin.pembayaran_spp') }}/"+nim+"/"+id_tahun_akademik+"/get_pembayaran_spp",
				type: "GET",
				dataType: "json",
				success: function (data) {
					if (data.status == 'success') {
						table.html("");

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
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			$("#select_mahasiswa").change(function (e) {
				var nim = this.value;
				var select_tahun_akademik = $("#select_tahun_akademik");
				var table = $(".table-spp").find("tbody");

				select_tahun_akademik.html("");
				select_tahun_akademik.append("<option value=''>- Pilih Tahun Akademik -</option>");
				
				table.html("");

				$.ajax({
					url: "{{ route('admin.pembayaran_spp') }}/"+nim+"/get_tahun_akademik",
					type: "GET",
					dataType: "json",
					success: function (data) {
						if (data.status == 'success') {
							$.each(data.tahun_akademik, function (key, val) {
								select_tahun_akademik.append("<option value='"+val.id_tahun_akademik+"'>"+val.keterangan+"</option>");
							});
						}
					}
				});
				
				e.preventDefault();
			});

			$("#select_tahun_akademik").change(function (e) {
				view_pembayaran();

				e.preventDefault();
			});

			$("#frm_pembayaran_spp").submit(function (e) {
				var formData = new FormData();

				$("#btn_simpan_transaksi").button('loading');

				formData.append('nim', $("#select_mahasiswa").val());
				formData.append('id_tahun_akademik', $("#select_tahun_akademik").val());
				formData.append('bayar', $("#input_bayar").val());
				formData.append('keterangan', $("#textarea_keterangan").val());
				formData.append('bulan', $("#bulan").val());

				$.ajax({
					url: "{{ route('admin.pembayaran_spp.simpan') }}",
					type: "POST",
					data: formData,
					dataType: "JSON",
					processData: false,
					contentType: false,
					cache: false,
					success: function (data) {
						if (data.status == 'success') {
							$("#btn_simpan_transaksi").button('reset');
							$("#modal-bayar").modal('hide');
							view_pembayaran();
						}
					}
				});
				
				e.preventDefault();
			});

			$(".table-spp").find("tbody").on("click", ".btn-bayar", function(e) {
				$("#bulan").val(this.getAttribute('data-bulan'));
				$("#input_bayar").val("");
				$("#textarea_keterangan").val("");

				$("#modal-bayar").modal('show');

				e.preventDefault();
			});
		});
	</script>
@stop