@extends ('template')

@section ('main')
<style>
	.table2 {
		border: 1px solid #ccc;
	}
	.table-bordered>thead>tr>th {
		border: 1px solid #ccc;
		text-align: center;
		vertical-align: middle;
	}

	.table-bordered>tbody>tr>td {
		border: 1px solid #ccc;
	}
</style>

<section class="content-header">
	<h1><a href="{{ route('admin.evaluasi.hasil_angket_dosen.index') }}"><i class="fa fa-arrow-circle-o-left"></i></a> Detail Angket Dosen</h1>
	<ol class="breadcrumb">
		<li>Home</li>
		<li class="active">Detail Angket Dosen</li>
	</ol>
</section>

<section class="content">
	<div class="box box-default">
		<div class="box-header with-border">
			<a href="{{ route('admin.evaluasi.hasil_angket_dosen.print', [$dosen->id_dosen, $matkul->id_matkul, $tahun_akademik->tahun_akademik, $semester->id_semester]) }}" target="_blank" class="btn btn-default btn-sm"><i class="fa fa-print"></i> Cetak</a>
		</div>
		<div class="box-body">
			<table class="table">
				<tr>
					<th width="150">Dosen</th>
					<td width="1">:</td>
					<td>{{ $dosen->nip }} - {{ $dosen->gelar_depan }}{{ $dosen->nama }}{{ $dosen->gelar_belakang }}</td>
				</tr>
				<tr>
					<th>Mata Kuliah</th>
					<td>:</td>
					<td>{{ $matkul->kode_matkul }} - {{ $matkul->nama_matkul }}</td>
				</tr>
				<tr>
					<th>Tahun Akademik</th>
					<td>:</td>
					<td>{{ $tahun_akademik->keterangan }}</td>
				</tr>
				<tr>
					<th>Semester</th>
					<td>:</td>
					<td>{{ $semester->semester_ke }}</td>
				</tr>
			</table>
			<br>
			<table class="table table2 table-striped table-bordered table-hover datatable">
				<thead>
					<tr>
						<th rowspan="2">NIM</th>
						<th rowspan="2">Nama Mahasiswa</th>
						<th colspan="4">Rekapitulasi</th>
						<th rowspan="2">Total Nilai</th>
					</tr>
					<tr>
						<th>Pedagogik</th>
						<th>Profesional</th>
						<th>Kepribadian</th>
						<th>Sosial</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($data as $list)
						<tr>
							<td>{{ $list->nim }}</td>
							<td>{{ $list->nama }}</td>
							<td class="text-center">{{ $list->total_pedagogik }}</td>
							<td class="text-center">{{ $list->total_profesional }}</td>
							<td class="text-center">{{ $list->total_kepribadian }}</td>
							<td class="text-center">{{ $list->total_sosial }}</td>
							<td class="text-center">{{ number_format(($list->total_pedagogik + $list->total_profesional + $list->total_kepribadian + $list->total_sosial) / 4, 2) }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</section>
@stop