@extends('template')

@section('main')
    <section class="content-header">
        <h1>Approve SKPI</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dosen SKPI</li>
        </ol><br>

            @if(session('hapus'))
            <div class="alert alert-danger" role="alert">
                {{session('hapus')}}
            </div>
            @endif

            @if(session('approved'))
            <div class="alert alert-success" role="alert">
                {{session('approved')}}
            </div>
            @endif
    </section>

    <section class="content">
        <p>Cari Data Skpi :</p>
        <div class="box box-default">
                <div class="box-header with-border">
                    <h4 class="box-title">Form Skpi</h4>
                </div><br>
<div class="container">            
        <div class="box-primary with-border">
        </div>
        <form action="{{route('dosen.skpi.cari')}}" method="GET">
            <input type="text" name="cari" placeholder="Cari Skpi .." value="{{ old('cari') }}">
            <input type="submit" value="CARI">
        </form>
        <br><p>
        <table class="table">
            <tr>
                <th>Nim</th>
                <th>Nama</th>
                <th>Sertifikat Ospek</th>
                <th>Sertifikat Seminar</th>
                <th>Sertifikat BNSP</th>
                <th>Status</th>
                <th>AKSI</th>
            </tr>
            @foreach($data_skpi as $data)
            <tr>
                <td>{{ $data->nim }}</td>
                <td>{{ $data->nama }}</td>
                {{-- 1 --}}
                <td>
                @if($data->sertifikat_ospek != '')  
                          <?php $view =  substr($data->sertifikat_ospek,-4); ?>
                              @if( $view == '.pdf' )
                                <a href="{{ asset('images/skpi/'.$data->sertifikat_ospek) }}" target="_blank" style="font-size:20px;"  alt="Responsive image"><i class="fa fa-file-pdf-o"></i>File Pdf</a>
                              @elseif($view == '.doc')
                                <a href="{{ asset('images/skpi/'.$data->sertifikat_ospek) }}" target="_blank"><i class="fa fa-file-doc-o"></i>File Doc</a>
                              @elseif($view == '.docx')
                                <a href="{{ asset('images/skpi/'.$data->sertifikat_ospek) }}" target="_blank"><i class="fa fa-file-doc-o"></i>File Docx</a>
                              @else
                              <a target="_blank" href="{{ asset('images/skpi/'.$data->sertifikat_ospek) }}"><img width="50px" src="{{ asset('images/skpi/'.$data->sertifikat_ospek) }}" alt="Foto Pendukung" class="img-responsive">
                              </a>
                              @endif
                   @endif</td>
                {{-- 2 --}}
                <td>
                        @if($data->sertifikat_seminar != '')  
                        <?php $view =  substr($data->sertifikat_seminar ,-4); ?>
                            @if( $view == '.pdf' )
                              <a href="{{ asset('images/skpi/'.$data->sertifikat_seminar) }}" target="_blank" style="font-size:20px;"><i class="fa fa-file-pdf-o"></i>File Pdf</a>
                            @elseif($view == '.doc')
                              <a href="{{ asset('images/skpi/'.$data->sertifikat_seminar) }}" target="_blank"><i class="fa fa-file-doc-o"></i>File Doc</a>
                            @elseif($view == '.docx')
                              <a href="{{ asset('images/skpi/'.$data->sertifikat_seminar) }}" target="_blank"><i class="fa fa-file-doc-o"></i>File Docx</a>
                            @else
                            <a target="_blank" href="{{ asset('images/skpi/'.$data->sertifikat_seminar) }}"><img width="50px" src="{{ asset('images/skpi/'.$data->sertifikat_seminar) }}" alt="Foto Pendukung" class="img-responsive">
                            </a>
                            @endif
                 @endif</td>
                {{-- 3 --}}
                <td>
                        @if($data->sertifikat_bnsp != '')  
                          <?php $view =  substr($data->sertifikat_bnsp ,-4); ?>
                              @if( $view == '.pdf' )
                                <a href="{{ asset('images/skpi/'.$data->sertifikat_bnsp) }}" target="_blank" style="font-size:20px;"><i class="fa fa-file-pdf-o"></i>File Pdf</a>
                              @elseif($view == '.doc')
                                <a href="{{ asset('images/skpi/'.$data->sertifikat_bnsp) }}" target="_blank"><i class="fa fa-file-doc-o"></i>File Doc</a>
                              @elseif($view == '.docx')
                                <a href="{{ asset('images/skpi/'.$data->sertifikat_bnsp) }}" target="_blank"><i class="fa fa-file-doc-o"></i>File Docx</a>
                              @else
                              <a target="_blank" href="{{ asset('images/skpi/'.$data->sertifikat_bnsp) }}"><img width="50px" src="{{ asset('images/skpi/'.$data->sertifikat_bnsp) }}" alt="Foto Pendukung" class="img-responsive">
                              </a>
                              @endif
                   @endif</td>
                   <td><strong>{{ $data->status }}</strong></td>
                   <td><a class="btn btn-info btn-sm" href="{{route('dosen.skpi.confirm',['$id'=>$data->id])}}">Approve</a>
                       <a class="btn btn-danger btn-sm fa fa-trash" href="{{route('dosen.skpi.hapus',['$id'=>$data->id])}}"></a>
                   </td>
                
            </tr>
            @endforeach</div>
        </table>
        <br/>
        Halaman : {{ $data_skpi->currentPage() }} <br/>
        Jumlah Data : {{ $data_skpi->total() }} <br/>
        Data Per Halaman : {{ $data_skpi->perPage() }} <br/>
       
        {{ $data_skpi->links() }}     
  </section>
@stop
