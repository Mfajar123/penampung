@extends('template')

@section('style')
	<style>
		.select-custom {
			width:300px
		}
		.table {
			margin-bottom: 0px;
		}
	</style>
@stop

@section('main')
	<section class="content-header">
		<h1>KRS</h1>
	</section>

	<section class="content">
		@include('_partials.flash_message')
		<div class="nav-tabs-custom">
			<div class="nav nav-tabs">
				<li class="active">
					<a href="#">KRS</a>
				</li>
				<li>

					<a href="{{ route('mahasiswa.krs.ulang') }}" @if ($ulang == 0) onclick="return false;" @endif>KRS Ulang Mata Kuliah</a>
				</li>
			</div>
			<div class="tab-content">
				<div class="tab-pane active">
				{!! Form::select('tahun_akademik', $list_tahun_akademik, null, ['placeholder' => '- Pilih Tahun Akademik -', 'class' => 'select-custom']) !!}
				@if (! empty($pembukaan_krs))
					<a href="{{ route('mahasiswa.krs.tambah') }}" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Input KRS</a>
				@endif
					<table class="table table-striped table-bordered table-approve">
						<thead>
							<tr>
								<th width="30">No.</th>
								<th nowrap>	Kode Mata Kuliah</th>
								<th nowrap>Nama Mata Kuliah</th>
								<th nowrap>SKS</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
		</div>
	</section>

	<!--
	<section class="content">
		@if(empty($pembukaan_krs))
		<div class="alert alert-info alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4><i class="fa fa-info"></i> Info</h4>
			Maaf KRS sudah ditutup.
		</div>
		@endif
		<div class="box box-primary">
			<div class="box-header with-border">
				{!! Form::select('tahun_akademik', $list_tahun_akademik, null, ['placeholder' => '- Pilih Tahun Akademik -', 'class' => 'select-custom']) !!}
				@if (! empty($pembukaan_krs))
					<a href="{{ route('mahasiswa.krs.tambah') }}" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Input KRS</a>
				@endif
			</div>
			<div class="box-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered">
						<thead>
							<tr>
								<th width="30">No.</th>
								<th nowrap>Kode Mata Kuliah</th>
								<th nowrap>Nama Mata Kuliah</th>
								<th nowrap>SKS</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
		</div>
	</section>
	-->
@stop

@section('script')
	<script type="text/javascript">
		function get_krs() {
			var tahun_akademik = $("select[name='tahun_akademik']").val();
			var table = $(".table").find("tbody");

			if (tahun_akademik !== '') {
				table.html("<tr><td colspan='4'>Loading...</td></tr>");

				$.ajax({
					type: "POST",
					url: "{{ route('mahasiswa.krs.get_krs') }}",
					data: {'tahun_akademik': tahun_akademik},
					success: function (data) {
						console.log(data);
						table.html("");

						if (data.status === 'success') {
							$.each(data.data.krs_item, function (key, val) {
								$("<tr>\
									<td>"+val.no+"</td>\
									<td>"+val.kode_matkul+"</td>\
									<td>"+val.nama_matkul+"</td>\
									<td>"+val.sks+"</td>\
								</tr>").appendTo(table);
							});

							var status = "";

							if (data.data.status === 'Y') {
								status = "<span class='text-success'>Sudah Disetujui</span> <a href='{{ route('mahasiswa.krs') }}/"+data.data.id_krs+"/print' class='btn btn-primary btn-sm' target='_blank'><i class='fa fa-print'></i> Print KRS</a>";
							} else if (data.data.status === 'N') {
								status = "<span class='text-warning'>KRS Anda ditolak</span><br>Keterangan: <span class='text-danger'>"+data.data.keterangan+"</span> <a href='{{ route('mahasiswa.krs') }}/"+data.data.id_krs+"/edit' class='btn btn-warning btn-xs'><i class='fa fa-edit'></i> Edit KRS</a>";
							} else {
								status = "<span class='text-danger'>Menunggu Persetujuan</span><a href=''><i class='fa fa-print'></i> Print</a>";
							}

							$("<tr>\
								<th colspan='3'>Status</th>\
								<th>"+status+"</th>\
							</tr>").appendTo(table);
						} else {
							table.html("<tr><td colspan='4'>"+data.message+"</td></tr>");
						}
					}
				});
			}
		}

		$(document).ready(function () {
			$("select[name='tahun_akademik']").on("change", function (e) {
				get_krs();

				e.preventDefault();
			});
		});
	</script>
@stop