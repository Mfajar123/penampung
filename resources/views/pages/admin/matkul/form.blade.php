<div class="form-group row">
    <div class="col-md-6">
        {!! Form::label('id_jenjang', 'Jenjang', ['class' => 'control-label']) !!}
        {!! Form::select('id_jenjang', $jenjang, null, ['class' => 'form-control']) !!}
    </div>

    <div class="col-md-6">
        {!! Form::label('id_kompetensi', 'Kompetensi', ['class' => 'control-label']) !!}
        {!! Form::select('id_kompetensi', $kompetensi, null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group row">
        <div class="col-md-6">
        {!! Form::label('id_prodi', 'Prodi', ['class' => 'control-label']) !!}
        {!! Form::select('id_prodi', $prodi, null, ['class' => 'form-control']) !!}
    </div>

    <div class="col-md-6">
        {!! Form::label('id_semester', 'Semester', ['class' => 'control-label']) !!}
        {!! Form::select('id_semester', $semester, null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('nama_matkul', 'Nama Matkul', ['class' => 'control-label']) !!}
    {!! Form::text('nama_matkul', null, ['class' => 'form-control', 'placeholder' => 'Nama Matkul', 'autocomplete' => 'off']) !!}
</div>

<div class="form-group">
    {!! Form::label('sks', 'SKS', ['class' => 'control-label']) !!}
    {!! Form::number('sks', null, ['class' => 'form-control', 'placeholder' => 'Jumlah SKS', 'autocomplete' => 'off']) !!}
</div>

<div class="form-group">
    <a href="{{ route('admin.matkul') }}" class="btn btn-default btn-sm"> Kembali</a>
    {!! Form::submit($btnSubmit, ['class' => 'btn btn-primary btn-sm']) !!}
</div>
