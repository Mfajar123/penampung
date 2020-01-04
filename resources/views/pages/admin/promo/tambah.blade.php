@extends('template')

@section('main')
    <section class="content-header">
        <h1>Tambah Promo</h1>
        <ol class="breadcrumb">
            <li>Home</li>
            <li>Promo</li>
            <li class="active">Tambah Promo</li>
          </ol>
    </section><!-- /.content-header -->

    <section class="content">
        @include('_partials.flash_message')
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Form Tambah</h3>
            </div>
            <div class="box-body">
                {!! Form::open(['method' => 'POST', 'route' => 'admin.promo.simpan', 'files' => 'true']) !!}
                    @include('pages.admin.promo.form', ['btnSubmit' => 'Tambah Data'])
                {!! Form::close() !!}
            </div>
        </div>
    </section><!-- /.content -->
@stop
