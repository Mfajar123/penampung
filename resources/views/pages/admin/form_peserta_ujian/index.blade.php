@extends ('template')

@section ('main')
<style>
	.table, .table thead tr th, .table tbody tr th, .table tbody tr td {border:1px solid #ccc}
</style>
<section class="content-header">
	<h1>Form Peserta Ujian</h1>
	<ol class="breadcrumb">
		<li>Home</li>
		<li class="active">Form Peserta Ujian</li>
	</ol>
</section>

<section class="content">
	<div class="box box-default">
		<div class="box-header with-border">
			<h4 class="box-title">Data</h4>
		</div>
		<div class="box-body">
			{!! Form::open(['method' => 'POST', 'route' => 'admin.form_peserta_ujian.submit', 'files' => 'true']) !!}
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
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							{!! Form::label('ju', 'Jenis Ujian', ['class' => 'control-label']) !!}
							<Select class="form-control" name="ju" required>
								<option value="UTS">UTS</option>
								<option value="UAS">UAS</option>
							</Select>
						</div>
					</div>
				</div>
			{!! Form::submit('Tampilkan', ['class' => 'btn btn-default']) !!}
			{!! Form::close() !!}
			@if (Request::isMethod('post'))
				<br>
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
									{{-- <div class="dropdown">
										<button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<i class="fa fa-print"></i> Print Or Save to PDF (List Kelas)
											<span class="caret"></span>
										</button>
										<ul class="dropdown-menu pre-scrollable">
											@foreach ($kls->matkul as $mkl)
												<li><a href="{{ route('admin.form_peserta_ujian.print', [$kls->id_kelas, $mkl->id_matkul, @$ju]) }}" target="_blank">{{ $mkl->kode_matkul }} - {{ $mkl->nama_matkul }}</a></li>
											@endforeach
										</ul>
									</div> --}}
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
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

				if (id_matkul !== '') {
					window.open("{{ route('admin.form_peserta_ujian') }}/" + id_kelas + "/" + id_matkul + "/{{ @$ju }}/print", '_blank');
				}
			});
		});
	</script>
@stop