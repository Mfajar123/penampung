@extends ('template')

@section ('main')
	<section class="content-header">
		<h1>Cetak Kartu Ujian</h1>

		<ol class="breadcrumb">
			<li><a href="#">Home</a></li>
			<li class="active">Cetak Kartu Ujian</li>
		</ol>
	</section>
    
	<section class="content">
		<div class="box box-default">
			<div class="box-header with-border">
				{!! Form::open(['method' => 'POST', 'route' => 'mahasiswa.cetak', 'class' => 'form-inline']) !!}
					{!! Form::select('tahun_akademik', $list_tahun_akademik, null, ['placeholder' => '- Pilih Tahun Akademik -', 'class' => 'form-control', 'required']) !!}
					<select name="ujian" id="" class="form-control">
						<option value=""> - Pilih Jenis Ujian - </option>
						<option value="uts">Ujian Tengah Semester</option>
						<option value="uas">Ujian Akhir Semester</option>
					</select>
					{!! Form::submit('Tampilkan', ['class' => 'btn btn-default']) !!}
				{!! Form::close() !!}
				
			</div>
		@if( $spp_terbayar == $bulan )
			@if (Request::isMethod('POST'))
				<div class="pull-right">
					@if( $ujian->jenis_ujian == 'uts' )
						<a href="{{ route('mahasiswa.cetak.uts.front', [$ujian->jenis_ujian, $ujian->id_tahun_akademik ] ) }}" class="btn btn-default"><i class="fa fa-print"></i> Print Front Page</a>
						<a href="{{ route('mahasiswa.cetak.uts.back', [$ujian->jenis_ujian, $ujian->id_tahun_akademik ] ) }}" class="btn btn-default"><i class="fa fa-print"></i> Print Back Page</a>
					@else
						<a href="{{ route('mahasiswa.cetak.uas.front', [$ujian->jenis_ujian, $ujian->id_tahun_akademik ] ) }}" class="btn btn-default"><i class="fa fa-print"></i> Print Front Page</a>
						<a href="{{ route('mahasiswa.cetak.uas.back', [$ujian->jenis_ujian, $ujian->id_tahun_akademik ] ) }}" class="btn btn-default"><i class="fa fa-print"></i> Print Back Page</a>
					@endif
				</div>
				<div class="row">
					<div class="col-md-4 col-xs-2"></div>
				 	<div class="konten col-md-4 col-xs-8" style="padding:0px 0px; ">
		                <span><img src="{{asset('images/logo/ppi.png')}}"  alt="Logo STIE PPI" class="img-responsive"  title="Logo STIE PPI" style="width: 20%; margin: 0px; margin-left: 145px;"></span>
		                <div class="bisa">
		                    <h4 style="color: black; text-align: center; margin-top: 5px; ">KARTU PESERTA UJIAN</h4>
		                    <h4 style="color: black; text-align: center; text-transform: uppercase;">( {{ $ujian->jenis_ujian }} {{ $ujian->keterangan }} )</h4>	
		                </div> 
		            </div>
	           		<div class="col-md-4 col-xs-2"></div>
		        </div>
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
							<td>: {{ @$mahasiswa->no_absen}}</td>
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
							<!--<li>Membawa kartu ujian yang telah disahkan, dan kartu ujian tersebut harus ditandatangani oleh pengawas ujian.</li>-->
							<li>Membawa kartu ujian, dan <b>tidak ada surat ijin mengikuti ujian bagi peserta ujian</b>yang tidak membawa kartu ujian.</li>
							<li>Mengisi daftar hadir ujian.</li>
							<li>Tidak diperkenankan: Memakai kaos oblong (tanpa krah), Memakai sandal(pria) atau sepatu tidak tertutup(wanita), Menyontek atau memberi contekan, Meninggalkan ruang ujian tanpa ijin pengawas, Menyalakan alat komunikasi dengan alasan apapun dan Membawa makanan dan minuman ke dalam ruang ujian.</li>
							<li>Peserta ujian wajib duduk sesuai nomor kursi masing2 yang tertera pada kartu.</li>
							<li>Pengawas atau dosen pengampu berhak menyatakan hasil ujian tidak syah atau batal atas pelanggaran diatas.</li>
							<li>Bagi peserta ujian yang meninggalkan ruang ujian tanpa seijin pengawas, dianggap telah menyelesaikan ujian.</li>
							<li>Ujian susulan diperkenankan dengan syarat dan ketentuan yang berlaku.</li>

						</ol>

					<center><h4>RENCANA STUDI</h4></center>

						<table class="table table-bordered">
							<tr>
								<td width="5%">No</td>
								<td width="10%">Kode</td>
								<td>Mata Kuliah</td>
								<td>SKS</td>
								<td>Paraf Pengawas</td>
							</tr>
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

		      
		       	
			@endif
		@else
    	   <?php  $message = "Maaf anda belum bisa mencetak kartu ujian. Silahkan selesaikan administrasi anda";
            echo "<script type='text/javascript'>alert('$message');</script>"; ?>
    	@endif
		</div>
	</section>

@stop