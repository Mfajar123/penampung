@extends('template')



@section('main')

<!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        Hak Akses Karyawan

      </h1>

      <ol class="breadcrumb">

        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

        <li><a href="{{ route('admin.karyawan') }}"><i class="fa fa-user"></i> Karyawan</a></li>

        <li class="active">Hak Akses Karyawan</li>

      </ol>

    </section>



    <section class="content">

        @include('_partials.flash_message')

        <div class="box">

            <div class="box-header with-border">

                <h3 class="box-title">Form Akses</h3>

            </div>

            <div class="box-body">

                {!! Form::model($karyawan, ['method' => 'POST', 'route' => ['smk.admin.karyawan.akses.perbarui', $id]]) !!}

                    <ol>

                      <li>

                        <div class="checkbox">

                          <label>

                            <input type="checkbox" name="m_mahasiswa" value="Y" {{ ($karyawan->m_mahasiswa == 'Y') ? 'checked' : '' }}>

                            Mahasiswa

                          </label>

                        </div>

                      </li>



                      <li>

                        <div class="checkbox">

                          <label>

                            <input type="checkbox" name="m_dosen" value="Y" {{ ($karyawan->m_dosen == 'Y') ? 'checked' : '' }}>

                            Dosen

                          </label>

                        </div>

                      </li>



                      <li>

                        <div class="checkbox">

                          <label>

                            <input type="checkbox" name="m_karyawan" value="Y" {{ ($karyawan->m_karyawan == 'Y') ? 'checked' : '' }}>

                            Karyawan

                          </label>

                        </div>

                      </li>



                      <li>

                        <div class="checkbox">

                          <label>

                            <input type="checkbox" name="m_matkul" value="Y" {{ ($karyawan->m_matkul == 'Y') ? 'checked' : '' }}>

                            Mata Kuliah

                          </label>

                        </div>

                      </li>

                    </ol>



                    <div class="col-md-12">

                        <a href="{{ route('admin.karyawan') }}" class="btn btn-default btn-sm"> Kembali</a>

                        {!! Form::submit('Simpan Data', ['class' => 'btn btn-primary btn-sm']) !!}

                    </div>

                {!! Form::close() !!}

            </div>

        </div>

    </section><!-- /.content -->

@stop