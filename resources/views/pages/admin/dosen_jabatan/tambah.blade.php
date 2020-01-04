@extends('template')

@section('main')
    <section class="content-header">
        <h1>Tambah Jabatan Dosen</h1>
        <ol class="breadcrumb">
            <li>Home</li>
            <li>Jabatan Dosen</li>
            <li class="active">Tambah Jabatan Dosen</li>
          </ol>
    </section><!-- /.content-header -->

    <section class="content">
        @include('_partials.flash_message')
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Form Tambah</h3>
            </div>
            <div class="box-body">
                {!! Form::open(['method' => 'POST', 'route' => 'admin.dosen_jabatan.simpan', 'files' => 'true']) !!}
                    @include('pages.admin.dosen_jabatan.form', ['btnSubmit' => 'Tambah Data'])
                {!! Form::close() !!}
            </div>
        </div>
    </section><!-- /.content -->
@stop
