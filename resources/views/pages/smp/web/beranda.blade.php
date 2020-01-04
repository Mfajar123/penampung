@extends('pages.smp.smp')



@section('main')

   <div class=" col-md-12 col-xs-12"  style="margin-top: 80px; padding: 0px;">
    <div style="margin: 200px 20px 65px 0px;">
     <div class=" col-xs-6 col-md-3" style="background: rgba(255, 255, 255, 0.7); border-radius: 5%; margin-left: 30px;">
       <p style="margin-top: 20px; color: blue;" ><img src="{{asset('images/logo/smp.png')}}" alt="Logo SMP PPI" style="width: 100%" ></p>
      <p style="font-style: italic; margin-bottom: 20px; color: black; " >"Sekolah Menengah Pertama yang   di dirikan oleh Yayasan PPI untuk  menciptakan lulusan lulusan yang  siap  meneruskan  kejenjang pendidikan yang lebih tinggi."</p>
   </div>      
   </div>
    </div> 

     <!--<div>
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
-->
        
 
    @if (!empty($info_list)) 
      <div class="container" style="margin-top: 20px; margin-bottom: 20px; border-bottom: 1px solid blue; ">
        <h2 style="color: blue; text-align: center; margin: 40px 0px 20px 0px; "> Berita dan Informasi</h2>
        <div class="row">
         <?php foreach ($info_list as $info): ?>

          <div class="col-md-4 col-xs-12" style="margin-bottom: 0px; height: 350px; ">
              <div class="ambang" style="padding-bottom: 10px;">
                <p>
                  <img src="{{ asset('images/info/'.$info->foto_info) }}" alt="{{ $info->judul_info }}" title="{{ $info->judul_info }}" class="img-thumbnail img-responsive" style=" height: 220px; width: 100%; "  >
                </p>
                <div style="padding-left: 5px;">  
                  <a href="{{ route('web.berita', $info->id_info) }}">
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


  
  <h2 style="color: yellow; text-align: center; margin: 40px 0px 0px 0px; "> Gallery</h2>
    <section>
      <div class="container gal-container" style="border-bottom: 1px solid yellow; padding: 10px 0px;">
          <div class="col-md-4 col-sm-6 co-xs-6 gal-item"  style="padding: 15px;">
            <div class="box">
              <a href="#" data-toggle="modal" data-target="#2">
                <img src="{{ asset('images/smk/siluet.jpeg') }}">
              </a>
              <div class="modal fade" id="2" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <div class="modal-body">
                      <img src="{{ asset('images/smk/siluet.jpeg') }}">
                    </div>
                      <div class="col-md-12 description">
                        <h4>This is the second one on my Gallery</h4>
                      </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-sm-6 co-xs-6 gal-item" style="padding: 15px;">
            <div class="box">
              <a href="#" data-toggle="modal" data-target="#3">
                <img src="{{ asset('images/smk/siluet.jpeg') }}">
              </a>
              <div class="modal fade" id="3" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <div class="modal-body">
                      <img src="{{ asset('images/smk/siluet.jpeg') }}">
                    </div>
                      <div class="col-md-12 description">
                        <h4>This is the third one on my Gallery</h4>
                      </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-sm-6 co-xs-6 gal-item" style="padding: 15px;">
            <div class="box">
              <a href="#" data-toggle="modal" data-target="#4">
                <img src="{{ asset('images/smk/siluet.jpeg') }}">
              </a>
              <div class="modal fade" id="4" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <div class="modal-body">
                      <img src="{{ asset('images/smk/siluet.jpeg') }}">
                    </div>
                      <div class="col-md-12 description">
                        <h4>This is the fourth one on my Gallery</h4>
                      </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-sm-6 co-xs-6 gal-item" style="padding: 15px;">
            <div class="box">
              <a href="#" data-toggle="modal" data-target="#5">
                <img src="{{ asset('images/smk/siluet.jpeg') }}">
              </a>
              <div class="modal fade" id="5" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <div class="modal-body">
                      <img src="{{ asset('images/smk/siluet.jpeg') }}">
                    </div>
                      <div class="col-md-12 description">
                        <h4>This is the fifth one on my Gallery</h4>
                      </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-sm-6 co-xs-6 gal-item" style="padding: 15px;">
            <div class="box">
              <a href="#" data-toggle="modal" data-target="#6">
                <img src="{{ asset('images/smk/siluet.jpeg') }}">
              </a>
              <div class="modal fade" id="6" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <div class="modal-body">
                      <img src="{{ asset('images/smk/siluet.jpeg') }}">
                    </div>
                      <div class="col-md-12 description">
                        <h4>This is the sixth one on my Gallery</h4>
                      </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-sm-6 co-xs-6 gal-item" style="padding: 15px;">
            <div class="box">
              <a href="#" data-toggle="modal" data-target="#7">
                <img src="{{ asset('images/smk/siluet.jpeg') }}">
              </a>
              <div class="modal fade" id="7" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <div class="modal-body">
                      <img src="{{ asset('images/smk/siluet.jpeg') }}">
                    </div>
                      <div class="col-md-12 description">
                        <h4>This is the seventh one on my Gallery</h4>
                      </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

      


    
    <footer style="padding: 0px; margin: 0px; background: black;">
    <div class="footer">
      <div class="container">
        <div class="row">
          <div class="col-md-3 col-xs-6">
            <h3 style="color: blue;" class="foot"><img src="{{ asset('images/logo/smp.png') }}" class="img-responsive"/></h3>
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