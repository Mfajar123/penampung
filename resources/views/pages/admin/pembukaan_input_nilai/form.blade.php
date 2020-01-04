<div class="form-group">
	{!! Form::label('tanggal_mulai', 'Tanggal Mulai', ['class' => 'control-label']) !!}
	{!! Form::date('tanggal_mulai', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
	{!! Form::label('tanggal_selesai', 'Tanggal Selesai', ['class' => 'control-label']) !!}
	{!! Form::date('tanggal_selesai', null, ['class' => 'form-control']) !!}
</div>

<div>
	{!! Form::submit($btn_submit_text, ['class' => 'btn btn-primary']) !!}
	<a href="{{ route('admin.setting.pembukaan_input_nilai.index') }}" class="btn btn-default">Batal</a>
</div>