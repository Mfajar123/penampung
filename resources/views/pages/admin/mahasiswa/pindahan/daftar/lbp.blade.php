@extends('template')



@section('main')

<!-- Content Header (Page header) -->

     <section class="content-header">

      <h1>

       Laporan

      </h1>

      <ol class="breadcrumb">

        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

         <li><a href="#">Pembayaran</a></li>

        <li class="active">Laporan Pembayaran SPP</li>

      </ol>

    </section>


    <!-- Main content -->

    <section class="content">

      <div class="row">

        <div class="col-md-12">

          <div class="box box-default">

            <div class="box-header with-border">
              <h4 class="box-title">Laporan Biaya Pendaftaran <?php if ($awal != '' ) { echo 'Periode ' . date('M-d-Y', strtotime($awal)) . ' &nbsp S/D &nbsp ' . date('M-d-Y', strtotime($akhir)) ; }else{} ?></h4>
           {!! Form::open(['method' => 'POST']) !!}
              <div class="form-group">
                <div class="col-md-6">
                  <label for="">Dari Tanggal</label>
                  <input type="date" name="awal" value="{{ @$awal }}" class="form-control">
                </div>
                <div class="col-md-6">
                  <label for="">Sampai Tanggal</label>
                  <input type="date" name="akhir" value="{{ @$akhir }}" class="form-control">
                </div>
              </div>

               <div style="margin-left: 15px; margin-top: 15px;">
                <br><br><br><br>
                {!! Form::submit('Tampilkan', ['class' => 'btn btn-default']) !!}
                {!! Form::close() !!}
              </div>
            </div>
  
            
          @if (Request::isMethod('post'))
            <div class="box-body">

              <div class="col-md-12 col-xs-12">

                <div class="row">

                  <div class="table-responsive">

                     <table class="table table-striped table-bordered dttbl" >

                      <thead>

                        <tr>

                          <th>No</th>

                          <th>ID Daftar</th>

                          <th>Nama Calon Mahasiswa</th>
                          
                          <th>Tanggal</th>
                      
                          <th>Prodi</th>

                          <th>Jenis Pembayaran</th>

                          <th>Status</th>

                          <th>Bayar</th>

                        </tr>

                      </thead>

                        <?php   $total_bayar = 0; ?>

                        @foreach($laporan as $lapor)
                        
                        <?php  $total_bayar += $lapor->bayar   ?>

                      <tbody>

                        <tr>  
                  
                          <td>{{ $no++ }}</td>

                          <td>{{ $lapor->id_daftar }}</td>

                          <td>{{ $lapor->nama }}</td>

                          <td>{{ date('d-M-Y', strtotime($lapor->created_at))}}</td>

                          <td>{{ $lapor->nama_prodi }}</td>

                          <td>Bayar Pendaftaran</td>

                          <td>{{ $lapor->status_bayar }}</td>

                        <?php  if ($lapor->bayar != '250000' ) { ?>
                          <th ><u>{{ $lapor->bayar }}</u></th>
                          <?php }else{ ?>
                            <td>{{ $lapor->bayar }}</td>
                          <?php } ?>

                        </tr>
                        
                      </tbody>

                      @endforeach

                      <tfoot>
                        <tr bgcolor="#CCC">
                          <td colspan="7" style="font-weight: bold; text-align: right;">Total : </td>
                          <td style="text-align: left; font-weight: bold;">Rp.<?php echo number_format($total_bayar); ?>,-</td>
                        </tr>
                    </tfoot>

                    </table>


                  </div>

                </div>

              </div>

            </div>
        @endif
          </div>

        </div>

      </div>
    
    </section>

@stop