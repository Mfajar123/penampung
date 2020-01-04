@extends('template')



@section('main')

    <section class="content-header">

        <h1>Ubah Pengumuman</h1>

        <ol class="breadcrumb">

            <li>Home</li>

            <li>Pengumuman</li>

            <li class="active">Ubah Pengumuman</li>

          </ol>

    </section><!-- /.content-header -->



    <section class="content">

        @include('_partials.flash_message')

        <div class="box">

            <div class="box-header with-border">

                <h3 class="box-title">Form Ubah</h3>

            </div>

            <div class="box-body">

                {!! Form::model($pengumuman, ['method' => 'POST', 'route' => ['admin.pengumuman.ubah', $id], 'files' => 'true']) !!}

                    @include('pages.admin.pengumuman.form', ['btnSubmit' => 'Ubah Data'])

                {!! Form::close() !!}

            </div>

        </div>

    </section><!-- /.content -->

@stop

