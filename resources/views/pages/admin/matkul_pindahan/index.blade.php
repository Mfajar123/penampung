@extends ('template')

@section ('main')
	<section class="content-header">
		<h1>Matkul Pindahan</h1>
	</section>

	<section class="content">
		@include ('_partials.flash_message')
		<div class="box box-default">
			<div class="box-header with-border">
				<a href="{{ route('admin.matkul_pindahan.buat') }}" class="btn btn-primary">Buat Matkul</a>
			</div>
			<div class="box-body">
				<table class="table table-striped table-bordered matkul_pindahan">
					<thead>
						<tr>
							<th nowrap>No.</th>
							<th nowrap>Nama</th>
							<th nowrap>Jumlah Matkul</th>
							<th nowrap>Jumlah SKS</th>
							<th nowrap>Aksi</th>
						</tr>
					</thead>
					<tbody>

					</tbody>
				</table>
			</div>
		</div>
	</section>
@stop

@section ('script')
	<script type="text/javascript">
		$(document).ready(function () {
			$(".matkul_pindahan").DataTable({
				processing: true,
				serverSide: true,
				ajax: {
					url: "{{ route('admin.matkul_pindahan.datatables') }}"
				},
				columns: [
					{'data': 'no'},
					{'data': 'nama'},
					{'data': 'jumlah_matkul'},
					{'data': 'jumlah_sks'},
					{'data': 'aksi'}
				]
			});
		});
	</script>
@stop