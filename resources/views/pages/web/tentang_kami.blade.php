@extends('under')



@section('main')
	
	<!-- Content Header (Page header) -->
  <div class="container ">
  	 <section class="content-header col-md-12"  >

        <h1 class="pala">
          Tentang Kami

        </h1> 

        <ol class="breadcrumb">

          <li>Beranda</li>

          <li>Profil</li>

          <li >Tentang Kami</li>

        </ol>

      </section>
  	
  	<section class="content col-md-12" >

        <div class="row">
  		
      		<div class="col-xs-12 col-md-12 tentang">
      			
             <h3>Sistem</h3>

             <p>STIE Putra Perdana Indonesia didirikan dengan berpedoman pada Corporate Culture yang dinamis dan akuntabel. Guna menjaga dan meningkatkan mutu pendidikan maka kami memiliki unit kendali mutu yang berfungsi mengkaji dan mengendalikan kualitas. Terlebih lagi perangkat sistem dan peraturan yang dimiliki oleh STIE PPI saat ini dapat mendukung pencapaian visi, misi dan tujuan yang telah ditetapkan di masa yang akan datang dengan melahirkan kurikulum berbasis Kompetensi dan Teknologi.</p>

             <h3>Sistem Pendidikan</h3>

             <p>STIE Putra Perdana Indonesia didirikan dengan berpedoman pada Corporate Culture yang dinamis dan akuntabel. Guna menjaga dan meningkatkan mutu pendidikan maka kami memiliki unit kendali mutu yang berfungsi mengkaji dan mengendalikan kualitas. Terlebih lagi perangkat sistem dan peraturan yang dimiliki oleh STIE PPI saat ini dapat mendukung pencapaian visi, misi dan tujuan yang telah ditetapkan di masa yang akan datang dengan melahirkan kurikulum berbasis Kompetensi dan Teknologi.</p> 
             <p>Metode belajar dilaksanakan secara intensif dan partisipatif dengan berpedoman pada kurikulum terbaru Perguruan Tinggi.</p>

             <h3>FASILITAS PENDIDIKAN</h3>

             <p>Untuk mengimbangi laju perkembangan ilmu pengetahuan dan fenomena akan kebutuhan pendidikan yang berkembang pesat di masyarakat Indonesia Khususnya di Tangerang – Banten, STIE PPI berupaya menjawab kebutuhan tersebut. Dengan fasilitas yang memadai dan tenaga pengajar yang kompeten, STIE Putra Perdana Indonesia menjawab tantangan dan kebutuhan masyarakat.</p>
             <p>Adapun fasilitas yang ada tersedia di STIE Putra Perdana Indonesia antara lain :</p>
             <ol>
               <li>Terakreditasi BAN-PT Predikat B (Perguruan Tinggi = B, Prodi Akuntans = B, dan Prodi Manajemen = B)</li>
               <li>Laboratorium Komputer dan Bahasa</li>
               <li>Tenaga Pengajar yang berpengalaman dan profesional si bidangnya masing – masing, bergelar S1, S2 dan S3 lulusan dari dalam dan luar negeri.</li>
               <li>Ruang kuliah FULL AC memberikan kenyamanan dalam mengikuti perkuliahan.</li>
               <li>Lokasi kampus dengan lokasi bisnis serta mudah diakses oleh angkutan umum.</li>
               <li>Pembayaran Biaya Kuliah dapat diangsur 6 Kali dalam 1 semester.</li>
               <li>Gratis Akses Internet dalam kampus (Free WIFI).</li>
               <li>AULA yang Representatif.</li>
               <li>Masjid Kampus.</li>
               <li>Radio Kampus.</li>
               <li>Beasiswa.</li>
               <li>ATM Center</li>
             </ol>

      		</div>

         <!--  <div class="col-xs-12 col-md-12 ">
           @if (!empty($info_list)) 
                 <h2 style="color: blue;"><span>Berita & Informasi</span></h2>
                 <div class="row">
                   <?php foreach ($info_list as $info): ?>
                     <div class="col-xs-12 col-sm-12 col-md-1 col-lg-3" style="text-align:center;">
                             <a href="" class="title">
                               <h4>{{ $info->judul_info }}</h4>
                             </a>
                             <span style="font-size: 12px; padding-left: 10px; text-align:left;">{{ $info->waktu_info }} - {{ $info->KategoriInfo->kategori_info }}</span>
                             <p style="text-align:center;">
                               <img src="{{ asset('images/info/'.$info->foto_info) }}" alt="{{ $info->judul_info }}" title="{{ $info->judul_info }}" style="width: 50%;">
                             </p>
                             <div class="caption maxheight2">
                               <div class="box_inner">
                                 <div class="box">
                                   <p>{{ $info->ringkasan_info }}</p>
                                 </div> 
                               </div>
                             </div>     
                     </div>
                 <?php endforeach ?>
         @else      
           <p>Tidak ada data berita </p>
         @endif      
         
         
         </div>    -->

        </div>

      </section>	
    </div>
@stop