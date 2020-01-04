<div class="form-group">
	{!! Form::label('nim', 'Mahasiswa', ['class' => 'control-label']) !!}
	{!! Form::select('nim', $list_mahasiswa, null, ['style' => 'width:100%', 'class' => 'form-control select-custom']) !!}
</div>

<div class="form-group">
	{!! Form::label('id_tahun_akademik', 'Tahun Akademik', ['class' => 'control-label']) !!}
	{!! Form::select('id_tahun_akademik', $list_tahun_akademik, null, ['style' => 'width:100%', 'class' => 'form-control select-custom']) !!}
</div>

<div class="form-group">
	{!! Form::label('bulan', 'Bulan', ['class' => 'control-label']) !!}
	{!! Form::select('bulan', $list_bulan, null, ['style' => 'width:100%', 'class' => 'form-control select-custom']) !!}
</div>

<div class="form-group">
	{!! Form::label('tanggal_akan_bayar', 'Tanggal Akan Bayar', ['class' => 'control-label']) !!}
	{!! Form::date('tanggal_akan_bayar', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
	{!! Form::label('nominal_akan_bayar', 'Nominal Akan Bayar', ['class' => 'control-label']) !!}
	{!! Form::text('nominal_akan_bayar', null, ['class' => 'form-control']) !!}
</div>

{!! Form::submit($btnSubmitText, ['class' => 'btn btn-primary']) !!}
<a href="{{ route('admin.dispensasi_spp.index') }}" class="btn btn-default">Batal</a>