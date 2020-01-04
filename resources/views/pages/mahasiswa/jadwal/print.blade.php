<html>
	<head>
		<title>Jadwal Kuliah</title>
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
           		<h4 style="text-align: center; margin: 5px;">Jadwal Kuliah(Tanggal Cetak : <?php echo date("d-M-Y ")  ?>)</h4>
           		<div class="col-md-5 col-xs-4" ></div>
           		<div class="col-md-2 col-xs-4" style="border-bottom: 1px solid black; text-align: center;"></div>
           		<div class="col-md-5 col-xs-4" ></div>
           	</div><br>
        
       		<div class="table-responsive">
				<table class="kolom" width="100%" cellspacing="0">
					<tr>
						<th>NIM</th>
						<td>: {{@$mahasiswa->nim}} </td>
						<td></td>
						<th>Waktu Kuliah</th>
						<td>: {{ Auth::guard('mahasiswa')->user()->waktu_kuliah->nama_waktu_kuliah }}</td>
					</tr>
					<tr>
						<th>Nama</th>
						<td>: {{@$mahasiswa->nama}}</td>
						<td></td>
						<th>Semester</th>
						<td>: {{@$mahasiswa->Semester->semester_ke}}</td>
					</tr>
					<tr>
						<th>PTS</th>
						<td>: STIE Putra Perdana Indonesia </td>
						<td></td>
						<th>Tahun Ajaran</th>
						<td>: {{ @$mahasiswa->keterangan }} </td>
					</tr>
					<tr>
						<th>Program Studi</th>
						<td>: {{@$mahasiswa->Prodi->nama_prodi}} </td>
						<td></td>
						<th>Kelas</th>
						<td>: @if(!empty(@$mahasiswa->nama_kelas)) {{ @$mahasiswa->nama_kelas }} @else  Pindahan  @endif</td>
					</tr>
				</table>
			</div><br>
		

		<div class="box-body">
      		<div class="row"> 
                <div class="col-xs-12 table-responsive">
                    <table class="table table-bordered table-striped jadwal">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Hari/Jam</th>
                          <th>Ruang</th>
                          <th>Kelas</th>
                          <th>Matkul</th>
                          <th>Dosen</th>
                        </tr>
                      </thead>
                      <tbody>
                        @if(count($list_jadwal))
                          <?php $no = 1; ?>
                          @foreach ($list_jadwal as $jadwal)
                            <tr>
                              <td>{{ $no++ }}</td>
                              <td>
                                {{ $jadwal->nama_hari }} /
                                {{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}
                              </td>
                              <td>{{ $jadwal->kode_ruang }}</td>
                              <td>{{ $jadwal->kode_kelas }} - {{ $jadwal->nama_kelas }}</td>
                              <td>{{ $jadwal->kode_matkul }} - {{ $jadwal->nama_matkul }}</td>
                              <td>{{ $jadwal->nama }}</td>
                            </tr>
                          @endforeach
                          
                        @else
                        <tr>
                          <td colspan="6">Tidak ada data</td>
                        </tr>
                        @endif
                      </tbody>
                    </table>
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
