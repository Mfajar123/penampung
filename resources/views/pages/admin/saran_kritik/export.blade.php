<?php
	// Fungsi header dengan mengirimkan raw data excel
	header("Content-type: application/vnd-ms-excel");
	
	// Mendefinisikan nama file ekspor "hasil-export.xls"
	header("Content-Disposition: attachment; filename=".$title."-".date('dmY').".xls");
?>
<table border="1">
	<thead>
		<tr>
			<th>No.</th>
			@if (! in_array($title, ['Sarana Prasarana', 'Pengembangan Soft Skill Mahasiswa']))
				<th>NIP</th>
				<th>Nama Dosen</th>
				<th>Mata Kuliah</th>
				<th>Kelas</th>
			@endif
			<th>Jawaban</th>
	</thead>
	<tbody>
		<?php $no = 1; ?>
		@foreach ($data as $list)
			<tr>
				<td>{{ $no++ }}</td>
				@if (! in_array($title, ['Sarana Prasarana', 'Pengembangan Soft Skill Mahasiswa']))						
					<td>{{ $list->nip }}</td>
					<td>{{ $list->gelar_depan }}{{ $list->nama }}{{ $list->gelar_belakang }}</td>
					<td>{{ $list->kode_matkul }} - {{ $list->nama_matkul }}</td>
					<td>{{ $list->nama_kelas }}</td>
				@endif
				<td>{{ $list->jawaban }}</td>
			</tr>
		@endforeach
	</tbody>
</table>