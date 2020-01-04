@extends('template')



@section('main')

    <section class="content-header">

        <h1>Ubah Informasi</h1>

        <ol class="breadcrumb">

            <li>Home</li>

            <li>Informasi</li>

            <li class="active">Ubah Informasi</li>

          </ol>

    </section><!-- /.content-header -->



    <section class="content">

        @include('_partials.flash_message')

        <div class="box">

            <div class="box-header with-border">

                <h3 class="box-title">Form Ubah</h3>

            </div>

            <div class="box-body">

                {!! Form::model($info, ['method' => 'POST', 'route' => ['admin.info.ubah', $id], 'files' => 'true']) !!}

                    @include('pages.admin.info.form', ['btnSubmit' => 'Ubah Data'])

                {!! Form::close() !!}

            </div>

        </div>

    </section><!-- /.content -->

@stop

