@extends ('template')

@section ('main')
	<style>.table{margin-bottom:0px}</style>
	<section class="content-header">
		<h1>File Materi</h1>
	</section>

	<section class="content">
		<div class="box box-default">
			<div class="box-header with-border">
				{!! Form::open(['method' => 'GET', 'class' => 'form-inline']) !!}
					<div class="form-group">
						{!! Form::select('id_prodi', $list_prodi, null, ['placeholder' => '- Pilih Program Studi -', 'class' => 'form-control', 'required']) !!}
					</div>
					<div class="form-group">
						{!! Form::submit('Tampilkan', ['class' => 'btn btn-default']) !!}
					</div>
				{!! Form::close() !!}
			</div>
			<div class="box-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>No.</th>
								<th>Nama Materi</th>
								<th>Dosen</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							@if (count($list_shared_material) > 0)
								<?php $no = 1; ?>
								@foreach ($list_shared_material as $shared_material)
									<tr>
										<td>{{ $no++ }}</td>
										<td>{{ ! empty($shared_material->nama_materi) ? $shared_material->nama_materi : '-' }}</td>
										<td>{{ ! empty($shared_material->nama) ? $shared_material->nama : '-' }}</td>
										<td>
											<a href="{{ asset('files/materials/'.$shared_material->file) }}" class="btn btn-info btn-sm" download><i class="fa fa-download"></i> Download</a>
										</td>
									</tr>
								@endforeach
							@else
								<tr>
									<td colspan="4">Tidak ada data.</td>
								</tr>
							@endif
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</section>
@stop