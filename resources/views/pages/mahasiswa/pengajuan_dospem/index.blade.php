@extends ('template')

@section ('main')

<section class="content-header">
		<h1>Form Pengajuan Dosen Pembimbing</h1>

		<ol class="breadcrumb">
			<li><a href="#">Home</a></li>
			<li class="active">Pengajuan Dospem</li>
		</ol>
    </section>
	
<section class="content"> 
        <div class="box box-default">
        <div class="box-header with-border">
        </div>
        <div class="box-body">
            <div class="col-md-12">
                <form action="" method="" id="">
                    
                <div class="form-group col-md-6">
                <label for="formGroupExampleInput">Example label</label>
                <input type="text" class="form-control" id="" name="" placeholder="Judul Yang disetujui">
                </div>

                <div class="form-group col-md-6">
                        <label for="formGroupExampleInput">Example label</label>
                        <input type="text" class="form-control"  id="formGroupExampleInput" name="" placeholder="Example input placeholder">
                </div>

                <div class="col-md-6">
                    {!! Form::label('Dospem', 'Dospem', ['class' => 'control-label']) !!}
                    {!! Form::select('dosen', $dosen, null, ['placeholder' => '- Pilih Dospem Pertama -', 'class' => 'form-control', 'required']) !!}
                </div>

                <div class="col-md-6">
                    {!! Form::label('Dospem', 'Dospem', ['class' => 'control-label']) !!}
                    {!! Form::select('dosen', $dosen, null, ['placeholder' => '- Pilih Dospem Kedua -', 'class' => 'form-control', 'required']) !!}
                </div>
                <br>
                <div class="col-md-6">
                </div><br>
              <div class="form-group col-md-4">
              <label for="image1">Input Form Judul Yang Sudah Disetuji</label>
                    <input type="file" class="form-control" name="sertifikat_ospek" placeholder="Choose image" id="image1">
                    <span class="text-danger">{{ $errors->first('title') }}</span>
              </div>
                    

                </form>
            </div>
            </div>
        </div>
</section>@stop


