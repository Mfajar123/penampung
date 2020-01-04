<div class="form-group">
    {!! Form::label('nama_ibu', 'Nama Ibu', ['class' => 'control-label']) !!}
    {!! Form::text('nama_ibu', null, ['class' => 'form-control', 'placeholder' => 'Nama Ibu', 'autocomplete' => 'off']) !!}
</div>

<div class="form-group">
    {!! Form::label('nama_ayah', 'Nama Ayah', ['class' => 'control-label']) !!}
    {!! Form::text('nama_ayah', null, ['class' => 'form-control', 'placeholder' => 'Nama Ayah', 'autocomplete' => 'off']) !!}
</div>

<div class="form-group">
    {!! Form::label('alamat_ortu', 'Alamat Orang Tua', ['class' => 'control-label']) !!}
    {!! Form::textarea('alamat_ortu', null, ['class' => 'form-control', 'placeholder' => 'Alamat Orang Tua', 'rows' => '3', 'autocomplete' => 'off']) !!}
</div>

<div class="form-group">
    {!! Form::label('no_telp_ortu', 'Nomor Telepon Orang Tua', ['class' => 'control-label']) !!}
    {!! Form::number('no_telp_ortu', null, ['class' => 'form-control', 'placeholder' => 'Nomor Telepon Orang Tua', 'autocomplete' => 'off']) !!}
</div>