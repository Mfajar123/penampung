@extends('pages.smk.smk')



@section('main')

   <div class="prllx col-md-12 col-xs-12"  style="margin-top: 80px; padding: 0px;">
    <div style="margin: 200px 20px 65px 0px;">
     <div class=" col-xs-6 col-md-3" style="background: rgba(255, 255, 255, 0.7); border-radius: 5%; margin-left: 30px;">
        <p style="margin-top: 20px; color: blue;" ><img src="{{asset('images/logo/smk.png')}}" alt="Logo Yayasan PPI" style="width: 100%" ></p>
        <p style="font-style: italic; margin-bottom: 20px; color: black; " >"Sekolah Menengah Kejuruan yang   di dirikan oleh Yayasan PPI untuk  menciptakan lulusan lulusan yang  siap kerja ataupun  meneruskan  kejenjang pendidikan yang lebih tinggi."</p>
   </div>      
   </div>
    </div> 

     <div>
      <h2 style="color: #15c008; text-align: center; margin: 40px 0px 0px 0px; ">Kejuruan</h2>
         <div class="container bss" style="margin-top: 0px; padding: 0px; border-bottom: 1px solid #15c008;">
           <a href="" class="col-md-4 col-xs-12 col-sm-12 col-lg-4" target="_blank">
             <div class="konten" >
                 <span><img src="{{asset('images/logo/tkj.png')}}"  alt="Logo SMK PPI" title="Logo SMK PPI"></span>
                  <div class="bisaa">
                   <h4>Tekhnnik Komputer Jaringan</h4>
                   <h5>SMK Putra Perdana Indonesia</h5>
                 </div>
             </div>
           </a>
       
           <a href="http://stieppi.ac.id" class="col-md-4 col-xs-12 col-sm-12  col-lg-4" target="_blank">
             <div class="konten">
                 <span><img src="{{asset('images/logo/akuntansi.png')}}"  alt="Logo STIE PPI" title="Logo STIE PPI"></span>
                 <div class="bisaa">
                   <h4>Akuntansi</h4>
                   <h5>SMK Putra Perdana Indonesia</h5>
                 </div> 
             </div>
           </a>
       
            <a href="mahasiswa" class="col-md-4 col-xs-12 col-sm-12 col-lg-4" target="_blank">
             <div class="konten">
                 <span><img src="{{asset('images/logo/admperkantoran.png')}}"  alt="Logo STIE PPI" title="Logo STIE PPI" ></span>
                 <div class="bisaa">
                   <h4>Administrasi Perkantoran</h4>
                   <h5>SMK Putra Perdana Indonesia</h5>
                 </div>
             </div>
           </a>
         </div>
       </div>

        
 
    @if (!empty($info_list)) 
      <div class="container" style="margin-top: 20px 0px;  border-bottom: 1px solid blue; ">
        <h2 style="color: blue; text-align: center; margin: 40px 0px 20px 0px; "> Berita dan Informasi</h2>
        <div class="row">
         <?php foreach ($info_list as $info): ?>

          <div class="col-md-4 col-sm-4 col-xs-6" style="height: 350px; margin-bottom: 30px;" >
              <div class="ambang" style="padding-bottom: 10px;">
                <p>
                  <img src="{{ asset('images/info/'.$info->foto_info) }}" alt="{{ $info->judul_info }}" title="{{ $info->judul_info }}" class="img-thumbnail img-responsive" style=" max-height: 220px; width: 100%; "  >
                </p>
                <div style="padding-left: 5px;">  
                  <a href="{{ route('smk.web.berita', $info->id_info) }}">
                    <h3 style="margin: 10px 0px;" >{{ $info->judul_info }}</h3>
                  </a>
                  <span style="font-size: 12px; ">{{ $info->SMKKategoriInfo->kategori_info }} - {{ date('d-m-Y', strtotime($info->waktu_info)) }}</span>
                  <p style="color: black;">{{ $info->ringkasan_info }}</p>
                </div>
              </div>
          </div>
 <?php endforeach ?>
        </div>
      </div>
   @else      
     <p>Tidak ada data berita </p>
   @endif 




@if (!empty($gallery_list))  
  <h2 style="color: yellow; text-align: center; margin: 40px 0px 0px 0px; "> Gallery</h2>
    <section>

      <div class="container gal-container" >
          <?php foreach ($gallery_list as $gallery): ?>
          <div class="col-md-4 col-sm-6 co-xs-6 gal-item">
            <div class="box">
              <a href="#" data-toggle="modal" data-target="#{{$gallery->id_info}}">
                <img src="{{ asset('images/info/'.$gallery->foto_info) }}">
              </a>
              <div class="modal fade" id="{{$gallery->id_info}}" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <div class="modal-body">
                      <img src="{{ asset('images/info/'.$gallery->foto_info) }}">
                    </div>
                      <div class="col-md-12 description">
                        <h4>{{ $gallery->judul_info }}</h4>
                      </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php endforeach ?>
        </div>
      </div>
    </section>
@else      
  <p>Tidak ada data berita </p>
@endif 
      


    
    <footer style="padding: 0px; margin-top: 30px; background: black;">
    <div class="footer">
      <div class="container">
        <div class="row">
          <div class="col-md-3 col-xs-6">
            <h3 style="color: blue;" class="foot"><img src="{{ asset('images/logo/smk.png') }}" class="img-responsive"/></h3>
          </div>
          <div class="col-md-3 col-xs-6">
            <h3 style="color: blue;" class="foot">Kontak Kami</h3> 
            <p style="text-align: center; color:black;">SMK PPI Citra Raya Cikupa - Tangerang</p>
            <div class="contact-info" style="text-align: center; color: #ccc;"> 
              <i class="fa fa-map-marker"></i>Jl. Citra Raya Utama Barat, Griya Harsa II Blok i 10 no. 29, Cikupa 15710 - Tangerang.<br><br>
              <i class="fa fa-phone"></i> 021-5961609 - 085100247554 <br><br>
            </div> 
          </div>
          <div class="col-md-6 col-xs-12">
            <h3 style="color: blue;" class="foot">Map</h3> 
             <div class="map-responsive">
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7932.316618331018!2d106.5184735!3d-6.2428571!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x1128b14ba030cbf8!2sSekolah+Tinggi+Ilmu+Ekonomi+Putra+Perdana+Indonesia!5e0!3m2!1sid!2sid!4v1519792928399" width="600" height="450" frameborder="0" style="border:0" allowfullscreen title="Map Yayasan PPI"></iframe>
              </div>
          </div>
        </div>
      </div>
    </div>
    



    <div style="clear: both;"></div>


   
@stop