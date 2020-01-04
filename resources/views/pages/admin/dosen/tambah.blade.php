@extends('template')

@section('main')
    <section class="content-header">
        <h1>Tambah Dosen</h1>
        <ol class="breadcrumb">
            <li>Home</li>
            <li>Dosen</li>
            <li class="active">Tambah Dosen</li>
          </ol>
    </section><!-- /.content-header -->

    <section class="content">
        {!! Form::open(['method' => 'POST', 'route' => 'admin.dosen.simpan', 'files' => 'true']) !!}
            @include('pages.admin.dosen.form', ['btnSubmit' => 'Tambah Data'])
        {!! Form::close() !!}
    </section><!-- /.content -->
@stop
