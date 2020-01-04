@extends('pages.smk.smk')



@section('main')
	
	<!-- Content Header (Page header) -->
  <div class="container ">
  	 <section class="content-header col-md-12"  >

        <h1 class="pala">
         Lab Komputer

        </h1> 

        <ol class="breadcrumb">

          <li>Beranda</li>
          <li>Fasilitas</li>
          <li >Lab Komputer</li>

        </ol>

      </section>
  	
  	<section class="content col-md-12" >

        <div class="row">
        
        @if (!empty($lab_komputer))
      		<div class="col-xs-12 col-md-12" style="margin-bottom: 30px;">
      			 <?php foreach ($lab_komputer as $lab): ?>
             <h3>{{ $lab->judul_info }}</h3>

             <p style="font-size: 15px;">{{ $lab->isi_info }}</p>
             
             <img src="{{ asset('images/info/'.$lab->foto_info) }}" alt="" class="fasilitas ">


            <?php endforeach ?>
        @else      
          <p>Tidak ada data berita </p>
        @endif 
      		</div>

        </div>

      </section>	
    </div>
@stop