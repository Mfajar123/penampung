@extends('template')



@section('main')

    <section class="content-header">

        <h1>Tambah Mahasiswa</h1>

        <ol class="breadcrumb">

            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

            <li><a href="{{ route('admin.karyawan') }}"><i class="fa fa-user"></i> Karyawan</a></li>

            <li class="active">Tambah Karyawan</li>

          </ol>

    </section><!-- /.content-header -->



    <section class="content">

        @include('_partials.flash_message')

        <div class="box">

            <div class="box-header with-border">

                <h3 class="box-title">Form Tambah</h3>

            </div>

            <div class="box-body">

                {!! Form::open(['method' => 'POST', 'route' => 'smp.admin.karyawan.simpan', 'files' => 'true']) !!}

                    @include('pages.smp.admin.karyawan.form', ['btnSubmit' => 'Tambah Data'])

                {!! Form::close() !!}

            </div>

        </div>

    </section><!-- /.content -->

@stop

