@extends('template')



@section('main')

    <section class="content-header">

        <h1>Detail Pengumuman</h1>

        <ol class="breadcrumb">

        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

        <li class="active">Detail Pengumuman</li>

      </ol>

    </section><!-- /.content-header -->



    <section class="content">

        <div class="row">

            <div class="col-md-4 col-xs-12">

              <div class="box box-primary">

                <div class="box-header with-border">

                  <h3 class="col-xs-12 box-title text-center">Foto </h3>

                </div>

                <div class="box-body">

                  @if($pengumuman->foto_pengumuman == '')

                    <img src="{{ asset('images/default-img.png') }}" class="img-responsive ">

                  @else

                    <img src="{{ asset('images/pengumuman/'.$pengumuman->foto_pengumuman) }}" class="img-responsive">

                  @endif

                </div>

              </div>

            </div>



            <div class="col-md-8 col-xs-12">

              <div class="box box-primary">

                <div class="box-header with-border">

                  <div class="box-title">

                      Detail Pengumuman : <strong>{{ $pengumuman->judul_pengumuman }}</strong>

                  </div>

                  <div class="box-body">

                    <table class="table table-respoonsive">

                      <tbody>

                        <tr>

                          <td width="150">Judul Pengumuman</td>

                          <td width="10">:</td>

                          <td>{{ $pengumuman->judul_pengumuman }}</td>

                        </tr>



                        <tr>

                          <td>Waktu Pengumuman</td>

                          <td>:</td>

                          <td>
                              {{ $pengumuman->waktu_pengumuman }}
                          </td>

                        </tr>



                        <tr>

                          <td>Ringkasan pengumumanrmai</td>

                          <td>:</td>

                          <td>{{ $pengumuman->ringkasan_pengumuman }}</td>

                        </tr>



                        <tr>

                          <td>Isi Pengumuman</td>

                          <td>:</td>

                          <td> 
                            {{ $pengumuman->isi_pengumuman }}
                          </td>

                        </tr>



                        <tr>

                          <td>Sumber Pengumuman</td>

                          <td>:</td>

                          <td>{{ $pengumuman->sumber_pengumuman }}</td>

                        </tr>
                        
                        <tr>

                          <td>Umumkan Kepada</td>

                          <td>:</td>

                          <td>{{ $pengumuman->umumkan_ke}}</td>

                        </tr>   

                      </tbody>

                    </table>

                    <a href="{{ route('admin.pengumuman') }}" class="btn btn-default btn-sm" style="margin-top: 10px"><i class="fa fa-arrow-left"></i> Kembali</a>

                  </div>

                </div>

              </div>

            </div>

        </div>

    </section><!-- /.content -->

@stop

