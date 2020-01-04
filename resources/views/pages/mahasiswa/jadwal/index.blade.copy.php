@extends('template')

@section('main')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Jadwal
      </h1>
      <ol class="breadcrumb">
        <li>Home</li>
        <li class="active">Jadwal</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
      	<div class="col-xs-12">
      		<div class="box box-default">
      			<div class="box-header with-border">
      				<h3 class="box-title">Data Jadwal</h3>
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
                <div class="col-xs-12 table-responsive">
                    <table class="table table-striped jadwal">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Hari/Jam</th>
                          <th>Ruang</th>
                          <th>Matkul</th>
                          <th>Dosen</th>
                        </tr>
                      </thead>
                      <tbody>
                        @if(count($jadwal))
                        @foreach($jadwal as $j)
                        <tr>
                          <td>{{$no++}}</td>
                          <td>{{! empty($j->hari) ? $j->hari : '-'}}<br>{{date('H:i', strtotime($j->jam_mulai)).'-'.date('H:i', strtotime($j->jam_selesai))}}</td>
                          <td>{{! empty($j->ruang->kode_ruang) ? $j->ruang->kode_ruang : '-'}}</td>
                          <td>{{! empty($j->matkul->kode_matkul) ? $j->matkul->kode_matkul : '-'.'-'.! empty($j->matkul->nama_matkul) ? $j->matkul->nama_matkul : '-'}}<br>{{$j->matkul->sks.' sks'}}</td>
                          <td>{{! empty($j->dosen->nama) ? $j->dosen->nama : '-'}}<br>{{! empty($j->dosen->nip) ? $j->dosen->nip : '-'}}</td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                          <td colspan="5">tidak ada data</td>
                        </tr>
                        @endif
                      </tbody>
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
        $('.select2').select2();
      });
</script>
@stop
