@extends('template')



@section('main')

<!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>
          
        PENGUMUMAN

      </h1>

      <ol class="breadcrumb">

        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

        <li class="active">Pengumuman</li>

      </ol>

    </section>



    <!-- Main content -->

    <section class="content">
     
      <div class="row">

        <div class="col-md-12 col-xs-12">
          <div class="col-md-3 col-xs-12 col-sm-3 " style="margin-left: -15px;">
          
          </div>
            <div class="col-md-3 pull-right" style="margin-right: -15px;">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search By Name" name="search" id="pengumuman" value="{{ @$search }}">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-default" style="padding: 6px 12px;" id="search"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                </div>
        </div>
        <div style="clear:both;"></div> <br> 
    
        <div class="col-xs-12">
    
        
    
             <!--<div class="callout callout-info">
    
              <h4>Pengumuman</h4>
    
            </div> -->

        
        @foreach ( $pengumuman as $umum )
            <div class="box box-default">

              <div class="box-header with-border">

                <h3 class="box-title" style="color: black;">
                    <i class="fa fa-warning" style="color: #FFD700;"></i>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    {{ $umum->judul_pengumuman }} 
                    <span style="font-size: 12px; color: grey;">( <?php echo date('D, d-M-Y', strtotime($umum->waktu_pengumuman)) ;?> )</span>
                </h3>

                <div class="box-tools pull-right">

                  <button data-original-title="collapse" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Show / Hide"><i class="fa fa-minus"></i></button>

                  <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>

                </div>

              </div>



              <div class="box-body">
        @if($umum->foto_pengumuman != '')  
              <div class="col-md-3">
                <?php $hasil =  substr($umum->foto_pengumuman ,-4); ?>
                    @if( $hasil == '.pdf' )
                      <a href="{{ asset('images/pengumuman/'.$umum->foto_pengumuman) }}" target="_blank" style="font-size:20px;"><i class="fa fa-file-pdf-o"></i>File Pdf</a>
                    @elseif($hasil == '.doc')
                      <a href="{{ asset('images/pengumuman/'.$umum->foto_pengumuman) }}" target="_blank"><i class="fa fa-file-doc-o"></i>File Doc</a>
                    @elseif($hasil == '.docx')
                      <a href="{{ asset('images/pengumuman/'.$umum->foto_pengumuman) }}" target="_blank"><i class="fa fa-file-doc-o"></i>File Docx</a>
                    @else
                    <a target="_blank" href="{{ asset('images/pengumuman/'.$umum->foto_pengumuman) }}"><img src="{{ asset('images/pengumuman/'.$umum->foto_pengumuman) }}" alt="Foto Pendukung" class="img-responsive">Gambar
                    </a>
                    @endif
              </div>
         @endif
               <div class="col-md-9">{!! $umum->isi_pengumuman !!} </div>

                </ol>

              </div>

            </div>
        @endforeach
        </div>

        

      </div>

    </section>

    <!-- /.content -->
<script>  
    $('#search').click(function() {
            var pengumuman = $('#pengumuman').val();


            if(pengumuman == '')
            {
                document.location="{{ url('mahasiswa/pengumuman') }}";
            }
            else
            {
                document.location="{{ url('mahasiswa/pengumuman?search=') }}"+pengumuman;
            }
        });

</script>

@stop