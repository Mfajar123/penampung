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
          <li >ATM Center</li>

        </ol>

      </section>
  	
  	<section class="content col-md-12" >

        <div class="row">
        
        @if (!empty($atm_center))
      		<div class="col-xs-12 col-md-12" style="margin-bottom: 30px;">
      			 <?php foreach ($atm_center as $atm): ?>
             <h3>{{ $atm->judul_info }}</h3>

             <p>{{ $atm->isi_info }}</p>
             
             <img src="{{ asset('images/info/'.$atm->foto_info) }}" alt="" class="fasilitas ">


            <?php endforeach ?>
        @else      
          <p>Tidak ada data berita </p>
        @endif 
      		</div>

        </div>

      </section>	
    </div>
@stop