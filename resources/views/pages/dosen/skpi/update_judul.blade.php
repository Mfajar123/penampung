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
        <div class="form-group">
          <label>Perkiraan Mulai Bimbingan</label>
          <div class="input-group date">
           <div class="input-group-addon">
                  <span class="glyphicon glyphicon-th"></span>
              </div>
              <input placeholder="masukkan tanggal awal Mulai bimbingan" type="text" class="form-control datepicker" name="mulai_bimbingan">
          </div>
         </div>
         <br>
         <div class="form-group">
          <label>Perkiraan Selesai Bimbingan</label>
          <div class="input-group date">
           <div class="input-group-addon">
                  <span class="glyphicon glyphicon-th"></span>
              </div>
              <input placeholder="masukkan tanggal Selesai bimbingan" type="text" class="form-control datepicker" name="selesai_bimbingan">
          </div></div>
         </div>

        <script type="text/javascript">
          $(function(){
          $(".datepicker").datepicker({
          format: 'yyyy-mm-dd',
          autoclose: true,
          todayHighlight: true,
          });
          });
        </script>
            
            <div class="col-sm-12"><button type="submit" class="btn btn-warning">Update</button></div>
      </div></form>
    </section>
    @stop