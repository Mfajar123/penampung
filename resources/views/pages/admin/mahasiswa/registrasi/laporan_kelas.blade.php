@extends('template')



@section('main')

<!-- Content Header (Page header) -->

     <section class="content-header">

      <h1>

       Laporan Kelas

      </h1>

      <ol class="breadcrumb">

        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

         <li><a href="#">Pembayaran</a></li>

        <li class="active">Laporan Keuangan Kelulusan</li>

      </ol>

    </section>


    <!-- Main content -->

    <section class="content">

      <div class="row">

        <div class="col-md-12">

          <div class="box box-default">

                <div class="box-header with-border">

                        
                </div>
                   
              <div class="box-body">

              <div class="row">
                <div class="col-lg-12 col-xs-12">
                  <!-- small box -->
                  <div class="small-box bg-blue">
                    <div class="inner">
                    <h3>{{ @$all }}</h3>

                      <p>Semua Kelas Terisi</p>
                    </div>
                    <div class="icon">
                      <i class="ion ion-android-document"></i>
                    </div>
                    <a href="{{ route('admin.kelas') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                </div>
              </div>

                <div class="row">
                  <div class="col-lg-6 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-fuchsia">
                      <div class="inner">
                      <h3>{{ @$akuntansi }}</h3>

                        <p>Akuntansi</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-android-document"></i>
                      </div>
                      <a href="{{ route('admin.kelas') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                  </div>
                  <!-- ./col -->
                  <div class="col-lg-6 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-maroon">
                      <div class="inner">
                      <h3>{{ @$manajemen }}</h3>

                        <p>Manajemen</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                      </div>
                      <a href="{{ route('admin.kelas') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <!-- ./col -->
                  <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-aqua">
                      <div class="inner">
                      <h3>{{ $pagi }}</h3>

                        <p>Pagi</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-person"></i>
                      </div>
                      <a href="{{ route('admin.kelas') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                  </div>
                  <!-- ./col -->
                  <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-black">
                      <div class="inner">
                      <h3>{{ $malem }}</h3>

                        <p>Malam</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                      </div>
                      <a href="{{ route('admin.kelas') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                  </div>

                  <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-navy">
                      <div class="inner">
                      <h3>{{ $executive }}</h3>

                        <p>Executive</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                      </div>
                      <a href="{{ route('admin.kelas') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                  </div>

                  <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-red">
                      <div class="inner">
                      <h3>{{ @$shift }}</h3>

                        <p>Shift</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                      </div>
                      <a href="{{ route('admin.kelas') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                  </div>
                  <!-- ./col -->
                </div>
                <!-- /.row -->
              </div>
          </div>
        </div>
      </div>
              
    </section>

@stop

