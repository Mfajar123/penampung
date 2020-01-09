@extends('template')

@section('main')
	<section class="content-header">
        <h1><b>Approve SKPI<b></h1>
        <div class="col-md-4"></div>
        <div class="col-md-4"></div>
        <div class="col-md-4" align="right">
                <form class="form-inline" action="{{route('dosen.skpi.cari')}}" method="GET">
                    <input type="text" class="form-control" id="search">
                <button type="submit" class="btn btn-primary mb-2">Cari</button>
                </form>
        </div>
    </section>
    <br><p>
	<section class="content">
        <!--konten gambar-->
        
        @foreach ( $data_skpi as $data )
        <div class="col-md-4">    
            <div class="box box-default">

            <div class="box-header with-border">

                <h3 class="box-title" style="color: black;">
                    <i class="fa fa-file" style="color: #FFD700;"></i>
                    Sertifikat Ospek
                </h3>
              </div>


              <div class="box-body">
        @if($data->sertifikat_ospek != '')  
              <div class="col-md-12">
                <?php $view =  substr($data->sertifikat_ospek ,-4); ?>
                    @if( $view == '.pdf' )
                      <a href="{{ asset('images/skpi/'.$data->sertifikat_ospek) }}" target="_blank" style="font-size:20px;"><i class="fa fa-file-pdf-o"></i>File Pdf</a>
                    @elseif($view == '.doc')
                      <a href="{{ asset('images/skpi/'.$data->sertifikat_ospek) }}" target="_blank"><i class="fa fa-file-doc-o"></i>File Doc</a>
                    @elseif($view == '.docx')
                      <a href="{{ asset('images/skpi/'.$data->sertifikat_ospek) }}" target="_blank"><i class="fa fa-file-doc-o"></i>File Docx</a>
                    @else
                    <a target="_blank" href="{{ asset('images/skpi/'.$data->sertifikat_ospek) }}"><img src="{{ asset('images/skpi/'.$data->sertifikat_ospek) }}" alt="Foto Pendukung" class="img-responsive">
                    </a>
                    @endif
              </div>
         @endif

                </ol>

              </div>

            </div></div>

            <!--sertifikat seminar-->
            <div class="col-md-4">    
                    <div class="box box-default">
        
                    <div class="box-header with-border">
        
                        <h3 class="box-title" style="color: black;">
                            <i class="fa fa-file" style="color: #FFD700;"></i>
                            Sertifikat Seminar
                        </h3>
                      </div>
        
        
                      <div class="box-body">
                @if($data->sertifikat_seminar != '')  
                      <div class="col-md-12">
                        <?php $view =  substr($data->sertifikat_seminar ,-4); ?>
                            @if( $view == '.pdf' )
                              <a href="{{ asset('images/skpi/'.$data->sertifikat_seminar) }}" target="_blank" style="font-size:20px;"><i class="fa fa-file-pdf-o"></i>File Pdf</a>
                            @elseif($view == '.doc')
                              <a href="{{ asset('images/skpi/'.$data->sertifikat_seminar) }}" target="_blank"><i class="fa fa-file-doc-o"></i>File Doc</a>
                            @elseif($view == '.docx')
                              <a href="{{ asset('images/skpi/'.$data->sertifikat_seminar) }}" target="_blank"><i class="fa fa-file-doc-o"></i>File Docx</a>
                            @else
                            <a target="_blank" href="{{ asset('images/skpi/'.$data->sertifikat_seminar) }}"><img src="{{ asset('images/skpi/'.$data->sertifikat_seminar) }}" alt="Foto Pendukung" class="img-responsive">
                            </a>
                            @endif
                      </div>
                 @endif
        
                        </ol>
        
                      </div>
        
                    </div></div>
            <!--end seminar-->

            <!--sertifikat bnsp-->
            <div class="col-md-4">    
                    <div class="box box-default">
        
                    <div class="box-header with-border">
        
                        <h3 class="box-title" style="color: black;">
                            <i class="fa fa-file" style="color: #FFD700;"></i>
                            Sertifikat BNSP
                        </h3>
                      </div>
        
        
                      <div class="box-body">
                @if($data->sertifikat_bnsp != '')  
                      <div class="col-md-12">
                        <?php $view =  substr($data->sertifikat_bnsp,-4); ?>
                            @if( $view == '.pdf' )
                              <a href="{{ asset('images/skpi/'.$data->sertifikat_bnsp) }}" target="_blank" style="font-size:20px;"><i class="fa fa-file-pdf-o"></i>File Pdf</a>
                            @elseif($view == '.doc')
                              <a href="{{ asset('images/skpi/'.$data->sertifikat_bnsp) }}" target="_blank"><i class="fa fa-file-doc-o"></i>File Doc</a>
                            @elseif($view == '.docx')
                              <a href="{{ asset('images/skpi/'.$data->sertifikat_bnsp) }}" target="_blank"><i class="fa fa-file-doc-o"></i>File Docx</a>
                            @else
                            <a target="_blank" href="{{ asset('images/skpi/'.$data->sertifikat_bnsp) }}"><img src="{{ asset('images/skpi/'.$data->sertifikat_bnsp) }}" alt="Foto Pendukung" class="img-responsive">
                            </a>
                            @endif
                      </div>
                 @endif
        
                        </ol>
        
                      </div>
        
                    </div></div>
            <!--end bnsp-->
        @endforeach
        </div>
        <!--end konten gambar-->
    </div>        
            
    </section>
@stop
