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
          @include('_partials.flash_message')
      		<div class="box box-default">
      			<div class="box-header with-border">
      				<h3 class="box-title"><a href="{{ route('admin.jadwal') }}" class="text-primary">Data Jadwal</a> | Trash
              </h3>
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
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <?php $no=1; ?>
                      <tbody>
                        @foreach($jadwal as $list)
                        <tr>
                          <td>{{$no++}}</td>
                          <td>{{$list->hari}}<br>{{date('H:i', strtotime($list->jam_mulai)).'-'.date('H:i', strtotime($list->jam_selesai))}}</td>
                          <td>{{$list->ruang->kode_ruang}}</td>
                          <td>{{$list->matkul->kode_matkul.'-'.$list->matkul->nama_matkul}}<br>{{$list->matkul->sks.' sks'}}</td>
                          <td>{{$list->dosen->nama}}<br>{{$list->dosen->nip}}</td>
                          <td>
                            <a href="{{route('admin.jadwal.restore', $list->id_jadwal)}}" class="btn btn-success btn-sm" title="Restore" onclick="return confirm('Anda Yakin Akan Mengembalikan Data jadwal ?')" title="Restore"><i class="fa fa-mail-reply"></i></a>
                            <a href="{{route( 'admin.jadwal.hapus.permanent', $list->id_jadwal)}}" class="btn btn-danger btn-sm"  title="Hapus Permanen"onclick="return confirm('Anda Yakin Akan Menghapus Permanen jadwal ?')" title="Hapus Permanen"><i class="fa fa-trash-o"></i></a>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                </div>
              </div>
      			</div>
      		</div>
      	</div>
      </div>
    </section>
    <!-- /.content -->
@stop
