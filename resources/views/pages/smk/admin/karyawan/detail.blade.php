@extends('template')



@section('main')

    <section class="content-header">

        <h1>Detail Karyawan</h1>

        <ol class="breadcrumb">

        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

        <li class="active">Detail Karyawan</li>

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

                  @if($karyawan->foto_profil == '')

                    <img src="{{ asset('images/default-avatar.png') }}" class="img-responsive img-profil">

                  @else

                    <img src="{{ asset('images/admin/'.$karyawan->foto_profil) }}" class="img-responsive img-profil">

                  @endif

                </div>

              </div>

            </div>



            <div class="col-md-8 col-xs-12">

              <div class="box box-primary">

                <div class="box-header with-border">

                  <div class="box-title">

                      Detail Karyawan : <strong>{{ $karyawan->nama }}</strong>

                  </div>

                  <div class="box-body">

                    <table class="table table-respoonsive">

                      <tbody>

                        <tr>

                          <td width="150">Username</td>

                          <td width="10">:</td>

                          <td>{{ $karyawan->username }}</td>

                        </tr>



                        <tr>

                          <td>Password</td>

                          <td>:</td>

                          <td>

                            @if(empty($system->crypt($karyawan->password, 'd')))

                              {{ $karyawan->password }}

                            @else

                              {{ $system->crypt($karyawan->password, 'd') }}

                            @endif

                          </td>

                        </tr>



                        <tr>

                          <td>Nama</td>

                          <td>:</td>

                          <td>{{ $karyawan->nama }}</td>

                        </tr>



                        <tr>

                          <td>Tempat, Tanggal Lahir</td>

                          <td>:</td>

                          <td>

                            @if(trim($karyawan->tmp_lahir) == '' || trim($karyawan->tgl_lahir) == '')

                              -

                            @elseif(trim($karyawan->tgl_lahir) == '')

                              {{ $karyawan->tgl_lahir }}

                            @elseif(trim($karyawan->tmp_lahir) == '')

                              {{ date('d F Y', strtotime($karyawan->tgl_lahir)) }}

                            @else

                              {{ $karyawan->tmp_lahir }}, {{ date('d-m-Y', strtotime($karyawan->tgl_lahir)) }}

                            @endif

                          </td>

                        </tr>



                        <tr>

                          <td>Jenis Kelamin</td>

                          <td>:</td>

                          <td>{{ $karyawan->jenkel }}</td>

                        </tr>



                        <tr>

                          <td>agama</td>

                          <td>:</td>

                          <td>{{ $karyawan->agama }}</td>

                        </tr>



                        <tr>

                          <td>Alamat</td>

                          <td>:</td>

                          <td>{{ $karyawan->alamat }}</td>

                        </tr>



                        <tr>

                          <td>No. Telepon</td>

                          <td>:</td>

                          <td>{{ $karyawan->no_telp }}</td>

                        </tr>

                      </tbody>

                    </table>

                    <a href="{{ route('smk.admin.karyawan') }}" class="btn btn-default btn-sm" style="margin-top: 10px"><i class="fa fa-arrow-left"></i> Kembali</a>

                  </div>

                </div>

              </div>

            </div>

        </div>

    </section><!-- /.content -->

@stop

