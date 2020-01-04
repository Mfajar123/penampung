<div class="form-group">
   <!--  {!! Form::label('id_pengumuman', 'Id pengumuman', ['class' => 'control-label']) !!} <span>*</span> -->
    {!! Form::hidden('id_pengumuman', null, ['class' => 'form-control', 'placeholder' => 'Id pengumuman', 'autocomplete' => 'off', 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('judul_pengumuman', 'Judul pengumuman', ['class' => 'control-label']) !!} <!-- <span>*</span> -->
    {!! Form::text('judul_pengumuman', null, ['class' => 'form-control', 'placeholder' => 'Judul pengumuman', 'autocomplete' => 'off', 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('foto_pengumuman', 'Foto / Pdf', ['class' => 'control-label']) !!}
    {!! Form::file('foto_pengumuman') !!}
</div>

<div class="container">
	
    <div class="row">
        <script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
            <script>
                    tinymce.init({
                        selector: "textarea",
                        plugins: [
                            "advlist autolink lists link image charmap print preview anchor",
                            "searchreplace visualblocks code fullscreen",
                            "insertdatetime media table contextmenu paste"
                        ],
                        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                    });
            </script>
  

        <div class="form-group">
            {!! Form::label('isi_pengumuman', 'Isi pengumuman', ['class' => 'control-label']) !!} <!-- <span>*</span> -->
            {!! Form::textarea('isi_pengumuman', null, ['class' => 'tinyMCE form-control', 'placeholder' => 'Isi pengumuman', 'autocomplete' => 'off']) !!}
        </div>
    </div>
</div>

<div class="form-group">
    {!! Form::label('sumber_pengumuman', 'Sumber pengumuman', ['class' => 'control-label']) !!} <!-- <span>*</span> -->
    {!! Form::text('sumber_pengumuman', null, ['class' => 'form-control', 'placeholder' => 'Sumber pengumuman', 'autocomplete' => 'off', 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('umumkan_ke', 'Umumkna Kepada', ['class' => 'control-label']) !!}
    {!! Form::select('umumkan_ke', ['Semua' => 'Semua', 'Dosen' => 'Dosen', 'Mahasiswa' => 'Mahasiswa'], null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    <a href="{{ route('admin.pengumuman') }}" class="btn btn-default btn-sm"> Kembali</a>
    {!! Form::submit($btnSubmit, ['class' => 'btn btn-primary btn-sm']) !!}
</div>


