<?php
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=jadwal.xls");
?>
<table border="1">

	<thead>

	<tr>

		<th>No</th>

		<th>Hari/Jam</th>

		<th>Ruang</th>

		<th>Matkul</th>

		<th>Kelas</th>

		<th>Dosen</th>

	</tr>

	</thead>

	<?php $no=1; ?>

	<tbody>

	@foreach($jadwal as $list)

	<tr>

		<td>{{$no++}}</td>

		<td>{{$list->hari}}<br>{{date('H:i', strtotime($list->jam_mulai)).'-'.date('H:i', strtotime($list->jam_selesai))}}</td>

		<td>{{$list->ruang->kode_ruang}}</td>

		<td>{{$list->matkul->kode_matkul.'-'.$list->matkul->nama_matkul}}<br>{{$list->matkul->sks.' sks'}}</td>

		<td>{{$list->id_prodi}} - {{$list->kelas->kode_kelas}}</td>

		<td>{{$list->dosen->nama}}<br>{{$list->dosen->nip}}</td>

	</tr>

	@endforeach

	</tbody>

</table>