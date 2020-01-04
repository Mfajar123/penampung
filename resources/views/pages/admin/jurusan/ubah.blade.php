@extends('template')

@section('main')
    <section class="content-header">
        <h1>Ubah Jurusan</h1>
    </section><!-- /.content-header -->

    <section class="content">
        @include('_partials.flash_message')
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Form Ubah</h3>
            </div>
            <div class="box-body">
                {!! Form::model($jurusan, ['method' => 'POST', 'route' => ['admin.jurusan.perbarui', $id]]) !!}
                    @include('pages.admin.jurusan.form', ['btnSubmit' => 'Ubah Data'])
                {!! Form::close() !!}
            </div>
        </div>
    </section><!-- /.content -->
@stop
