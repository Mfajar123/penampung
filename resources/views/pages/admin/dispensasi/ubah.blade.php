@extends('template')



@section('main')

    <section class="content-header">

        <h1>Ubah dispensasi</h1>

        <ol class="breadcrumb">

            <li>Home</li>

            <li>dispensasi</li>

            <li class="active">Ubah dispensasi</li>

          </ol>

    </section><!-- /.content-header -->



    <section class="content">

        @include('_partials.flash_message')

        <div class="box">

            <div class="box-header with-border">

                <h3 class="box-title">Form Ubah</h3>

            </div>

            <div class="box-body">

                {!! Form::model($daftar, ['method' => 'POST', 'route' => ['admin.dispensasi.ubah', $id, $dp], 'files' => 'true']) !!}
                    @include('pages.admin.dispensasi.form', ['btnSubmit' => 'Ubah Data'])

                {!! Form::close() !!}

            </div>

        </div>

    </section><!-- /.content -->

@stop

