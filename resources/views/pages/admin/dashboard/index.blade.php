@extends('template')

@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/fullcalendar.min.css">
    <style>
        .content-title {
            margin-top: 0;
            margin-bottom: 15px;
        }
    </style>
@stop

@section('main')
    <section class="content-header">
        <h1>Dashboard</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-blue">
                    <div class="inner">
                        <h3>{{ $count_dosen }}</h3>
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
                        <h3>{{ $count_karyawan }}</h3>
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
                        <h3>{{ $count_mahasiswa }}</h3>
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
                        <h3>{{ $count_pendaftaran }}</h3>
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
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-bell"></i> Notification</h3>
                        <div class="box-tools pull-right">
                            <button data-original-title="collapse" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Show / Hide"><i class="fa fa-minus"></i></button>
                            <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <ul>
                            @foreach( $list_notification_dispensasi as $row)
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
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h5 class="box-title">Agenda</h5>
                    </div>
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/fullcalendar.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            var events = [
                @foreach ($list_agenda as $agenda)
                    {
                        title: "{{ $agenda['title'] }}",
                        start: "{{ $agenda['start'] }}",
                        end: "{{ $agenda['end'] }}"
                    },
                @endforeach
            ];

            $("#calendar").fullCalendar({
                defaultView: "month",
                defaultDate: "{{ date('Y-m-d') }}",
                eventColor: "#2196F3",
                events: events
            });
        });
    </script>
@stop