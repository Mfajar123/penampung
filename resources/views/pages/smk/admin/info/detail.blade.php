@extends('template')



@section('main')

    <section class="content-header">

        <h1>Detail Informasi</h1>

        <ol class="breadcrumb">

        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

        <li class="active">Detail Informasi</li>

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

                  @if($info->foto_info == '')

                    <img src="{{ asset('images/default-img.png') }}" class="img-responsive ">

                  @else

                    <img src="{{ asset('images/info/'.$info->foto_info) }}" class="img-responsive">

                  @endif

                </div>

              </div>

            </div>



            <div class="col-md-8 col-xs-12">

              <div class="box box-primary">

                <div class="box-header with-border">

                  <div class="box-title">

                      Detail Informasi : <strong>{{ $info->judul_info }}</strong>

                  </div>

                  <div class="box-body">

                    <table class="table table-respoonsive">

                      <tbody>

                        <tr>

                          <td width="150">Judul Informasi</td>

                          <td width="10">:</td>

                          <td>{{ $info->judul_info }}</td>

                        </tr>



                        <tr>

                          <td>Waktu Informasi</td>

                          <td>:</td>

                          <td>
                              {{ $info->waktu_info }}
                          </td>

                        </tr>



                        <tr>

                          <td>Ringkasan Informai</td>

                          <td>:</td>

                          <td>{{ $info->ringkasan_info }}</td>

                        </tr>



                        <tr>

                          <td>Isi Informasi</td>

                          <td>:</td>

                          <td> 
                            {{ $info->isi_info }}
                          </td>

                        </tr>



                        <tr>

                          <td>Sumber Informasi</td>

                          <td>:</td>

                          <td>{{ $info->sumber_info }}</td>

                        </tr>
                        
                        <tr>

                          <td>Kategori Informasi</td>

                          <td>:</td>

                          <td>{{ $info->SMKKategoriInfo->kategori_info }}</td>

                        </tr>   

                      </tbody>

                    </table>

                    <a href="{{ route('smk.admin.info') }}" class="btn btn-default btn-sm" style="margin-top: 10px"><i class="fa fa-arrow-left"></i> Kembali</a>

                  </div>

                </div>

              </div>

            </div>

        </div>

    </section><!-- /.content -->

@stop

