@extends('template')

@section('main')
	<section class="content-header">
		<h1>Jadwal</h1>
	</section>

	<section class="content">
		@include('_partials.flash_message')
		<div class="box box-primary">
			<div class="box-header with-border">
				<div class="box-title">
					<a href="{{ route('admin.jadwal.tambah') }}" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Tambah</a>
					<a class="btn btn-primary" data-toggle="modal" href='#modal-filter'><i class="fa fa-filter"></i> Filter</a>				
				</div>
			</div>
			<div class="box-body">
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th width="20">No.</th>
							<th nowrap>Hari/Jam</th>
							<th nowrap>Ruang</th>
							<th nowrap>Matkul</th>
							<th nowrap>Kelas</th>
							<th nowrap>Dosen</th>
							<th width="110">Actions</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</section>

	<div class="modal fade" id="modal-filter">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Filter</h4>
				</div>
				{!! Form::open(['id' => 'form_filter', 'method' => 'POST']) !!}
					<div class="modal-body">
						<div class="form-group">
							{!! Form::label('tahun_akademik', 'Tahun Akademik', ['class' => 'control-label']) !!}
							{!! Form::select('tahun_akademik', $list_tahun_akademik, null, ['class' => 'form-control', 'onchange' => 'get_kelas()']) !!}
						</div>
						<div class="form-group">
							{!! Form::label('id_prodi', 'Program Studi', ['class' => 'control-label']) !!}
							{!! Form::select('id_prodi', $list_prodi, null, ['class' => 'form-control', 'onchange' => 'get_kelas()']) !!}
						</div>
						<div class="form-group">
							{!! Form::label('id_waktu_kuliah', 'Waktu Kuliah', ['class' => 'control-label']) !!}
							{!! Form::select('id_waktu_kuliah', $list_waktu_kuliah, null, ['class' => 'form-control', 'onchange' => 'get_kelas()']) !!}
						</div>
						<div class="form-group">
							{!! Form::label('id_semester', 'Semester', ['class' => 'control-label']) !!}
							{!! Form::select('id_semester', $list_semester, null, ['class' => 'form-control', 'onchange' => 'get_kelas()']) !!}
						</div>
						<div class="form-group">
							{!! Form::label('id_kelas', 'Kelas', ['class' => 'control-label']) !!}
							{!! Form::select('id_kelas', ['' => '- Semua -'], null, ['class' => 'form-control']) !!}
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary">OK</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
@stop

@section('script')
	<script type="text/javascript">
		function get_kelas() {
            var formData = $("#form_filter").serialize();
            var id_kelas = $("select[name='id_kelas']");

            $(id_kelas).html('<option value="">- Semua -</option>');

            $.ajax({
                type: "POST",
                url: "{{ route('admin.jadwal.get_kelas') }}",
                data: formData,
                success: function (data) {
					console.log(data);
                    if (data.status === 'success') {
                        $.each(data.data, function (key, val) {
                            $(id_kelas).append('<option value="'+val.id_kelas+'">'+val.kode_kelas+'</option>');
                        });
                    }
                }
            });
        }

		$(document).ready(function () {
			var modalFilter = $("#modal-filter");
			
			var table = $(".table").DataTable({
				processing: true,
				serverSide: true,
				ajax: "{{ route('admin.jadwal.datatable') }}",
				columns: [
					{'data': 'no'},
					{'data': 'hari_jam'},
					{'data': 'ruang'},
					{'data': 'matkul'},
					{'data': 'kelas'},
					{'data': 'dosen'},
					{'data': null}
				],
				columnDefs: [{
					targets: -1,
					data: null,
					defaultContent: '\
						<button type="button" class="btn btn-warning btn-edit btn-sm"><i class="fa fa-edit"></i> Edit</button>\
						<button type="button" class="btn btn-danger btn-hapus btn-sm"><i class="fa fa-trash"></i> Hapus</button>\
					'
				}]
			});

			$("#form_filter").on("submit", function (e) {
				var formData = $(this).serialize();

				table.ajax.url("{{ route('admin.jadwal.datatable') }}?" + formData).load();
				
				modalFilter.modal('hide');

				e.preventDefault();
			});

			$(".table tbody").on("click", ".btn-edit", function () {
				var data = table.row($(this).parents('tr')).data();
				
				document.location="{{ route('admin.jadwal') }}/"+data.id_jadwal+"/ubah";
			});

			$(".table tbody").on("click", ".btn-hapus", function () {
				var data = table.row($(this).parents('tr')).data();
				
				if (confirm("Anda yakin ingin menghapus data tersebut?")) {
					$.ajax({
						type: "DELETE",
						url: "{{ route('admin.jadwal') }}/"+data.id_jadwal+"/hapus",
						success: function (data) {
							if (data.status === 'success') {
								alert("Data berhasil dihapus.");

								table.ajax.reload();
							}
						}
					});
				}
			});
		});
	</script>
@stop