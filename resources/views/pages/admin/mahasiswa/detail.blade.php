@extends('template')





@section('main')


<style type="text/css">


  .title-profil


  {


    font-size: 18pt;


    font-weight: 600;


    color: #333333ab;


    margin: 0;


    margin-bottom: 10px;


    text-align: center;


  }


</style>





<section class="content-header">


    <h1>Detail Mahasiswa </h1>


    <ol class="breadcrumb">


    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>


    <li class="active">Detail Mahasiswa</li>


  </ol>


</section><!-- /.content-header -->





<section class="content">


    <div class="row">


        <div class="col-md-4 col-xs-12">


          <div class="box box-primary">


            <div class="box-header with-border">


              <h3 class="col-xs-12 box-title text-center">Foto Profil</h3>


            </div>


            <div class="box-body">


              @if($mahasiswa->foto_profil == '')


                <img src="{{ asset('images/default-avatar.png') }}" class="img-responsive img-profil">


              @else


                <img src="{{ asset('images/mahasiswa/'.$mahasiswa->foto_profil) }}" class="img-responsive img-profil">


              @endif


            </div>


          </div>


          <a href="{{ route('admin.mahasiswa') }}" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Kembali</a>


        </div>





        <div class="col-md-8 col-xs-12">


          <div class="nav-tabs-custom">


            <ul class="nav nav-tabs">


              <li class="active"><a href="#biodata" data-toggle="tab">Biodata</a></li>


              <li><a href="#sekolah" data-toggle="tab">Sekolah</a></li>


              <li><a href="#pekerjaan" data-toggle="tab">Pekerjaan</a></li>


              <li><a href="#ortu" data-toggle="tab">Orang Tua</a></li>

		<li><a href="#kelas" data-toggle="tab">Kelas</a></li>


            </ul>


            <div class="tab-content">


              <div class="tab-pane active" id="biodata">


                <h3 class="title-profil">{{ $mahasiswa->nama }}</h3>


                <table class="table table-respoonsive">


                  <tbody>


                    <tr>


                      <td width="150">NIM</td>


                      <td width="10">:</td>


                      <td>{{ $mahasiswa->nim }}</td>


                    </tr>
                    
                    <td>Password</td>


                      <td>:</td>


                    <td>{{ $system->decrypt($mahasiswa->password, $mahasiswa->nim, $mahasiswa->nim) }} | {{ $system->encrypt(123, $mahasiswa->nim, $mahasiswa->nim) }}</td>


                    <!--<tr>


                      <td>Password</td>


                      <td>:</td>


                      <td><?php md5($system->decrypt($mahasiswa->password, $mahasiswa->nim, $mahasiswa->nim))?></td>


                    </tr>-->


          


                    <tr>


                      <td>Nama</td>


                      <td>:</td>


                      <td>{{ $mahasiswa->nama }}</td>


                    </tr>


          


                    <tr>


                      <td>Status</td>


                      <td>:</td>


                      <td>{{ $mahasiswa->statusMahasiswa->nama_status }}</td>


                    </tr>


          


                    <tr>


                      <td>Prodi</td>


                      <td>:</td>


                      <td>{{ $mahasiswa->prodi->nama_prodi }}</td>


                    </tr>


          


                    <tr>


                      <td>Tempat, Tanggal Lahir</td>


                      <td>:</td>


                      <td>


                        @if(trim($mahasiswa->tmp_lahir) == '' || trim($mahasiswa->tgl_lahir) == '')


                          -


                        @elseif(trim($mahasiswa->tgl_lahir) == '')


                          {{ $mahasiswa->tgl_lahir }}


                        @elseif(trim($mahasiswa->tmp_lahir) == '')


                          {{ date('d F Y', strtotime($mahasiswa->tgl_lahir)) }}


                        @else


                          {{ $mahasiswa->tmp_lahir }}, {{ date('d-m-Y', strtotime($mahasiswa->tgl_lahir)) }}


                        @endif


                      </td>


                    </tr>


          


                    <tr>


                      <td>Jenis Kelamin</td>


                      <td>:</td>


                      <td>{{ $mahasiswa->jenkel }}</td>


                    </tr>


          


                    <tr>


                      <td>agama</td>


                      <td>:</td>


                      <td>{{ $mahasiswa->agama }}</td>


                    </tr>


          


                    <tr>


                      <td>Alamat</td>


                      <td>:</td>


                      <td>{{ $mahasiswa->alamat }}</td>


                    </tr>


          


                    <tr>


                      <td>No. Telepon</td>


                      <td>:</td>


                      <td>{{ $mahasiswa->no_telp }}</td>


                    </tr>





                  </tbody>


                </table>


              </div>


              


              <div class="tab-pane" id="sekolah">


                <h3 class="title-profil">{{ $mahasiswa->nama }}</h3>


                <table class="table table-respoonsive">


                  <tbody>


                    <tr>
	
		@if($status_mahasiswa->nama_status == 'Pindahan')
                  <tr>

                      <td width="150">Perguruan Tinggi Asal</td>

                      <td width="10">:</td>

                      <td>{{ (!empty($sekolah->pt_asal)) ? $sekolah->pt_asal : '' }}</td>

                    </tr>
                @endif


                      <td width="150">Asal Sekolah</td>


                      <td width="10">:</td>


                      <td>{{ (!empty($sekolah->asal_sekolah)) ? $sekolah->asal_sekolah : '' }}</td>


                    </tr>




                    <tr>


                      <td>Nomor Ijazah</td>


                      <td>:</td>


                      <td>{{ (!empty($sekolah->no_ijazah)) ? $sekolah->no_ijazah : '' }}</td>


                    </tr>





                    <tr>


                      <td>Jurusan</td>


                      <td>:</td>


                      <td>{{ (!empty($sekolah->jurusan)) ? $sekolah->jurusan : '' }}</td>


                    </tr>





                    <tr>


                      <td>Alamat Sekolah</td>


                      <td>:</td>


                      <td>{{ (!empty($sekolah->alamat_sekolah)) ? $sekolah->alamat_sekolah : '' }}</td>


                    </tr>





                  </tbody>


                </table>


              </div>


              


              <div class="tab-pane" id="pekerjaan">


                <h3 class="title-profil">{{ $mahasiswa->nama }}</h3>


                <table class="table table-respoonsive">


                  <tbody>


                    <tr>


                      <td width="150">Perusahaan</td>


                      <td width="10">:</td>


                      <td>{{ (!empty($pekerjaan->perusahaan)) ? $pekerjaan->perusahaan : '' }}</td>


                    </tr>





                    <tr>


                      <td>Posisi</td>


                      <td>:</td>


                      <td>{{ (!empty($pekerjaan->posisi)) ? $pekerjaan->posisi : '' }}</td>


                    </tr>





                    <tr>


                      <td>Alamat Perusahaan</td>


                      <td>:</td>


                      <td>{{ (!empty($pekerjaan->alamat_perusahaan)) ? $pekerjaan->alamat_perusahaan : '' }}</td>


                    </tr>





                  </tbody>


                </table>


              </div>





              <div class="tab-pane" id="ortu">


                <h3 class="title-profil">{{ $mahasiswa->nama }}</h3>


                <table class="table table-respoonsive">


                  <tbody>


                    <tr>


                      <td width="150">Nama Ibu</td>


                      <td width="10">:</td>


                      <td>{{ (!empty($ortu->nama_ibu)) ? $ortu->nama_ibu : '' }}</td>


                    </tr>





                    <tr>


                      <td>Nama Ayah</td>


                      <td>:</td>


                      <td>{{ (!empty($ortu->nama_ayah)) ? $ortu->nama_ayah : '' }}</td>


                    </tr>





                    <tr>


                      <td>Alamat Orang Tua</td>


                      <td>:</td>


                      <td>{{ (!empty($ortu->alamat_ortu)) ? $ortu->alamat_ortu : '' }}</td>


                    </tr>





                    <tr>


                      <td>No. Telepon Orang Tua</td>


                      <td>:</td>


                      <td>{{ (!empty($ortu->no_telp_ortu)) ? $ortu->no_telp_ortu : '' }}</td>


                    </tr>





                  </tbody>


                </table>


              </div>

		<div class="tab-pane" id="kelas">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>No.</th>
                        <th>Kelas</th>
                        <th>Waktu Kuliah</th>
                        <th>Semester</th>
                        <th>Tahun Akademik</th>
                        <th>Jumlah SKS</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $no = 1; ?>
                      @foreach ($kelas as $list)
                        <tr>
                          <td>{{ $no++ }}</td>
                          <td>{{ $list->id_prodi }} - {{ $list->kode_kelas }} {{ $list->actived == 1 ? '(Aktif)' : '' }}</td>
                          <td>{{ $list->nama_waktu_kuliah }}</td>
                          <td>{{ $list->semester_ke }}</td>
                          <td>{{ $list->keterangan }}</td>
                          <td>{{ $jumlah_sks }}</td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>


              <!-- /.tab-pane -->


            </div>


            <!-- /.tab-content -->


          </div>


          <!-- nav-tabs-custom -->


        </div>


    </div>


</section><!-- /.content -->


@stop


