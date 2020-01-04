@extends('template')



@section('main')

    <section class="content-header">

        <h1>Detail Dispensasi</h1>

        <ol class="breadcrumb">

        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

        <li class="active">Detail Dispensasi</li>

      </ol>

    </section><!-- /.content-header -->



    <section class="content">

       


            <div class="col-md-12 col-xs-12">

              <div class="box box-primary">

                <div class="box-header with-border">

                  <div class="box-title">

                      Detail Dispensasi : <strong>{{ @$dispensasi->judul_dispensasi }}</strong>

                  </div>

                  <div class="box-body">

                    <table class="table table-respoonsive">

                      <tbody>

                    
                        <tr>

                          <td>Nama</td>

                          <td>:</td>

                          <td>
                              {{ @$dispensasi->nama }}
                          </td>

                        </tr>



                        <tr>

                          <td>Jenis Pembayara</td>

                          <td>:</td>

                          <td>{{ $dispensasi->jenis_pembayaran }}</td>

                        </tr>



                        <tr>

                          <td>Tanggal Akan Bayar</td>

                          <td>:</td>

                          <td> 
                            {{ $dispensasi->tanggal_akan_bayar }}
                          </td>

                        </tr>



                        <tr>

                          <td>Nominal Akan Bayar</td>

                          <td>:</td>

                          <td>{{ $dispensasi->nominal_akan_bayar }}</td>

                        </tr>   

                      </tbody>

                    </table>

                    <a href="{{ route('admin.dispensasi') }}" class="btn btn-default btn-sm" style="margin-top: 10px"><i class="fa fa-arrow-left"></i> Kembali</a>

                  </div>

                </div>

              </div>

            </div>

        </div>

    </section><!-- /.content -->

@stop

