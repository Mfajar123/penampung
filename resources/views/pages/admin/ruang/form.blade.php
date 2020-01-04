<div class="form-group">
    {!! Form::label('kode_ruang', 'Kode Ruang', ['class' => 'control-label']) !!} <span>*</span>
    {!! Form::text('kode_ruang', null, ['class' => 'form-control', 'placeholder' => 'Kode Ruang', 'autocomplete' => 'off', 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('nama_ruang', 'Nama Ruang', ['class' => 'control-label']) !!} <span>*</span>
    {!! Form::text('nama_ruang', null, ['class' => 'form-control', 'placeholder' => 'Nama Ruang', 'autocomplete' => 'off', 'required']) !!}
</div>

<div class="form-group">
    <a href="{{ route('admin.ruang') }}" class="btn btn-default btn-sm"> Kembali</a>
    {!! Form::submit($btnSubmit, ['class' => 'btn btn-primary btn-sm']) !!}
</div>
