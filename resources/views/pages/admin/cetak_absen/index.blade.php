@extends ('template')

@section ('main')
	<style>
		.table, .table thead tr th, .table tbody tr th, .table tbody tr td {border:1px solid #ccc}
	</style>
	<section class="content-header">
		<h1>Absensi Mahasiswa</h1>
		<ol class="breadcrumb">
			<li>Home</li>
			<li class="active">Absensi Mahasiswa</li>
		</ol>
	</section>

	<section class="content">
		<div class="nav-tabs-custom">
			<ul class="nav nav-tabs">
				<li class="active"><a href="{{ route('admin.cetak_absen') }}">Form Absensi</a></li>
				<li><a href="{{ route('admin.cetak_absen.kehadiran') }}">Cek Kehadiran</a></li>
				<li><a href="{{ route('admin.cetak_absen.alpha') }}">Kehadiran <= 3</a></li>
			</ul>
			<div class="tab-content">
				{!! Form::open(['method' => 'POST']) !!}

					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								{!! Form::label('semester', 'Semester', ['class' => 'control-label']) !!}
								{!! Form::select('semester', $semester, null, ['placeholder' => '- Pilih Semester -', 'class' => 'form-control select-custom', 'required']) !!}
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								{!! Form::label('prodi', 'Prodi', ['class' => 'control-label']) !!}
								{!! Form::select('prodi', $prodi, null, ['placeholder' => '- Pilih Prodi -', 'class' => 'form-control ', 'required']) !!}
							</div>
						</div>
					</div>

				{!! Form::submit('Tampilkan', ['class' => 'btn btn-default']) !!}
				{!! Form::close() !!}
				@if (Request::isMethod('post'))
					<br>
					<div class="table-responsive">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th class="text-center" width="50">No.</th>
									<th class="text-center">Kelas</th>
									<th class="text-center" width="400">Aksi</th>
								</tr>
							</thead>
							<tbody>
							    <?php $no = 1;?>    
								@foreach ($list as $kls)
									<tr>
										<td class="text-center">{{ $no++ }}</td>
										<td>{{ ! empty($kls->nama_kelas) ? $kls->nama_kelas : '-' }}</td>
										<td>
											<select name="id_matkul" class="form-control select-custom" width="100%">
												<option value="">- Print Or Save to PDF (List Mata Kuliah) -</option>
												@foreach ($kls->matkul as $mkl)
													<option data-kelas="{{ $kls->id_kelas }}" data-dosen="{{ $mkl->id_dosen }}" value="{{ $mkl->id_matkul }}">{{ $mkl->kode_matkul }} - {{ $mkl->nama_matkul }}</option>
												@endforeach
											</select>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				@endif
			</div>
		</div>
	</section>
@stop


@section('script')
	<script type="text/javascript">
		$(document).ready(function () {
			$('select[name="id_matkul"]').on('change', function (e) {
				e.preventDefault();
				
				var id_kelas = $(this).find(':selected').attr('data-kelas');
				var id_matkul = $(this).find(':selected').val();
				var semester = $('select[name="semester"]').val();

				if (id_matkul !== '') {
					window.open("{{ route('admin.cetak_absen') }}/" + id_kelas + "/" + id_matkul + "/" + semester + "/print", '_blank');
				}
			});
		});
	</script>
@stop