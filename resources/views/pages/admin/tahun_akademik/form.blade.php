<div class="form-group">
    {!! Form::label('tahun_akademik', 'Tahun Akademik', ['class' => 'control-label']) !!}
    {!! Form::select('tahun_akademik', [''.$tahun_ini.'/'.$tahun_depan.'' => ''.$tahun_ini.'/'.$tahun_depan.'', ''.$tahun_lalu.'/'.$tahun_ini.'' => ''.$tahun_lalu.'/'.$tahun_ini.'', ''.$dua_tahun_lalu.'/'.$tahun_lalu.'' => ''.$dua_tahun_lalu.'/'.$tahun_lalu.'', ''.$tiga_tahun_lalu.'/'.$dua_tahun_lalu.'' => ''.$tiga_tahun_lalu.'/'.$dua_tahun_lalu.'', ''.$empat_tahun_lalu.'/'.$tiga_tahun_lalu.'' => ''.$empat_tahun_lalu.'/'.$tiga_tahun_lalu.'', ''.$lima_tahun_lalu.'/'.$empat_tahun_lalu.'' => ''.$lima_tahun_lalu.'/'.$empat_tahun_lalu.''], null, ['class' => 'form-control akademik']) !!}
</div>
<div class="form-group">
    {!! Form::label('semester', 'Semester', ['class' => 'control-label']) !!}
    {!! Form::select('semester', ['Ganjil' => 'Ganjil', 'Ganjil Pendek' => 'Ganjil Pendek', 'Genap' => 'Genap', 'Genap Pendek' => 'Genap Pendek'], null, ['class' => 'form-control semester']) !!}
</div>
<div class="form-group">
  {!! Form::label('keterangan', 'Keterangan', ['class' => 'control-label']) !!}
  {!! Form::text('keterangan', null, ['class' => 'form-control keterangan', 'readonly']) !!}
</div>
<div class="form-group">
    {!! Form::label('status', 'Status', ['class' => 'control-label']) !!}
    {!! Form::select('status', ['1' => 'Aktif', '2' => 'Tidak'], null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    <a href="{{ route('admin.tahun_akademik') }}" class="btn btn-default btn-sm"> Kembali</a>
    {!! Form::submit($btnSubmit, ['class' => 'btn btn-primary btn-sm']) !!}
</div>

<script type="text/javascript">
  $(document).ready(function(){
    $('.keterangan').val('Tahun Akademik '+ $('.akademik').val() +' '+ $('.semester').val());

    $('.akademik').change(function(){
      $('.keterangan').val('Tahun Akademik '+ $(this).val() +' '+ $('.semester').val());
    });

    $('.semester').change(function(){
      $('.keterangan').val('Tahun Akademik '+ $('.akademik').val() +' '+ $(this).val());
    });
  })
</script>
