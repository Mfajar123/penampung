@extends ('template')

@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/fullcalendar.min.css">
    <style>
        .content-title {
            margin-top: 0;
            margin-bottom: 15px;
        }
    </style>
@stop

@section ('main')

	<section class="content-header">
		<h1>Formulir Judul</h1>

		<ol class="breadcrumb">
			<li><a href="#">Home</a></li>
			<li class="active">Formuli Judul</li>
		</ol>
    </section>
    <p>  
    <section class="content"> 
	<div class="col-md-12">
	<div class="col-md-6">
            <form action="{{route('mahasiswa.judul.update',['id'=>$edit->id])}}" method="POST">
                {{csrf_field()}}
						<div class="form-group">
							<label for="Masukan Judul ke-1">Judul Skripsi Pertama</label>
							<textarea class="form-control" required="required" name="judul1" id="judul1" rows="2">{{$edit->judul1}}</textarea>
							</div>

						<div class="form-group">
							<label for="Masukan Judul ke-1">Judul Skripsi Ke-Dua</label>
							<textarea class="form-control" required="required" name="judul2" id="judul2" rows="2">{{$edit->judul2}}</textarea>
							</div>

						<div class="form-group">
							<label for="Masukan Judul ke-1">Judul Skripsi Ke-Tiga</label>
							<textarea class="form-control" required="required" name="judul3" id="judul3" rows="2">{{$edit->judul3}}</textarea>
							</div>
							<p>
							<button type="submit" class="btn btn-warning">Update</button>
							</form>
    </div></div></section> @stop