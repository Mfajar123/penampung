@extends('template')



@section('main')

<!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        Dashboard

      </h1>

      <ol class="breadcrumb">

        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

        <li class="active">Dashboard</li>

      </ol>

    </section>



    <!-- Main content -->

    <section class="content">

      <div class="row">

        <div class="col-xs-12">

          @if(Request::segment(1) == 'admin')
<!--<div class="callout callout-info">-->
<!--    <h4>Selamat Datang Admin</h4>-->
<!--</div>-->

<div class="row">
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-blue">
            <div class="inner">
                <h3>{{ $dosen }}</h3>
                <p>Dosen</p>
            </div>
            <div class="icon">
                <i class="fa fa-user"></i>
            </div>
            <a href="{{route('admin.dosen')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-green">
            <div class="inner">
                <h3>{{ $karyawan }}</h3>
                <p>Karyawan</p>
            </div>
            <div class="icon">
                <i class="fa fa-user"></i>
            </div>
            <a href="{{route('admin.karyawan')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3>{{ $mahasiswa }}</h3>
                <p>Mahasiswa</p>
            </div>
            <div class="icon">
                <i class="fa fa-user"></i>
            </div>
            <a href="{{route('admin.mahasiswa')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-red">
            <div class="inner">
                <h3>{{ $pendaftar }}</h3>
                <p>Pendaftar</p>
            </div>
            <div class="icon">
                <i class="fa fa-user"></i>
            </div>
            <a href="{{route('admin.daftar') }} " class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-bell"></i> Notification</h3>
                <div class="box-tools pull-right">
                    <button data-original-title="collapse" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Show / Hide"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                <ul>
                    @foreach( $notif_dispen as $row)
                    <?php 
                        $nama = $row->nama;
                        $tgl = $row->tanggal_akan_bayar;
                        $date = date('d-M-Y', strtotime($tgl));
                        $tgl2 = date('Y-m-d', strtotime($tgl . ' - 2 days'));
                        $tgl1 = date('Y-m-d', strtotime($tgl . ' - 1 days'));
                        $judul = '';
                        $tgl_notif =  date('d/m/Y h:i:sa', strtotime($row->created_date));
                        $notif = '';  
                    
                        if ( $tgl == $tanggal ) {
                            $judul = 'Notification Dispensasi' ;
                            $notif =  $nama . ' Telah memasuki tanggal perjanjian pembayaran dispensasi pada hari ini tanggal '. date('d-M-Y', strtotime($tgl ));
                        }elseif( $tgl2 == $tanggal )  {
                            $judul = 'Notification Dispensasi' ;
                            $notif =  $nama . ' 2 hari sebelum memasuki tanggal perjanjian pembayaran dispensasi pada tanggal '. date('d-M-Y', strtotime($tgl ));
                        }elseif( $tgl1 == $tanggal ) {
                            $judul = 'Notification Dispensasi' ;
                            $notif = $nama . ' 1 hari sebelum memasuki tanggal perjanjian pembayaran dispensasi pada tanggal '. date('d-M-Y', strtotime($tgl ));
                        }
                        ?>
                        <?php 
                        if ( $notif !== '' ) { ?>
                            <a href="{{ route('admin.dispensasi') }}"  target="_blank" class="box-header with-border">
                                <div class="notification_module text-primary">
                                    <i class="fa fa-circle-o col-md-8 col-sm-9"> Dispensasi</i>
                                    <small >{{ $tgl_notif }}</small>
                                </div>
                                <div class="notification_text col-md-12">
                                    {{   @$notif  }}
                                </div>
                            </a>
                        <?php } ?>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
    @elseif(Request::segment(1) == 'mahasiswa')
            
        <div class="row">
            <div class="col-xs-12 col-md-12">
                
            @foreach ( $pengumuman as $umum )
                <div class="box box-default">
    
                  <div class="box-header with-border">
    
                    <h3 class="box-title" style="color: black;">
                        <i class="fa fa-warning" style="color: #FFD700;"></i>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        {{ $umum->judul_pengumuman }} 
                        <span style="font-size: 12px; color: grey;">( <?php echo date('D, d-M-Y', strtotime($umum->waktu_pengumuman)) ;?> )</span>
                    </h3>
    
                    <div class="box-tools pull-right">
    
                      <button data-original-title="collapse" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Show / Hide"><i class="fa fa-minus"></i></button>
    
                      <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
    
                    </div>
    
                  </div>
        
                <div class="box-body">
                    @if($umum->foto_pengumuman != '')              
                        <div class="col-md-3" >
                             <?php $hasil =  substr($umum->foto_pengumuman ,-4); ?>
                            @if( $hasil == '.pdf' )
                              <a href="{{ asset('images/pengumuman/'.$umum->foto_pengumuman) }}" target="_blank" style="font-size:20px;"><i class="fa fa-file-pdf-o"></i>File Pdf</a>
                            @elseif($hasil == '.doc')
                              <a href="{{ asset('images/pengumuman/'.$umum->foto_pengumuman) }}" target="_blank"><i class="fa fa-file-doc-o"></i>File Doc</a>
                            @elseif($hasil == '.docx')
                              <a href="{{ asset('images/pengumuman/'.$umum->foto_pengumuman) }}" target="_blank"><i class="fa fa-file-doc-o"></i>File Docx</a>
                            @else
                            <a target="_blank" href="{{ asset('images/pengumuman/'.$umum->foto_pengumuman) }}"><img src="{{ asset('images/pengumuman/'.$umum->foto_pengumuman) }}" alt="Foto Pendukung" class="img-responsive">Gambar
                            </a>
                            @endif
                        </div>
                    @endif
                   <div class="col-md-9">
                       {!! $umum->isi_pengumuman !!}
                   </div>
    
                </div>
            </div>
                @endforeach
       
    @elseif(Request::segment(1) == 'dosen')
            
        <div class="row">
            <div class="col-xs-12 col-md-12">
                
            @foreach ( $pengumuman as $umum )
                <div class="box box-default">
    
                  <div class="box-header with-border">
    
                    <h3 class="box-title" style="color: black;">
                        <i class="fa fa-warning" style="color: #FFD700;"></i>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        {{ $umum->judul_pengumuman }} 
                        <span style="font-size: 12px; color: grey;">( <?php echo date('D, d-M-Y', strtotime($umum->waktu_pengumuman)) ;?> )</span>
                    </h3>
    
                    <div class="box-tools pull-right">
    
                      <button data-original-title="collapse" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Show / Hide"><i class="fa fa-minus"></i></button>
    
                      <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
    
                    </div>
    
                  </div>
        
                <div class="box-body">
                    @if($umum->foto_pengumuman != '')              
                        <div class="col-md-3" >
                             <?php $hasil =  substr($umum->foto_pengumuman ,-4); ?>
                            @if( $hasil == '.pdf' )
                              <a href="{{ asset('images/pengumuman/'.$umum->foto_pengumuman) }}" target="_blank" style="font-size:20px;"><i class="fa fa-file-pdf-o"></i>File Pdf</a>
                            @elseif($hasil == '.doc')
                              <a href="{{ asset('images/pengumuman/'.$umum->foto_pengumuman) }}" target="_blank"><i class="fa fa-file-doc-o"></i>File Doc</a>
                            @elseif($hasil == '.docx')
                              <a href="{{ asset('images/pengumuman/'.$umum->foto_pengumuman) }}" target="_blank"><i class="fa fa-file-doc-o"></i>File Docx</a>
                            @else
                            <a target="_blank" href="{{ asset('images/pengumuman/'.$umum->foto_pengumuman) }}"><img src="{{ asset('images/pengumuman/'.$umum->foto_pengumuman) }}" alt="Foto Pendukung" class="img-responsive">Gambar
                            </a>
                            @endif
                        </div>
                    @endif
                   <div class="col-md-9">
                       {!! $umum->isi_pengumuman !!}
                   </div>
    
                </div>
            </div>
        @endforeach
       
    @endif
        </div>

      </div>

    </section>

    <!-- /.content -->

@stop