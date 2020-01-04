@extends('pages.smp.smp')



@section('main')
	
	<!-- Content Header (Page header) -->
  <div class="container ">
  	 <section class="content-header col-md-12"  >

        <h1 class="pala">
         Ruang Kelas Ber-AC

        </h1> 

        <ol class="breadcrumb">

          <li>Beranda</li>

          <li>Fasilitas</li>

          <li >Ruang Kelas Ber-AC</li>

        </ol>

      </section>
  	
  	<section class="content col-md-12" >

        <div class="row">
        
        @if (!empty($ruang_kelas_ac))
      		<div class="col-xs-12 col-md-12" style="margin-bottom: 30px;">
      			 <?php foreach ($ruang_kelas_ac as $rka): ?>
             <h3>{{ $rka->judul_info }}</h3>

             <p style="font-size: 15px;">{{ $rka->isi_info }}</p>
             
             <img src="{{ asset('images/info/'.$rka->foto_info) }}" alt="" class="fasilitas ">


            <?php endforeach ?>
        @else      
          <p>Tidak ada data berita </p>
        @endif 
      		</div>

        </div>

      </section>	
    </div>
@stop