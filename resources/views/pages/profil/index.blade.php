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
    <h1>Profil</h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Profil</li>
    </ol>
</section><!-- /.content-header -->

<section class="content">
    <div class="row">
      @include('_partials.flash_message')
      <div class="col-md-4 col-xs-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title text-center">Foto Profil</h3>
            <div class="box-tools pull-right">
              <a class="btn btn-primary btn-xs" title="Ubah Foto" data-toggle="modal" data-target="#ubah-foto"><i class="fa fa-edit"></i></a>
            </div>
          </div>
          <div class="box-body">
            @if($profil->foto_profil == '')
              <div class="form-group">
                <img src="{{ asset('images/default-avatar.png') }}" class="img-responsive">
              </div>
            @else
              <div class="form-group">
                <img src="{{ asset($path.$profil->foto_profil) }}" class="img-responsive">
              </div>

              <div class="col-md-12">
                  @if(Request::segment(1) == 'mahasiswa')
                    <a href="{{ route('mahasiswa.profil.foto.hapus') }}" onclick="return confirm('Anda Yakin Akan Menghapus Foto Profil ?')" class="btn btn-danger btn-sm col-md-offset-4" title="Hapus Foto"><i class="fa fa-trash-o"></i> Hapus Foto</a>
                  @elseif(Request::segment(1) == 'admin')
                    <a href="{{ route('admin.profil.foto.hapus') }}" onclick="return confirm('Anda Yakin Akan Menghapus Foto Profil ?')" class="btn btn-danger btn-sm col-md-offset-4" title="Hapus Foto"><i class="fa fa-trash-o"></i> Hapus Foto</a>
                  @else
                    <a href="{{ route('karyawan.profil.foto.hapus') }}" onclick="return confirm('Anda Yakin Akan Menghapus Foto Profil ?')" class="btn btn-danger btn-sm col-md-offset-4" title="Hapus Foto"><i class="fa fa-trash-o"></i> Hapus Foto</a>
                  @endif
              </div>
            @endif
          </div>
        </div>
        
        <div class="modal fade" id="ubah-foto">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Ubah Foto Profil</h4>
              </div>
              @if(Request::segment(1) == 'mahasiswa')
              {!! Form::open(['method' => 'POST', 'route' => ['mahasiswa.profil.foto'], 'files' => 'true']) !!}
              @elseif(Request::segment(1) == 'admin')
              {!! Form::open(['method' => 'POST', 'route' => ['admin.profil.foto'], 'files' => 'true']) !!}
              @else
              {!! Form::open(['method' => 'POST', 'route' => ['karyawan.profil.foto'], 'files' => 'true']) !!}
              @endif
              <div class="modal-body">
                  <div class="form-group">
                    {!! Form::label('foto_profil', 'Foto', ['class' => 'control-label']) !!}
                    {!! Form::file('foto_profil', ['class' => 'form-control', 'accept' => 'image/*']) !!}
                  </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm pull-left" data-dismiss="modal">Close</button>
                {!! Form::submit('Ubah Foto', ['class' => 'btn btn-primary btn-sm pull-right']) !!}
              </div>
              {!! Form::close() !!}
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

        <div class="form-group">
          <a href="javascript: window.history.go(-1)" class="btn btn-default"><i class="fa fa-chevron-left"></i> Kembali</a>
        </div>
      </div>

      <div class="col-md-8 col-xs-12">
        @if(Request::segment(1) == 'mahasiswa')
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#biodata" data-toggle="tab">Biodata</a></li>
              <li><a href="#sekolah" data-toggle="tab">Sekolah Asal</a></li>
              <li><a href="#pekerjaan" data-toggle="tab">Pekerjaan</a></li>
              <li><a href="#ortu" data-toggle="tab">Orang Tua</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="biodata">
                <h3 class="title-profil">{{ $profil->nama }}</h3>
                <table class="table table-respoonsive">
                  <tbody>
                    <tr>
                      <td width="150">NIM</td>
                      <td width="10">:</td>
                      <td>{{ $profil->nim }}</td>
                    </tr>

                    <tr>
                      <td>Nama</td>
                      <td>:</td>
                      <td>{{ $profil->nama }}</td>
                    </tr>
                    
                    <tr>
                      <td>Email</td>
                      <td>:</td>
                      <td>{{ @$profil->email }}</td>
                    </tr>
          
                    <tr>
                      <td>Status</td>
                      <td>:</td>
                      <td>{{ $profil->statusMahasiswa->nama_status }}</td>
                    </tr>
          
                    <tr>
                      <td>Prodi</td>
                      <td>:</td>
                      <td>{{ $profil->prodi->nama_prodi }}</td>
                    </tr>
          
                    <tr>
                      <td>Tempat, Tanggal Lahir</td>
                      <td>:</td>
                      <td>
                        @if(trim($profil->tmp_lahir) == '' || trim($profil->tgl_lahir) == '')
                          -
                        @elseif(trim($profil->tgl_lahir) == '')
                          {{ $profil->tgl_lahir }}
                        @elseif(trim($profil->tmp_lahir) == '')
                          {{ date('d F Y', strtotime($profil->tgl_lahir)) }}
                        @else
                          {{ $profil->tmp_lahir }}, {{ date('d-m-Y', strtotime($profil->tgl_lahir)) }}
                        @endif
                      </td>
                    </tr>
          
                    <tr>
                      <td>Jenis Kelamin</td>
                      <td>:</td>
                      <td>{{ $profil->jenkel }}</td>
                    </tr>
          
                    <tr>
                      <td>agama</td>
                      <td>:</td>
                      <td>{{ $profil->agama }}</td>
                    </tr>
          
                    <tr>
                      <td>Alamat</td>
                      <td>:</td>
                      <td>{{ $profil->alamat }}</td>
                    </tr>
          
                    <tr>
                      <td>No. Telepon</td>
                      <td>:</td>
                      <td>{{ $profil->no_telp }}</td>
                    </tr>

                  </tbody>
                </table>
              </div>
              
              <div class="tab-pane" id="sekolah">
                <h3 class="title-profil">{{ $profil->nama }}</h3>
                <table class="table table-respoonsive">
                  <tbody>
                    <tr>
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
                <h3 class="title-profil">{{ $profil->nama }}</h3>
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
                <h3 class="title-profil">{{ $profil->nama }}</h3>
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
              <!-- /.tab-pane -->
              <div class="form-group">
                <a href="{{ route('mahasiswa.profil.ubah') }}" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i> Ubah Data</a>
              </div>
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
        @elseif(Request::segment(1) == 'dosen')
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#profil" data-toggle="tab">Profil</a></li>
              <li><a href="#jabatan" data-toggle="tab">Jabatan</a></li>
              <li><a href="#pendidikan" data-toggle="tab">Pendidikan</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="profil">
                <h3 class="title-profil">{{ $profil->nama }}</h3>
                <table class="table table-respoonsive">
                  <tbody> 
                    <tr>
                      <td width="150">NIP</td>
                      <td width="10">:</td>
                      <td>{{ $profil->nip }}</td>
                    </tr>

                    <tr>
                      <td>E - mail</td>
                      <td>:</td>
                      <td>{{ $profil->email }}</td>
                    </tr>

                    <tr>
                      <td>Tempat, Tanggal Lahir</td>
                      <td>:</td>
                      <td>
                        @if(trim($profil->tmp_lahir) == '' || trim($profil->tgl_lahir) == '')
                          -
                        @elseif(trim($profil->tgl_lahir) == '')
                          {{ $profil->tgl_lahir }}
                        @elseif(trim($profil->tmp_lahir) == '')
                          {{ date('d F Y', strtotime($profil->tgl_lahir)) }}
                        @else
                          {{ $profil->tmp_lahir }}, {{ date('d-m-Y', strtotime($profil->tgl_lahir)) }}
                        @endif
                      </td>
                    </tr>
          
                    <tr>
                      <td>Jenis Kelamin</td>
                      <td>:</td>
                      <td>{{ $profil->jenis_kelamin }}</td>
                    </tr>

                    <tr>
                      <td>Status Pernikahan</td>
                      <td>:</td>
                      <td>{{ $profil->status_pernikahan }}</td>
                    </tr>
          
                    <tr>
                      <td>Agama</td>
                      <td>:</td>
                      <td>{{ $profil->agama }}</td>
                    </tr>
          
                    <tr>
                      <td>Alamat</td>
                      <td>:</td>
                      <td>{{ $profil->alamat }}</td>
                    </tr>
          
                    <tr>
                      <td>No. Telepon</td>
                      <td>:</td>
                      <td>{{ $profil->no_telp }}</td>
                    </tr>

                    <tr>
                      <td>No. HP</td>
                      <td>:</td>
                      <td>{{ $profil->no_hp }}</td>
                    </tr>                  </tbody>
                </table>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="jabatan">
                <h3 class="title-profil">{{ $profil->nama }}</h3>
                <table class="table table-respoonsive">
                  <tbody>
                    <tr>
                      <td width="150">NIDN</td>
                      <td width="10">:</td>
                      <td>{{ $profil->nidn }}</td>
                    </tr>

                    <tr>
                      <td>Jabatan</td>
                      <td>:</td>
                      <td>{{ $profil->jabatan->nama }}</td>
                    </tr>

                    <tr>
                      <td>Program Studi</td>
                      <td>:</td>
                      <td>{{ $profil->prodi->nama_prodi }}</td>
                    </tr>

                    <tr>
                      <td>Status Dosen</td>
                      <td>:</td>
                      <td>{{ ($profil->status_dosen == '1') ? 'Dosen Tetap' : 'Dosen Luar' }}</td>
                    </tr>

                    <tr>
                      <td>No. SKYYS</td>
                      <td>:</td>
                      <td>{{ $profil->no_skyys }}</td>
                    </tr>

                    <tr>
                      <td>Tanggal SKYYS</td>
                      <td>:</td>
                      <td>{{ $profil->tgl_skyys }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="pendidikan">
                <h3 class="title-profil">{{ $profil->nama }}</h3>
                <table class="table table-respoonsive">
                  <tbody>
                    <tr>
                      <td width="150">Jenjang</td>
                      <td width="10">:</td>
                      <td>{{ (!empty($pendidikan->jenjang)) ? $pendidikan->jenjang : '' }}</td>
                    </tr>

                    <tr>
                      <td>Nama Sekolah</td>
                      <td>:</td>
                      <td>{{ (!empty($pendidikan->nama_sekolah)) ? $pendidikan->nama_sekolah : '' }}</td>
                    </tr>

                    <tr>
                      <td>Jurusan</td>
                      <td>:</td>
                      <td>{{ (!empty($pendidikan->jurusan)) ? $pendidikan->jurusan : '' }}</td>
                    </tr>

                    <tr>
                      <td>Gelar</td>
                      <td>:</td>
                      <td>{{ (!empty($pendidikan->gelar)) ? $pendidikan->gelar : '' }}</td>
                    </tr>
                    
                    <tr>
                      <td>Konsentrasi</td>
                      <td>:</td>
                      <td>{{ (!empty($pendidikan->konsentrasi)) ? $pendidikan->konsentrasi : '' }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.tab-pane -->
              <div class="form-group">
                <a href="{{ route('dosen.profil.ubah') }}" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i> Ubah Data</a>
              </div>
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
        @else
          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Data Karyawan <strong>{{ $profil->nama }}</strong></h3>
              <div class="box-tools pull-right">
                <a class="btn btn-primary btn-xs" title="Ubah Foto" data-toggle="modal" data-target="#ubah-foto"><i class="fa fa-edit"></i></a>
              </div>
            </div>

            <div class="box-body">
              
            </div>
          </div>
        @endif
      </div>
    </div>
</section><!-- /.content -->
@stop