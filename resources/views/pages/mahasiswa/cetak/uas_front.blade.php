<html>
	<head>
		<title>KRS (Kartu Rencana Studi)</title>
		<link rel="stylesheet" href="{{ asset('plugins/assets/css/bootstrap.min.css') }}">
		<link rel="stylesheet" href="{{ asset('css/model.css') }}">
	</head>
	<body>
		<div class="row">
			<div class="col-md-5 col-xs-5"></div>
			<div class="col-md-6 col-xs-6">
				 <span><img src="{{asset('images/logo/ppi.png')}}"  alt="Logo STIE PPI" class="img-responsive"  title="Logo STIE PPI" style="width: 20%; margin: 0px; margin-left: 10px;"></span>
			</div>
			<div class="col-md-1 col-xs-1"></div>
		</div>
		<div class="row">
			<div class="col-md-4 col-xs-2"></div>
		 	<div class="konten col-md-4 col-xs-8" style="padding:0px 0px; ">
		       
		        <div class="bisa">
		            <h4 style="color: black; text-align: center; margin-top: 5px; ">KARTU PESERTA UJIAN</h4>
		            <h4 style="color: black; text-align: center; text-transform: uppercase;">( {{ $ujian->jenis_ujian }} {{ $ujian->keterangan }} )</h4>	
		        </div> 
		    </div>
				<div class="col-md-4 col-xs-2"></div>
		</div><br><br>
		<div class="container">
			<table class="kolom" width="100%" cellspacing="0">
				<tr>
					<th>Nama</th>
					<td>: <b> {{@$mahasiswa->nama}} </b></td>
					<td></td>
					<th>Waktu Kuliah</th>
					<td>: {{ Auth::guard('mahasiswa')->user()->waktu_kuliah->nama_waktu_kuliah }}</td>
				</tr>
				<tr>
					<th>NIM</th>
					<td>: <b> {{@$mahasiswa->nim}} </b></td>
					<td></td>
				<th>No Kursi</th>
				<td>: {{ @$m_kelas->no_absen}}</td>
				</tr>
				<tr>
					<th>Program Studi</th>
					<td>: {{@$mahasiswa->Prodi->nama_prodi}} </td>
					<td></td>
					<th>Kelas</th>
					<td>: {{ @$m_kelas->id_prodi. '' .@$m_kelas->kode_kelas }}</td>
				</tr>
			</table> <br>

			<b><p>Tata tertib peserta ujian:</p></b>
				
				<ol>
					<li>Mengenakan jas alamamater selama ujian berlangsung.</li>
					<li>Datang 5 menit sebelum ujian dimulai, bagi peserta yang terlambat tidak ada perpanjangan waktu.</li>
					<li>Membawa kartu ujian, dan <b>tidak ada surat ijin mengikuti ujian bagi peserta ujian</b>yang tidak membawa kartu ujian.</li>
					<li>Mengisi daftar hadir ujian.</li>
					<li>Tidak diperkenankan: Memakai kaos oblong (tanpa krah), Memakai sandal(pria) atau sepatu tidak tertutup(wanita), Menyontek atau memberi contekan, Meninggalkan ruang ujian tanpa ijin pengawas, Menyalakan alat komunikasi dengan alasan apapun dan Membawa makanan dan minuman ke dalam ruang ujian.</li>
					<li>Peserta ujian wajib duduk sesuai nomor kursi masing2 yang tertera pada kartu</li>
					<li>Pengawas atau dosen pengampu berhak menyatakan hasil ujian tidak syah atau batal atas pelanggaran diatas.</li>
					<li>Bagi peserta ujian yang meninggalkan ruang ujian tanpa seijin pengawas, dianggap telah menyelesaikan ujian.</li>
					<li>Ujian susulan diperkenankan dengan syarat dan ketentuan yang berlaku.</li>

				</ol>
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
