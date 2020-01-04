@extends('template')



@section('main')

    <section class="content-header">

        <h1>Pendaftaran Mahasiswa</h1>

        <ol class="breadcrumb">

            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

            <li><a href="#"><i class="fa fa-file-text-o"></i> Pendaftaran</a></li>

            <li class="active">Pendaftaran Mahasiswa</li>

          </ol>

    </section><!-- /.content-header -->



    <section class="content">

        @include('_partials.flash_message')

            <div class="box">

                <div class="box-header with-border">

                    <h3 class="box-title">Form Pendaftaran</h3>

                </div>

                <div class="box-body">

                    {!! Form::open(['method' => 'POST', 'route' => 'admin.daftar.pindahan.simpan', 'files' => true]) !!}

                        @include('pages.admin.mahasiswa.pindahan.daftar.form', ['Submit' => 'Daftar'])

                    {!! Form::close() !!}

                </div>

            </div>

    </section><!-- /.content -->

@stop

