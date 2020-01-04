<p>
		<a href="{{ route('mahasiswa.khs.print', $semester) }}" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Cetak KHS</a>
</p>
<table class="table table-striped table-bordered">
  	<thead>
	      <tr>
	        <th width="30" rowspan="2">No.</th>
	        <th rowspan="2">Kode</th>
	        <th rowspan="2">Mata Kuliah</th>
	        <th rowspan="2">SKS</th>
	        <th colspan="2">Nilai</th>
	        <th rowspan="2">Angka Mutu</th>
	        <th rowspan="2">Nilai Mutu</th>
	      </tr>
	    <tr>
	      <th>Angka</th>
	      <th>Huruf</th>
	    </tr>
  	</thead>

	<tbody>
	@if($count > 0)
		<?php
			$total_sks = 0;
			$total_score = 0;
		?>
		@foreach($matkul as $list)
			<?php
				$total_sks += $list->sks;
				$total_score += $list->sks * $list->bobot;
			?>
			<tr>
				<td>{{ $no++ }}</td>
				<td>{{ $list->kode_matkul }}</td>
				<td>{{ $list->nama_matkul }}</td>
				<td class="text-center">{{ $list->sks }}</td>
				<td class="text-center">{{ $list->total }}</td>
				<td class="text-center">{{ $list->huruf }}</td>
				<td class="text-center">{{ $list->bobot }}</td>
				<td class="text-center">{{ number_format($list->sks * $list->bobot, 2) }}</td>
			</tr>
		@endforeach
		<tr>
			<th class="text-right" colspan="3">Total</th>
			<th class="text-center">{{ $total_sks }}</th>
			<th colspan="3"></th>
			<th class="text-center">{{ number_format($total_score, 2) }}</th>
		</tr>
		<tr>
			<th class="text-right" colspan="3">Indeks Prestasi Semester</th>
			<th class="text-center" colspan="5">{{ number_format($total_score / $total_sks, 2) }}</th>
		</tr>
		<tr>
			<th class="text-right" colspan="3">Indeks Prestasi Kumulatif</th>
			<th class="text-center" colspan="5">{{ number_format($ipk, 2) }}</th>
		</tr>
	@else
	<tr>
		<td colspan="9"><center>Tidak Ada Data</center></td>
	</tr>
	@endif
	</tbody>
</table>

<br><br>

<b> Detail Nilai : </b>
<table class="table table-striped table-bordered" style="width: 50%;">
	<thead>
	    <tr>
	        <th width="30">No.</th>
	        <th>Mata Kuliah</th>
	        <th>Kehadiran</th>
	        <th>Tugas</th>
	        <th>UTS</th>
	        <th>UAS</th>
	    </tr>
  	</thead>

	<tbody>
	<?php $no=1 ?>
	@foreach($matkul as $list)
		<?php
			$total_sks += $list->sks;
			$total_score += $list->sks * $list->bobot;
		?>
		<tr>
			<td>{{ $no++ }}</td>
			<td>{{ $list->nama_matkul }}</td>
			<td class="text-center">{{ $list->hadir }}</td>
			<td class="text-center">{{ $list->tugas }}</td>
			<td class="text-center">{{ $list->uts }}</td>
			<td class="text-center">{{ $list->uas }}</td>
			</tr>
	@endforeach
	</tbody>
</table>