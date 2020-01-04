@extends('template')

@section('main')
	<section class="content-header">
		<h1>Mahasiswa</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Mahasiswa</li>
		</ol>
	</section>

	<section class="content">
		@include('_partials.flash_message')
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs">
				<li class="{{ $type == null ? 'active' : '' }}"><a href="{{ route('admin.mahasiswa') }}">Semua</a></li>
				<li class="{{ $type == 'aktif' ? 'active' : '' }}"><a href="{{ route('admin.mahasiswa', ['type' => 'aktif']) }}">Aktif</a></li>
				<li class="{{ $type == 'non-aktif' ? 'active' : '' }}"><a href="{{ route('admin.mahasiswa', ['type' => 'non-aktif']) }}">Non Aktif</a></li>
				<!-- <li class="{{ $type == 'lulus' ? 'active' : '' }}"><a href="{{ route('admin.mahasiswa', ['type' => 'lulus']) }}">Lulus</a></li> -->
				<!-- <li class="{{ $type == 'keluar' ? 'active' : '' }}"><a href="{{ route('admin.mahasiswa', ['type' => 'keluar']) }}">Keluar</a></li> -->
				<li class="{{ $type == 'cuti' ? 'active' : '' }}"><a href="{{ route('admin.mahasiswa', ['type' => 'cuti']) }}">Cuti</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active">
					<p>
						<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
							Filter By
						</button>
					</p>
					<div class="collapse" id="collapseExample">
						<div class="row">
							<div class="form-group col col-md-6">
								{!! Form::label('tahun_akademik', 'Tahun Akademik', ['class' => 'control-label']) !!}
								{!! Form::select('tahun_akademik', $list_tahun_akademik, null, ['class' => 'form-control']) !!}
							</div>
							<div class="form-group col col-md-6">
								{!! Form::label('id_status', 'Status Mahasiswa', ['class' => 'control-label']) !!}
								{!! Form::select('id_status', $list_status, null, ['class' => 'form-control' ]) !!}
							</div>
							<div class="form-group col col-md-6">
								{!! Form::label('id_prodi', 'Prodi', ['class' => 'control-label']) !!}
								{!! Form::select('id_prodi', $list_prodi, null, ['class' => 'form-control' ]) !!}
							</div>
							<div class="form-group col col-md-6">
								{!! Form::label('id_waktu_kuliah', 'Waktu Kuliah', ['class' => 'control-label']) !!}
								{!! Form::select('id_waktu_kuliah', $list_wakul, null, ['class' => 'form-control' ]) !!}
							</div>
							<div class="form-group col col-md-6">
								<button type="button" id="btnCari" class="btn btn-primary"><i class="fa fa-search"></i> Filter</button>
							</div>
						</div>
					</div>
					<table class="table table-striped mahasiswa">
						<thead>
							<tr>
								<th>No</th>
								<th>NIM</th>
								<th>Nama Mahasiswa</th>
								<th>Kelas</th>
								<th>Tempat, Tanggal Lahir</th>
								<th width="150">Penasihat Akademik</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
		</div>
	</section>
@stop

@section('script')
	<script type="text/javascript">
		var table = $(".mahasiswa").DataTable({
			processing: true,
			serverSide: true,
			ajax: "{{ route('admin.mahasiswa.datatable', ['type' => $type]) }}",
			columns: [
				{
					data: null,
					sortable: false, 
					render: function (data, type, row, meta) {
						return meta.row + meta.settings._iDisplayStart + 1;
					}
				},
				{'data': 'nim'},
				{'data': 'nama'},
				{'data': 'nama_kelas'},
				{'data': 'ttl'},
				{'data': 'dosen_pa'},
				{'data': 'aksi'},
			],
			columnDefs: [{
				searchable: false,
				orderable: false,
				targets: 0
			}],
			order: [[ 1, 'asc' ]]
		});

		$('#btnCari').click(function(){
			var tahun_akademik = $('#tahun_akademik').val();
			var id_status = $('#id_status').val();
			var id_waktu_kuliah = $('#id_waktu_kuliah').val();
			var id_prodi = $('#id_prodi').val();
			var type = "{{ $type == null ? 'aktif' : $type }}";
			var url = "{{ route('admin.mahasiswa.datatable') }}?tahun_akademik=" + tahun_akademik + "&id_status=" + id_status + "&id_prodi=" + id_prodi + "&id_waktu_kuliah=" + id_waktu_kuliah + "&type=" + type;

			table.ajax.url(url).load();
		});
	</script>
@stop