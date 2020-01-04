<div class="box box-default">
	<div class="box-header with-border">
		<h4 class="box-title">Detail</h4>
	</div>
	<div class="box-body">
		<div class="table-responsive">
			<table class="table">
				<tbody>
					<tr>
						<th width="150">Dosen</th>
						<td width="10">:</td>
						<td>{{ @$dosen->nip }} - {{  @$dosen->nama }}</td>
					</tr>
					<tr>
						<th>Tahun Akademik</th>
						<td>:</td>
						<td>{{ ! empty($tahun_akademik) ? $tahun_akademik : '-' }}</td>
					</tr>
					<tr>
						<th>Program Studi</th>
						<td>:</td>
						<td>{{ ! empty($kelas->prodi->nama_prodi) ? $kelas->prodi->nama_prodi : '-' }}</td>
					</tr>
					<tr>
						<th>Semester</th>
						<td>:</td>
						<td>{{ ! empty($kelas->semester->semester_ke) ? $kelas->semester->semester_ke : '-' }}</td>
					</tr>
					<tr>
						<th>Kelas</th>
						<td>:</td>
						<td>{{ ! empty($kelas->id_prodi) ? $kelas->id_prodi : '-' }} - {{ ! empty($kelas->kode_kelas) ? $kelas->kode_kelas : '-' }}</td>
					</tr>
					<tr>
						<th>Mata Kuliah</th>
						<td>:</td>
						<td>{{ ! empty($matkul->kode_matkul) ? $matkul->kode_matkul : '-' }} - {{ ! empty($matkul->nama_matkul) ? $matkul->nama_matkul : '-' }}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>