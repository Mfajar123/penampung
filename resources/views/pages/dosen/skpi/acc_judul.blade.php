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
        <div class="box-body">
        <div class="box box-default">
                <div class="box-header with-border">
                    <h4 class="box-title">Cari Data Berdasarkan Nama</h4>
                </div><br>
<div class="container">            
        <div class="box-primary with-border">
        </div>
        <form action="{{route('dosen.skripsi.cari')}}" method="GET">
            <input type="text" name="cari" placeholder="Cari Nama .." value="{{ old('cari') }}">
            <input type="submit" value="CARI">
        </form>
        <br><p>
        <table class="table">
            <tr>
                <th>Nim</th>
                <th>Nama</th>
                <th>Prodi</th>
                <th>Judul Disetujui</th>
                <th>AKSI</th>
            </tr>
            @foreach($data as $d)
            <tr>
               <td>{{$d->nim}}</td>
               <td>{{$d->nama}}</td>
               <td>{{$d->prodi}}</td>
               <td>{{$d->judul_disetujui}}</td>
               <td><a href="{{route('mahasiswa.skripsi.edit',['$id'=>$d->id])}}" class="btn btn-warning"><i class="fa fa-edit"></i></a>
										
            </tr>
            @endforeach</div>
        </table>
        <br/>   
</section>@stop


