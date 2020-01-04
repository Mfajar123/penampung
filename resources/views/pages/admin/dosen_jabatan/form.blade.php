<div class="form-group">
    {!! Form::label('id_dosen_jabatan', 'Kode Jabatan', ['class' => 'control-label']) !!} <span>*</span>
    {!! Form::text('id_dosen_jabatan', null, ['class' => 'form-control', 'placeholder' => 'Kode Jabatan', 'autocomplete' => 'off', 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('nama', 'Nama Jabatan', ['class' => 'control-label']) !!} <span>*</span>
    {!! Form::text('nama', null, ['class' => 'form-control', 'placeholder' => 'Nama Jabatan', 'autocomplete' => 'off', 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('tunjangan_jabatan', 'Tunjangan Jabatan', ['class' => 'control-label']) !!} <span>*</span>
    {!! Form::number('tunjangan_jabatan', null, ['class' => 'form-control', 'placeholder' => 'Tunjangan Jabatan', 'autocomplete' => 'off', 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('tunjangan_sks', 'Tunjangan SKS', ['class' => 'control-label']) !!} <span>*</span>
    {!! Form::number('tunjangan_sks', null, ['class' => 'form-control', 'placeholder' => 'Tunjangan SKS', 'autocomplete' => 'off', 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('jumlah_komulatif_maksimal', 'Jumlah Komulatif Maksimal', ['class' => 'control-label']) !!} <span>*</span>
    {!! Form::number('jumlah_komulatif_maksimal', null, ['class' => 'form-control', 'placeholder' => 'Jumlah Komulatif Maksimal', 'autocomplete' => 'off', 'required']) !!}
</div>

<div class="form-group">
    <a href="{{ route('admin.dosen_jabatan') }}" class="btn btn-default btn-sm"> Kembali</a>
    {!! Form::submit($btnSubmit, ['class' => 'btn btn-primary btn-sm']) !!}
</div>
