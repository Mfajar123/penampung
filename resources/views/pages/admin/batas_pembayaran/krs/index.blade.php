@extends('template')

@section('main')
	<section class="content-header">
		<h1>Batas Pembayaran KRS</h1>
	</section>

	<section class="content">
		@include('_partials.flash_message')

		<div class="box box-primary">
			<div class="box-header with-border">
				<a href="{{ route('admin.batas_pembayaran.krs.tambah') }}" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Tambah</a>
			</div>
			<div class="box-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>No.</th>
								<th>Semester</th>
								<th>Bulan</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php $no = 1 ?>
							@foreach ($list_batas_pembayaran as $list)
								<tr>
									<td>{{ $no++ }}</td>
									<td>{{ $list->semester }}</td>
									<td>{{ $list_bulan[$list->bulan] }}</td>
									<td>
										<a href="{{ route('admin.batas_pembayaran.krs.edit', $list->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Edit</a>
										<a href="{{ route('admin.batas_pembayaran.krs.hapus', $list->id) }}" class="btn btn-danger btn-sm" onClick="return konfirmasi_hapus()"><i class="fa fa-trash"></i> Hapus</a>
									</td>
								</tr>
							@endforeach
						</tbody>
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

		$(document).ready(function () {
			$('.table').DataTable();
		});
	</script>
@stop