@extends ('template')

@section ('main')
	<style>.table{margin-bottom:0px;}</style>

	<section class="content-header">
		<h1>Pembukaan KRS</h1>

		<ol class="breadcrumb">
			<li><a href="#">Home</a></li>
			<li>Pembukaan KRS</li>
		</ol>
	</section>

	<section class="content">
		@include ('_partials.flash_message')

		<div class="box box-default">
			<div class="box-header with-border">
				<a href="{{ route('admin.setting.pembukaan_krs.tambah') }}" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Tambah</a>
			</div>
			<div class="box-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered datatable">
						<thead>
							<th width="30">No.</th>
							<th nowrap>Program Studi</th>
							<th nowrap>Tanggal Mulai</th>
							<th nowrap>Tanggal Selesai</th>
							<th width="150">Actions</th>
						</thead>
						<tbody>
							<?php $no = 1; ?>
							@foreach ($list_pembukaan as $list)
								<tr>
									<td>{{ $no++ }}</td>
									<td>{{ $list->nama_prodi }}</td>
									<td>{{ date('d M Y', strtotime($list->tanggal_mulai)) }}</td>
									<td>{{ date('d M Y', strtotime($list->tanggal_selesai)) }}</td>
									<td>
										{!! Form::open(['method' => 'DELETE', 'route' => ['admin.setting.pembukaan_krs.hapus', $list->id_pembukaan_krs]]) !!}
											<a href="{{ route('admin.setting.pembukaan_krs.edit', $list->id_pembukaan_krs) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Edit</a>
											<button type="submit" class="btn btn-danger btn-sm" onClick="return confirm('Anda yakin ingin menghapus data tersebut?')"><i class="fa fa-trash"></i> Hapus</button>
										{!! Form::close() !!}
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