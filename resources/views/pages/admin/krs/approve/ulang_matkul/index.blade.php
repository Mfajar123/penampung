@extends('template')

@section('main')
	<section class="content-header">
		<h1>Approve KRS (Ulang Mata Kuliah)</h1>
	</section>

	<section class="content">
		@include('_partials.flash_message')
		<div class="nav-tabs-custom">
			<div class="nav nav-tabs">
				<li>
					<a href="{{ route('admin.krs.approve.index') }}">Approve KRS</a>
				</li>
				<li class="active">
					<a href="#">Approve KRS (Ulang Mata Kuliah)</a>
				</li>
			</div>
			<div class="tab-content">
				<div class="tab-pane active">
					<table class="table table-striped table-bordered table-approve">
						<thead>
							<tr>
								<th width="30">No.</th>
								<th nowrap>Mahasiswa</th>
								<th nowrap>Dosen PA</th>
								<th nowrap>Tahun Akademik</th>
								<th nowrap>Aksi</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
		</div>
	</section>

	<div class="modal fade modal-detail-krs" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title"><i class="fa fa-search"></i> Detail KRS</h4>
				</div>
				<div class="modal-body">
					<table class="table table-striped table-detail-krs">
						<thead>
							<tr>
								<th>Kode Mata Kuliah</th>
								<th>Nama Mata Kuliah</th>
								<th>SKS</th>
								<th>Kelas</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
@stop

@section('script')
	<script type="text/javascript">
		function confirm_approve() {
			return confirm("Anda yakin ingin melakukan approve?");
		}
		
		$(document).ready(function () {
			$(".table-approve").DataTable({
				processing: true,
				serverSide: true,
				ajax: "{{ route('admin.krs.approve.datatable_ulang_matkul') }}",
				columns: [
					{'data': 'no'},
					{'data': 'nim_nama'},
					{'data': 'nip_nama'},
					{'data': 'tahun_akademik'},
					{'data': 'aksi'},
				]
			});

			$(".table-approve").on("click", ".btn-detail", function (e) {
				e.preventDefault();

				var button = $(this);
				var modal_detail_krs = $(".modal-detail-krs");
				var table_detail_krs = $(".table-detail-krs").find("tbody");

				$(table_detail_krs).html("");
				$(button).button('loading');

				$.ajax({
					url: "{{ route('admin.krs.approve.get_detail_krs_ulang_matkul') }}",
					type: "POST",
					data: {
						id_krs: $(button).val()
					},
					success: function (data) {
						$(button).button('reset');

						if (data.status === 'success') {
							$.each(data.krs_item, function (key, val) {
								$("<tr>\
									<td>"+val.kode_matkul+"</td>\
									<td>"+val.nama_matkul+"</td>\
									<td>"+val.sks+"</td>\
									<td>"+val.nama_kelas+"</td>\
								</tr>").appendTo(table_detail_krs);
							});

							$(modal_detail_krs).modal("show");
						}
					}
				});
			});
		});
	</script>
@stop