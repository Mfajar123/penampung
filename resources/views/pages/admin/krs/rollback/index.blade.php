@extends('template')

@section('main')
	<section class="content-header">
		<h1>Rollback Waktu Kuliah</h1>
	</section>

	<section class="content">
		@include('_partials.flash_message')
		<div class="box box-default">
			<div class="box-header with-border">
				<h4 class="box-title">Data</h4>
			</div>
			<div class="box-body">
				<table class="table table-striped table-bordered table-rollback">
					<thead>
						<tr>
							<th width="30">No.</th>
							<th nowrap>Mahasiswa</th>
							<th nowrap>Tahun Akademik</th>
							<th nowrap>Waktu Kuliah</th>
							<th nowrap>Status</th>
							<th width="150">Aksi</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</section>

	<div class="modal fade modal-rollback-krs" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title"><i class="fa fa-repeat"></i> Form Rollback Waktu Kuliah</h4>
				</div>
				{!! Form::open(['method' => 'POST', 'route' => 'admin.krs.rollback.rollback']) !!}
				<div class="modal-body">
					{!! Form::hidden('id') !!}

					<div class="form-group">
						{!! Form::label('id_waktu_kuliah', 'Waktu Kuliah', ['class' => 'control-label']) !!}
						{!! Form::select('id_waktu_kuliah', $list_waktu_kuliah, null, ['class' => 'form-control']) !!}
					</div>
				</div>
				<div class="modal-footer">
					{!! Form::submit('Simpan', ['class' => 'btn btn-primary']) !!}
					<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
				</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>

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
		$(document).ready(function () {
			$(".table-rollback").DataTable({
				processing: true,
				serverSide: true,
				ajax: "{{ route('admin.krs.rollback.datatable') }}",
				columns: [
					{'data': 'no'},
					{'data': 'nim_nama'},
					{'data': 'keterangan'},
					{'data': 'nama_waktu_kuliah'},
					{'data': 'status'},
					{'data': 'aksi'}
				]
			});

			$(".table-rollback").on("click", ".btn-rollback", function (e) {
				e.preventDefault();

				var button = $(this);
				var modal_rollback_krs = $(".modal-rollback-krs");
				var form_rollback = $(".modal-rollback-krs").find("form");

				$(form_rollback).find("input[name='id']").val($(button).val());
				$(button).button('loading');

				$.ajax({
					url: "{{ route('admin.krs.rollback.get_waktu_kuliah') }}",
					type: "POST",
					data: {
						id_krs: $(button).val()
					},
					success: function (data) {
						$(button).button('reset');

						if (data.status === 'success') {
							$(form_rollback).find("select[name='id_waktu_kuliah']").val(data.id_waktu_kuliah).change();
							$(modal_rollback_krs).modal("show");
						}
					}
				});
			});

			$(".table-rollback").on("click", ".btn-detail", function (e) {
				e.preventDefault();

				var button = $(this);
				var modal_detail_krs = $(".modal-detail-krs");
				var table_detail_krs = $(".table-detail-krs").find("tbody");

				$(table_detail_krs).html("");
				$(button).button('loading');

				$.ajax({
					url: "{{ route('admin.krs.approve.get_detail_krs') }}",
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