<div class="form-group">
    {!! Form::label('username', 'Username', ['class' => 'control-label']) !!} <span>*</span>
    {!! Form::text('username', null, ['class' => 'form-control', 'placeholder' => 'Username', 'autocomplete' => 'off', 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('nama', 'Nama Lengkap', ['class' => 'control-label']) !!} <span>*</span>
    {!! Form::text('nama', null, ['class' => 'form-control', 'placeholder' => 'Nama Lengkap', 'autocomplete' => 'off', 'required']) !!}
</div>

<div class="form-group row">
  <div class="col-md-6">
    {!! Form::label('tmp_lahir', 'Tempat Lahir', ['class' => 'control-label']) !!}
    {!! Form::text('tmp_lahir', null, ['class' => 'form-control', 'placeholder' => 'Tempat Lahir', 'autocomplete' => 'off']) !!}
  </div>

  <div class="col-md-6">
    {!! Form::label('tgl_lahir', 'Tanggal Lahir', ['class' => 'control-label']) !!}
    {!! Form::text('tgl_lahir', null, ['class' => 'form-control date', 'placeholder' => 'Tanggal Lahir', 'autocomplete' => 'off']) !!}
  </div>
</div>

<div class="form-group">
    {!! Form::label('jenkel', 'Jenis Kelamin', ['class' => 'control-label']) !!}
    {!! Form::select('jenkel', ['Pria' => 'Pria', 'Wanita' => 'Wanita'], null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('agama', 'Agama', ['class' => 'control-label']) !!}
    {!! Form::select('agama', ['Islam' => 'Islam', 'Buddha' => 'Buddha', 'Protestan' => 'Protestan', 'Katolik' => 'Katolik', 'Hindu' => 'Hindu', 'Kong Hu Cu' => 'Kong Hu Cu'], null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('alamat', 'Alamat', ['class' => 'control-label']) !!}
    {!! Form::textarea('alamat', null, ['class' => 'form-control', 'placeholder' => 'Alamat', 'rows' => '2']) !!}
</div>

<div class="form-group">
  {!! Form::label('no_telp', 'Nomor Telepon', ['class' => 'control-label']) !!}
  {!! Form::number('no_telp', null, ['class' => 'form-control', 'placeholder' => 'Nomor Telepon']) !!}
</div>

<div class="form-group">
  {!! Form::label('foto_profil', 'Foto', ['class' => 'control-label']) !!}
  {!! Form::file('foto_profil', ['class' => 'form-control', 'accept' => 'image/*']) !!}
</div>

<div class="form-group">
    <a href="{{ route('smk.admin.karyawan') }}" class="btn btn-default btn-sm"> Kembali</a>
    {!! Form::submit($btnSubmit, ['class' => 'btn btn-primary btn-sm']) !!}
</div>
