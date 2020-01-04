@extends ('template')

@section ('main')
	<style>.table{margin-bottom:0;}</style>
	<section class="content-header">
		<h1>Edit Absensi Mahasiswa</h1>
		<ol class="breadcrumb">
			<li>Home</li>
			<li class="active">Edit Absensi Mahasiswa</li>
		</ol>
	</section>

	<section class="content">
		<p>
			<a href="{{ route('admin.absensi.detail', [$kelas->id_kelas, $matkul->id_matkul, $dosen->id_dosen, $jadwal->id_jadwal]) }}" class="btn btn-default">Kembali</a>
		</p>
		@include ('pages.admin.absensi.box_detail')
		@include ('pages.admin.absensi.form_absensi', ['is_edit' => true])
	</section>
@stop