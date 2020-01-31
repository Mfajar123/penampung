@extends ('template')

@section ('main')

<section class="content-header">
		<h1>Edit SKPI</h1>

		<ol class="breadcrumb">
			<li><a href="#">Home</a></li>
			<li class="active">Edit SKPI</li>
		</ol>
    </section>
	
    <section class="content"> 
			<div class="col-sm-12">
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
					
			<div class="col-md-6">
						<form action="{{route('mahasiswa.judul.save')}}" method="POST" id="formulir">
							{{csrf_field()}}
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
								</div></div>

			
			<table class="table">
				<thead>
					<tr>
					<th scope="col">Judul Pertama</th>
					<th scope="col">Judul Kedua</th>
					<th scope="col">Judul Ketiga</th>
					<th scope="col-2">Aksi</th>
					</tr>
				</thead>
				@foreach ($data as $d)
				<tbody>
					<tr>
					<td>{{$d->judul1}}</td>
					<td>{{$d->judul2}}</td>
					<td>{{$d->judul3}}</td>
					<td><a href="{{route('mahasiswa.judul.edit',['$id'=>$d->id])}}" class="btn btn-warning"><i class="fa fa-edit"></i></a>
					<a href="{{route('mahasiswa.judul.cetak')}}" class="btn btn-success" target="_blank"><i class="fa fa-print"></i></a></td>
					
					</tr>
					@endforeach
					<tr>
					<th></th>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					</tr>
				</tbody>
				</table><br>
			</div>				
</section>@stop


