@extends ('template')

@section ('main')
	<section class="content-header">
		<h1>Jadwal Ujian</h1>
	</section>

	<section class="content">
		@include ('_partials.flash_message')
		<div class="box box-default">
			<div class="box-header with-border">
				<a href="{{ route('admin.jadwal_ujian.buat') }}" class="btn btn-primary">Buat Jadwal</a>
			</div>
			<div class="box-body">
				<table class="table table-striped table-bordered table-jadwal-ujian">
					<thead>
						<tr>
							<th width="30">No.</th>
							<th nowrap>Tahun Akademik</th>
							<th nowrap>Jenis Ujian</th>
							<th width="200">Aksi</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</section>
@stop

@section ('script')
	<script type="text/javascript">
		$(document).ready(function () {
			$(".table-jadwal-ujian").DataTable({
				processing: true,
				serverSide: true,
				ajax: {
					url: "{{ route('admin.jadwal_ujian.datatables') }}"
				},
				columns: [
					{'data': 'no'},
					{'data': 'tahun_akademik'},
					{'data': 'jenis_ujian'},
					{'data': 'aksi'}
				]
			});
		});
	</script>
@stop