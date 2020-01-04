<div class="form-group">
	{!! Form::label('id_prodi', 'Program Studi', ['class' => 'control-label']) !!}
	{!! Form::select('id_prodi', $list_prodi, null, ['class' => 'form-control select-custom', 'required']) !!}
</div>

<div class="form-group">
	{!! Form::label('nama_materi', 'Nama Materi', ['class' => 'control-label']) !!}
	{!! Form::text('nama_materi', null, ['class' => 'form-control', 'required']) !!}
</div>

<div class="form-group">
	{!! Form::label('file', 'File', ['class' => 'control-label']) !!}
	{!! Form::file('file') !!}
	<span>Max size upload: 60mb</span>
</div>

<div>
	{!! Form::submit($btn_submit_text, ['class' => 'btn btn-primary']) !!}
	<a href="{{ route('dosen.shared_material') }}" class="btn btn-default">Batal</a>
</div>