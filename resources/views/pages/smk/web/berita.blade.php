@extends('pages.smk.smk')


@section('main')
	
	<!-- Content Header (Page header) -->
  <div class="container ">
  	 <section class="content-header col-md-12"  >

        <h1 class="pala">
         Berita

        </h1> 

        <ol class="breadcrumb">

          <li>Beranda</li>

          <li>Berita</li>

          <li>Detail Berita</li>

        </ol>

      </section>
  	
  	<section class="content col-md-12" style="margin-top: 20px;" >

        <div class="row">
        
        @if (!empty($info))
      		<div class="col-xs-12 col-md-9"  >

            <h3 style="margin: 20px 0px;">{{ $info->judul_info }}</h3>

            <span style="font-style: italic;">{{ $info->waktu_info }} - {{ $info->SMKKategoriInfo->kategori_info}}</span>
             
            <img src="{{ asset('images/info/'.$info->foto_info) }}" alt="" style="float: left; margin: 0px 20px 20px 0px;" >

            <p style="font-size: 15px;" >{{ $info->isi_info }}</p>

      		</div>
        @else      
          <p>Tidak ada data berita </p>
        @endif 


      @if (!empty($list))
        <?php foreach ($list as $lain): ?>
          <div class="col-md-3 col-xs-12 kotak_detail_berita" style="border-left: 1px solid #ccc;" >
          <a href="{{ route('smk.web.berita', $lain->id_info) }}" class="detail_berita">
            <img src="{{ asset('images/info/'.$lain->foto_info) }}" alt="" >
            <h4>{{ $lain->judul_info }}</h4>
             <span style="font-style: italic;">{{ $info->waktu_info }} - {{ $info->SMKKategoriInfo->kategori_info}}</span>
          </a>
          </div>
        <?php endforeach ?>
        @else      
          <p>Tidak ada data berita </p>
        @endif 

        </div>

      </section>	
    </div>
@stop