@extends('under')



@section('main')
	
	<!-- Content Header (Page header) -->
  <div class="container ">
  	 <section class="content-header col-md-12"  >

        <h1 class="pala">
         Fasilitas

        </h1> 

        <ol class="breadcrumb">

          <li>Beranda</li>
			<li>Fasilitas</li>
          <li >Studio Musik</li>

        </ol>

      </section>
  	
  	<section class="content col-md-12" >

        <div class="row">
        
        @if (!empty($studio_musik))
      		<div class="col-xs-12 col-md-12" style="margin-bottom: 30px;">
      			 <?php foreach ($studio_musik as $studio): ?>
             <h3>{{ $studio->judul_info }}</h3>

             <p>{{ $studio->isi_info }}</p>
             
             <img src="{{ asset('images/info/'.$studio->foto_info) }}" alt="" class="fasilitas ">


            <?php endforeach ?>
        @else      
          <p>Tidak ada data berita </p>
        @endif 
      		</div>

        </div>

      </section>	
    </div>
@stop