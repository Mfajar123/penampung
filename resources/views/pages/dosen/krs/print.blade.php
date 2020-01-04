<html>
	<head>
		<title>KRS (Kartu Rencana Studi)</title>
		<link rel="stylesheet" href="{{ asset('plugins/assets/css/bootstrap.min.css') }}">
		<link rel="stylesheet" href="{{ asset('css/model.css') }}">
	</head>
	<body>
		<div>
			<div class="row" >
				<div class="col-md-2 col-xs-2"></div>
			 	<div class="konten col-md-8 col-xs-8" style="padding:0px 0px; ">
	                <span><img src="{{asset('images/logo/stie-logo.png')}}"  alt="Logo STIE PPI" class="img-responsive"  title="Logo STIE PPI" style="width: 10%; margin: 0px; margin-left: 20px; " class="img-responsive"></span>
	                <div class="bisa">
	                    <h4 style="color: black; text-align: center; margin-top: 5px; ">Sekolah Tinggi Ilmu Ekonomi Putra Perdana Indonesia</h4>
	                    
	                    <p style="text-align: center; color: black; padding-top: 10px; font-size:11px; ">Jl. Citra Raya Utama Barat, Griya Harsa II Blok i 10 no. 29, Cikupa 15710 - Tangerang.</p>
	               
	                    <h5 style="color: black; text-align: center; margin-left: 50px;">Kartu Rencana Studi</h5>
	                </div> 
	            </div>
           	
	        </div><br>
           <div class="table-responsive">
				<table class="kolom" width="100%" cellspacing="0">
					<tr>
						<th>NIM</th>
						<td>: {{@$mahasiswa->nim}} </td>
						<td></td>
						<th>Waktu Kuliah</th>
						<td>: {{ @$mahasiswa->waktu_kuliah->nama_waktu_kuliah }}</td>
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
			
			<div class="table-responsive">
				<table id="tabel-data" class="table table-striped table-bordered" align="center" width="100%" cellspacing="0">
					<thead>
						<tr align="center">
							<th width="5%" >No</th>
							<th width="15%">Kode MK</th>	
							<th width="40%">Mata Kuliah</th>
							<th width="5%" >SKS</th>
							<th>Catatan</th>
						</tr>
					</thead>
					  <?php $no=1; ?>
                      @if(count($krs_item))
                      <tbody>
                        @foreach($krs_item as $item)
                        <tr align="center">
                          <td >{{$no++}}</td>
                          <td>{{$item->matkul->kode_matkul}}</td>
                          <td align="left">{{$item->matkul->nama_matkul}}</td>
                          <td >{{$item->matkul->sks}}</td>
                          <td align="left">{{ ! empty($mahasiswa->nama_kelas) ? '' : $item->kelas->nama_kelas }}</td>
                        </tr>
                     	@endforeach
                      </tbody>
                      <tfoot>
                      	 <tr >
                        	<td colspan="3" align="right">Jumlah SKS</td>
                        	<td align="center">{{$total_sks}}</td>
                        	<td></td>
                        </tr>
                    </tfoot>
                      @else
                      <tbody>
                        <tr>
                          <td colspan="5">Tidak Ada Data</td>
                        </tr>
                        
                      @endif
				</table>
			</div>
    
	
	</body>
	<style>
		.table>tbody>tr>th {
			padding: 2px;
			font-size: 13px;
		}
		
		.table>tbody>tr>td {
			padding: 2px;
			font-size: 13px;
		}
	
		.kolom>tbody>tr>th,td {
			padding: 2px; 
			font-size: 13px;
			
		}
	</style>
</html>
