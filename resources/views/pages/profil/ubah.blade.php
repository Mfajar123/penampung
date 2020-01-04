@extends('template')





@section('main')


<style type="text/css">


  .title-profil


  {


    font-size: 18pt;


    font-weight: 600;


    color: #333333ab;


    margin: 0;


    margin-bottom: 10px;


    text-align: center;


  }


</style>





<section class="content-header">


    <h1>Ubah Profil</h1>


    <ol class="breadcrumb">


      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>


      <li><a href="#"><i class="fa fa-user"></i> Profil</a></li>


      <li class="active">Ubah Profil</li>


    </ol>


</section><!-- /.content-header -->





<section class="content">


  <div class="row">


    @include('_partials.flash_message')


    <div class="col-md-12 col-xs-12">

	@if (Session::has('flash_lengkapi'))
      <div class="alert alert-info">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{ Session::get('flash_lengkapi') }}
      </div>
    @endif


      {!! Form::model($profil, ['method' => 'POST', 'route' => $route]) !!}


        @if(Request::segment(1) == 'mahasiswa')


        <div class="box box-primary">


          <div class="box-header with-border">


            <h3 class="box-title">


              Ubah Profil


            </h3>


          </div>





          <div class="box-body">


            <div class="form-group">


              {!! Form::label('nim', 'NIM', ['class' => 'control-label']) !!}


              {!! Form::text('nim', null, ['class' => 'form-control', 'autocomplete' => 'off', 'required', 'disabled']) !!}


            </div>





            <div class="form-group">


              {!! Form::label('nama', 'Nama Lengkap *', ['class' => 'control-label']) !!}


              {!! Form::text('nama', null, ['class' => 'form-control', 'autocomplete' => 'off', 'required']) !!}


            </div>





            <div class="form-group">


              {!! Form::label('email', 'Email', ['class' => 'control-label']) !!}


              {!! Form::email('email', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}


            </div>





            <div class="form-group row">


              <div class="col-md-6">


                {!! Form::label('tmp_lahir', 'Tempat Lahir', ['class' => 'control-label']) !!}


                {!! Form::text('tmp_lahir', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}


              </div>





              <div class="col-md-6">


                {!! Form::label('tgl_lahir', 'Tanggal Lahir', ['class' => 'control-label']) !!}


                {!! Form::text('tgl_lahir', null, ['class' => 'form-control date', 'autocomplete' => 'off']) !!}


              </div>


            </div>





            <div class="form-group row">


              <div class="col-md-6">


                {!! Form::label('agama', 'Agama', ['class' => 'control-label']) !!}


                {!! Form::select('agama', ['Islam' => 'Islam', 'Protestan' => 'Protestan', 'Katolik' => 'Katolik', 'Hindu' => 'Hindu', 'Buddha' => 'Buddha', 'Kong Hu Cu' => 'Kong Hu Cu'], null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}


              </div>





              <div class="col-md-6">


                {!! Form::label('jenkel', 'Jenis Kelamin', ['class' => 'control-label']) !!}


                {!! Form::select('jenkel', ['Laki - Laki' => 'Laki - Laki', 'Perempuan' => 'Perempuan'], null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}


              </div>


            </div>





            <div class="form-group row">


              <div class="col-md-6">


                {!! Form::label('warga_negara', 'Warga Negara', ['class' => 'control-label']) !!}


                {!! Form::select('warga_negara', ['WNI' => 'WNI', 'WNA' => 'WNA'], null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}


              </div>





              <div class="col-md-6">


                {!! Form::label('status', 'Status', ['class' => 'control-label']) !!}


                {!! Form::select('status', ['Kawin' => 'Kawin', 'Belum Kawin' => 'Belum Kawin'], null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}


              </div>


            </div>





            <div class="form-group row">


              <div class="col-md-6">


                {!! Form::label('id_prov', 'Provinsi', ['class' => 'control-label']) !!}


                {!! Form::select('id_prov', $provinsi, null, ['class' => 'form-control select-custom', 'autocomplete' => 'off']) !!}


              </div>





              <div class="col-md-6">


                {!! Form::label('kota', 'Kota', ['class' => 'control-label']) !!}


                {!! Form::text('kota', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}


              </div>


            </div>





            <div class="form-group">


              {!! Form::label('alamat', 'Alamat', ['class' => 'control-label']) !!}


              {!! Form::textarea('alamat', null, ['class' => 'form-control', 'autocomplete' => 'off', 'rows' => '5']) !!}


            </div>





            <div class="form-group">


              {!! Form::label('no_telp', 'Nomor Telepon', ['class' => 'control-label']) !!}


              {!! Form::number('no_telp', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}


            </div>


          </div>


        </div>





        <div class="box box-primary">


          <div class="box-header with-border">


            <h3 class="box-title">


              Data Orang Tua


            </h3>


          </div>





          <div class="box-body">


            <div class="form-group">


              {!! Form::label('nama_ibu', 'Nama Ibu', ['class' => 'control-label']) !!}


              {!! Form::text('nama_ibu', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}


            </div>





            <div class="form-group">


              {!! Form::label('nama_ayah', 'Nama Ayah', ['class' => 'control-label']) !!}


              {!! Form::text('nama_ayah', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}


            </div>





            <div class="form-group">


              {!! Form::label('alamat_ortu', 'Alamat Orang Tua', ['class' => 'control-label']) !!}


              {!! Form::textarea('alamat_ortu', null, ['class' => 'form-control', 'autocomplete' => 'off', 'rows' => '5']) !!}


            </div>





            <div class="form-group">


              {!! Form::label('no_telp_ortu', 'Nomor Telepon Orang Tua', ['class' => 'control-label']) !!}


              {!! Form::number('no_telp_ortu', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}


            </div>


          </div>


        </div>





        <div class="box box-primary">


          <div class="box-header with-border">


            <h3 class="box-title">


              Data Pekerjaan


            </h3>


          </div>





          <div class="box-body">


            <div class="form-group">


              {!! Form::label('perusahaan', 'Nama Perusahaan', ['class' => 'control-label']) !!}


              {!! Form::text('perusahaan', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}


            </div>





            <div class="form-group">


              {!! Form::label('posisi', 'Posisi', ['class' => 'control-label']) !!}


              {!! Form::text('posisi', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}


            </div>





            <div class="form-group">


              {!! Form::label('alamat_perusahaan', 'Alamat Perusahaan', ['class' => 'control-label']) !!}


              {!! Form::textarea('alamat_perusahaan', null, ['class' => 'form-control', 'autocomplete' => 'off', 'rows' => '5']) !!}


            </div>


          </div>


        </div>





        <div class="box box-primary">


          <div class="box-header with-border">


            <h3 class="box-title">


              Data Sekolah


            </h3>


          </div>





          <div class="box-body">


            <div class="form-group">


              {!! Form::label('asal_sekolah', 'Asal Sekolah', ['class' => 'control-label']) !!}


              {!! Form::text('asal_sekolah', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}


            </div>





            <div class="form-group">


              {!! Form::label('no_ijazah', 'Nomor Ijazah', ['class' => 'control-label']) !!}


              {!! Form::text('no_ijazah', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}


            </div>





            <div class="form-group">


              {!! Form::label('jurusan', 'Jurusan', ['class' => 'control-label']) !!}


              {!! Form::text('jurusan', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}


            </div>





            <div class="form-group">


              {!! Form::label('alamat_sekolah', 'Alamat Sekolah', ['class' => 'control-label']) !!}


              {!! Form::textarea('alamat_sekolah', null, ['class' => 'form-control', 'autocomplete' => 'off', 'rows' => '5']) !!}


            </div>





            <div class="form-group">


              <a href="{{ route('mahasiswa.profil') }}" class="btn btn-sm btn-default">Kembali</a>


              {!! Form::submit('Simpan Data', ['class' => 'btn btn-sm btn-primary']) !!}


            </div>


          </div>


        </div>


        @elseif(Request::segment(1) == 'dosen')


        <div class="box box-primary">


          <div class="box-header with-border">


            <h3 class="box-title">


              Ubah Profil


            </h3>


          </div>





          <div class="box-body">


            <div class="form-group">


              {!! Form::label('nip', 'NIP', ['class' => 'control-label']) !!}


              {!! Form::text('nip', null, ['class' => 'form-control', 'autocomplete' => 'off', 'disabled']) !!}


            </div>





            <div class="form-group">


              {!! Form::label('nama', 'Nama Lengkap *', ['class' => 'control-label']) !!}


              {!! Form::text('nama', null, ['class' => 'form-control', 'autocomplete' => 'off', 'required']) !!}


            </div>





            <div class="form-group">


              {!! Form::label('email', 'E - mail', ['class' => 'control-label']) !!}


              {!! Form::email('email', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}


            </div>





            <div class="form-group">


              {!! Form::label('status_dosen', 'Status Dosen', ['class' => 'control-label']) !!}


              {!! Form::select('status_dosen', ['1' => 'Dosen Tetap', '2' => 'Dosen Luar'], null, ['class' => 'form-control select-custom', 'autocomplete' => 'off']) !!}


            </div>





            <div class="form-group row">


              <div class="col-md-6">


                {!! Form::label('tempat_lahir', 'Tempat Lahir', ['class' => 'control-label']) !!}


                {!! Form::text('tempat_lahir', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}


              </div>





              <div class="col-md-6">


                {!! Form::label('tgl_lahir', 'Tanggal Lahir', ['class' => 'control-label']) !!}


                {!! Form::text('tgl_lahir', null, ['class' => 'form-control date', 'autocomplete' => 'off']) !!}


              </div>


            </div>





            <div class="form-group row">


              <div class="col-md-4">


                {!! Form::label('jenis_kelamin', 'Warga Negara', ['class' => 'control-label']) !!}


                {!! Form::select('jenis_kelamin', ['Laki - Laki' => 'Laki - Laki', 'Perempuan' => 'Perempuan'], null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}


              </div>





              <div class="col-md-4">


                {!! Form::label('warga_negara', 'Warga Negara', ['class' => 'control-label']) !!}


                {!! Form::select('warga_negara', ['WNI' => 'WNI', 'WNA' => 'WNA'], null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}


              </div>





              <div class="col-md-4">


                {!! Form::label('status_pernikahan', 'Status Pernikahan', ['class' => 'control-label']) !!}


                {!! Form::select('status_pernikahan', ['Menikah' => 'Menikah', 'Belum Menikah' => 'Belum Menikah'], null, ['class' => 'form-control']) !!}


              </div>


            </div>





            <div class="form-group">


              {!! Form::label('agama', 'Agama', ['class' => 'control-label']) !!}


              {!! Form::select('agama', ['Islam' => 'Islam', 'Protestan' => 'Protestan', 'Katolik' => 'Katolik', 'Hindu' => 'Hindu', 'Buddha' => 'Buddha', 'Kong Hu Cu' => 'Kong Hu Cu'], null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}


            </div>





            <div class="form-group">


              {!! Form::label('alamat', 'Alamat', ['class' => 'control-label']) !!}


              {!! Form::textarea('alamat', null, ['class' => 'form-control', 'autocomplete' => 'off', 'rows' => '5']) !!}


            </div>





            <div class="form-group">


              {!! Form::label('no_telp', 'Nomor Telepon', ['class' => 'control-label']) !!}


              {!! Form::number('no_telp', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}


            </div>





            <div class="form-group">


              {!! Form::label('no_hp', 'Nomor Handphone', ['class' => 'control-label']) !!}


              {!! Form::number('no_hp', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}


            </div>


          </div>


        </div>





        <div class="box box-primary">


          <div class="box-header with-border">


            <h3 class="box-title">


              Data Jabatan


            </h3>


          </div>





          <div class="box-body">


            <div class="form-group">


              {!! Form::label('nidn', 'NIDN', ['class' => 'control-label']) !!}


              {!! Form::text('nidn', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}


            </div>





            <div class="form-group row">


              <div class="col-md-6">


                {!! Form::label('id_dosen_jabatan', 'Jabatan', ['class' => 'control-label']) !!}


                {!! Form::select('id_dosen_jabatan', $jabatan, null, ['class' => 'form-control select-custom', 'autocomplete' => 'off']) !!}


              </div>





              <div class="col-md-6">


                {!! Form::label('id_prodi', 'Program Studi', ['class' => 'control-label']) !!}


                {!! Form::select('id_prodi', $prodi, null, ['class' => 'form-control select-custom', 'autocomplete' => 'off']) !!}


              </div>


            </div>





            <div class="form-group">


              {!! Form::label('no_skyys', 'Nomor SKYYS', ['class' => 'control-label']) !!}


              {!! Form::text('no_skyys', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}


            </div>





            <div class="form-group">


              {!! Form::label('tgl_skyys', 'Tanggal SKYYS', ['class' => 'control-label']) !!}


              {!! Form::text('tgl_skyys', null, ['class' => 'form-control date', 'autocomplete' => 'off']) !!}


            </div>


          </div>


        </div>





        <div class="box box-primary">


          <div class="box-header with-border">


            <h3 class="box-title">


              Data Pendidikan


            </h3>


          </div>





          <div class="box-body">


            <div class="form-group">


              {!! Form::label('jenjang', 'Jenjang', ['class' => 'control-label']) !!}


              {!! Form::text('jenjang', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}


            </div>





            <div class="form-group">


              {!! Form::label('nama_sekolah', 'Nama Sekolah', ['class' => 'control-label']) !!}


              {!! Form::text('nama_sekolah', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}


            </div>





            <div class="form-group">


              {!! Form::label('jurusan', 'Jurusan', ['class' => 'control-label']) !!}


              {!! Form::text('jurusan', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}


            </div>





            <div class="form-group">


              {!! Form::label('gelar', 'Gelar', ['class' => 'control-label']) !!}


              {!! Form::text('gelar', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}


            </div>





            <div class="form-group">


              {!! Form::label('konsentrasi', 'Konsentrasi', ['class' => 'control-label']) !!}


              {!! Form::text('konsentrasi', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}


            </div>





            <div class="form-group">


              <a href="{{ route('dosen.profil') }}" class="btn btn-sm btn-default">Kembali</a>


              {!! Form::submit('Simpan Data', ['class' => 'btn btn-sm btn-primary']) !!}


            </div>


          </div>


        </div>


        @else


            


        @endif


      {!! Form::close() !!}


  </div>


</section><!-- /.content -->


@stop