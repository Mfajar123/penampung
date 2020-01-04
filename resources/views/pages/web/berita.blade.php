@extends('under')



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
      		<div class="col-xs-12 col-md-9" style=" height: auto;" >

            <h3 style="margin: 20px 0px;">{{ $info->judul_info }}</h3>

            <span style="font-style: italic;">{{ $info->waktu_info }} - {{ $info->KategoriInfo->kategori_info}}</span>
             
            <img src="{{ asset('images/info/'.$info->foto_utama) }}" alt="" style="float: left; margin: 0px 20px 20px 0px;" >

            <p >{{ $info->isi_info }}</p>

      		</div>
        @else      
          <p>Tidak ada data berita </p>
        @endif 


      @if (!empty($list))
        <?php foreach ($list as $lain): ?>
          <div class="col-md-3 col-xs-12 kotak_detail_berita" >
          <a href="{{ route('web.berita', $lain->id_info) }}" class="detail_berita">
            <img src="{{ asset('images/info/'.$lain->foto_utama) }}" alt="" >
            <h4>{{ $lain->judul_info }}</h4>
             <span style="font-style: italic;">{{ $info->waktu_info }} - {{ $info->KategoriInfo->kategori_info}}</span>
          </a>
          </div>
        <?php endforeach ?>
        @else      
          <p>Tidak ada data berita </p>
        @endif 

        </div>
        @if(!empty($fotkung))      
            <h4>File / Foto Pendukung</h4>
              <div class="row">
                @foreach( $fotkung as $fk )
                  <div class="col-md-2">
                    <?php $hasil =  substr($fk->nama_foto ,-4); ?>
                    @if( $hasil == '.pdf' )
                      <a href="{{ asset('images/info/'.$fk->nama_foto) }}" target="_blank" style="font-size:20px;"><i class="fa fa-file-pdf-o"></i>File Pdf</a>
                    @elseif($hasil == '.doc')
                      <a href="{{ asset('images/info/'.$fk->nama_foto) }}" target="_blank"><i class="fa fa-file-doc-o"></i>File Doc</a>
                    @elseif($hasil == '.docx')
                      <a href="{{ asset('images/info/'.$fk->nama_foto) }}" target="_blank"><i class="fa fa-file-doc-o"></i>File Docx</a>
                    @else
                    <img src="{{ asset('images/info/'.$fk->nama_foto) }}" alt="Foto Pendukung">Gambar
                    @endif
                  </div>
                @endforeach
              </div>
        @else
        
        @endif

      </section>	
    </div>
@stop