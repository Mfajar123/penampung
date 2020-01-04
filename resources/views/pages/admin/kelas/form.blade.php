<div class="form-group">
    {!! Form::label('nama_kelas', 'Nama Kelas', ['class' => 'control-label']) !!}
    {!! Form::text('nama_kelas', null, ['class' => 'form-control nama', 'placeholder' => 'Nama Kelas', 'autocomplete' => 'off', 'readOnly']) !!}
</div>

<div class="form-group row">
    <div class="col-md-6">
        {!! Form::label('semester', 'Semester', ['class' => 'control-label']) !!}
        {!! Form::select('id_semester', $semester, null, ['class' => 'form-control semester']) !!}
    </div>

    <div class="col-md-6">
        {!! Form::label('kelas', 'Kelas', ['class' => 'control-label']) !!}
        @if(!empty(Request::segment(4)))
            <select class="form-control kelas" name="kelas">
                <option value="A" {{ (substr($kelas->kode_kelas, 1, 1) == 'A') ? 'selected' : '' }}>A</option>
                <option value="B" {{ (substr($kelas->kode_kelas, 1, 1) == 'B') ? 'selected' : '' }}>B</option>
                <option value="C" {{ (substr($kelas->kode_kelas, 1, 1) == 'C') ? 'selected' : '' }}>C</option>
                <option value="D" {{ (substr($kelas->kode_kelas, 1, 1) == 'D') ? 'selected' : '' }}>D</option>
                <option value="E" {{ (substr($kelas->kode_kelas, 1, 1) == 'E') ? 'selected' : '' }}>E</option>
                <option value="F" {{ (substr($kelas->kode_kelas, 1, 1) == 'F') ? 'selected' : '' }}>F</option>
                <option value="G" {{ (substr($kelas->kode_kelas, 1, 1) == 'G') ? 'selected' : '' }}>G</option>
                <option value="H" {{ (substr($kelas->kode_kelas, 1, 1) == 'H') ? 'selected' : '' }}>H</option>
                <option value="I" {{ (substr($kelas->kode_kelas, 1, 1) == 'I') ? 'selected' : '' }}>I</option>
                <option value="J" {{ (substr($kelas->kode_kelas, 1, 1) == 'J') ? 'selected' : '' }}>J</option>
                <option value="SH" {{ (substr($kelas->kode_kelas, 1, 1) == 'SH') ? 'selected' : '' }}>SH</option>
                <option value="SH2" {{ (substr($kelas->kode_kelas, 1, 1) == 'SH2') ? 'selected' : '' }}>SH2</option>
            </select>
        @else
            {!! Form::select('kelas', ['A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E', 'F' => 'F', 'G' => 'G', 'H' => 'H', 'I' => 'I', 'J' => 'J', 'SH' => 'SH', 'SH2' => 'SH2'], null, ['class' => 'form-control kelas']) !!}
        @endif
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('tahun_akademik', 'Tahun Akademik', ['class' => 'control-label']) !!}
            {!! Form::select('tahun_akademik', $tahun_akademik , null, ['class' => 'form-control tahun_akademik']) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('waktu_kuliah', 'Waktu Kuliah', ['class' => 'control-label']) !!}
            {!! Form::select('id_waktu_kuliah', $waktu_kuliah , null, ['class' => 'form-control waktu_kuliah']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('prodi', 'Prodi', ['class' => 'control-label']) !!}
            {!! Form::select('id_prodi', $prodi , null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('kapasitas', 'Kapasitas Kelas', ['class' => 'control-label']) !!}
            {!! Form::number('kapasitas', null, ['class' => 'form-control', 'placeholder' => 'Kapasitas', 'autocomplete' => 'off']) !!}
        </div>
    </div>
</div>

<div>
    {!! Form::submit($btnSubmit, ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('admin.kelas') }}" class="btn btn-default">Batal</a>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        var semester = $('.semester').val();
        var kelas = $('.kelas').val();

        $('.nama').val('Semester '+ semester +' Kelas '+ kelas);

        $('.semester').change(function(){
            $('.nama').val('Semester '+ $('.semester').val() +' Kelas '+ $('.kelas').val());

        });

        $('.kelas').change(function(){
            $('.nama').val('Semester '+ $('.semester').val() +' Kelas '+ $('.kelas').val());
             if( $('.kelas').val() == 'SH' ){
                $('.waktu_kuliah').val(4);  
            }
        });
    });
</script>
