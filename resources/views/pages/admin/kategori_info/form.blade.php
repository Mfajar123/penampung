<div class="form-group">
   <!--  {!! Form::label('id_kategori_info', 'Id Kategori Info', ['class' => 'control-label']) !!} <span>*</span> -->
    {!! Form::hidden('id_kategori_info', null, ['class' => 'form-control', 'placeholder' => 'Id Kategori Info', 'autocomplete' => 'off', 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('kategori_info', 'Kategori Info', ['class' => 'control-label']) !!} <span>*</span>
    {!! Form::text('kategori_info', null, ['class' => 'form-control', 'placeholder' => 'Kategori Info', 'autocomplete' => 'off', 'required']) !!}
</div>

<div class="form-group">
    <a href="{{ route('admin.kategori_info') }}" class="btn btn-default btn-sm"> Kembali</a>
    {!! Form::submit($btnSubmit, ['class' => 'btn btn-primary btn-sm']) !!}
</div>
