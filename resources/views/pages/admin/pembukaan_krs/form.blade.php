<div class="form-group">
	{!! Form::label('id_prodi', 'Program Studi', ['class' => 'control-label']) !!}
	{!! Form::select('id_prodi', $list_prodi, null, ['placeholder' => '- Pilih Program Studi -', 'class' => 'form-control', 'required']) !!}
</div>

<div class="form-group">
	{!! Form::label('tanggal_mulai', 'Tanggal Mulai', ['class' => 'control-label']) !!}
	{!! Form::text('tanggal_mulai', @$tanggal_mulai, ['class' => 'form-control datepicker', 'required']) !!}
</div>

<div class="form-group">
	{!! Form::label('tanggal_selesai', 'Tanggal Selesai', ['class' => 'control-label']) !!}
	{!! Form::text('tanggal_selesai', @$tanggal_selesai, ['class' => 'form-control datepicker', 'required']) !!}
</div>

<div>
	{!! Form::submit($btn_submit_text, ['class' => 'btn btn-primary']) !!}
	<a href="{{ route('admin.setting.pembukaan_krs.index') }}" class="btn btn-default">Batal</a>
</div>