<div class="form-group">
    {!! Form::label('kode_kurikulum', 'Kode Kurikulum', ['class' => 'control-label']) !!}
    {!! Form::text('kode_kurikulum', $kode, ['class' => 'form-control', 'placeholder' => 'Kode Kurikulum', 'readOnly']) !!}
</div>

<div class="form-group">
	{!! Form::label('id_fakultas', 'Fakultas', ['class' => 'control-label']) !!}
  
  @if(!empty(Request::segment(4)))
    <select name="id_fakultas" class="form-control fakultas">
        @foreach(DB::table('fakultas')->get() as $listFakultas)
            @if($listFakultas->id_fakultas == $kurikulum->jurusan->fakultas->id_fakultas)
                <option value="{{ $listFakultas->id_fakultas }}" selected>{{ $listFakultas->nama_fakultas }}</option>
            @else
                <option value="{{ $listFakultas->id_fakultas }}">{{ $listFakultas->nama_fakultas }}</option>
            @endif
        @endforeach
    </select>
  @else
    {!! Form::select('id_fakultas', $listFakultas, null, ['class' => 'form-control fakultas', 'placeholder' => '-- Pilih Fakultas --']) !!}
  @endif
</div>

<div class="form-group jurusan">
    {!! Form::label('id_jurusan', 'Jurusan', ['class' => 'control-label']) !!}
    @if(!empty(Request::segment(4)))
      {!! Form::select('id_jurusan', $listJurusan, null, ['class' => 'form-control getJurusan']) !!}
    @else
      {!! Form::select('id_jurusan', [null], null, ['class' => 'form-control getJurusan']) !!}
    @endif
</div>

<div class="form-group">
    {!! Form::label('tahun', 'Tahun', ['class' => 'control-label']) !!}
    {!! Form::text('tahun', null, ['class' => 'form-control year', 'placeholder' => 'Tahun']) !!}
</div>

<div class="form-group">
    {!! Form::label('nama_kurikulum', 'Nama Kurikulum', ['class' => 'control-label']) !!}
    {!! Form::text('nama_kurikulum', null, ['class' => 'form-control', 'placeholder' => 'Nama Kurikulum', 'autocomplete' => 'off']) !!}
</div>

<div class="form-group">
    {!! Form::label('sk_rektor', 'SK Rektor', ['class' => 'control-label']) !!}
    {!! Form::text('sk_rektor', null, ['class' => 'form-control', 'placeholder' => 'SK Rektor', 'autocomplete' => 'off']) !!}
</div>

<div class="form-group">
    <a href="{{ route('admin.kurikulum') }}" class="btn btn-default btn-sm"> Kembali</a>
    {!! Form::submit($btnSubmit, ['class' => 'btn btn-primary btn-sm']) !!}
</div>

<script type="text/javascript">
  $('.fakultas').change(function() {
      var id = $(this).val();
      var urlname = "{{ url('admin/kurikulum/getJurusan') }}/" + id;

      $.ajax({
          type: 'GET',
          url: urlname,
          success: function(data) {
              $('.getJurusan').html(data);
          }
      })
  })
</script>
