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
		{!! Form::open(['method' => 'PATCH', 'route' => ['admin.absensi.perbarui_mahasiswa', $kelas->id_kelas, $matkul->id_matkul, $dosen->id_dosen, $jadwal->id_jadwal, $nim]]) !!}
			<div class="box box-default">
				<div class="box-body">
					<div class="table-responsive">
						<table class="table table-bordered table-absensi">
							<thead>
								<tr>
									<th rowspan="2" class="text-center">NPM</th>
									<th rowspan="2" class="text-center">Nama Mahasiswa</th>
									<th colspan="15" class="text-center">Pertemuan</th>
								</tr>
								<tr>
									@for ($i = 0; $i <= count($pertemuan) - 1; $i++)
										@if (empty($pertemuan[$i]->tanggal))
											<th class="text-center">{{ $i + 1 }}</th>
										@else
											<th class="text-center">{{ $i + 1 }}</th>
										@endif
									@endfor
								</tr>
							</thead>
							<tbody>
								<?php $no = 1; ?>
								@foreach ($list_kehadiran as $kehadiran)
									<tr>
										<td>{{ $kehadiran->nim }}</td>
										<td>{{ $kehadiran->nama }}</td>
										@for ($i = 0; $i <= count($pertemuan) - 1; $i++)
											@if (empty($pertemuan[$i]->tanggal))
												<td></td>
											@else
												<td class="text-center">
													{!! Form::checkbox('kehadiran['.$pertemuan[$i]->tanggal.'.'.$pertemuan[$i]->pertemuan_ke.']', 'Hadir', (@$kehadiran->kehadiran[$pertemuan[$i]->tanggal.'.'.$pertemuan[$i]->pertemuan_ke]->keterangan == 'fa-check')) !!}
												</td>
											@endif
										@endfor
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<br>
					{!! Form::submit('Perbarui Kehadiran', ['class' => 'btn btn-primary']) !!}
				</div>
			</div>
		{!! Form::close() !!}
	</section>
@stop