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
			<a href="{{ route('admin.absensi') }}" class="btn btn-default">Kembali</a>
		</p>
		@include ('pages.admin.absensi.box_detail')
		@include ('pages.admin.absensi.kehadiran_v2')
		<div class="box box-primary">
			<div class="box-header">
				<h4 class="box-title">Catatan</h4>
			</div>
			<div class="box-body">
				@foreach ($pertemuan as $i => $list)
					<p><strong>Pertemuan {{ $i + 1 }} ({{ date('j M Y', strtotime($list->tanggal)) }})</strong><br> {{ @$absensi_detail[$i]->catatan_dosen }}</p>
				@endforeach
			</div>
		</div>
	</section>
@stop