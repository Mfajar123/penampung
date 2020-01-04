@extends('template')



@section('main')

    <section class="content-header">

        <h1>Detail Pesan</h1>

        <ol class="breadcrumb">

        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

        <li class="active">Detail Pesan</li>

      </ol>

    </section><!-- /.content-header -->



    <section class="content">



            <div class="col-md-12 col-xs-12">

              <div class="box box-primary">

                <div class="box-header with-border">

                  <div class="box-title">

                      Detail Pesan Dari : <strong>{{ $pesan->nama }}</strong>

                  </div>

                  <div class="box-body">

                    <table class="table table-respoonsive">

                      <tbody>

                        <tr>

                          <td width="150">Nama</td>

                          <td width="10">:</td>

                          <td>{{ $pesan->nama }}</td>

                        </tr>



                        <tr>

                          <td>E-mail</td>

                          <td>:</td>

                          <td>
                              {{ $pesan->email }}
                          </td>

                        </tr>



                        <tr>

                          <td>No Telepon</td>

                          <td>:</td>

                          <td>{{ $pesan->no_telp }}</td>

                        </tr>



                        <tr>

                          <td>Subjek</td>

                          <td>:</td>

                          <td> 
                            {{ $pesan->subjek }}
                          </td>

                        </tr>



                        <tr>

                          <td>Pesan</td>

                          <td>:</td>

                          <td>{{ $pesan->pesan }}</td>

                        </tr>
                        
                       

                      </tbody>

                    </table>

                    <a href="{{ route('admin.pesan') }}" class="btn btn-default btn-sm" style="margin-top: 10px"><i class="fa fa-arrow-left"></i> Kembali</a>

                  </div>

                </div>

              </div>

            </div>

        </div>

    </section><!-- /.content -->

@stop

