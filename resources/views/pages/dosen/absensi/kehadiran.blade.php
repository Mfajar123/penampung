@extends ('template')

@section ('main')
	<style>.table{margin-bottom:0;}</style>
	<section class="content-header">
		<h1>Cek Kehadiran</h1>
		<ol class="breadcrumb">
			<li>Home</li>
			<li class="active">Cek Kehadiran</li>
		</ol>
	</section>

	<section class="content">
		<p>
			<a href="{{ route('dosen.absensi') }}" class="btn btn-default"><i class="fa fa-chevron-left"></i> Kembali</a>
		</p>
		<div class="box box-default">
			<div class="box-header with-border">
				{!! Form::open(['method' => 'PATCH', 'class' => 'form-inline']) !!}
					{!! Form::select('tanggal', $list_pertemuan, null, ['placeholder' => '- Pilih Tanggal -', 'class' => 'form-control', 'required']) !!}
					{!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
				{!! Form::close() !!}
			</div>
			@if (Request::isMethod('patch'))
				<div class="box-body">
					<div class="table-responsive">
						<table class="table">
							<tbody>
								<tr>
									<th width="200">Tanggal</th>
									<td width="10">:</td>
									<td>{{ ! empty($pertemuan->tanggal) ? $pertemuan->tanggal : '-' }}</td>
								</tr>
								<tr>
									<th width="200">Notes</th>
									<td width="10">:</td>
									<td>{{ ! empty($notes) ? $notes : '-' }}</td>
								</tr>
							</tbody>
						</table>
					</div>
					<br>
					<div class="table-responsive">
						<table class="table table-striped table-bordered">
							<thead>
								<tr>
									<th width="30">No.</th>
									<th width="100">NIM</th>
									<th nowrap>Nama Mahasiswa</th>
									<th width="150">Keterangan</th>
								</tr>
							</thead>
							<tbody>
								@if (count($list_mahasiswa) > 0)
									<?php $no = 1; ?>
									@foreach ($list_mahasiswa as $mahasiswa)
										<tr>
											<td>{{ $no++ }}</td>
											<td>{{ $mahasiswa->nim }}</td>
											<td>{{ $mahasiswa->nama }}</td>
											<td>{{ $mahasiswa->keterangan }}</td>
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
			@endif
		</div>
	</section>
@stop