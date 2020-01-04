<div class="modal fade" id="modal-edit-absensi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Form Edit Absensi</h4>
			</div>
			{!! Form::open(['method' => 'PATCH', 'route' => ['admin.absensi.edit_absensi', $kelas->id_kelas, $matkul->id_matkul, $dosen->id_dosen, $jadwal->id_jadwal]]) !!}
			<div class="modal-body">
				{!! Form::hidden('nim') !!}
				<div class="form-group">
					{!! Form::label('nama', 'Nama Mahasiswa', ['class' => 'control-label']) !!}
					{!! Form::text('nama', null, ['disabled', 'class' => 'form-control']) !!}
				</div>
				<div class="form-group">
					{!! Form::label('pertemuan_ke', 'Pertemuan ke', ['class' => 'control-label']) !!}
					{!! Form::select('pertemuan_ke', $list_pertemuan, null, ['required', 'placeholder' => '- Pilih Pertemuan -', 'class' => 'form-control']) !!}
				</div>
				<div class="form-group">
					{!! Form::label('keterangan', 'Kehadiran', ['class' => 'control-label']) !!}
					{!! Form::select('keterangan', ['Hadir' => 'Hadir', 'Alpha' => 'Tidak Hadir'], null, ['required', 'placeholder' => '- Pilih Status Kehadiran -', 'class' => 'form-control']) !!}
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary">Simpan</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
			</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
<div class="box box-default">
	<div class="box-header with-border">
		<a href="{{ route('admin.absensi.form_absensi', [$kelas->id_kelas, $matkul->id_matkul, $dosen->id_dosen, $jadwal->id_jadwal]) }}" class="btn btn-default"><i class="fa fa-check-square-o"></i> Tambah Absensi</a>
	</div>
	<div class="box-body">
		@include('_partials.flash_message')
		<div class="table-responsive">
			<table class="table table-bordered table-absensi">
				<thead>
					<tr>
						<th rowspan="2" class="text-center">NPM</th>
						<th rowspan="2" class="text-center">Nama Mahasiswa</th>
						<th colspan="16" class="text-center">Pertemuan</th>
						<th rowspan="2" class="text-center">Jumlah</th>
						<th rowspan="2" class="text-center">Aksi</th>
					</tr>
					<tr>
						@for ($i = 0; $i <= 15; $i++)
							@if (empty($pertemuan[$i]->tanggal))
								<th class="text-center">{{ $i + 1 }}</th>
							@else
								{{-- <th class="text-center"><a href="{{ route('admin.absensi.form_edit', [$kelas->id_kelas, $matkul->id_matkul, $dosen->id_dosen, $jadwal->id_jadwal, $pertemuan[$i]->tanggal, $pertemuan[$i]->pertemuan_ke]) }}" data-toggle="tooltip" data-placement="top" title="Edit Absensi">{{ $i + 1 }}</a></th> --}}
								<th class="text-center">
									{{ $i + 1 }}<br/>
									<a href="{{ route('admin.absensi.form_edit', [$kelas->id_kelas, $matkul->id_matkul, $dosen->id_dosen, $jadwal->id_jadwal, $pertemuan[$i]->tanggal, $pertemuan[$i]->pertemuan_ke]) }}" data-toggle="tooltip" data-placement="top" title="Edit Absensi"><i class="fa fa-fw fa-edit"></i></a>
									<a href="{{ route('admin.absensi.hapus_absensi', [$kelas->id_kelas, $matkul->id_matkul, $dosen->id_dosen, $jadwal->id_jadwal, $pertemuan[$i]->tanggal, $pertemuan[$i]->pertemuan_ke]) }}" data-toggle="tooltip" data-placement="top" title="Hapus Absensi"><i class="fa fa-fw fa-remove"></i></a>
								</th>
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
							@for ($i = 0; $i <= 15; $i++)
								@if (empty($pertemuan[$i]->tanggal))
									<td></td>
								@else
									<td class="text-center">
										<i data-toggle="tooltip" data-placement="top" title="{{ @$kehadiran->kehadiran[$pertemuan[$i]->tanggal]->notes }}" class="fa {{ @$kehadiran->kehadiran[$pertemuan[$i]->tanggal.'.'.$pertemuan[$i]->pertemuan_ke]->keterangan }}"></i>
									</td>
								@endif
							@endfor
							<td class="text-center">{{ $kehadiran->jumlah }}</td>
							<td>
								{{-- <button type="button" data-nim="{{ $kehadiran->nim }}" data-nama="{{ $kehadiran->nama }}" class="btn btn-warning btn-xs btn-edit-absensi"><i class="fa fa-edit"></i> Edit</button> --}}
								<a href="{{ route('admin.absensi.edit_mahasiswa', [$kelas->id_kelas, $matkul->id_matkul, $dosen->id_dosen, $jadwal->id_jadwal, $kehadiran->nim]) }}" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i> Edit</a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>

@section('script')
	<script type="text/javascript">
		$(document).ready(function () {
			$(".table-absensi").on("click", ".btn-edit-absensi", function (e) {
				e.preventDefault();

				var modal = $("#modal-edit-absensi");
				var nim = $("#modal-edit-absensi").find("input[name='nim'][type='hidden']");
				var nama = $("#modal-edit-absensi").find("input[name='nama']");

				$(nim).val(this.getAttribute('data-nim'));
				$(nama).val(this.getAttribute('data-nama'));
				$(modal).modal('show');
			});
		});
	</script>
@stop