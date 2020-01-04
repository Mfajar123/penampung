@extends('template')

@section('main')
    <section class="content-header">
        <h1>Ubah Karyawan</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ route('admin.karyawan') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Ubah Karyawan</li>
          </ol>
    </section><!-- /.content-header -->

    <section class="content">
        @include('_partials.flash_message')
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Form Ubah</h3>
            </div>
            <div class="box-body">
                {!! Form::model($karyawan, ['method' => 'POST', 'route' => ['admin.karyawan.ubah', $id], 'files' => 'true']) !!}
                    @include('pages.admin.karyawan.form', ['btnSubmit' => 'Ubah Data'])
                {!! Form::close() !!}
            </div>
        </div>
    </section><!-- /.content -->
@stop
