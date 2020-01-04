@extends('template')

@section('main')
	<section class="content-header">
		<h1>Dispensasi SPP</h1>
	</section>

	<section class="content">
		@include('_partials.flash_message')
		<div class="box box-primary">
			<div class="box-header with-border">
				<a href="{{ route('admin.dispensasi_spp.tambah') }}" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Tambah</a>
			</div>
			<div class="box-body">
				<div class="table-responsive">
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>No</th>
								<th>NIM</th>
								<th>Nama</th>
								<th>Jenis Pembayaran</th>
								<th>Bulan</th>
								<th>Tahun Akademik</th>
								<th>Tanggal Akan Bayar</th>
								{{-- <th>Nominal Akan Bayar</th> --}}
								<th>Status</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
		</div>
	</section>
@stop

@section('script')
	<script type="text/javascript">
		function konfirmasi_hapus() {
			return confirm('Anda yakin ingin menghapus data tersebut?');
		}

		function konfirmasi_sudah_bayar() {
			return confirm('Anda yakin ingin melanjutkan proses pembayaran?');
		}
		
		$(document).ready(function () {
			var table = $(".table").DataTable({
				processing: true,
				serverSide: true,
				ajax: "{{ route('admin.dispensasi_spp.datatable') }}",
				columns: [
					{'data': 'no'},
					{'data': 'nim'},
					{'data': 'nama'},
					{'data': 'jenis_pembayaran'},
					{'data': 'nama_bulan'},
					{'data': 'keterangan'},
					{'data': 'tanggal_akan_bayar'},
					// {'data': 'nominal_akan_bayar'},
					{'data': 'status'},
					{'data': 'aksi'}
				]
			});
		});
	</script>
@stop