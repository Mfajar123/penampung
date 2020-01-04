<div class="form-group">
    {!! Form::label('nama_jurusan', 'Nama Jurusan', ['class' => 'control-label']) !!}
    {!! Form::text('nama_jurusan', null, ['class' => 'form-control', 'placeholder' => 'Nama Jurusan', 'autocomplete' => 'off', 'required']) !!}
</div>

<div class="form-group">
	{!! Form::label('id_fakultas', 'Fakultas', ['class' => 'control-label']) !!}
    {!! Form::select('id_fakultas', $listFakultas, null, ['class' => 'form-control', 'placeholder' => '-- Pilih Fakultas --']) !!}
</div>

<div class="form-group">
    <a href="{{ route('admin.jurusan') }}" class="btn btn-default btn-sm"> Kembali</a>
    {!! Form::submit($btnSubmit, ['class' => 'btn btn-primary btn-sm']) !!}
</div>
