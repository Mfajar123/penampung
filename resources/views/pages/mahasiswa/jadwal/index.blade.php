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
                    <table class="table table-bordered table-striped jadwal">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Hari/Jam</th>
                          <th>Ruang</th>
                          <th>Kelas</th>
                          <th>Matkul</th>
                          <th>Dosen</th>
                        </tr>
                      </thead>
                      <tbody>
                        @if(count($list_jadwal))
                          <?php $no = 1; ?>
                          @foreach ($list_jadwal as $jadwal)
                            <tr>
                              <td>{{ $no++ }}</td>
                              <td>
                                {{ $jadwal->nama_hari }}<br>
                                {{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}
                              </td>
                              <td>{{ $jadwal->kode_ruang }}</td>
                              <td>{{ $jadwal->kode_kelas }} - {{ $jadwal->nama_kelas }}</td>
                              <td>{{ $jadwal->kode_matkul }} - {{ $jadwal->nama_matkul }}</td>
                              <td>{{ $jadwal->nip }} - {{ $jadwal->nama }}</td>
                            </tr>
                          @endforeach
                        @else
                        <tr>
                          <td colspan="6">Tidak ada data</td>
                        </tr>
                        @endif
                      </tbody>
                    </table>
                      <a href="{{ route('mahasiswa.jadwal.print', $t) }}" class="btn btn-default" target="_blank" style="text-align: right;"><i class="fa fa-print"></i>Print</a>
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
