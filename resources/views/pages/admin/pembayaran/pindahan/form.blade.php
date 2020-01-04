<div class="form-group">
    {!! Form::label('tahun_akademik', 'Tahun Akademik', ['class' => 'control-label']) !!}
    {!! Form::select('tahun_akademik', $akademik, null, ['class' => 'form-control select-custom']) !!}
</div>

<div class="form-group">
    {!! Form::label('nama_biaya', 'Nama Pembayaran', ['class' => 'control-label']) !!}
    {!! Form::text('nama_biaya', null, ['class' => 'form-control', 'autocomplete' => 'off', 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('biaya', 'Biaya', ['class' => 'control-label']) !!}
    {!! Form::text('biaya', null, ['class' => 'form-control money', 'placeholder' => 'Contoh : 200,000', 'autocomplete' => 'off']) !!}
</div>

<div class="form-group">
    {!! Form::label('minimal', 'Minimal Biaya', ['class' => 'control-label']) !!}
    {!! Form::text('minimal', null, ['class' => 'form-control money', 'placeholder' => 'Contoh : 200,000', 'autocomplete' => 'off']) !!}
</div>

<div class="form-group">
    <a href="{{ route('admin.pembayaran.pindahan') }}" class="btn btn-default btn-sm"> Kembali</a>
    {!! Form::submit($btnSubmit, ['class' => 'btn btn-primary btn-sm']) !!}
</div>
