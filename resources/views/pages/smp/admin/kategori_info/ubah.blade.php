@extends('template')



@section('main')

    <section class="content-header">

        <h1>Ubah Kategori Informasi</h1>

        <ol class="breadcrumb">

            <li>Home</li>

            <li>Kategori Informasi</li>

            <li class="active">Ubah Kategori Informasi</li>

          </ol>

    </section><!-- /.content-header -->



    <section class="content">

        @include('_partials.flash_message')

        <div class="box">

            <div class="box-header with-border">

                <h3 class="box-title">Form Ubah</h3>

            </div>

            <div class="box-body">

                {!! Form::model($kategori_info, ['method' => 'POST', 'route' => ['smp.admin.kategori_info.ubah', $id], 'files' => 'true']) !!}

                    @include('pages.smp.admin.kategori_info.form', ['btnSubmit' => 'Ubah Data'])

                {!! Form::close() !!}

            </div>

        </div>

    </section><!-- /.content -->

@stop

