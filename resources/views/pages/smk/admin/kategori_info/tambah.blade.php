@extends('template')



@section('main')

    <section class="content-header">

        <h1>Tambah Kategori Informasi</h1>

        <ol class="breadcrumb">

            <li>Home</li>

            <li>Kategori Informasi</li>

            <li class="active">Tambah Kateori Infromasi</li>

          </ol>

    </section><!-- /.content-header -->



    <section class="content">

        @include('_partials.flash_message')

        <div class="box">

            <div class="box-header with-border">

                <h3 class="box-title">Form Tambah</h3>

            </div>

            <div class="box-body">

                {!! Form::open(['method' => 'POST', 'route' => 'smk.admin.kategori_info.simpan', 'files' => 'true']) !!}

                    @include('pages.smk.admin.kategori_info.form', ['btnSubmit' => 'Tambah Data'])

                {!! Form::close() !!}

            </div>

        </div>

    </section><!-- /.content -->

@stop

