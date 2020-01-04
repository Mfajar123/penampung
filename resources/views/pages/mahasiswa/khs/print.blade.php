<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>PRINT KARTU HASIL STUDI</title>
	<style>
		body {
			font-family: Arial, Helvetica, sans-serif;
			font-size: 12px;
		}

		.clearfix {
			overflow: hidden;
			content: "";
			clear: both;
		}

		.logo img {
			float: left;
		}

		h3 {
			margin-top: 0;
			padding-top: 0;
		}

		.table-khs {
			width: 100%;
		}

		.table-khs thead tr td {
			border-top: 1px dashed #000;
			border-bottom: 1px dashed #000;
		}

		.table-khs thead tr td {
			text-align: center;
		}

		.table-khs tfoot tr:first-child td {
			border-top: 1px dashed #000;
		}

		.table-khs tfoot tr:last-child td {
			border-bottom: 1px dashed #000;
		}
	</style>
</head>
<body>
	<header>
		<div class="logo">
			<img src="{{ asset('images/logo/ppi.png') }}" alt="Logo STIE PPI" width="60" height="60">
			<small>STIE PUTRA PERDANA INDONESIA</small>
		</div>
		<div class="clearfix"></div>
		<center>
			<h3>KARTU HASIL STUDI (KHS)</h3>
		</center>
	</header>
	<table width="100%">
		<tbody>
			<tr>
				<td width="80">Nama Mahasiswa</td>
				<td>{{ $mahasiswa->nama }}</td>
				<td width="80">Program Studi</td>
				<td>{{ $mahasiswa->prodi->nama_prodi }}</td>
			</tr>
			<tr>
				<td>NIM</td>
				<td>{{ $mahasiswa->nim }}</td>
				@if (! empty($kelas))
					<td>Kelas</td>
					<td>{{ $kelas->kode_kelas }}</td>
				@endif
			</tr>
			<tr>
				<td>Semester</td>
				<td>{{ $semester }}</td>
				<td>Tahun Akademik</td>
				<td>{{ substr($krs->tahun_akademik, 0, 4)."/".(substr($krs->tahun_akademik, 0, 4) + 1) }}</td>
			</tr>
		</tbody>
	</table>
	<table class="table-khs">
		<thead>
			<tr>
				<td>No.</td>
				<td>Kode MK</td>
				<td>Mata Kuliah</td>
				<td>HM</td>
				<td>AM</td>
				<td>K</td>
				<td>NM</td>
			</tr>
		</thead>
		<tbody>
			<?php
				$no = 1;
				$total_sks = 0;
				$total_nm = 0;
			?>
			@foreach ($matkul as $m)
				<?php
					$nm = $m->bobot * $m->sks;
					$total_sks += $m->sks;
					$total_nm += $nm;
				?>
				<tr>
					<td align="center">{{ $no++ }}</td>
					<td align="center">{{ $m->kode_matkul }}</td>
					<td>{{ $m->nama_matkul }}</td>
					<!-- <td align="center">{{ $m->grade }}</td> -->
					<td align="center">{{ $m->huruf }}</td>
					<td align="center">{{ $m->bobot }}</td>
					<td align="center">{{ $m->sks }}</td>
					<td align="center">{{ $nm }}</td>
				</tr>
			@endforeach
		</tbody>
		<tfoot>
			<tr>
				<td colspan="6" align="right">Indeks Prestasi Semester (IPS)</td>
				<td align="center">{{ number_format(($total_nm / $total_sks), 2) }}</td>
			</tr>
			<tr>
				<td colspan="2" align="right">Jumlah SKS</td>
				<td>{{ $total_sks }}</td>
				<td colspan="3" align="right">Indeks Prestasi Komulatif (IPK)</td>
				<td align="center">{{ $ipk['ipk'] }}</td>
			</tr>
			<tr>
				<td colspan="2" align="right">SKS diperoleh</td>
				<td>{{ $ipk['total_sks'] }}</td>
				<td colspan="3" align="right">Kredit Maksimum Semester (KMS)</td>
				<td align="center">
					<?php
						$kms = null;

						if ($total_nm > 3) {
							$kms = "24";
						} else if ($total_nm > 2.49) {
							$kms = "15 - 18";
						} else {
							$kms = "18 - 21";
						}

						echo $kms." SKS";
					?>
				</td>
			</tr>
		</tfoot>
	</table>
	<br>
	<table width="100%">
		<thead>
			<tr>
				<td width="60%"></td>
				<td width="25%">Ketua Program Studi :</td>
				<td width="15%"></td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td></td>
				<td style="border-bottom: 1px dashed #000">
					<br>
					<br>
					<br>
					<br>
				</td>
				<td></td>
			</tr>
		</tbody>
	</table>
</body>
</html>