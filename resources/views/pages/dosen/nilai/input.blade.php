@extends ('template')

@section ('main')
	<section class="content-header">
		<h1>Input Nilai Mahasiswa</h1>
	</section>

	<section class="content">
		<div class="box box-default">
			<div class="box-header with-border">
				<h4 class="box-title">Form</h4>
			</div>
			<div class="box-body">
			{!! Form::open(['method' => 'POST', 'route' => ['dosen.nilai.input.simpan', $tahun_akademik, $id_kelas, $matkul->kode_matkul]]) !!}
				<table class="table">
					<tr>
						<th width="200">Kode Mata Kuliah</th>
						<td width="10">:</td>
						<td>{{ $matkul->kode_matkul }}</td>
					</tr>
					<tr>
						<th>Nama Mata Kuliah</th>
						<td>:</td>
						<td>{{ $matkul->nama_matkul }}</td>
					</tr>
				</table>

				<div class="table-responsive">
					<table class="table table-striped table-bordered">
						<thead>
							<tr>
								<th width="50">No.</th>
								<th width="150">NIM</th>
								<th nowrap>Nama Mahasiswa</th>
								<th width="150" class="text-center">Kehadiran ({{ !empty($persentase_nilai->kehadiran) ? $persentase_nilai->kehadiran : '0' }}%)</th>
								<th width="150" class="text-center">Nilai Tugas ({{ !empty($persentase_nilai->tugas) ? $persentase_nilai->tugas : '0' }}%)</th>
								<th width="150" class="text-center">Nilai UTS ({{ !empty($persentase_nilai->uts) ? $persentase_nilai->uts : '0' }}%)</th>
								<th width="150" class="text-center">Nilai UAS ({{ !empty($persentase_nilai->uas) ? $persentase_nilai->uas : '0' }}%)</th>
								<th width="150" class="text-center">Total</th>
								<th width="150" class="text-center">Bobot</th>
								<th width="150" class="text-center">Grade</th>
							</tr>
						</thead>
						<tbody>
							@if (!empty($list_mahasiswa) || count($list_mahasiswa) > 0)
								<?php
									$no = 1;
									$tabindex = 1;
								?>
								@foreach ($list_mahasiswa as $mahasiswa)
									<tr>
										<td>{{ $no++ }}</td>
										<td>{{ $mahasiswa->nim }}</td>
										<td>{{ $mahasiswa->nama }}</td>
										<td>{!! Form::text('nim['.$mahasiswa->nim.'][hadir]', ! empty($mahasiswa->hadir) ? number_format($mahasiswa->hadir, 0) : 0, ['persentase' => ! empty($persentase_nilai->kehadiran) ? $persentase_nilai->kehadiran : 0, 'readonly', 'class' => 'form-control text-center form-number form-kehadiran']) !!}</td>
										<td>{!! Form::text('nim['.$mahasiswa->nim.'][tugas]', ! empty($mahasiswa->tugas) ? number_format($mahasiswa->tugas, 0) : 0, ['persentase' => ! empty($persentase_nilai->tugas) ? $persentase_nilai->tugas : 0, 'tabindex' => $tabindex, 'class' => 'form-control text-center form-number form-tugas']) !!}</td>
										<td>{!! Form::text('nim['.$mahasiswa->nim.'][uts]', ! empty($mahasiswa->uts) ? number_format($mahasiswa->uts, 0) : 0, ['persentase' => ! empty($persentase_nilai->uts) ? $persentase_nilai->uts : 0, 'tabindex' => $tabindex + count($list_mahasiswa), 'class' => 'form-control text-center form-number form-uts']) !!}</td>
										<td>{!! Form::text('nim['.$mahasiswa->nim.'][uas]', ! empty($mahasiswa->uas) ? number_format($mahasiswa->uas, 0) : 0, ['persentase' => ! empty($persentase_nilai->uas) ? $persentase_nilai->uas : 0, 'tabindex' => $tabindex + (count($list_mahasiswa) * 2), 'class' => 'form-control text-center form-number form-uas']) !!}</td>
										<td>{!! Form::text('nim['.$mahasiswa->nim.'][total]', ! empty($mahasiswa->total) ? number_format($mahasiswa->total, 2) : 0, ['readonly', 'class' => 'form-control text-center form-total']) !!}</td>
										<td>{!! Form::text('nim['.$mahasiswa->nim.'][bobot]', ! empty($mahasiswa->bobot) ? $mahasiswa->bobot : 0, ['readonly', 'class' => 'form-control text-center form-bobot']) !!}</td>
										<td>{!! Form::text('', ! empty($mahasiswa->grade) ? $mahasiswa->grade : NULL, ['readonly', 'class' => 'form-control text-center form-grade']) !!}</td>
									</tr>
									<?php $tabindex++ ?>
								@endforeach
							@else
								<tr>
									<td colspan="10">Tidak ada data.</td>
								</tr>
							@endif
						</tbody>
					</table>
				</div>
				
				{!! Form::submit('Simpan', ['class' => 'btn btn-primary']) !!}
				<a href="{{ route('dosen.nilai.index') }}" class="btn btn-default">Batal</a>
			</div>
			{!! Form::close() !!}
		</div>
	</section>
@endsection

@section('script')
	<script type="text/javascript">
		function get_grade(nilai) {
			@foreach ($grade_nilai as $list)
				if (nilai >= {{ round($list->nilai_min) }} && nilai <= {{ round($list->nilai_max) }}) {
					return "{{ $list->huruf }}";
				}
			@endforeach
		}

		function get_bobot(nilai) {
			@foreach ($grade_nilai as $list)
				if (nilai >= {{ round($list->nilai_min) }} && nilai <= {{ round($list->nilai_max) }}) {
					return {{ $list->bobot }};
				}
			@endforeach
		}

		$(document).ready(function () {
			$(".form-number").on("keyup", function (e) {
				e.preventDefault();

				var total_score = 0;

				var kehadiran = ($(this).parent().parent().find(".form-kehadiran").val() === '') ? 0 : $(this).parent().parent().find(".form-kehadiran");
				var tugas = ($(this).parent().parent().find(".form-tugas").val() === '') ? 0 : $(this).parent().parent().find(".form-tugas");
				var uts = ($(this).parent().parent().find(".form-uts").val() === '') ? 0 : $(this).parent().parent().find(".form-uts");
				var uas = ($(this).parent().parent().find(".form-uas").val() === '') ? 0 : $(this).parent().parent().find(".form-uas");
				var total = $(this).parent().parent().find(".form-total");
				var grade = $(this).parent().parent().find(".form-grade");
				var bobot = $(this).parent().parent().find(".form-bobot");

				total_score += ($(kehadiran).val() === undefined ? 0 : $(kehadiran)[0].getAttribute('persentase')) / 100 * ($(kehadiran).val() === undefined ? 0 : $(kehadiran).val());
				total_score += ($(tugas).val() === undefined ? 0 : $(tugas)[0].getAttribute('persentase')) / 100 * ($(tugas).val() === undefined ? 0 : $(tugas).val());
				total_score += ($(uts).val() === undefined ? 0 : $(uts)[0].getAttribute('persentase')) / 100 * ($(uts).val() === undefined ? 0 : $(uts).val());
				total_score += ($(uas).val() === undefined ? 0 : $(uas)[0].getAttribute('persentase')) / 100 * ($(uas).val() === undefined ? 0 : $(uas).val());

				// total_score = Math.round(total_score);
				
				// total_score = (Math.floor(total_score) * 100) / 100;

				$(total).val(total_score);
				$(grade).val(get_grade(total_score));
				$(bobot).val(get_bobot(total_score));
			});
		});
	</script>
@stop