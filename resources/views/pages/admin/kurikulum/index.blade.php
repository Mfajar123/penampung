@extends('template')

@section('main')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Kurikulum
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Data Kurikulum</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
      	<div class="col-xs-12">
          @include('_partials.flash_message')
      		<div class="box box-default">
      			<div class="box-header with-border">
      				<h3 class="box-title">Data Kurikulum
              </h3>
                <a href="{{ route('admin.kurikulum.tambah') }}" class="btn btn-primary btn-sm pull-right" title="Tambah"><i class="fa fa-plus"></i></a>
      			</div>
            
      			<div class="box-body">
      				<div class="row">
                <div class="col-xs-12 table-responsive">
                    <table class="table table-striped table-responsive DataTable">
                      <thead>
                        <tr>
                          <th width="100">Kode Kurikulum</th>
                          <th>Program Studi</th>
                          <th>Jurusan</th>
                          <th>Tahun</th>
                          <th>Nama</th>
                          <th>SK Rektor</th>
                          <th width="100">Aksi</th>
                        </tr>
                      </thead>

                      <tbody>
                        @foreach($kurikulum as $list)
                        <tr>
                          <td>{{ $list->kode_kurikulum }}</td>
                          <td>{{ $list->jurusan->nama_jurusan }}</td>
                          <td>{{ $list->jurusan->fakultas->nama_fakultas }}</td>
                          <td>{{ $list->tahun }}</td>
                          <td>{{ $list->nama_kurikulum }}</td>
                          <td>{{ $list->sk_rektor }}</td>
                          <td align="center">
                            <a href="{{ route('admin.kurikulum.ubah', $list->id_kurikulum) }}" class="btn btn-warning btn-sm" title="Ubah"><i class="fa fa-edit"></i></a> <a href="{{ route('admin.kurikulum.hapus', $list->id_kurikulum) }}" class="btn btn-danger btn-sm" onclick="return confirm('Apa anda yakin akan menghapus {{ $list->nama_kurikulum }}')" title="Hapus"><i class="fa fa-trash-o"></i></a></td>
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

@section('script')
  <script type="text/javascript">
      $('.fakultas').change(function() {
          var id = $(this).val();
          var urlname = "{{ url('admin/kurikulum/getJurusan') }}/" + id;

          $.ajax({
              type: 'GET',
              url: urlname,
              success: function(data) {
                  $('.getJurusan').html(data);
              }
          })
      })
  </script>
@endsection