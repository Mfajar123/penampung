<div class="form-group">
    {!! Form::label('kode_semester', 'Kode Semester', ['class' => 'control-label']) !!}
    {!! Form::text('kode_semester', $kode, ['class' => 'form-control', 'placeholder' => 'Kode Semester', 'autocomplete' => 'off', 'readOnly']) !!}
</div>

<div class="form-group row">
	<div class="col-md-6">
    {!! Form::label('tgl_mulai', 'Tanggal Mulai', ['class' => 'control-label']) !!}
    {!! Form::text('tgl_mulai', null, ['class' => 'form-control date', 'placeholder' => 'Tanggal Mulai', 'autocomplete' => 'off', 'readOnly']) !!}
  </div>

  <div class="col-md-6">
    {!! Form::label('tgl_selesai', 'Tanggal Selesai', ['class' => 'control-label']) !!}
    {!! Form::text('tgl_selesai', null, ['class' => 'form-control date', 'placeholder' => 'Tanggal Selesai', 'autocomplete' => 'off', 'readOnly']) !!}
  </div>
</div>

<div class="form-group row">
  <div class="col-md-6">
    {!! Form::label('tahun', 'Tahun', ['class' => 'control-label']) !!}
    {!! Form::text('tahun', null, ['class' => 'form-control year', 'placeholder' => 'Tahun', 'autocomplete' => 'off', 'readOnly']) !!}
  </div>

  <div class="col-md-6">
    {!! Form::label('tipe', 'Tipe ( Ganjil / Genap )', ['class' => 'control-label']) !!}
    {!! Form::select('tipe', ['Ganjil' => 'Ganjil', 'Genap' => 'Genap'], null, ['class' => 'form-control']) !!}
  </div>
</div>

<div class="form-group">
    <a href="{{ route('admin.semester') }}" class="btn btn-default btn-sm"> Kembali</a>
    {!! Form::submit($btnSubmit, ['class' => 'btn btn-primary btn-sm']) !!}
</div>

<script type="text/javascript">
  $(document).ready(function(){
    $('.date').datepicker({
      format: 'yyyy-mm-dd',
      orientation: 'bottom'
    });
  });
</script>