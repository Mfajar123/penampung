<html>
	<head>
		<title>KRS (Kartu Rencana Studi)</title>
		<link rel="stylesheet" href="{{ asset('plugins/assets/css/bootstrap.min.css') }}">
		<link rel="stylesheet" href="{{ asset('css/model.css') }}">
	</head>
	<body>
		<center><h4>RENCANA STUDI</h4></center>
				<table class="table table-bordered">
					<tr>
						<td width="5%">No</td>
						<td width="10%">Kode</td>
						<td>Mata Kuliah</td>
						<td>SKS</td>
						<td>Paraf Pengawas</td>
					</tr>
			@if(count($krs_item))
				<?php $no = 1; ?>
				@foreach( $krs_item as $krs )
					<tr>
						<td> {{ $no++ }} </td>
						<td> {{ $krs->kode_matkul }} </td>
						<td> {{ $krs->nama_matkul }} </td>
						<td> {{ $krs->sks }} </td>
						<td>  </td>
					</tr>
				@endforeach
			@else
				<tr>
					<td colspan="5" style="text-align: center;">Jadwal Tidak Ada</td>
				</tr>
			@endif
					
				</table>

        </div>
		
		<p>Catatan:</p>
		<ol>
			<li>Kartu ini dianggap sah setelah distamp Bagian Administrasi Akademik.</li>
			<li>Simpan sebagai bukti mengikuti ujian.</li>
		</ol>

		<div class="row" style="margin-bottom: 50px;">
			<div class="col-md-8"></div>
			<div class="col-md-4">
				<div >
					Tangerang,<?php echo date("d-M-Y ")  ?>
					<br><br><br><br>
					<p>BAAK</p>
				</div>
			</div>
		</div>
	</body>
	<style>
		.table>tbody>tr>th {
			padding: 2px;
		}
		
		.table>tbody>tr>td {
			padding: 2px;
		}
	
		.kolom>tbody>tr>th,td {
			padding: 2px; 
			
		}
	</style>
</html>
