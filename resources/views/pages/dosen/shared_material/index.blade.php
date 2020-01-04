@extends ('template')

@section ('main')
	<section class="content-header">
		<h1>Share File Materi</h1>
	</section>

	<section class="content">
		@include ('_partials.flash_message')

		<div class="box box-default">
			<div class="box-header with-border">
				<a href="{{ route('dosen.shared_material.tambah') }}" class="btn btn-primary">Tambah File Materi</a>
			</div>
			<div class="box-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered">
						<thead>
							<tr>
								<th width="30">No.</th>
								<th nowrap>Program Studi</th>
								<th nowrap>Nama Materi</th>
								<th nowrap>File</th>
								<th width="150">Aksi</th>
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
		$(document).ready(function () {
			var table = $(".table").DataTable({
				processing: true,
				serverSide: true,
				ajax: "{{ route('dosen.shared_material.datatable') }}",
				columns: [
					{'data': 'no'},
					{'data': 'nama_prodi'},
					{'data': 'nama_materi'},
					{'data': 'file'},
					{'data': 'aksi'},
				]
			});
		});
	</script>
@stop