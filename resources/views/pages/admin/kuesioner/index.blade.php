@extends ('template')

@section ('main')
	<section class="content-header">
		<h1>Kuesioner Evaluasi Pembelajaran</h1>
	</section>

	<section class="content">
		@include ('_partials.flash_message')
		@foreach ($kuesioner_form->kuesioner_kategori()->get() as $kuesioner_kategori)
			<div class="box box-primary">
				<div class="box-header with-border">
					<h4 class="box-title">{{ $kuesioner_kategori->title }} <small>{{ $kuesioner_kategori->jenis_pertanyaan }}</small></h4>
					<div class="box-tools pull-left">
						<button type="button" data-id="{{ $kuesioner_kategori->id_kuesioner_kategori }}" data-title="{{ $kuesioner_kategori->title }}" data-jenis-pertanyaan="{{ $kuesioner_kategori->jenis_pertanyaan }}" class="btn btn-warning btn-edit-kategori btn-xs"><i class="fa fa-edit"></i> Edit</button>
						<a href="{{ route('admin.kuesioner.form.hapus_kategori', $kuesioner_kategori->id_kuesioner_kategori) }}" class="btn btn-danger btn-xs" onClick="return konfirmasiHapus()"><i class="fa fa-trash"></i> Hapus</a>
					</div>
				</div>
				<div class="box-body">
					<?php $no = 1 ?>
					<table class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>No.</th>
								<th>Pertanyaan</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($kuesioner_kategori->kuesioner_pertanyaan()->get() as $kuesioner_pertanyaan)
								<tr>
									<td>{{ $no++ }}</td>
									<td>{{ $kuesioner_pertanyaan->pertanyaan }}</td>
									<td>
										<button type="button" data-id="{{ $kuesioner_kategori->id_kuesioner_kategori }}" data-title="{{ $kuesioner_kategori->title }}" data-id-pertanyaan="{{ $kuesioner_pertanyaan->id_kuesioner_pertanyaan }}" data-pertanyaan="{{ $kuesioner_pertanyaan->pertanyaan }}" class="btn btn-warning btn-xs btn-edit-pertanyaan"><i class="fa fa-edit"></i> Edit</button>
										<a href="{{ route('admin.kuesioner.form.hapus_pertanyaan', $kuesioner_pertanyaan->id_kuesioner_pertanyaan) }}" class="btn btn-danger btn-xs" onClick="return konfirmasiHapus()"><i class="fa fa-trash"></i> Hapus</button>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				<div class="box-footer">
					<button type="button" data-id="{{ $kuesioner_kategori->id_kuesioner_kategori }}" data-title="{{ $kuesioner_kategori->title }}" class="btn btn-primary btn-tambah-pertanyaan">Tambah Pertanyaan</button>
				</div>
			</div>
		@endforeach

		<button type="button" id="btnTambahKategoriPertanyaan" class="btn btn-primary">Tambah Kategori Pertanyaan</button>
	</section>

	<div class="modal fade" id="modalKategori" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title"></h4>
				</div>
				{!! Form::open(['method' => 'POST', 'route' => 'admin.kuesioner.form.kategori_submit']) !!}
					<div class="modal-body">
						{!! Form::hidden('id_kuesioner_kategori') !!}
						<div class="form-group">
							{!! Form::label('title', 'Kategori Pertanyaan', ['control-label']) !!}
							{!! Form::text('title', null, ['required', 'placeholder' => 'Contoh: KOMPETENSI PEDAGOGIK', 'class' => 'form-control']) !!}
						</div>
						<div class="form-group">
							{!! Form::label('jenis_pertanyaan', 'Jenis Pertanyaan', ['control-label']) !!}
							{!! Form::select('jenis_pertanyaan', $list_jenis_pertanyaan, null, ['required', 'class' => 'form-control']) !!}
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
						<button type="submit" class="btn btn-primary">Simpan</button>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>

	<div class="modal fade" id="modalPertanyaan" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title"></h4>
				</div>
				{!! Form::open(['method' => 'POST', 'route' => 'admin.kuesioner.form.pertanyaan_submit']) !!}
					<div class="modal-body">
						{!! Form::hidden('id_kuesioner_kategori') !!}
						{!! Form::hidden('id_kuesioner_pertanyaan') !!}
						<div class="form-group">
							{!! Form::label('title', 'Kategori Pertanyaan', ['control-label']) !!}
							{!! Form::text('title', null, ['disabled', 'class' => 'form-control']) !!}
						</div>
						<div class="form-group">
							{!! Form::label('pertanyaan', 'Pertanyaan', ['control-label']) !!}
							{!! Form::text('pertanyaan', null, ['required', 'placeholder' => 'Contoh: Kesiapan memberikan kuliah dan atau praktikum', 'class' => 'form-control']) !!}
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
						<button type="submit" class="btn btn-primary">Simpan</button>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
@stop

@section('script')
	<script type="text/javascript">
		function konfirmasiHapus() {
			return confirm('Anda yakin ingin menghapus data tersebut?');
		}

		var btnTambahKategoriPertanyaan = $("#btnTambahKategoriPertanyaan");
		var modalKategori = $("#modalKategori");
		var modalPertanyaan = $("#modalPertanyaan");
		var formKategori = $(modalKategori).find('form');
		var formPertanyaan = $(modalPertanyaan).find('form');
		
		$(btnTambahKategoriPertanyaan).on('click', function (e) {
			e.preventDefault();
			
			$(formKategori)[0].reset();
			$(modalKategori).find('.modal-title').html('Tambah Kategori');
			$(modalKategori).modal('show');
		});

		$('.content').on('click', '.btn-edit-kategori', function (e) {
			e.preventDefault();

			var id = this.getAttribute('data-id');
			var title = this.getAttribute('data-title');
			var jenis_pertanyaan = this.getAttribute('data-jenis-pertanyaan');

			$(formKategori)[0].reset();
			$(formKategori).find('input[name="id_kuesioner_kategori"]').val(id);
			$(formKategori).find('input[name="title"]').val(title);
			$(formKategori).find('select[name="jenis_pertanyaan"]').val(jenis_pertanyaan);

			$(modalKategori).find('.modal-title').html('Edit Kategori');
			$(modalKategori).modal('show');
		});

		$('.content').on('click', '.btn-tambah-pertanyaan', function (e) {
			e.preventDefault();

			var id = this.getAttribute('data-id');
			var title = this.getAttribute('data-title');

			$(formPertanyaan)[0].reset();
			$(formPertanyaan).find('input[name="id_kuesioner_kategori"]').val(id);
			$(formPertanyaan).find('input[name="title"]').val(title);

			$(modalPertanyaan).find('.modal-title').html('Tambah Pertanyaan');
			$(modalPertanyaan).modal('show');
		});

		$('.content').on('click', '.btn-edit-pertanyaan', function (e) {
			e.preventDefault();

			var id = this.getAttribute('data-id');
			var title = this.getAttribute('data-title');
			var id_pertanyaan = this.getAttribute('data-id-pertanyaan');
			var pertanyaan = this.getAttribute('data-pertanyaan');

			$(formPertanyaan)[0].reset();
			$(formPertanyaan).find('input[name="id_kuesioner_kategori"]').val(id);
			$(formPertanyaan).find('input[name="title"]').val(title);
			$(formPertanyaan).find('input[name="id_kuesioner_pertanyaan"]').val(id_pertanyaan);
			$(formPertanyaan).find('input[name="pertanyaan"]').val(pertanyaan);

			$(modalPertanyaan).find('.modal-title').html('Edit Pertanyaan');
			$(modalPertanyaan).modal('show');
		});
	</script>
@stop