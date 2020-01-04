<html>
	<head>
		<title>Hasil Angket Dosen</title>
		<link rel="stylesheet" href="{{ asset('plugins/assets/css/bootstrap.min.css') }}">
		<link rel="stylesheet" href="{{ asset('css/model.css') }}">
	</head>
	<body>
		<div>
			<div class="row">
				<div class="col-md-4 col-xs-2"></div>
			 	<div class="konten col-md-4 col-xs-8" style="padding:0px 0px; ">
	                <span><img src="{{asset('images/logo/ppi.png')}}"  alt="Logo STIE PPI" class="img-responsive"  title="Logo STIE PPI" style="width: 20%; margin: 0px;"></span>
	                <div class="bisa">
	                    <h4 style="color: black; text-align: center; margin-top: 5px; ">Sekolah Tinggi Ilmu Ekonomi Putra Perdana Indonesia</h4>
	                    <p style="text-align: center; color: black; padding-top: 10px;">Jl. Citra Raya Utama Barat, Griya Harsa II Blok i 10 no. 29, <br> Cikupa 15710 - Tangerang.</p>
	                </div> 
	            </div>
           		<div class="col-md-4 col-xs-2"></div>
	        </div>
	        <div class="row">
           		<div class="col-md-12" style="border-bottom: 1px solid black; margin: 15px 0px;"></div>
           	</div><br>
			   <table class="kolom" width="100%" cellspacing="0">
					<tr>
						<td>Dosen</td>
						<td>: {{@$dosen->gelar_depan}} {{@$dosen->nama}} {{@$dosen->gelar_belakang}} </td>
						<td></td>
						<td>Mata Kuliah</td>
						<td>: {{ $matkul->kode_matkul }} - {{ $matkul->nama_matkul }} </td>
					</tr>
					<tr>
						<td>Program Studi</td>
						<td>: {{ $dosen->prodi->nama_prodi }}  </td>
						<td></td>
						<td>Tahun Akademik</td>
						<td>: {{ $tahun_akademik->keterangan }}</td>
					</tr>
				</table>
				<br>
			
				<table class="table  table-bordered"  >
				
						<tr >
							<td rowspan="2" style="text-align: center;" width="5%" rowspan="2">No.</td>
							<td rowspan="2" style="text-align: center;" width="10%" rowspan="2">NIM</td>
							<td rowspan="2" style="text-align: center;" width="35%" rowspan="2">Nama Mahasiswa</td>
							<td colspan="4" style="text-align: center; padding: 5px; " colspan="7" rowspan="1" >Rekapitulasi</td>
							<td rowspan="2" style="text-align: center; " rowspan="2" width="5%">Total Nilai</td>
						</tr>
						<tr>
							<td rowspan="2" style="text-align: center;">Pedagogik</td>
							<td rowspan="2" style="text-align: center;">Profesional</td>
							<td rowspan="2" style="text-align: center;">Kepribadian</td>
							<td rowspan="2" style="text-align: center;">Sosial</td>
						</tr>
					<tbody>
						@if (count($data) > 0)
						    <?php $numb = 1; ?>
							@foreach ($data as $list)
								<tr>
									<td style="padding: 5px; text-align: center; font-size: 13px;">{{ $numb++ }}</td>
									<td style="padding: 5px; text-align: center; font-size: 13px;">{{ $list->nim }}</td>
									<td style="padding: 5px; text-align: center; font-size: 13px;">{{ $list->nama }}</td>
									<td style="padding: 5px; text-align: center; font-size: 13px;" class="text-center">{{ $list->total_pedagogik }}</td>
									<td style="padding: 5px; text-align: center; font-size: 13px;" class="text-center">{{ $list->total_profesional }}</td>
									<td style="padding: 5px; text-align: center; font-size: 13px;" class="text-center">{{ $list->total_kepribadian }}</td>
									<td style="padding: 5px; text-align: center; font-size: 13px;" class="text-center">{{ $list->total_sosial }}</td>
									<td style="padding: 5px; text-align: center; font-size: 13px;" class="text-center">{{ number_format(($list->total_pedagogik + $list->total_profesional + $list->total_kepribadian + $list->total_sosial) / 2, 2) }}</td>
								</tr>
							@endforeach
						@else
							<tr>
								<td colspan="11">Tidak ada data.</td>
							</tr>
						@endif
					</tbody>
				</table>
			
		</div>
		<script type="text/javascript">window.print()</script>
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
		
		.table-bordered td, .table-bordered th{
            border: 1px black dotted !important;
            
        }
        
       
</style>
</html>
