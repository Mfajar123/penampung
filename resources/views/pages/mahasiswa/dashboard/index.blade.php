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
                        <p><h3>Profile</h3></p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user"></i></div>
                        <a href="#" class="small-box-footer">More Info
                        <i class="fa fa-arrow-circle-right"></a></i>
                    </div></div>
            
        <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-green">
                    <div class="inner">
                        <p><h3>Bayaran</h3></p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-btc"></i></div>
                        <a href="#" class="small-box-footer">More Info
                        <i class="fa fa-arrow-circle-right"></a></i>
                    </div></div>
        

        <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <p><h3>Agenda</h3></p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-calendar"></i></div>
                        <a href="#" class="small-box-footer">More Info
                        <i class="fa fa-arrow-circle-right"></a></i>
                    </div></div>

        <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-red">
                    <div class="inner">
                        <p><h3>Info</h3></p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-info"></i></div>
                        <a href="#" class="small-box-footer">More Info
                        <i class="fa fa-arrow-circle-right"></i>
                    </div></div>

        </div>
                    
        <div class="row">
            <div class="col-md-6">
                
                @include('pages.mahasiswa.dashboard.components.pengumuman')
                 
            </div>
            <div class="col-md-6">
                @include('pages.mahasiswa.dashboard.components.profile')
                @include('pages.mahasiswa.dashboard.components.agenda')
                @include('pages.mahasiswa.dashboard.components.jadwal_kuliah')
                 @include('pages.mahasiswa.dashboard.components.pembayaran_spp') 
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