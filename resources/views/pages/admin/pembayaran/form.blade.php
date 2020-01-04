<div class="form-group">
    {!! Form::label('nama_kategori', 'Nama Kategori', ['class' => 'control-label']) !!}
    {!! Form::select('nama_kategori', ['Diterima' => 'Diterima', 'Tidak Diterima' => 'Tidak Diterima'], null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
</div>

<div class="form-group row">
    <div class="col-md-6">
        {!! Form::label('id_prodi', 'Program Studi', ['class' => 'control-label']) !!}
        {!! Form::select('id_prodi', $prodi, null, ['placeholder' => '- Pilih Tahun Akademik -', 'class' => 'form-control', 'required']) !!}
    </div>

    <div class="col-md-6">
        {!! Form::label('tahun_akademik', 'Tahun Akademik', ['class' => 'control-label']) !!}
        {!! Form::select('tahun_akademik', $akademik, null, ['placeholder' => '- Pilih Tahun Akademik -', 'class' => 'form-control', 'required']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('id_waktu_kuliah', 'Waktu Kuliah', ['class' => 'control-label']) !!}
    {!! Form::select('id_waktu_kuliah', $waktu, null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('biaya', 'Biaya', ['class' => 'control-label']) !!}
    {!! Form::text('biaya', null, ['class' => 'form-control money', 'placeholder' => 'Contoh : 200,000', 'autocomplete' => 'off']) !!}
</div>

<div class="form-group">
    {!! Form::label('minimal_biaya', 'Minimal Biaya', ['class' => 'control-label']) !!}
    {!! Form::text('minimal_biaya', null, ['class' => 'form-control money', 'placeholder' => 'Contoh : 200,000', 'autocomplete' => 'off']) !!}
</div>

<div class="form-group">
    {!! Form::label('potongan', 'Potongan', ['class' => 'control-label']) !!}
    {!! Form::text('potongan', null, ['class' => 'form-control money', 'placeholder' => 'Contoh : 200,000', 'autocomplete' => 'off']) !!}
</div>

<div class="form-group">
    {!! Form::label('nilai_terendah', 'Nilai Terendah', ['class' => 'control-label']) !!} <span>*</span>
    {!! Form::text('nilai_terendah', null, ['class' => 'form-control nilai', 'placeholder' => 'Contoh : 32.90', 'autocomplete' => 'off', 'onkeypress' => 'return event.charCode >= 46 && event.charCode <= 57', 'maxlength' => '6', 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('nilai_tertinggi', 'Nilai Tertinggi', ['class' => 'control-label']) !!} <span>*</span>
    {!! Form::text('nilai_tertinggi', null, ['class' => 'form-control nilai', 'placeholder' => 'Contoh : 100.00', 'autocomplete' => 'off', 'onkeypress' => 'return event.charCode >= 46 && event.charCode <= 57', 'maxlength' => '6', 'required']) !!}
</div>

<div class="form-group">
    <a href="{{ route('admin.pembayaran') }}" class="btn btn-default btn-sm"> Kembali</a>
    {!! Form::submit($btnSubmit, ['class' => 'btn btn-primary btn-sm']) !!}
</div>

<script type="text/javascript">
  $('.nilai').keyup(function(){
        var current = $(this).val();
        if($(this).val().length == 3)
        {
            if(current.substr(2, 3) == '.')
            {
                $(this).val(current.replace('.', ''));
            }
            else
            {
                $(this).val(current.substr(0, 2)+'.'+current.substr(2, 6));
            }

        }
        else if($(this).val().length == 6)
        {
            $(this).val(current.replace('.', ''));
            var max = parseInt(100);
            if($(this).val() < max.toFixed(2))
            {
                $(this).val($(this).val().substr(0, 3)+'.'+$(this).val().substr(3, 6));
            }
            else
            {
                $(this).val(max.toFixed(2));
            }
        }
        else if($(this).val().length < 3)
        {
            $(this).val(current.replace('.', ''));
        }
  });
</script>
