@extends('template')



@section('main')

<!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

       Laporan

      </h1>

      <ol class="breadcrumb">

        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

         <li><a href="#">Pendaftaran</a></li>

        <li class="active">Laporan Jumlah Pendaftar</li>

      </ol>

    </section>
    
    <section class="content">

      <div class="row">

        <div class="col-md-12">

          <div class="box box-default">

            <div class="box-header with-border">

              <h4 class="box-title">Laporan Jumlah Pendaftar</h4>


               {!! Form::open(['method' => 'POST']) !!}
             
                <div class="form-group"><br>
                  <label for="">Tahun</label>
                   <select name="year" class="form-control" >
                        <option value="">Pilih Tahun</option>
                        <?php 
                        for ($i=2010; $i <= date('Y')  ; $i++) {                          
                           if ($i == $year ) { ?>
                        <option value="<?php echo $i;?>" selected="selected">Tahun <?php echo $i;?></option>
                  <?php   } else { ?>
                        <option value="<?php echo $i; ?>" >Tahun <?php echo $i; ?></option>
                    <?php   }
                    } ?>
                 </select>
              </div>
            <div>
              {!! Form::submit('Tampilkan', ['class' => 'btn btn-default']) !!}
              {!! Form::close() !!}
            </div>
        </div>
       

    @if (Request::isMethod('post'))
    <!-- Main content -->
    
              <div class="box-body">

                <div class="col-md-12 col-xs-12">

                  <div class="row">

                    <h3 class="box-title">Laporan</h3>
                    <div class="pull-right">
                        <a href="#"></a>
                    </div>
                  </div>

                  <div class="box-body">
                    <div class="chart">
                      <div id="grafik"></div>
                    </div>
                  </div>
                  <!-- /.box-body -->
                </div>

              </div>

            </div>
        @endif
          </div>

        </div>
    
    </section>

    @stop
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    @section('script')
    <script type="text/javascript">

    /*peminjaman*/

    var pindahan = [ <?php echo $list_mahasiswa_pindahan;?> ];
    var baru = [ <?php echo $list_mahasiswa_baru;?> ];
    var asing = [ <?php echo $list_mahasiswa_asing;?> ];
    Highcharts.chart('grafik', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Laporan Jumlah Pendaftar Tahun <?php echo $year; ?>'
    },
    subtitle: {
        text: 'Source: yayasanppi.net'
    },
    xAxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
    },
    yAxis: {
        title: {
            text: 'Laporan'
        }
    },
    tooltip: {
        crosshairs: true,
        shared: true
    },
    plotOptions: {
        spline: {
            marker: {
                radius: 4,
                lineColor: '#666666',
                lineWidth: 1
            }
        }
    },
    series: [{
        name: 'Mahasiswa Baru',
        marker: {
            symbol: 'square'
        },
        data: baru

    }, {
        name: 'Mahasiswa Pindahan',
        marker: {
            symbol: 'square'
        },
        data: pindahan

    }, {
        name: 'Mahasiswa Asing',
        marker: {
            symbol: 'square'
        },
        data: asing
    }]
});
</script>
@endsection