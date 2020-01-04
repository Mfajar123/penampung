<div class="form-group">
	{!! Form::label('semester', 'Semester', ['class' => 'control-label']) !!}
	{!! Form::select('semester', $list_semester, null, ['class' => 'form-control select-custom']) !!}
</div>

<div class="form-group">
	{!! Form::label('jenis_ujian', 'Jenis Ujian', ['class' => 'control-label']) !!}
	{!! Form::select('jenis_ujian', $list_jenis_ujian, null, ['class' => 'form-control select-custom']) !!}
</div>

<div class="form-group">
	{!! Form::label('bulan', 'Bulan', ['class' => 'control-label']) !!}
	{!! Form::select('bulan', $list_bulan, null, ['class' => 'form-control select-custom']) !!}
</div>

{!! Form::submit($btn_submit_text, ['class' => 'btn btn-primary']) !!}
<a href="{{ route('admin.batas_pembayaran.ujian') }}" class="btn btn-default">Batal</a>