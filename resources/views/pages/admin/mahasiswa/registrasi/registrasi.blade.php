@extends('template')

@section('main')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Registrasi Data Mahasiswa
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{ route('admin.registrasi') }}"><i class="fa fa-file-text-o"></i> Pendaftaran</a></li>
    <li class="active">Nilai Calon Mahasiswa</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
  	<div class="col-md-12">
      @include('_partials.flash_message')
  		{!! Form::model($daftar, ['method' => 'POST', 'route' => ['admin.registrasi.action', $id], 'files' => 'true']) !!}
        <!-- <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Data Mahasiswa</h3>
          </div>
        
          <div class="box-body">
            <div class="form-group">
              {!! Form::label('id_daftar', 'ID Daftar', ['class' => 'control-label']) !!}
              {!! Form::text('id_daftar', null, ['class' => 'form-control', 'autocomplete' => 'off', 'readonly']) !!}
            </div>
        
            <div class="form-group">
              {!! Form::label('nim', 'Nama', ['class' => 'control-label']) !!}
              {!! Form::text('nim', $nim, ['class' => 'form-control', 'autocomplete' => 'off', 'readonly']) !!}
            </div>
        
            <div class="form-group">
              {!! Form::label('nama', 'Nama', ['class' => 'control-label']) !!}
              {!! Form::text('nama', null, ['class' => 'form-control', 'autocomplete' => 'off', 'readonly']) !!}
            </div>
        
            <div class="form-group">
              <div class="col-md-6">
                {!! Form::label('tmp_lahir', 'Tempat Lahir', ['class' => 'control-label']) !!}
                {!! Form::text('tmp_lahir', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
              </div>
        
              <div class="col-md-6">
                {!! Form::label('tgl_lahir', 'Tanggal Lahir', ['class' => 'control-label']) !!}
                {!! Form::text('tgl_lahir', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
              </div>
            </div>
          </div>
        </div> -->
        <!-- Custom Tabs -->
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#biodata" data-toggle="tab">Biodata</a></li>
            <li><a href="#sekolah" data-toggle="tab">Asal Sekolah</a></li>
            <li><a href="#pekerjaan" data-toggle="tab">Pekerjaan</a></li>
            <li><a href="#ortu" data-toggle="tab">Orang Tua</a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="biodata">
              <div class="form-group">
                {!! Form::label('id_daftar', 'ID Daftar', ['class' => 'control-label']) !!}
                {!! Form::text('id_daftar', null, ['class' => 'form-control', 'autocomplete' => 'off', 'readonly']) !!}
              </div>
          
              <div class="form-group">
                {!! Form::label('nim', 'NIM', ['class' => 'control-label']) !!}
                {!! Form::text('nim', $nim, ['class' => 'form-control', 'autocomplete' => 'off', 'readonly']) !!}
              </div>
          
              <div class="form-group">
                {!! Form::label('nama', 'Nama', ['class' => 'control-label']) !!}
                {!! Form::text('nama', null, ['class' => 'form-control', 'autocomplete' => 'off', 'readonly']) !!}
              </div>

              <div class="form-group">
                {!! Form::label('no_ktp', 'Nomor KTP', ['class' => 'control-label']) !!}
                {!! Form::text('no_ktp', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
              </div>
          
              <div class="form-group row">
                <div class="col-md-6">
                  {!! Form::label('tmp_lahir', 'Tempat Lahir', ['class' => 'control-label']) !!}
                  {!! Form::text('tmp_lahir', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                </div>
          
                <div class="col-md-6">
                  {!! Form::label('tgl_lahir', 'Tanggal Lahir', ['class' => 'control-label']) !!}
                  {!! Form::text('tgl_lahir', null, ['class' => 'form-control datepicker', 'autocomplete' => 'off']) !!}
                </div>
              </div>

              <div class="form-group row">
                <div class="col-md-6">
                  {!! Form::label('id_prodi', 'Program Studi', ['class' => 'control-label']) !!}
                  {!! Form::text('id_prodi', $daftar->prodi->id_prodi.'-'.$daftar->prodi->nama_prodi, ['class' => 'form-control', 'autocomplete' => 'off', 'readonly']) !!}
                </div>
          
                <div class="col-md-6">
                  {!! Form::label('sumber_biaya', 'Sumber Biaya', ['class' => 'control-label']) !!}
                  {!! Form::select('sumber_biaya', ['Biaya Sendiri' => 'Biaya Sendiri', 'Biaya Orang Tua' => 'Biaya Orang Tua', 'Biaya Kantor' => 'Biaya Kantor', 'Beasiswa' => 'Beasiswa'], null, ['class' => 'form-control select-custom', 'autocomplete' => 'off']) !!}
                </div>
              </div>

              <div class="form-group row">
                <div class="col-md-6">
                  {!! Form::label('status', 'Status', ['class' => 'control-label']) !!}
                  {!! Form::select('status', ['Kawin' => 'Kawin', 'Belum Kawin' => 'Belum Kawin'], null, ['class' => 'form-control select-custom', 'autocomplete' => 'off']) !!}
                </div>
          
                <div class="col-md-6">
                  {!! Form::label('agama', 'Agama', ['class' => 'control-label']) !!}
                  {!! Form::select('agama', ['Islam' => 'Islam', 'Protestan' => 'Protestan', 'Katolik' => 'Katolik', 'Hindu' => 'Hindu', 'Buddha' => 'Buddha', 'Kong Hu Cu' => 'Kong Hu Cu'], null, ['class' => 'form-control select-custom', 'autocomplete' => 'off']) !!}
                </div>
              </div>

               <div class="form-group row">
                <div class="col-md-6">
                {!! Form::label('id_waktu_kuliah', 'Waktu Kuliah', ['class' => 'control-label']) !!}
                {!! Form::text('id_waktu_kuliah', $daftar->waktu_kuliah->id_waktu_kuliah.'-'.$daftar->waktu_kuliah->nama_waktu_kuliah, ['class' => 'form-control', 'autocomplete' => 'off', 'readonly']) !!}
                </div>
                <div class="col-md-6">
                  {!! Form::label('nip', 'Dosen Penasihat Akademik ', ['class' => 'control-label']) !!}
                  {!! Form::select('nip', $dosen, null, ['class' => 'form-control select-custom', 'autocomplete' => 'off', 'placeholder' => 'Pilih Dosen Penasihat Akademik', 'required']) !!}
                </div>
              </div>

              <div class="form-group row">
                <div class="col-md-6">
                  {!! Form::label('id_provinsi', 'Provinsi', ['class' => 'control-label']) !!}
                  {!! Form::select('id_provinsi', $provinsi, null, ['class' => 'form-control select-custom', 'autocomplete' => 'off']) !!}
                </div>
          
                <div class="col-md-6">
                  {!! Form::label('kota', 'Kota', ['class' => 'control-label']) !!}
                  {!! Form::text('kota', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                </div>
              </div>

              <div class="form-group row">
                <div class="col-md-6">
                  {!! Form::label('kelurahan', 'Kelurahan / Desa', ['class' => 'control-label']) !!}
                  {!! Form::text('kelurahan', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                </div>
          
                <div class="col-md-6">
                  {!! Form::label('kecamatan', 'Kecamatan', ['class' => 'control-label']) !!}
                  {!! Form::text('kecamatan', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                </div>
              </div>

              <div class="form-group">
                {!! Form::label('alamat', 'Alamat', ['class' => 'control-label']) !!}
                {!! Form::textarea('alamat', null, ['class' => 'form-control', 'rows' => '5']) !!}
              </div>

              <div class="form-group">
                {!! Form::label('no_telp', 'Nomor Telepon', ['class' => 'control-label']) !!}
                {!! Form::number('no_telp', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
              </div>

              <div class="form-group">
                {!! Form::label('foto_profil', 'Foto Profil', ['class' => 'control-label']) !!}
                {!! Form::file('foto_profil', ['accept' => 'image/*']) !!}
              </div>
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="sekolah">
              @if($daftar->status->nama_status == 'Pindahan')
                <div class="form-group">
                  {!! Form::label('pt_asal', 'Perguruan Tinggi Asal', ['class' => 'control-label']) !!}
                  {!! Form::text('pt_asal', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                </div>
              @endif

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

              <div class="form-group row">
                <div class="col-md-6">
                  {!! Form::label('kabupaten_sekolah', 'Kabupaten', ['class' => 'control-label']) !!}
                  {!! Form::text('kabupaten_sekolah', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
                </div>

                <div class="col-md-6">
                  {!! Form::label('id_provinsi', 'Provinsi', ['class' => 'control-label']) !!}
                  {!! Form::select('id_provinsi', $provinsi, null, ['class' => 'form-control select-custom', 'autocomplete' => 'off', 'style' => 'width:100%']) !!}
                </div>
              </div>

              <div class="form-group">
                {!! Form::label('alamat_sekolah', 'Alamat', ['class' => 'control-label']) !!}
                {!! Form::textarea('alamat_sekolah', null, ['class' => 'form-control', 'autocomplete' => 'off', 'rows' => '5']) !!}
              </div>
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="pekerjaan">
              <div class="form-group">
                {!! Form::label('perusahaan', 'Nama Perusahaan', ['class' => 'control-label']) !!}
                {!! Form::text('perusahaan', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
              </div>

              <div class="form-group">
                {!! Form::label('posisi', 'Posisi', ['class' => 'control-label']) !!}
                {!! Form::text('posisi', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
              </div>

              <div class="form-group">
                {!! Form::label('alamat_perusahaan', 'Alamat', ['class' => 'control-label']) !!}
                {!! Form::textarea('alamat_perusahaan', null, ['class' => 'form-control', 'autocomplete' => 'off', 'rows' => '5']) !!}
              </div>
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="ortu">
              <div class="form-group">
                {!! Form::label('nama_ibu', 'Nama Ibu', ['class' => 'control-label']) !!}
                {!! Form::text('nama_ibu', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
              </div>

              <div class="form-group">
                {!! Form::label('nama_ayah', 'Nama Ayah', ['class' => 'control-label']) !!}
                {!! Form::text('nama_ayah', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
              </div>

              <div class="form-group">
                {!! Form::label('alamat_ortu', 'Alamat', ['class' => 'control-label']) !!}
                {!! Form::textarea('alamat_ortu', null, ['class' => 'form-control', 'autocomplete' => 'off', 'rows' => '5']) !!}
              </div>

              <div class="form-group">
                {!! Form::label('no_telp_ortu', 'Nomor Telepon Orang Tua', ['class' => 'control-label']) !!}
                {!! Form::number('no_telp_ortu', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
              </div>
            </div>
            <!-- /.tab-pane -->
            <div class="form-group">
              <a href="{{ route('admin.registrasi') }}" class="btn btn-default btn-sm">Kembali</a>
              {!! Form::submit('Registrasi', ['class' => 'btn btn-primary btn-sm']) !!}
            </div>
          </div>
          <!-- /.tab-content -->
        </div>
        <!-- nav-tabs-custom -->
      {!! Form::close() !!}
  	</div>
  </div>
</section>
<!-- /.content -->
@stop