<div class="form-group">
    {!! Form::label('tahun_akademik', 'Tahun Akademik', ['class' => 'control-label']) !!}
    {!! Form::select('tahun_akademik', $akademik, null, ['class' => 'form-control select-custom', 'autocomplete' => 'off', 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('nama', 'Nama Lengkap', ['class' => 'control-label']) !!} <span>*</span>
    {!! Form::text('nama', null, ['class' => 'form-control', 'placeholder' => 'Nama Lengkap', 'autocomplete' => 'off', 'required']) !!}
</div>

<div class="form-group row">
    <div class="col-md-6">
      {!! Form::label('tempat_lahir', 'Tempat Lahir', ['class' => 'control-label']) !!}
      {!! Form::text('tempat_lahir', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
    </div>

    <div class="col-md-6">
      {!! Form::label('tanggal_lahir', 'Tanggal Lahir', ['class' => 'control-label']) !!}
      {!! Form::text('tanggal_lahir', null, ['class' => 'form-control datepicker', 'autocomplete' => 'off']) !!}
    </div>
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
    {!! Form::select('id_status', $status, null, ['class' => 'form-control select-custom status']) !!}
  </div>

  <div class="col-md-6">
    {!! Form::label('id_waktu_kuliah', 'Waktu Kuliah', ['class' => 'control-label']) !!}
    {!! Form::select('id_waktu_kuliah', $waktu, null, ['class' => 'form-control select-custom']) !!}
  </div>
</div>

{{-- <div class="form-group">
    {!! Form::label('id_promo[]', 'Promo', ['class' => 'control-label']) !!}
    {!! Form::select('id_promo[]', $promo, null, ['class' => 'form-control select-custom']) !!}
</div> --}}

<div id="transkip_nilai"></div>

<div id="list_promo">
  @if (isset($daftar))
    @foreach (explode(',', $daftar->id_promo) as $id_promo)
      <div class="form-group">
        {!! Form::label('id_promo[]', 'Promo', ['class' => 'control-label']) !!}
        <div class="input-group">
          {!! Form::select('id_promo[]', $promo, $id_promo, ['class' => 'form-control select-custom']) !!}
          <span class="input-group-btn">
            <button type="button" class="btn btn-danger btn-hapus-promo"><i class="fa fa-remove"></i></button>
          </span>
        </div>
      </div>
    @endforeach
  @endif
</div>

<div class="form-group">
  <button type="button" class="btn btn-default btn-tambah-promo">Tambah Promo</button>
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
    <a href="{{ route('admin.daftar') }}" class="btn btn-default btn-sm"> Kembali</a>
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
    var transkip_nilai = $('#transkip_nilai');

    if (status == 6) {
      $(transkip_nilai).html('<div class="form-group">\
          {!! Form::label("id_transkip", "Transkip Nilai", ["class" => "control-label"]) !!}\
          {!! Form::file("transkrip", ["required"]) !!}\
        </div>');
    } else {
      $(transkip_nilai).html('');
    }

    // if(status == 6)
    // {
    //   $('select[name="id_promo"]').parent().after('\
    //     <div class="form-group">\
    //     {!! Form::label("id_transkip", "Transkip Nilai", ["class" => "control-label"]) !!}\
    //     {!! Form::file("transkrip", ["required", "id" => "file"]) !!}\
    //     </div>');
    // }
    // else
    // {
    //   $('#file').remove();
    // }
  });

  $(document).ready(function(){
    if($('[name="id_status"]').val() == 6)
    {
      $('select[name="id_promo"]').parent().after('\
        <div class="form-group">\
        {!! Form::file("transkrip", ["id" => "file"]) !!}\
        </div>');
    }
    else
    {
      $('#file').remove();
    }

    $('.btn-tambah-promo').on('click', function (e) {
      e.preventDefault();

      var lists = $('#list_promo');

      $('<div class="form-group">\
        {!! Form::label('id_promo[]', 'Promo', ['class' => 'control-label']) !!}\
        <div class="input-group">\
          {!! Form::select('id_promo[]', $promo, null, ['class' => 'form-control select-custom']) !!}\
          <span class="input-group-btn">\
            <button type="button" class="btn btn-danger btn-hapus-promo"><i class="fa fa-remove"></i></button>\
          </span>\
        </div>\
      </div>').appendTo(lists);
    });

    $('#list_promo').on('click', '.btn-hapus-promo', function (e) {
      e.preventDefault();

      $(this).parent().parent().parent().remove();
    });
  });
</script>