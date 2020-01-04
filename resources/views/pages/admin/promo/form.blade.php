<div class="form-group">
    {!! Form::label('nama_promo', 'Nama Promo', ['class' => 'control-label']) !!} <span>*</span>
    {!! Form::text('nama_promo', null, ['class' => 'form-control', 'placeholder' => 'Nama Promo', 'autocomplete' => 'off', 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('diskon', 'Diskon', ['class' => 'control-label']) !!} <span>*</span>
    {!! Form::number('diskon', null, ['class' => 'form-control', 'placeholder' => 'Diskon', 'autocomplete' => 'off', 'required']) !!}
</div>

<div class="form-group">
    <a href="{{ route('admin.promo') }}" class="btn btn-default btn-sm"> Kembali</a>
    {!! Form::submit($btnSubmit, ['class' => 'btn btn-primary btn-sm']) !!}
</div>
