@extends ('template')

@section ('main')
	<style>.table{margin-bottom:0px}</style>

	<section class="content-header">
		<h1>Grade Nilai</h1>

		<ol class="breadcrumb">
			<li><a href="#">Home</a></li>
			<li class="active">Grade Nilai</li>
		</ol>
	</section>

	<section class="content">
		@include ('_partials.flash_message')
		
		<div class="box box-default">
			<div class="box-header with-border">
				{!! Form::open(['method' => 'POST', 'route' => 'admin.grade_nilai.index.submit', 'class' => 'form-inline']) !!}
					<a href="{{ route('admin.grade_nilai.tambah') }}" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Tambah</a>
					
					{!! Form::select('tahun_akademik', $list_tahun_akademik, null, ['placeholder' => '- Pilih Tahun Akademik -', 'class' => 'form-control', 'required']) !!}
					<button type="submit" class="btn btn-default"><i class="fa fa-search"></i> Tampil</button>
				{!! Form::close() !!}
			</div>
			@if (Request::isMethod('POST'))
				<div class="box-body">
					{!! Form::open(['method' => 'DELETE', 'route' => ['admin.grade_nilai.hapus', $tahun_akademik]]) !!}
						<a href="{{ route('admin.grade_nilai.ubah', $tahun_akademik) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Ubah</a>
						<button type="submit" class="btn btn-danger btn-sm" onClick="return confirm('Anda yakin ingin menghapus data tersebut?')"><i class="fa fa-trash"></i> Hapus</button>
					{!! Form::close() !!}
					
					<p></p>
					
					<div class="table-responsive">
						<table class="table table-striped table-bordered">
							<thead>
								<tr>
									<th width="30">No.</th>
									<th nowrap>Huruf</th>
									<th nowrap>Nilai Min</th>
									<th nowrap>Nilai Max</th>
									<th nowrap>Bobot</th>
								</tr>
							</thead>
							<tbody>
								@if ($list_grade_nilai->count() > 0)
									<?php $no = 1; ?>
									@foreach ($list_grade_nilai as $list)
										<tr>
											<td>{{ $no++ }}</td>
											<td>{{ $list->huruf }}</td>
											<td>{{ $list->nilai_min }}</td>
											<td>{{ $list->nilai_max }}</td>
											<td>{{ $list->bobot }}</td>
										</tr>
									@endforeach
								@else
									<tr>
										<td colspan="5">Tidak ada data.</td>
									</tr>
								@endif
							</tbody>
						</table>
					</div>
				</div>
			@endif
		</div>
	</section>
@stop