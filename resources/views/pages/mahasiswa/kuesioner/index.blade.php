@extends ('template')

@section ('main')
	<section class="content">
		<div class="box box-primary">
			<div class="box-body">
				{!! Form::open(['method' => 'POST', 'route' => 'mahasiswa.kuesioner.simpan']) !!}
					{!! Form::hidden('id_dosen', $jadwal->id_dosen) !!}
					{!! Form::hidden('nim', $jadwal->nim) !!}
					{!! Form::hidden('id_semester', $jadwal->id_semester) !!}
					{!! Form::hidden('id_matkul', $jadwal->id_matkul) !!}
					{!! Form::hidden('id_kelas', $jadwal->id_kelas) !!}
					{!! Form::hidden('tahun_akademik', $jadwal->tahun_akademik) !!}
					<h4 class="text-center text-bold" style="line-height: 1.5; margin-bottom: 0">SEKOLAH TINGGI ILMU EKONOMI<br>PUTRA PERDANA INDONESIA</h4>
					<p class="text-center">Jl citra raya Utama Barat No.29 Griya Harsa II Blok I 10 Citra Raya. Cikupa Tangerang15710</p>
					<hr>
					<h4 class="text-center" style="line-height: 1.5">KUESIONER EVALUASI PEMBELAJARAN<br>PRODI AKUNTANSI/MANAJEMEN</h4>
					<table class="table">
						<thead>
							<tr>
								<td width="150"><strong>Nama Dosen</strong></td>
								<td width="5">:</td>
								<td>{{ $jadwal->nip }} - {{ $jadwal->nama }}</td>
								<td width="150"><strong>Mata Kuliah</strong></td>
								<td width="5">:</td>
								<td>{{ $jadwal->kode_matkul }} - {{ $jadwal->nama_matkul }}</td>
							</tr>
							<tr>
								<td><strong>Semester</strong></td>
								<td>:</td>
								<td>{{ $jadwal->semester_ke }}</td>
								<td><strong>Kelas</strong></td>
								<td>:</td>
								<td>{{ $jadwal->kode_kelas }}</td>
							</tr>
						</thead>
					</table>
					<hr>
					<h5><strong>PETUNJUK:</strong></h5>
					<p class="text-justify">Program studi Akuntansi dan Manajemen, akan menyelenggarakan evaluasi terhadap proses perkuliahan, untuk itu kami mohon kerjasama saudara memberikan informasi secara jujur, objektif, dan penuh tanggung jawab terhadap dosen Saudara. Hasil penilaian saudara tidak akan berpengaruh terhadap status dan hasil ujian Saudara sebagai mahasiswa. Penilaian dilakukan terhadap aspek-aspek dalam tabel berikut dengan cara memilih salah satu angka (1-5) pada kolom skor/ lembar yang telah disediakan.</p>
					<p style="margin-bottom: 15px">
						1 = sangat tidak baik/sangat rendah/tidak pernah<br>
						2 = tidak baik/rendah/jarang<br>
						3 = biasa/cukup/kadang-kadang<br>
						4 = baik/tinggi/sering<br>
						5 = sangat baik/sangat tinggi/selalu
					</p>
					<?php $no = 1 ?>
					@foreach ($kuesioner_form->kuesioner_kategori()->get() as $kuesioner_kategori)
						<h5 style="margin-top: 0; margin-bottom: 15px; font-size: 12pt"><strong>{{ $kuesioner_kategori->title }}</strong></h5>
						@if ($kuesioner_kategori->jenis_pertanyaan == 'Pilihan Ganda')
							<div class="table-responsive">
								<table class="table table-striped table-bordered">
									<thead>
										<tr>
											<th width="50" class="text-center">No.</th>
											<th class="text-center">Butir-butir yang Dinilai</th>
											<th width="250 "class="text-center">Pengampu</th>
										</tr>
									</thead>
									<tbody>
										@foreach ($kuesioner_kategori->kuesioner_pertanyaan()->get() as $kuesioner_pertanyaan)
											<tr>
												<td class="text-center">{{ $no++ }}</td>
												<td>{{ $kuesioner_pertanyaan->pertanyaan }}</td>
												<td class="text-center">
													@for ($i = 1; $i <= 5; $i++)
														<div class="radio-inline">
															<label>{!! Form::radio('kuesioner_detail['.$kuesioner_pertanyaan->id_kuesioner_pertanyaan.']', $i, false, ['required']) !!} {{ $i }}</label>
														</div>
													@endfor
												</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						@else
							@foreach ($kuesioner_kategori->kuesioner_pertanyaan()->get() as $kuesioner_pertanyaan)
								<div class="form-group">
									{!! Form::label('kuesioner_detail['.$kuesioner_pertanyaan->id_kuesioner_pertanyaan.']', $kuesioner_pertanyaan->pertanyaan, ['class' => 'control-label']) !!}
									{!! Form::textarea('kuesioner_detail['.$kuesioner_pertanyaan->id_kuesioner_pertanyaan.']', null, ['rows' => 3, 'class' => 'form-control']) !!}
								</div>
							@endforeach
						@endif
					@endforeach
					{!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
				{!! Form::close() !!}
			</div>
		</div>
	</section>
@stop