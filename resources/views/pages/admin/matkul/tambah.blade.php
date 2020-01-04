@extends('template')

@section('main')
    <section class="content-header">
        <h1>Tambah Mata Kuliah</h1>
        <ol class="breadcrumb">
          <li>Home</li>
          <li>Mata Kuliah</li>
          <li class="active">Tambah Mata Kuliah</li>
        </ol>
    </section><!-- /.content-header -->

    <section class="content">
        @include('_partials.flash_message')
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Form Tambah</h3>
            </div>
            <div class="box-body">
                {!! Form::open(['method' => 'POST', 'route' => 'admin.matkul.simpan', 'files' => true]) !!}
                    @include('pages.admin.matkul.form', ['btnSubmit' => 'Tambah Data'])
                {!! Form::close() !!}
            </div>
        </div>
    </section><!-- /.content -->
@stop
