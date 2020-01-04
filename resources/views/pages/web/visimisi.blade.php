@extends('under')



@section('main')
	
	<!-- Content Header (Page header) -->
  <div class="container ">
  	 <section class="content-header col-md-12"  >

        <h1 class="pala">
          Visi & Misi

        </h1> 

        <ol class="breadcrumb">

          <li>Beranda</li>

          <li>Profil</li>

          <li >Visi & Misi</li>

        </ol>

      </section>
  	
  	<section class="content col-md-12" >

        <div class="row">
  		
      		<div class="col-xs-12 col-md-12 vimi">
      			
             <h3>Visi</h3>

             <p>Menjadi Yayasan unggulan dalam menghasilkan lulusan yang memiliki daya saing tinggi dan berjiwa entrepreneurship pada tahun 2020 di tingkat nasional.</p>

             <h3>Misi</h3>

             <ol>
                <li>Menyelenggarakan proses pendidikan secara profesional di bidang manajemen dan akuntansi sesuai kebutuhan masyarakat khususnya dalam pengembangan usaha mikro kecil dan menengah.</li>
                <li>Menyelenggarakan pendidikan untuk menciptakan peserta didik yang memiliki jiwa entrepreneurship yang ditopang oleh jiwa sosial.</li>
                <li>Melaksanakan kegiatan penelitian yang bermutu di bidang manajemen dan akuntansi.</li>
                <li>Melaksanakan kegiatan pengabdian masyarakat dalam rangka memberikan sumbangan dalam bentuk pemikiran, pemecahan masalah terhadap pengembangan usaha mikro, kecil dan menengah.</li>
                <li>Membangun kemitraan dengan lembaga yang terkait baik dalam maupun luar negeri dalam rangka pengembangan ilmu pengetahuan di bidang manajemen dan akuntansi.</li>
                <li>Meningkatkan kualitas sumberdaya manusia, baik dosen maupun karyawan untuk memberikan pelayanan yang prima.</li>
               <li> Mengembangkan sarana dan prasarana untuk mendukung proses pembelajaran yang berkualitas.</li>
             </ol>

             <h3>Tujuan</h3>
               <ol>
                  <li>Menghasilkan lulusan yang memiliki kemampuan manajerial dalam mengelola usaha.</li>
                  <li>Menghasilkan hasil penelitian di bidang manajemen dan akuntansi yang dapat dimanfaatkan oleh sipengguna.</li>
                  <li>Menghasilkan lulusan yang memiliki jiwa entrepreneurship yang ditopang oleh jiwa sosial.</li>
                  <li>Menghasilkan lulusan yang mampu melakukan kegiatan pengabdian masyarakat dalam rangka memberikan sumbangan dalam bentuk pemikiran, pemecahan masalah terhadap pengembangan usaha mikro, kecil dan menengah di wilayah Banten.</li>
                  <li>Terjalinnya kemitraan antara pihak-pihak terkait dalam rangka pengembangan ilmu pengetahuan di bidang manajemen dan akuntansi.</li>
                  <li>Tersedianya sumberdaya manusia yang profesional, baik dosen maupun karyawan untuk memberikan pelayanan yang prima.</li>
                  <li>Tersedianya sarana dan prasarana pembelajaran untuk mendukung proses pembelajaran yang berkualitas.</li>
               </ol>

            <h3>Sasaran</h3>
              <ol>
                <li>Meningkatkan standar mutu  pendidikan dan pengajaran.</li>
                <li>Meningkatkan kualitas penelitian dan pengabdian masyarakat dan berdaya guna bagi pengguna.</li>
                <li>Meningkatkan Tata kelola manajemen dan pengelolaan administrasi yang baik.</li>
                <li>Meningkatkan Lulusan yang berjiwa entrepreneurship.</li>
                <li>Meningkatkan kemitraan dengan pihak-pihak terkait dalam rangka  pengembangan ilmu pengetahuan dan sumberdaya manusia.</li>
                <li>Meningkatkan sarana dan prasarana pembelajaran yang berkualitas.</li>
             </ol>
           
      		</div>
<!-- 
          <div class="col-xs-12 col-md-12 ">
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


          </div>   
 -->
        </div>

      </section>	
    </div>
@stop