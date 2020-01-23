@extends ('template')

@section ('main')

<section class="content-header">
		<h1>Form Persetujuan Dospem Pembimbing</h1>

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

<form action="{{route('mahasiswa.skripsi.update',['id'=>$edit->id])}}" method="POST" onsubmit="return validasi()">
        {{csrf_field()}}
             
        <fieldset class="form-group">
                <div class="form-group">
                        <label for="exampleFormControlSelect1">Example select</label>
                        <select class="form-control" id="exampleFormControlSelect1" name="judul">
                          <option>{{$edit->judul1}}</option>
                          <option>{{$edit->judul2}}</option>
                          <option>{{$edit->judul3}}</option>
                        </select>
                      </div>
        </fieldset>

        <br><br>
        <div class='col-sm-4'>
                <div class="well">
                        <div id="datetimepicker1" nama="mulai_bimbingan" class="input-append date">
                          <input data-format="dd/MM/yyyy hh:mm:ss" type="text"></input>
                          <span class="add-on">
                            <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                            </i>
                          </span>
                        </div>
                      </div>
                      <script type="text/javascript">
                        $(function() {
                          $('#datetimepicker1').datetimepicker({
                            language: 'pt-BR'
                          });
                        });
                      </script>   
            </div>
            
            <div class="col-sm-12"><button type="submit" class="btn btn-warning">Update</button></div>
        </form>
    </section>
    @stop