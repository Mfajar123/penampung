<div class="form-group">
    {!! Form::label('perusahaan', 'Nama Perusahaan', ['class' => 'control-label']) !!}
    {!! Form::text('perusahaan', null, ['class' => 'form-control', 'placeholder' => 'Nama Perusahaan', 'autocomplete' => 'off']) !!}
</div>

<div class="form-group">
    {!! Form::label('posisi', 'Posisi', ['class' => 'control-label']) !!}
    {!! Form::text('posisi', null, ['class' => 'form-control', 'placeholder' => 'Posisi', 'autocomplete' => 'off']) !!}
</div>

<div class="form-group">
    {!! Form::label('alamat_perusahaan', 'Alamat Perusahaan', ['class' => 'control-label']) !!}
    {!! Form::textarea('alamat_perusahaan', null, ['class' => 'form-control', 'placeholder' => 'Alamat Perusahaan', 'rows' => '3', 'autocomplete' => 'off']) !!}
</div>