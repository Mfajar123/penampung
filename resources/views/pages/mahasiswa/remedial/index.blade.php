@extends('template')

@section('style')
	<style>.table{margin-bottom:0px;}</style>
@stop

@section('main')
	<section class="content-header">
		<h1>Ulang Mata Kuliah</h1>

		<ol class="breadcrumb">
			<li>Home</li>
			<li class="active">Ulang Mata Kuliah</li>
		</ol>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-default">
					<div class="box-header with-border">
						@if (! empty($pembukaan_krs))
							<div class="form-inline">
								{!! Form::select('tahun_akademik', $list_tahun_akademik, null, ['id' => 'select_tahun_akademik', 'placeholder' => '- Pilih Tahun Akademik -', 'class' => 'form-control select-custom']) !!}
							</div>
						@endif
					</div>
					<div class="box-body">
						<div class="table-responsive">
							<table class="table table-bordered table-striped table-remedial">
								<thead>
									<tr>
										<th>No.</th>
										<th>Kode</th>
										<th>Mata Kuliah</th>
										<th>Nilai</th>
										<th>Grade</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<div class="modal fade modal-ulang" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title"><i class="fa fa-search"></i> Pilih Jadwal</h4>
				</div>
				<div class="modal-body">
					<table class="table table-striped table-jadwal">
						<thead>
							<tr>
								<th>Hari</th>
								<th>Jam</th>
								<th>Aksi</th>
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
		function konfirmasi_mengulang() {
			return confirm("Anda yakin ingin mengulang mata kuliah tersebut?");
		}

		$(document).ready(function () {
			$("#select_tahun_akademik").on("change", function (e) {
				e.preventDefault();
				var tahun_akademik = $(this).val();
				var table = $(".table-remedial tbody");

				table.html("<tr><td colspan='5'>Loading...</td></tr>");

				$.ajax({
					url: "{{ route('mahasiswa.remedial.get_remedial') }}",
					type: "POST",
					data: {
						tahun_akademik: tahun_akademik
					},
					success: function (response) {
						if (response.status === 'success') {
							table.html("");

							var no = 1;

							if (response.data.length === 0) {
								table.html("<tr><td colspan='6'>Tidak ada remedial.</td></tr>");
							} else {
								$.each(response.data, function (key, val) {
									$("<tr>\
										<td>"+no+"</td>\
										<td>"+val['kode_matkul']+"</td>\
										<td>"+val['nama_matkul']+"</td>\
										<td>"+val['total']+"</td>\
										<td>"+val['huruf']+"</td>\
										<td><button type='button' value='"+val['id_matkul']+"' class='btn btn-primary btn-sm btn-ulang'><i class='fa fa-repeat'></i> Mengulang Mata Kuliah</button></td>\
									</tr>").appendTo(table);

									no++;
								});
							}
						}
					},
					error: function (xhr, err) {
						alert(err);
					}
				});
			});

			$(".table-remedial").on("click", ".btn-ulang", function (e) {
				e.preventDefault();

				var btn = $(this);
				var modal = $(".modal-ulang");
				var table = $(".table-jadwal tbody");

				$(table).html("");

				$.ajax({
					url: "{{ route('mahasiswa.remedial.get_jadwal') }}",
					type: "POST",
					data: {
						id_matkul: $(btn).val()
					},
					success: function (data) {
						$.each(data.list_jadwal, function (key, val) {
							$("<tr>\
								<td>"+val['hari']+"</td>\
								<td>"+val['jam_mulai']+"</td>\
								<td>"+val['jam_selesai']+"</td>\
								<td><button type='button' class='btn btn-primary btn-sm btn-kelas' value='"+val['id_kelas']+"' id_matkul='"+$(btn).val()+"'><i class='fa fa-check'></i> Pilih Jadwal</i></td>\
							</tr>").appendTo(table);
						});

						$(modal).modal("show");
					}
				});
			});

			$(".table-jadwal").on("click", ".btn-kelas", function (e) {
				e.preventDefault();

				var btn = $(this);

				if (confirm("Anda yakin ingin mengulang mata kuliah tersebut?")) {
					$.ajax({
						url: "{{ route('mahasiswa.remedial.ulang_matkul') }}",
						type: "POST",
						data: {
							id_matkul: $(btn).attr("id_matkul"),
							id_kelas: $(btn).val()
						},
						success: function (data) {
							if (data.status === 'success') {
								alert("Pengulangan mata kuliah, berhasil diajukan.");
								
								document.location="{{ route('mahasiswa.remedial') }}";
							}
						}
					});
				}

			});
		});
	</script>
@stop