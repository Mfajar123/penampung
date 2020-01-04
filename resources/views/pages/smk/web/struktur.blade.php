@extends('pages.smk.smk')



@section('main')
	
	<!-- Content Header (Page header) -->
  <div class="container ">
  	 <section class="content-header col-md-12"  >

        <h1 class="pala">
          Struktur SMK Putra Perdana Indonesia

        </h1> 

        <ol class="breadcrumb" style="margin-bottom: 30px;">

          <li>Beranda</li>

          <li >Struktur</li>

        </ol>

      </section>
  	
  	<section class="content col-md-12" >

        <div class="row">
        
        @if (!empty($struktur))
          <div class="col-xs-12 col-md-12" style="margin-bottom: 30px;">
             <?php foreach ($struktur as $strkr): ?>
             <h3>{{ $strkr->judul_info }}</h3>
             
             <img src="{{ asset('images/info/'.$strkr->foto_info) }}" alt="" class="fasilitas ">


            <?php endforeach ?>
        @else      
          <p>Tidak ada data berita </p>
        @endif 
          </div>

        </div>

      </section>  
    </div>
@stop