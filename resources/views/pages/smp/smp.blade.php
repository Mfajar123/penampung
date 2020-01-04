
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SMP PPI</title>
  <link rel="shortcut icon" href="{{ asset('images/logo/ppi.png')}} ">
  <link rel="stylesheet" media="screen" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
  <link rel="stylesheet" href="{{ asset('plugins/assets/css/bootstrap.min.css')}} ">
  <link rel="stylesheet" href="{{ asset('plugins/assets/css/font-awesome.min.css')}}"> 
  <link rel="stylesheet" href="{{ asset('plugins/assets/css/bootstrap-theme.css')}}" media="screen"> 
  <link rel="stylesheet" href="{{ asset('css/model.css') }}">
  <link rel="stylesheet" href="{{ asset('css/animate.css')}}">
  <!-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css"> -->
  <link rel="stylesheet" type="text/css" href="{{asset('plugins/gallery/css/lightgallery.css')}}">
</head>
<body>
  <!-- Fixed navbar -->

  <div class="navbar navbar-inverse navbar-fixed-top" style="border-bottom: 2px solid yellow;">
    <div class="container" >
      <div class="navbar-header" >
        <!-- Button for smallest screens -->
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
        <a class="navbar-brand" href="" style="margin: 0px; padding: 0px;">
          <img src="{{asset('images/logo/smp.png')}}" alt="Logo Yayasan PPI" style="width: 90%" ></a>
      </div>
      <div class="navbar-collapse collapse" >
        <ul class="nav navbar-nav pull-right mainNav"  >
            <li><a href="{{route('smp.web.beranda')}}" style="color: black;">Beranda</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color: black;"  >Profil<b class="caret"></b></a>
              <ul class="dropdown-menu " style="background: black;">
                <li><a href="{{ route('smp.web.sejarah')}}">Sejarah</a></li>
                <li><a href="{{ route('smp.web.tentang_kami')}}">Tentang Kami</a></li>
                <li><a href="{{ route('smp.web.visimisi')}}">Visi & Misi</a></li>
              </ul>
            </li>
            <li><a href="{{ route('smp.web.struktur')}}" style="color: black;">Struktur</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color: black;"  >Fasilitas<b class="caret"></b></a>
              <ul class="dropdown-menu" style="background: black;">
                <li><a href="{{ route('smp.web.perpustakaan')}}">Perpustakaan</a></li>
                <li><a href="{{ route('smp.web.lab_komputer')}}">Lab Komputer</a></li>
                <li><a href="{{ route('smp.web.ruang_kelas_ac')}}">Ruang Kelas Ber AC</a></li>
                <li><a href="{{ route('smp.web.masjid')}}">Masjid</a></li>
                <li><a href="{{ route('smp.web.studio_musik')}}">Studio Musik</a></li>
                <li><a href="{{ route('smp.web.free_wifi')}}">Free Wifi</a></li>
                <li><a href="{{ route('smp.web.atm_center')}}">ATM Center</a></li>
                <li><a href="{{ route('smp.web.radio_ppi')}}">Radio PPI</a></li>
                <li><a href="{{ route('smp.web.kantin')}}">Kantin</a></li>
              </ul>
            </li>
            <li><a href="{{route('smk.web.kontak')}}" style="color: black;">Kontak</a></li>
        </ul>
      </div>
      <!--/.nav-collapse -->
    </div>
  </div>
  <div class="container" >
    <span class="shadow" style="margin-left: 30px;"></span>
  </div>

   
 <!--  <div id="tombolScrollTop">
   <nav class="navbar navbar-default navbar-fixed-top" style="background: #fff; z-index:99; ">
     <div class="container">
       <div class="navbar-header" style="z-index: 99;">
       Button for smallest screens
         <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
         <a class="navbar-brand" href="#" style="margin: 0px; padding: 0px;">
           <img src="{{asset('images/logo/logo.png')}}" alt="Logo Yayasan PPI" style="width: 60%" ></a>
       </div>
       <div class="navbar-collapse collapse">
         <ul class="nav navbar-nav pull-right mainNav"  >
           <li><a href="{{route('web.beranda')}}" style="color: black;">Beranda</a></li>
           <li class="dropdown">
             <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color: black;" >Profil<b class="caret"></b></a>
             <ul class="dropdown-menu " style="background: black;">
               <li><a href="{{ route('web.sejarah')}}">Sejarah</a></li>
               <li><a href="{{ route('web.tentang_kami')}}">Tentang Kami</a></li>
               <li><a href="{{ route('web.visimisi')}}">Visi & Misi</a></li>
             </ul>
           </li>
           <li><a href="{{ route('web.struktur')}}" style="color: black;">Struktur</a></li>
           <li class="dropdown">
             <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color: black;"  >Fasilitas<b class="caret"></b></a>
             <ul class="dropdown-menu  " style="background: black;">
               <li><a href="{{ route('web.perpustakaan')}}">Perpustakaan</a></li>
               <li><a href="{{ route('web.lab_komputer')}}">Lab Komputer</a></li>
               <li><a href="{{ route('web.ruang_kelas_ac')}}">Ruang Kelas Ber AC</a></li>
               <li><a href="{{ route('web.masjid')}}">Masjid</a></li>
               <li><a href="{{ route('web.studio_musik')}}">Studio Musik</a></li>
               <li><a href="{{ route('web.free_wifi')}}">Free Wifi</a></li>
               <li><a href="{{ route('web.atm_center')}}">ATM Center</a></li>
               <li><a href="{{ route('web.radio_ppi')}}">Radio PPI</a></li>
               <li><a href="{{ route('web.kantin')}}">Kantin</a></li>
             </ul>
           </li>
           <li><a href="{{route('web.kontak')}}" style="color: black;">Kontak</a></li>
           <li>
             <a href="#"  onclick="scrolltotop()"> 
               <img src="{{asset('images/fitur/top.png')}}" alt="Scrool To Top" >
             </a>
           </li>
         </ul>
       </div>
     </div>
   </nav>
 </div> -->
  
  @yield('main')
<div class="ftr" style="padding: 0px;">
   
 

     <div class="footer2">
        <div class="container">
          <div class="row">
            <div class="col-md-6 panel">
              <div class="panel-body">
                <p class="simplenav">
                  <a href="{{ route('smp.web.beranda')}}" >Beranda</a></li> |
                  <a href="{{ route('smp.web.tentang_kami')}}">Tentang</a> |
                  <a href="{{ route('smp.web.sejarah')}}">Sejarah</a> |
                  <a href="{{ route('smp.web.struktur')}}" >Struktur</a> |  
                </p>
              </div>
            </div>
            <!--  <a href="#"  onclick="scrolltotop()" id="tombolScrollTop"> 
              <img src="{{asset('images/fitur/top3.png')}}" alt="Scrool To Top" width="50%;" class="img-responsive" >
            </a> -->
            <div class="col-md-6 panel">
              <div class="panel-body">
                <p class="text-right">
                  Copyright &copy;  SMP PPI Powered By<a href="http://cnplus.biz" target="_blank" rel="develop">CNPLUS</a>
                </p>
              </div>
            </div>  
          </div>

          <!-- /row of panels -->
        </div>
       
      </div>
    </div>

  <!-- JavaScript libs are placed at the end of the document so the pages load faster -->
   <script type='text/javascript' src='{{asset("plugins/assets/js/jquery.min.js")}}'></script>
   <script type="text/javascript" src="http://yayasanppi.net/plugins/assets/js/modernizr-latest.js"></script> 
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script type='text/javascript' src='http://yayasanppi.net/plugins/assets/js/fancybox/jquery.fancybox.pack.js'></script>
    <script type='text/javascript' src='http://yayasanppi.net/plugins/assets/js/jquery.mobile.customized.min.js'></script>
    <script type='text/javascript' src='http://yayasanppi.net/plugins/assets/js/jquery.easing.1.3.js'></script> 
    <script type='text/javascript' src="http://yayasanppi.net/plugins/assets/js/bootstrap.min.js"></script>
    <script type='text/javascript' src="http://yayasanppi.net/plugins/assets/js/custom.js"></script>
  <script src='https://www.google.com/recaptcha/api.js'></script>
  <script type='text/javascript' src='{{asset("js/jquery.min.js")}}'></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js"></script>
  <script type="text/javascript" src="{{asset('plugins/gallery/js/lightgallery.js')}}"></script>
  <script type="text/javascript" src="{{asset('plugins/assets/js/modernizr-latest.js')}}"></script> 

    <script>

       $(document).ready(function(){
        $(window).scroll(function(){
          if ($(window).scrollTop() > 100) {
            $('#tombolScrollTop').fadeIn();
          } else {
            $('#tombolScrollTop').fadeOut();
          }
        });
      });

      function scrolltotop()
      {
        $('html, body').animate({scrollTop : 0},500);
      }
        
          $('#lightgallery').lightGallery({
              thumbnail : true,
              selector : '.img'
          });

      
         
</script>  
<style>
  #tombolScrollTop
{
  cursor: pointer;
  position:fixed;
  left:90%;
  bottom:20px;

  border-radius:100%;
  height:90px;
  width:90px;
  font-size:15px;
  display:none;
}
</style>
</body>
</html>
