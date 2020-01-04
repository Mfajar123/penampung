@extends('template')

@section('main')
    <section class="content-header">
        <h1>Ubah Dosen</h1>
        <ol class="breadcrumb">
            <li>Home</li>
            <li>Dosen</li>
            <li class="active">Ubah Dosen</li>
          </ol>
    </section><!-- /.content-header -->

    <section class="content">
        @include('_partials.flash_message')
        {!! Form::model($dosen, ['method' => 'POST', 'route' => ['admin.dosen.ubah', $id], 'files' => 'true']) !!}
            @include('pages.admin.dosen.form', ['btnSubmit' => 'Ubah Data'])
        {!! Form::close() !!}
    </section><!-- /.content -->
@stop
