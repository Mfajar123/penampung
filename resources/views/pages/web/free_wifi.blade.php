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

          <li >Free Wifi</li>

        </ol>

      </section>
  	
  	<section class="content col-md-12" >

        <div class="row">
        
        @if (!empty($free_wifi))
      		<div class="col-xs-12 col-md-12" style="margin-bottom: 30px;">
      			 <?php foreach ($free_wifi as $wifi): ?>
             <h3>{{ $wifi->judul_info }}</h3>

             <p>{{ $wifi->isi_info }}</p>
             
             <img src="{{ asset('images/info/'.$wifi->foto_info) }}" alt="" class="fasilitas ">


            <?php endforeach ?>
        @else      
          <p>Tidak ada data berita </p>
        @endif 
      		</div>

        </div>

      </section>	
    </div>
@stop