@extends('template')

@section('main')
    <section class="content-header">
        <h1>Ubah Tahun Akademik</h1>
        <ol class="breadcrumb">
            <li>Home</li>
            <li>Tahun Akademik</li>
            <li class="active">Ubah Tahun Akademik</li>
          </ol>
    </section><!-- /.content-header -->

    <section class="content">
        @include('_partials.flash_message')
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Form Ubah</h3>
            </div>
            <div class="box-body">
                {!! Form::model($tahun, ['method' => 'POST', 'route' => ['admin.tahun_akademik.ubah', $id], 'files' => 'true']) !!}
                    @include('pages.admin.tahun_akademik.form', ['btnSubmit' => 'Ubah Data'])
                {!! Form::close() !!}
            </div>
        </div>
    </section><!-- /.content -->
@stop
