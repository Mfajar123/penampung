@extends ('template')

@section ('main')
	<section class="content-header">
		<h1>Kehadiran Dosen</h1>
	</section>

	<section class="content">
		@include ('_partials.flash_message')
		<div class="box box-default">
			<div class="box-header with-border">
				<h4 class="box-title">Form</h4>
			</div>
			<div class="box-body">
				{!! Form::open(['method' => 'GET', 'route' => 'admin.kehadiran_dosen.index']) !!}
					<div class="form-group">
						{!! Form::label('tahun_akademik', 'Tahun Akademik', ['class' => 'control-label']) !!}
						{!! Form::select('tahun_akademik', $list_tahun_akademik, null, ['required', 'placeholder' => '- Pilih Tahun Akademik -', 'class' => 'form-control select-custom']) !!}
					</div>
					{!! Form::submit('Tampilkan', ['class' => 'btn btn-primary']) !!}
				{!! Form::close() !!}
				@if (Request::isMethod('GET') && Request::get('tahun_akademik'))
					<br>
					<div class="table-responsive">
						<table class="table table-bordered table-striped datatable">
							<thead>
								<tr>
									<th width="30">No.</th>
									<th>NIP</th>
									<th>Nama Dosen</th>
									<th>Mata Kuliah</th>
									<th>Kelas</th>
									<th>Kehadiran</th>
								</tr>
								<tbody>
									<?php $no = 1 ?>
									@if (count($list_kehadiran) > 0)
										@foreach ($list_kehadiran as $list)
											<tr>
												<td>{{ $no++ }}</td>
												<td>{{ $list->nip }}</td>
												<td>{{ $list->gelar_depan.$list->nama.$list->gelar_belakang }}</td>
												<td>{{ $list->kode_matkul }} - {{ $list->nama_matkul }}</td>
												<td>{{ $list->id_prodi.$list->kode_kelas }}</td>
												<td class="text-right">{{ $list->kehadiran }}</td>
											</tr>
										@endforeach
									@else
										<tr>
											<td colspan="6">Belum ada data.</td>
										</tr>
									@endif
								</tbody>
							</thead>
						</table>
					</div>
				@endif
			</div>
		</div>
	</section>
@stop