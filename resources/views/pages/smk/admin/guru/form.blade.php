<div class="form-group">
   <!--  {!! Form::label('id_info', 'Id Info', ['class' => 'control-label']) !!} <span>*</span> -->
    {!! Form::hidden('id_info', null, ['class' => 'form-control', 'placeholder' => 'Id Info', 'autocomplete' => 'off', 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('judul_info', 'Judul Info', ['class' => 'control-label']) !!} <!-- <span>*</span> -->
    {!! Form::text('judul_info', null, ['class' => 'form-control', 'placeholder' => 'Judul Info', 'autocomplete' => 'off', 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('foto_info', 'Foto', ['class' => 'control-label']) !!}
    {!! Form::file('foto_info') !!}
</div>

<div class="form-group">
    {!! Form::label('ringkasan_info', 'Ringkasan Info', ['class' => 'control-label']) !!} <!-- <span>*</span> -->
    {!! Form::textarea('ringkasan_info', null, ['class' => 'form-control', 'placeholder' => 'Ringkasan Info', 'autocomplete' => 'off', 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('isi_info', 'Isi Info', ['class' => 'control-label']) !!} <!-- <span>*</span> -->
    {!! Form::textarea('isi_info', null, ['class' => 'form-control', 'placeholder' => 'Isi Info', 'autocomplete' => 'off', 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('sumber_info', 'Sumber Info', ['class' => 'control-label']) !!} <!-- <span>*</span> -->
    {!! Form::text('sumber_info', null, ['class' => 'form-control', 'placeholder' => 'Sumber Info', 'autocomplete' => 'off', 'required']) !!}
</div>

<div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::label('id_kategori_info', 'Kategori Info', ['class' => 'control-label']) !!}
                    @if(count($kategori) > 0)
                        {!! Form::select('id_kategori_info', $kategori, null, ['class'=>'form-control selectpicker','id'=>'id_kategori_info', 'placeholder'=>'Pilih Kategori Info', 'data-show-subtext' => 'true', 'data-live-search' => 'true', 'required']) !!}
                    @else
                        <p>Tidak Ada kategori</p>
                    @endif
                </div>
            </div>
<div class="form-group">
    <a href="{{ route('smk.admin.guru') }}" class="btn btn-default btn-sm"> Kembali</a>
    {!! Form::submit($btnSubmit, ['class' => 'btn btn-primary btn-sm']) !!}
</div>
