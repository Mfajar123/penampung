@extends('template')



@section('main')

    <section class="content-header">

        <h1>Tambah Kelas Dibuka</h1>

    </section><!-- /.content-header -->



    <section class="content">

        @include('_partials.flash_message')

        <div class="box">

            <div class="box-header with-border">

                <h3 class="box-title">Form Tambah</h3>

            </div>

            <div class="box-body">

                {!! Form::open(['method' => 'POST', 'route' => 'admin.kelas.simpan', 'files' => true]) !!}

                    @include('pages.admin.kelas.form', ['btnSubmit' => 'Simpan'])

                {!! Form::close() !!}

            </div>

        </div>

    </section><!-- /.content -->

@stop

