@extends('template')

@section('main')
    <section class="content-header">
        <h1>Edit KRS Mahasiswa</h1>
        <ol class="breadcrumb">
            <li>Home</li>
            <li>KRS</li>
            <li class="active">Edit KRS Mahasiswa</li>
          </ol>
    </section><!-- /.content-header -->

    <section class="content">
        @include('_partials.flash_message')
        {!! Form::model($krs, ['name' => 'frm_krs', 'method' => 'PUT', 'route' => ['mahasiswa.krs.perbarui', $krs->id_krs], 'files' => 'true']) !!}
            @include('pages.mahasiswa.krs.form', ['btnSubmit' => 'Perbarui'])
        {!! Form::close() !!}
    </section><!-- /.content -->
@stop
