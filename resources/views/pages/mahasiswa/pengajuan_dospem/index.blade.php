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
                @if(session('sukses'))
                <div class="alert alert-warning" role="alert">
                    {{session('sukses')}}
                </div>
                @endif
                @if(session('gagal'))
                <div class="alert alert-warning" role="alert">
                    {{session('gagal')}}
                </div>
                @endif
                @if(session('update'))
                <div class="alert alert-warning" role="alert">
                    {{session('update')}}
                </div>
                @endif
        </div>
        <div class="box-body">
            <div class="col-md-12">
              
                <form action="{{route('mahasiswa.dospem.save')}}" method="POST" onsubmit="return validasi()" enctype="multipart/form-data">
                {{csrf_field()}}

                <div class="form-group col-md-8">
                  {!! Form::label('dosen', 'Pilih Dospem Pertama', array('class' => 'control-label')) !!}

                    <select name="dospem1" class="form-control" id="dospem1">
                    @foreach ($data as $d)
                      <option value="{{$d->nama}}{{ $d->gelar_belakang }}">{{$d->nama}}{{ $d->gelar_belakang }}</option>
                    @endforeach
                    </select>
                  </div>

                  <div class="form-group col-md-8">
                    {!! Form::label('dosen', 'Pilih Dospem Kedua', array('class' => 'control-label')) !!}
                      <select name="dospem2" class="form-control" id="dospem2">
                      @foreach ($data as $d)
                        <option value="{{$d->nama}}{{ $d->gelar_belakang }}">{{$d->nama}}{{ $d->gelar_belakang }}</option>
                      @endforeach
                      </select>
                    </div>
              <br>
              <div class="col-md-8" align="right">
                    <button type="submit" class="btn btn-primary">Save</button>
              </div>
          </form>
            </div>
            </div>
        </div>

        <script>
          function validasi(){
              var val2 = document.getElementById('dospem1');
              var val3 = document.getElementById('dospem2');
  
              if (harusDiisi(val2, "Pilih Dosen Pembimbing Pertama!!!")) {
                  if (harusDiisi(val3, "Pilih Dosen Pembimbing Kedua!!!") {
                      if (harusDiisi(val4, "Isi Scan Formulir Pengajuan Judul!!!"){
                          {
                          return true;
                        };
                      };
                  };
              };
              return false;
          }
  
          function harusDiisi(att, msg){
              if (att.value.length == 0) {
                  alert(msg);
                  att.focus();
                  return false;
              }
  
              return true;
          }
      </script>
</section>
@stop


