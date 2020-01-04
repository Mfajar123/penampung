<div class="form-group">
    {!! Form::label('judul', 'Judul', ['class' => 'control-label']) !!}
    {!! Form::text('judul', null, ['required', 'class' => 'form-control']) !!}
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('tanggal_mulai', 'Tanggal Mulai', ['class' => 'control-label']) !!}
            {!! Form::date('tanggal_mulai', null, ['required', 'class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('tanggal_selesai', 'Tanggal Selesai', ['class' => 'control-label']) !!}
            {!! Form::date('tanggal_selesai', null, ['required', 'class' => 'form-control']) !!}
        </div>
    </div>
</div>

{!! Form::submit($btnSubmitText, ['class' => 'btn btn-primary']) !!}
<a href="{{ route('admin.agenda.index') }}" class="btn btn-default">Batal</a>