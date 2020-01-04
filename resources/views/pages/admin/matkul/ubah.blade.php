@extends('template')

@section('main')
    <section class="content-header">
        <h1>Ubah Mata Kuliah</h1>
        <ol class="breadcrumb">
          <li>Home</li>
          <li>Mata Kuliah</li>
          <li class="active">Ubah Mata Kuliah</li>
        </ol>
    </section><!-- /.content-header -->

    <section class="content">
        @include('_partials.flash_message')
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Form Ubah</h3>
            </div>
            <div class="box-body">
                {!! Form::model($matkul, ['method' => 'POST', 'route' => ['admin.matkul.perbarui', $id]]) !!}
                    @include('pages.admin.matkul.form', ['btnSubmit' => 'Ubah Data'])
                {!! Form::close() !!}
            </div>
        </div>
    </section><!-- /.content -->
@stop
