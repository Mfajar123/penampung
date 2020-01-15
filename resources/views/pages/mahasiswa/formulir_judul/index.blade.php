@extends ('template')

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
	<div class="col-md-12">
	@if(session('gagal'))
            <div class="alert alert-danger" role="alert">
                {{session('gagal')}}
            </div><br>
			@endif 
	</div>		
	<div class="col-md-6">
			 
				<form action="{{route('mahasiswa.judul.save')}}" method="POST" id="formulir">
					{{csrf_field()}}
						<div class="form-group">
						<label for="Nim"><b>NIM :</b></label>
						<input type="text" class="form-control" required="required" name="nim" id="nim" value="{{ Auth::guard('mahasiswa')->user()->nim }}" disabled>
						</div>
						
						<div class="form-group">
						<label for="Nama"><b>NAMA :</b></label>
						<input type="text" class="form-control" required="required" name="nama" id="nama" value="{{ Auth::guard('mahasiswa')->user()->nama }}" disabled>
						</div>

						<div class="form-group">
						<label for="Prodi"><b>PRODI :</b></label>
						<input type="text" class="form-control" required="required" name="prodi" id="prodi" value="{{ Auth::guard('mahasiswa')->user()->id_prodi }}" disabled>
						</div>
					</div>
	<div class="col-md-6">
						<div class="form-group">
							<label for="Masukan Judul ke-1">Judul Skripsi Pertama</label>
							<textarea class="form-control" required="required" name="judul1" id="judul1" rows="2"></textarea>
							</div>

						<div class="form-group">
							<label for="Masukan Judul ke-1">Judul Skripsi Ke-Dua</label>
							<textarea class="form-control" required="required" name="judul2" id="judul2" rows="2"></textarea>
							</div>

						<div class="form-group">
							<label for="Masukan Judul ke-1">Judul Skripsi Ke-Tiga</label>
							<textarea class="form-control" required="required" name="judul3" id="judul3" rows="2"></textarea>
							</div>
							<p>
							<button type="submit" class="btn btn-primary">Submit</button>
						</form> 
						<a href="{{route('mahasiswa.judul.cetak')}}" class="btn btn-warning" target="_blank"><i class="fa fa-print"></i></a>
		
						</div>
					  
	</div> 
				</div></div>
    </section>       
    
@stop