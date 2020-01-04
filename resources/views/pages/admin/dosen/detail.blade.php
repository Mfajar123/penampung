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
        <h1>Detail Dosen</h1>
        <ol class="breadcrumb">
        <li>Home</li>
        <li>Dosen</li>
        <li class="active">Detail Dosen</li>
      </ol>
    </section><!-- /.content-header -->

    <section class="content">
    @foreach($dsn as $dosen)
        <div class="row">
            <div class="col-md-4 col-xs-12">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="col-xs-12 box-title text-center">Foto Profil</h3>
                </div>
                <div class="box-body">
                  @if($dosen->foto_profil == '')
                    <img src="{{ asset('images/default-avatar.png') }}" class="img-responsive img-profil">
                  @else
                    <img src="{{ asset('images/dosen/'.$dosen->foto_profil) }}" class="img-profil img-responsive">
                  @endif
                </div>
              </div>
              <a href="{{route('admin.dosen')}}" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Kembali</a>
            </div>
            <div class="col-md-8">
                <!-- Custom Tabs -->
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab">Jabatan</a></li>
                    <li><a href="#tab_3" data-toggle="tab">Biodata</a></li>
                    <li><a href="#tab_2" data-toggle="tab">Pendidikan</a></li>
                    </ul>
                    <div class="tab-content">
                    <h3 class="title-profil">{{$dosen->gelar_depan}} {{$dosen->nama}} {{$dosen->gelar_belakang}}</h3>
                        <div class="tab-pane active" id="tab_1">
                            <table class="table">
                                <tr>
                                    <td width="150">NIP</td>
                                    <td width="10">:</td>
                                    <td>{{$dosen->nip}}</td>
                                </tr>
                                
                                <tr>
                                    <td>NIDN</td>
                                    <td>:</td>
                                    <td>{{$dosen->nidn}}</td>
                                </tr>
                                <tr>
                                    <td>Jabatan</td>
                                    <td>:</td>
                                    <td>{{$dosen->jabatan->nama}}</td>
                                </tr>
                                <tr>
                                    <td>Prodi</td>
                                    <td>:</td>
                                    <td>{{$dosen->prodi->nama_prodi}}</td>
                                </tr>
                                <tr>
                                    <td>Status Dosen</td>
                                    <td>:</td>
                                    <td>@if($dosen->status_dosen == 1)Dosen Tetap @else Dosen Luar @endif</td>
                                </tr>
                                <tr>
                                    <td>No. SKYYS</td>
                                    <td>:</td>
                                    <td>{{$dosen->no_skyys}}</td>
                                </tr>
                                <tr>
                                    <td>Tgl SKYYS</td>
                                    <td>:</td>
                                    <td>{{date('d-m-Y', strtotime( !empty($dosen->tgl_skyys) ? $dosen->tgl_skyys : '-' ))}}</td>
                                </tr>
                            </table>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="tab_2">
                        @foreach($pendidikan as $pendidikan)
                            <table class="table">
                                <tr>
                                    <td width="150">Jenjang</td>
                                    <td width="10">:</td>
                                    <td>{{$pendidikan->jenjang}}</td>
                                </tr>
                                <tr>
                                    <td>Universitas</td>
                                    <td>:</td>
                                    <td>{{$pendidikan->nama_sekolah}}</td>
                                </tr>
                                <tr>
                                    <td>Jurusan</td>
                                    <td>:</td>
                                    <td>{{$pendidikan->jurusan}}</td>
                                </tr>
                                <tr>
                                    <td>Gelar</td>
                                    <td>:</td>
                                    <td>{{$pendidikan->gelar}}</td>
                                </tr>
                                <tr>
                                    <td>Konsentrasi</td>
                                    <td>:</td>
                                    <td>{{$pendidikan->konsentrasi}}</td>
                                </tr>
                            </table>
                            @endforeach
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="tab_3">
                            <table class="table">
                                <tr>
                                    <td width="150">Tempat, tanggal lahir</td>
                                    <td width="10">:</td>
                                    <td>{{$dosen->tempat_lahir}}, {{date('d-m-Y', strtotime($dosen->tgl_lahir))}}</td>
                                </tr>
                                <tr>
                                    <td>Kerwarganegaraan</td>
                                    <td>:</td>
                                    <td>{{$dosen->warga_negara}}</td>
                                </tr>
                                <tr>
                                    <td>Jenis Kelamin</td>
                                    <td>:</td>
                                    <td>{{$dosen->jenis_kelamin}}</td>
                                </tr>
                                <tr>
                                    <td>Status Pernikahan</td>
                                    <td>:</td>
                                    <td>{{$dosen->status_pernikahan}}</td>
                                </tr>
                                <tr>
                                    <td>Agama</td>
                                    <td>:</td>
                                    <td>{{$dosen->agama}}</td>
                                </tr>
                                <tr>
                                    <td>alamat</td>
                                    <td>:</td>
                                    <td>{{$dosen->alamat}}</td>
                                </tr>
                                <tr>
                                    <td>No.Telp</td>
                                    <td>:</td>
                                    <td>{{$dosen->no_telp}}</td>
                                </tr>
                                <tr>
                                    <td>No.Hp</td>
                                    <td>:</td>
                                    <td>{{$dosen->no_hp}}</td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td>:</td>
                                    <td>{{$dosen->email}}</td>
                                </tr>
                            </table>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- nav-tabs-custom -->
            </div>
            <!-- /.col -->
        </div>
    @endforeach
    </section><!-- /.content -->
@stop
