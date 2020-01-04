<div class="nav-tabs-custom">
    <ul class="nav nav-tabs pull-right">
      <li><a href="#tab_1-1" data-toggle="tab">Pendidikan</a></li>
      <li class="active"><a href="#tab_2-2" data-toggle="tab">Profil</a></li>
      <li class="pull-left header">Form Dosen</li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane" id="tab_1-1">

                <div class="form-group">
                    {!! Form::label('jenjang', 'Jenjang', ['class' => 'control-label']) !!} <span>*</span>
                    {!! Form::select('jenjang', ['SD' => 'SD', 'SMP' => 'SMP', 'SMA' => 'SMA', 'S1' => 'S1', 'S2' => 'S2', 'S3' => 'S3'], null, ['placeholder' => 'Pilih Jenjang', 'class'=>'form-control', 'required']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('nama_sekolah', 'Universitas', ['class' => 'control-label']) !!} <span>*</span>
                    {!! Form::text('nama_sekolah', null, ['class' => 'form-control', 'placeholder' => 'Universitas', 'autocomplete' => 'off', 'required']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('jurusan', 'Jurusan', ['class' => 'control-label']) !!} <span>*</span>
                    {!! Form::text('jurusan', null, ['class' => 'form-control', 'placeholder' => 'Jurusan', 'autocomplete' => 'off', 'required']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('gelar', 'Gelar', ['class' => 'control-label']) !!}
                    {!! Form::text('gelar', null, ['class' => 'form-control', 'placeholder' => 'Gelar', 'autocomplete' => 'off']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('konsentrasi', 'Konsentrasi', ['class' => 'control-label']) !!}
                    {!! Form::text('konsentrasi', null, ['class' => 'form-control', 'placeholder' => 'Konsentrasi', 'autocomplete' => 'off']) !!}
                </div>
                <div class="form-group">
                    <a href="{{ route('admin.dosen') }}" class="btn btn-default btn-sm"> Kembali</a>
                    {!! Form::submit($btnSubmit, ['class' => 'btn btn-primary btn-sm']) !!}
                </div>
      </div>
      <!-- /.tab-pane -->
      <div class="tab-pane active" id="tab_2-2">

                             
                <div class="form-group">
                    {!! Form::label('nidn', 'NIDN', ['class' => 'control-label']) !!} <span>*</span>
                    {!! Form::text('nidn', null, ['class' => 'form-control', 'placeholder' => 'NIDN', 'autocomplete' => 'off', 'required']) !!}
                </div>
                

                <div class="form-group">
                    {!! Form::label('gelar_depan', 'Gelar Depan', ['class' => 'control-label']) !!} 
                    {!! Form::text('gelar_depan', null, ['class' => 'form-control', 'placeholder' => 'Gelar Depan', 'autocomplete' => 'off', '']) !!}
                </div>
                
                <div class="form-group">
                    {!! Form::label('nama', 'Nama', ['class' => 'control-label']) !!} <span>*</span>
                    {!! Form::text('nama', null, ['class' => 'form-control', 'placeholder' => 'Nama', 'autocomplete' => 'off', 'required']) !!}
                </div>
                
                <div class="form-group">
                    {!! Form::label('gelar_belakang', 'Gelar Belakang', ['class' => 'control-label']) !!} 
                    {!! Form::text('gelar_belakang', null, ['class' => 'form-control', 'placeholder' => 'Gelar Belakang', 'autocomplete' => 'off', '']) !!}
                </div>

                 

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('tempat_lahir', 'Tempat Lahir', ['class' => 'control-label']) !!} <span>*</span>
                    {!! Form::text('tempat_lahir', null, ['class' => 'form-control', 'placeholder' => 'Tempat Lahir', 'autocomplete' => 'off', 'required']) !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('tgl_lahir', 'Tanggal Lahir', ['class' => 'control-label']) !!} <span>*</span>
                    {!! Form::text('tgl_lahir', @$tgl_lahir, ['class' => 'form-control datepicker',  'autocomplete' => 'off']) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('id_prodi', 'Prodi', ['class' => 'control-label']) !!}<span>*</span>
                    @if(count($prodi) > 0)
                        {!! Form::select('id_prodi', $prodi, null, ['class'=>'form-control selectpicker','id'=>'id_kategori_buku', 'placeholder'=>'Pilih Prodi', 'data-show-subtext' => 'true', 'data-live-search' => 'true', 'required']) !!}
                    @else
                        <p>Tidak Ada kategori</p>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('status_dosen', 'Status Dosen', ['class' => 'control-label']) !!} <span>*</span>
                    {!! Form::select('status_dosen', ['1' => 'Dosen Tetap', '2' => 'Dosen Luar'], null, ['placeholder' => 'Pilih Status Dosen', 'class'=>'form-control', 'required']) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('warga_negara', 'Kewarganegaraan', ['class' => 'control-label']) !!} <span>*</span>
                    {!! Form::select('warga_negara', ['WNI' => 'WNI', 'WNA' => 'WNA'], null, ['placeholder' => 'Pilih Kewarganegaraan', 'class'=>'form-control', 'required']) !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('jenis_kelamin', 'Jenis Kelamin', ['class' => 'control-label']) !!} <span>*</span>
                    {!! Form::select('jenis_kelamin', ['Laki - Laki' => 'Laki - Laki', 'Perempuan' => 'Perempuan'], null, ['placeholder' => 'Pilih Jenis Kelamin', 'class'=>'form-control', 'required']) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('status_pernikahan', 'Status Pernikahan', ['class' => 'control-label']) !!} <span>*</span>
                    {!! Form::select('status_pernikahan', ['Menikah' => 'Menikah', 'Belum Menikah' => 'Belum Menikah'], null, ['placeholder' => 'Pilih Status Pernikahan', 'class'=>'form-control', 'required']) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('agama', 'Agama', ['class' => 'control-label']) !!} <span>*</span>
                    {!! Form::select('agama', ['Islam' => 'Islam', 'Katolik' => 'Katolik', 'Buddha' => 'Buddha', 'Kong Hu Cu' => 'Kong Hu Cu', 'Hindu' => 'Hindu', 'Protestan' => 'Protestan', 'Lainnya' => 'Lainnya'], null, ['placeholder' => 'Pilih Agama', 'class'=>'form-control', 'required']) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('id_dosen_jabatan', 'Jabatan', ['class' => 'control-label']) !!}<span>*</span>
                    @if(count($jabatan) > 0)
                        {!! Form::select('id_dosen_jabatan', $jabatan, null, ['class'=>'form-control selectpicker','id'=>'id_kategori_buku', 'placeholder'=>'Pilih Jabatan', 'data-show-subtext' => 'true', 'data-live-search' => 'true', 'required']) !!}
                    @else
                        <p>Tidak Ada kategori</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('no_skyys', 'no skyys', ['class' => 'control-label']) !!}
                    {!! Form::text('no_skyys', null, ['class' => 'form-control', 'placeholder' => 'no skyys', 'autocomplete' => 'off']) !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {!! Form::label('tgl_skyys', 'tgl skyys', ['class' => 'control-label']) !!}
                    {!! Form::text('tgl_lahir', @$tgl_skyys, ['class' => 'form-control datepicker',  'autocomplete' => 'off', '']) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('no_telp', 'no.telp', ['class' => 'control-label']) !!}
                    {!! Form::text('no_telp', null, ['class' => 'form-control', 'placeholder' => 'no.telp', 'autocomplete' => 'off']) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('no_hp', 'no.hp', ['class' => 'control-label']) !!} <span>*</span>
                    {!! Form::text('no_hp', null, ['class' => 'form-control', 'placeholder' => 'no.hp', 'autocomplete' => 'off', 'required']) !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
                    {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Email', 'autocomplete' => 'off']) !!}
                </div>
            </div>
        </div>
                <div class="form-group">
                    {!! Form::label('alamat', 'Alamat', ['class' => 'control-label']) !!} <span>*</span>
                    {!! Form::textarea('alamat', null, ['class' => 'form-control', 'placeholder' => 'Alamat', 'autocomplete' => 'off', 'rows' => 3, 'required']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('foto_profil', 'Foto', ['class' => 'control-label']) !!}
                    {!! Form::file('foto_profil') !!}
                </div>

      </div>
      <!-- /.tab-pane -->
    </div>
    <!-- /.tab-content -->
  </div>
  <!-- nav-tabs-custom -->
