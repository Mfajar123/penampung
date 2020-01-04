@extends('template')



@section('main')

    <section class="content-header">

        <h1>Ubah Mahasiswa</h1>

        <ol class="breadcrumb">

        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

        <li class="active">Ubah Mahasiswa</li>

      </ol>

    </section><!-- /.content-header -->



    <section class="content">

        @include('_partials.flash_message')

            <div class="box">

                <div class="box-header with-border">

                    <h3 class="box-title">Form Ubah</h3>

                </div>

                <div class="box-body">

                    {!! Form::model($daftar, ['method' => 'POST', 'route' => ['admin.daftar.pindahan.perbarui', $id], 'files' => true]) !!}

                        @include('pages.admin.mahasiswa.pindahan.daftar.form', ['Submit' => 'Ubah Data'])

                    {!! Form::close() !!}

                </div>

            </div>

    </section><!-- /.content -->

@stop

