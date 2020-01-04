@extends('template')

@section('main')
<section class="content-header">

  <h1>Role</h1>

  </ol>
</section>



<!-- Main content -->

<section class="content">

	<div class="box">
		<div class="box-header">
			<div class="box-header-actions">
				<a href="#" class="box-header-action btn btn-primary btn-tambah" title="Tambah"><i class="fa fa-plus"></i> Tambah</a>
			</div>
		</div>
		<div class="box-body">
			<table class="table table-striped table-bordered display nowrap" width="100%">
				<thead>
					<tr>
						<th width="30">No.</th>
						<th>Nama Role</th>
						<th>Level</th>
						<th width="50">Aksi</th>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
		</div>
	</div>
	
	<div class="modal fade" id="modalForm" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				{!! Form::open(['method' => 'POST']) !!}
					<div class="modal-body">
						{!! Form::hidden('id_role', null) !!}

						<div class="form-group row">
							<label for="role_name" class="col-sm-3 col-form-label">Nama Role <span class="text-danger">*</span></label>
							<div class="col-sm-9">
								{!! Form::text('role_name', null, ['required', 'class' => 'form-control']) !!}
							</div>
						</div>

						<div class="form-group row">
							<label for="level" class="col-sm-3 col-form-label">Level <span class="text-danger">*</span></label>
							<div class="col-sm-9">
								{!! Form::select('level', ["Admin" => "Admin", "User" => "User"], null, ['required', 'class' => 'form-control']) !!}
							</div>
						</div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
						<button type="submit" class="btn btn-primary">Simpan</button>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
@stop

@section('script')
	<script type="text/javascript">
		var action;

		var modalForm = $('#modalForm');
		var modalFormTitle = $(modalForm).find('.modal-title');

		var form = $(modalForm).find('form');

		var idRole = $(form).find('input[name="id_role"]');
		var level = $(form).find('input[name="level"]');
		var roleName = $(form).find('input[name="role_name"]');

		function clearForm() {
			$(idRole).val('');
			$(roleName).val('');
			$(level).val('');
		}

		$(document).ready(function () {
			var table = $('.table').DataTable({
				processing: true,
				serverSide: true,
				ajax: "{{ route('role.datatables') }}",
				columns: [
					{'data': 'no'},
					{'data': 'role_name'},
					{'data': 'level'},
					{'data': 'aksi'}
				],
				responsive: true
			});

			$('.btn-tambah').on('click', function (e) {
				e.preventDefault();

				action = 'tambah';

				clearForm();

				$(modalFormTitle).html('Tambah Role');
				$(modalForm).modal('show');
			});

			$('.table').on('click', '.btn-edit', function (e) {
				e.preventDefault();

				var id = this.getAttribute('data-id');

				action = 'edit';

				clearForm();

				$.ajax({
					url: "{{ route('role.index') }}/"+id+"/edit",
					type: "GET",
					success: function (data) {
						$(idRole).val(data.role.id_role);
						$(roleName).val(data.role.role_name);
						$(level).val(data.role.level);

						$(modalFormTitle).html('Edit Role');
						$(modalForm).modal('show');
					}
				});
			});

			$('.table').on('click', '.btn-hapus', function (e) {
				e.preventDefault();

				var id = this.getAttribute('data-id');
				
				if (confirm('Anda yakin ingin menghapus data tersebut?')) {

					$.ajax({
						url: "{{ route('role.index') }}/"+id+"/hapus",
						type: "DELETE",
						data: {id},
						success: function (data) {
							alert('Data berhasil dihapus.');

							table.ajax.reload();
						}
					});
				}
			});

			$(form).on('submit', function (e) {
				e.preventDefault();

				if (action === 'tambah') {
					url = "{{ route('role.simpan') }}";
					type = 'POST';
				} else {
					var id = $(idRole).val();

					url = "{{ route('role.index') }}/"+id+"/edit";
					type = 'PATCH';
				}

				$.ajax({
					url: url,
					type: type,
					data: $(form).serialize(),
					success: function (data) {
						$(modalForm).modal('hide');
						table.ajax.reload();
					}
				});
			});
		});
	</script>
@stop