@extends('under')



@section('main')
	
	<!-- Content Header (Page header) -->
  <div class="container ">
  	 <section class="content-header col-md-12"  >

        <h1 class="pala">
         Kontak

        </h1> 

        <ol class="breadcrumb">

          <li>Beranda</li>

          <li>Fasilitas</li>

          <li >Kontak</li>

        </ol>

      </section>
  	
  	<section class="content col-md-12" >

        <div class="row">
          
           <div style="clear: both;"></div>
              <footer id="footer" style="background: white; border-top: 1px solid white; margin: 0;"> 
                <div class="container">
                  <div class="row">
                    <div class="footerbottom">
                      <div class="col-md-6 col-xs-12" style="color: black; margin-bottom: 30px;"> 
                     
                      @include('_partials.flash_message')
                        <h4 style="color: blue; margin: 0px 0px 20px 0px;">Hubungi Kami</h4> 
                        {!! Form::open(['method' => 'POST', 'route' => 'web.simpan', 'files' => 'true', 'id' => 'form']) !!}

                           <div class="form-group">
                              {!! Form::label('nama', 'Nama Lengkap', ['class' => 'control-label']) !!} <!-- <span>*</span> -->
                              {!! Form::text('nama', null, ['class' => 'form-control',  'autocomplete' => 'off', 'required']) !!}
                          </div>
                          <div class="form-group">
                              {!! Form::label('email', 'E-mail', ['class' => 'control-label']) !!} <!-- <span>*</span> -->
                              {!! Form::email('email', null, ['class' => 'form-control',  'autocomplete' => 'off', 'required']) !!}
                          </div>
                          <div class="form-group">
                              {!! Form::label('no_telp', 'No Telepon', ['class' => 'control-label']) !!} <!-- <span>*</span> -->
                              {!! Form::text('no_telp', null, ['class' => 'form-control',  'autocomplete' => 'off', 'required']) !!}
                          </div>
                          <div class="form-group">
                              {!! Form::label('subjek', 'Subjek', ['class' => 'control-label']) !!} <!-- <span>*</span> -->
                              {!! Form::text('subjek', null, ['class' => 'form-control',  'autocomplete' => 'off', 'required']) !!}
                          </div>
                          <div class="form-group">
                            {!! Form::label('pesan', 'Pesan', ['class' => 'control-label']) !!} <!-- <span>*</span> -->
                            {!! Form::textarea('pesan', null, ['class' => 'form-control', 'rows' => '5', 'autocomplete' => 'off', 'required']) !!}
                          </div>
                          <div class="form-group">
                             <p><div class="g-recaptcha" data-sitekey="6Ld6tE0UAAAAABPOhYKDIV-yaZDtGGOGUtUOh-M7"></div></p>
                          </div>
                          <div class="form-group">
                              <button type="submit" name="submit" class="btn btn-primary btn-sm" id="submit">Kirim Pesan</button>
                          </div>       
                      
                      </div>
                      <div class="col-md-6 col-xs-12" style="color: black; margin-bottom: 30px;"> 
                        <h4 style="color: blue; margin: 0px 0px 20px 0px;">Kontak Kami</h4> 
                        <p>Yayasan PPI Citra Raya Cikupa - Tangerang</p>
                        <div class="contact-info"> 
                          <i class="fa fa-map-marker"></i>Jl. Citra Raya Utama Barat, Griya Harsa II Blok i 10 no. 29, Cikupa 15710 - Tangerang.<br><br>
                          <i class="fa fa-phone"></i> 021-5961609 - 085100247554 <br><br>
                          <i class="fa fa-envelope-o"></i> info.stieppi@gmail.com
                        </div> 
                      </div>
                      <div class="col-md-12 col-xs-12" style="margin-bottom: 25px;"> 
                        <div class="footerwidget "> 
                          <h4 style="color: blue; margin: 0px 0px 25px 0px;">Map Yayasan PPI</h4> 
                          <div class="map-responsive">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7932.316618331018!2d106.5184735!3d-6.2428571!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x1128b14ba030cbf8!2sSekolah+Tinggi+Ilmu+Ekonomi+Putra+Perdana+Indonesia!5e0!3m2!1sid!2sid!4v1519792928399" width="600" height="450" frameborder="0" style="border:0" allowfullscreen title="Map Yayasan PPI"></iframe>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                <div class="clear"></div>
                <!--CLEAR FLOATS-->
              </div>

        </div>

      </section>	
    </div>
@stop

@section('script')
<script>
  $('#submit').click(function(){
    var response = $('textarea#g-recaptcha-response').val();
    if(response.length < 1)
    {   
      alert('Please Check ReCaptcha !');
      return false;
    }
  });
</script>
@endsection