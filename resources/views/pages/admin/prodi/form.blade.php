<div class="form-group">
    {!! Form::label('id_prodi', 'ID Prodi', ['class' => 'control-label']) !!} <span>*</span>
    {!! Form::number('id_prodi', null, ['class' => 'form-control', 'placeholder' => 'ID Prodi', 'autocomplete' => 'off', 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('kode_prodi', 'Kode Prodi', ['class' => 'control-label']) !!} <span>*</span>
    {!! Form::text('kode_prodi', null, ['class' => 'form-control', 'placeholder' => 'Kode Prodi', 'autocomplete' => 'off', 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('nama_prodi', 'Nama Prodi', ['class' => 'control-label']) !!} <span>*</span>
    {!! Form::text('nama_prodi', null, ['class' => 'form-control', 'placeholder' => 'Nama Prodi', 'autocomplete' => 'off', 'required']) !!}
</div>

<div class="form-group">
    <a href="{{ route('admin.prodi') }}" class="btn btn-default btn-sm"> Kembali</a>
    {!! Form::submit($btnSubmit, ['class' => 'btn btn-primary btn-sm']) !!}
</div>
