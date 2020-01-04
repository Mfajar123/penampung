@extends('template')

@section('main')
    <section class="content-header">
        <h1>Ubah Mata Kuliah</h1>
    </section><!-- /.content-header -->

    <section class="content">
        @include('_partials.flash_message')
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Form Ubah</h3>
            </div>
            <div class="box-body">
                {!! Form::model($pembayaran, ['method' => 'POST', 'route' => ['admin.pembayaran.perbarui', $id]]) !!}
                    @include('pages.admin.pembayaran.form', ['btnSubmit' => 'Ubah Data'])
                {!! Form::close() !!}
            </div>
        </div>
    </section><!-- /.content -->
@stop
