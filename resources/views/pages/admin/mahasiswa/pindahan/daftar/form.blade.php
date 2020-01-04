<div class="form-group">
    {!! Form::label('tahun_akademik', 'Tahun Akademik', ['class' => 'control-label']) !!}
    {!! Form::select('tahun_akademik', $akademik, null, ['class' => 'form-control select-custom', 'autocomplete' => 'off', 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('nama', 'Nama Lengkap', ['class' => 'control-label']) !!} <span>*</span>
    {!! Form::text('nama', null, ['class' => 'form-control', 'placeholder' => 'Nama Lengkap', 'autocomplete' => 'off', 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('no_telp', 'Nomor Telepon', ['class' => 'control-label']) !!}
    {!! Form::number('no_telp', null, ['class' => 'form-control', 'placeholder' => 'Nomor Telepon', 'autocomplete' => 'off']) !!}
</div>

<div class="form-group">
    {!! Form::label('id_provinsi', 'Provinsi', ['class' => 'control-label']) !!}
    {!! Form::select('id_provinsi', $provinsi, null, ['class' => 'form-control select-custom']) !!}
</div>

<div class="form-group">
    {!! Form::label('alamat', 'Alamat', ['class' => 'control-label']) !!}
    {!! Form::textarea('alamat', null, ['class' => 'form-control', 'placeholder' => 'Alamat', 'autocomplete' => 'off', 'rows' => '3']) !!}
</div>

<div class="form-group row">
  <div class="col-md-6">
    {!! Form::label('id_jenjang', 'Jenjang', ['class' => 'control-label']) !!}
    {!! Form::select('id_jenjang', $jenjang, null, ['class' => 'form-control select-custom']) !!}
  </div>

  <div class="col-md-6">
    {!! Form::label('id_prodi', 'Program Studi', ['class' => 'control-label']) !!}
    {!! Form::select('id_prodi', $prodi, null, ['class' => 'form-control select-custom']) !!}
  </div>
</div>

<div class="form-group row">
  <div class="col-md-6">
    {!! Form::label('id_status', 'Status', ['class' => 'control-label']) !!}
    {!! Form::select('id_status', $status, null, ['class' => 'form-control select-custom status', 'value' => 'Pindahan' ]) !!}
  </div>

  <div class="col-md-6">
    {!! Form::label('id_waktu_kuliah', 'Waktu Kuliah', ['class' => 'control-label']) !!}
    {!! Form::select('id_waktu_kuliah', $waktu, null, ['class' => 'form-control select-custom']) !!}
  </div>
</div>

<div class="form-group">
    {!! Form::label('id_promo', 'Promo', ['class' => 'control-label']) !!}
    {!! Form::select('id_promo', $promo, null, ['class' => 'form-control select-custom']) !!}
</div>

<!--<div class="form-group">
    {!! Form::label('biaya', 'Biaya Pendaftaran', ['class' => 'control-label']) !!}
    @if(!empty(Request::segment(4)))
      @if($daftar->bayar_ke > 1)
        <input type="text" value="{{ $daftar->bayar }}" disabled class="form-control money">
      @else
        <input type="text" value="{{ $daftar->bayar }}" class="form-control money" autocomplete="off">
      @endif
    @else
      {!! Form::text('biaya', null, ['class' => 'form-control money', 'placeholder' => '250,000', 'autocomplete' => 'off']) !!}
    @endif
</div>-->

<div class="form-group">
    <a href="{{ route('admin.daftar.pindahan') }}" class="btn btn-default btn-sm"> Kembali</a>
    {!! Form::submit($Submit, ['class' => 'btn btn-primary btn-sm']) !!}
</div>

<script type="text/javascript">
  $('.money').keyup(function(){
    if($(this).val() > 250000)
    {
      $(this).val(250000);
    }
  });

  $('.status').change(function(){
    var status = $(this).val();

    if(status == 6)
    {
      $('select[name="id_promo"]').parent().after('\
        <div class="form-group">\
        {!! Form::label("id_transkip", "Transkip Nilai", ["class" => "control-label"]) !!}\
        {!! Form::file("transkrip", [ "id" => "file"]) !!}\
        </div>');
    }
    else
    {
      $('#file').remove();
    }
  });

  $(document).ready(function(){
    if($('[name="id_status"]').val() == 6)
    {
      $('select[name="id_promo"]').parent().after('\
        <div class="form-group">\
        {!! Form::label("id_transkip", "Transkip Nilai", ["class" => "control-label"]) !!}\
        {!! Form::file("transkrip", [ "id" => "file"]) !!}\
        </div>');
    }
    else
    {
      $('#file').remove();
    }
  });
</script>