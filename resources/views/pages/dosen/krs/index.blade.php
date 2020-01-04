@extends('template')

@section('main')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        KRS Mahasiswa
      </h1>
      <ol class="breadcrumb">
        <li>Home</li>
        <li class="active">KRS Mahasiswa</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
      	<div class="col-xs-12">
          @include('_partials.flash_message')
      		<div class="box box-default">
      			<div class="box-header with-border">
      				<h3 class="box-title">Data KRS</h3>
              <div class="pull-right">
                <form class="form-inline">
                  <div class="form-group">
                    <select class="form-control select2" name="tahun_akademik">
                        <option value="#"> Pilih Tahun Akademik </option>
                        @foreach($tahun_akademik as $tahun)
                        <option value="{{$tahun->tahun_akademik}}" id="txt_tahun_akademik" {{ $tahun->tahun_akademik == @$_GET['tahun_akademik'] ? 'selected' : ''}}>{{$tahun->keterangan}}</option>
                        @endforeach
                    </select>
                  </div>
                  <button type="submit" class="btn btn-primary">Cari</button>
                </form>
              </div>
      			</div>

      			<div class="box-body">
      				<div class="row">                 
              <br>
                <div class="col-xs-12 table-responsive">
                    <table class="table table-bordered table-striped krs">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>NIM</th>
                          <th>Nama</th>
                          <th>Prodi</th>
                          <th>Semester</th>
                          <th>Status</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <?php $no=1;?>
                      @if(count($mahasiswa))
                      <tbody>
                        @foreach($mahasiswa as $m)
                        <tr>
                          <td>{{$no++}}</td>
                          <td>{{$m->nim}}</td>
                          <td>{{$m->nama}}</td>
                          <td>{{$m->prodi->nama_prodi}}</td>
                          <td>{{$m->semester->semester_ke}}</td>
                          <td>  
                            @if($m->status == "N")
                            <p class="text-danger">Tidak Disetujui</p>
                            @elseif($m->status == "Y")
                            <p class="text-success">Disetujui</p>
                            @else
                            <p class="text-warning">Pending</p>
                            @endif
                          </td>
                          <td>
                            @if($m->status == 'N' OR $m->status == 'Y' )
                            <a href="{{url('dosen/krs/detail?id='.$m->id_krs.'&nim='.$m->nim.'&tahun_akademik='.$_GET['tahun_akademik'])}}" class="btn btn-primary btn-sm"><i class="fa fa-search"></i> Detail</a>
                            @else
                            <a href="{{route('dosen.krs.setuju', $m->id_krs)}}" class="btn btn-success btn-sm"><i class="fa fa-check"></i> Setuju</a>
                            <a href="{{route('dosen.krs.tolak', $m->id_krs)}}" class="btn btn-danger btn-sm"><i class="fa fa-ban"></i> Tidak</a>
                            @if (!empty($m->file_surat))
                            <a href="{{ url('/files/surat/'.$m->file_surat) }}" class="btn btn-info btn-sm" target="_blank"><i class="fa fa-search"></i> Lihat Surat</a>
                            @endif
                             <a href="{{url('dosen/krs/detail?id='.$m->id_krs.'&nim='.$m->nim.'&tahun_akademik='.$_GET['tahun_akademik'])}}" class="btn btn-primary btn-sm"><i class="fa fa-search"></i> Detail</a>
                            @endif
                            <!-- <a href="{{url('dosen/krs/detail?id='.$m->id_krs.'&nim='.$m->nim.'&tahun_akademik='.$_GET['tahun_akademik'])}}" class="btn btn-primary btn-sm"><i class="fa fa-search"></i> Detail</a>
                            <a href="{{route('dosen.krs.setuju', $m->id_krs)}}" class="btn btn-success btn-sm"><i class="fa fa-check"></i> Setuju</a>
                            <a href="{{route('dosen.krs.tolak', $m->id_krs)}}" class="btn btn-danger btn-sm"><i class="fa fa-ban"></i> Tidak</a> -->
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                      
                      @else
                      <tbody>
                        <tr>
                          <td colspan="6">Tidak Ada Data</td>
                        </tr>
                      </tbody>
                      @endif
                    </table>
                </div>
              </div>
      			</div>
      		</div>
      	</div>
      </div>
    </section>
    <script type="text/javascript">
      $(document).ready(function(){
        $(".krs").DataTable();
      });
    </script>
@stop
