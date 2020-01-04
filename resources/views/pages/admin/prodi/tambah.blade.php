@extends('template')

@section('main')
    <section class="content-header">
        <h1>Tambah Prodi</h1>
    </section><!-- /.content-header -->

    <section class="content">
        @include('_partials.flash_message')
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Form Tambah</h3>
            </div>
            <div class="box-body">
                {!! Form::open(['method' => 'POST', 'route' => 'admin.prodi.simpan', 'files' => true]) !!}
                    @include('pages.admin.prodi.form', ['btnSubmit' => 'Tambah Data'])
                {!! Form::close() !!}
            </div>
        </div>
    </section><!-- /.content -->
@stop
