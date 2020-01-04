
<div class="form-group">
	{!! Form::label('jenis_ujian', 'Jenis Ujian', ['class' => 'control-label']) !!}
	{!! Form::select('jenis_ujian', ['uts' => 'UTS', 'uas' => 'UAS', 'remedial' => 'Remedial'], null, ['placeholder' => '- Pilih Jenis Ujian -', 'class' => 'form-control', 'required']) !!}
</div>

<div class="form-group">
	{!! Form::label('tanggal_mulai', 'Tanggal Mulai', ['class' => 'control-label']) !!}
	{!! Form::date('tanggal_mulai', null, ['class' => 'form-control', 'required']) !!}
</div>

<div class="form-group">
	{!! Form::label('tanggal_selesai', 'Tanggal Selesai', ['class' => 'control-label']) !!}
	{!! Form::date('tanggal_selesai', null, ['class' => 'form-control', 'required']) !!}
</div>

<div>
	{!! Form::submit($btn_submit_text, ['class' => 'btn btn-primary']) !!}
	<a href="{{ route('admin.setting.pembukaan_krs.index') }}" class="btn btn-default">Batal</a>
</div>