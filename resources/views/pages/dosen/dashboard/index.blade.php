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
            <div class="col-md-6">
                @include('pages.dosen.dashboard.components.pengumuman')
            </div>
            <div class="col-md-6">
                @include('pages.dosen.dashboard.components.jadwal_kuliah')
                @include('pages.dosen.dashboard.components.agenda')
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