@extends ('template')

@section ('main')
	<style>.table{margin-bottom:0;}</style>
	<section class="content-header">
		<h1>Absensi Mahasiswa</h1>
		<ol class="breadcrumb">
			<li>Home</li>
			<li class="active">Absensi Mahasiswa</li>
		</ol>
	</section>

	<section class="content">
		<p>
			<a href="{{ route('dosen.absensi.detail', [$kelas->id_kelas, $matkul->id_matkul, $jadwal->id_jadwal]) }}" class="btn btn-default">Kembali</a>
		</p>
		@include ('pages.dosen.absensi.box_detail')
		@include ('pages.dosen.absensi.form_absensi')
	</section>
@stop