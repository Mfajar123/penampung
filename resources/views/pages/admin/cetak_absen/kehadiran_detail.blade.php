@extends ('template')

@section ('main')
	<style>.table{margin-bottom:0;}</style>
	<section class="content-header">
		<h1><a href="{{ route('admin.cetak_absen.kehadiran') }}" title="Kembali"><i class="fa fa-arrow-circle-o-left"></i></a> Cetak Kehadiran</h1>
		<ol class="breadcrumb">
			<li>Home</li>
			<li class="active">Cetak Kehadiran</li>
		</ol>
	</section>
	<section class="content">
		<div class="box box-primary">
			<div class="box-body">
				<table class="table">
					<tbody>
						<tr>
							<th width="100">Kelas</th>
							<td width="1">:</td>
							<td>{{ $kelas->nama_kelas }}</td>
						</tr>
						<tr>
							<th>Mata Kuliah</th>
							<td>:</td>
							<td>{{ $matkul->kode_matkul }} - {{ $matkul->nama_matkul }}</td>
						</tr>
					</tbody>
				</table>
				<br>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th width="50">No.</th>
							<th>NIM</th>
							<th>Nama Mahasiswa</th>
							<th>Jumlah Kehadiran</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 1 ?>
						@foreach ($list as $mahasiswa)
							<tr class="{{ ($mahasiswa->jumlah_kehadiran >= 3 ? '' : 'bg-danger') }}">
								<td>{{ $no++ }}</td>
								<td>{{ $mahasiswa->nim }}</td>
								<td>{{ $mahasiswa->nama }}</td>
								<td>{{ $mahasiswa->jumlah_kehadiran }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</section>
@stop