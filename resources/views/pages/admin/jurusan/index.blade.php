@extends('template')

@section('main')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Jurusan
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Jurusan</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
      	<div class="col-xs-12">
          @include('_partials.flash_message')
      		<div class="box box-default">
      			<div class="box-header with-border">
      				<h3 class="box-title">Data Jurusan
              </h3>
                <a href="{{ route('admin.jurusan.tambah') }}" class="btn btn-primary btn-sm pull-right" title="Tambah"><i class="fa fa-plus"></i></a>
      			</div>
            
      			<div class="box-body">
      				<div class="row">
                <div class="col-xs-12 table-responsive">
                    <table class="table table-striped table-responsive DataTable">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Nama Jurusan</th>
                          <th>Nama Fakultas</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>

                      <tbody>
                        <?php $no = 1; ?>
                        @foreach($jurusan as $list)
                        <tr>
                          <td>{{ $no }}</td>
                          <td>{{ $list->nama_jurusan }}</td>
                          <td>{{ $list->fakultas->nama_fakultas }}</td>
                          <td align="center"><a href="{{ route('admin.jurusan.ubah', $list->id_jurusan) }}" class="btn btn-warning btn-sm" title="Ubah"><i class="fa fa-edit"></i></a> <a href="{{ route('admin.jurusan.hapus', $list->id_jurusan) }}" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin akan menghapus jurusan {{ $list->nama_jurusan }}')" title="Hapus"><i class="fa fa-trash-o"></i></a></td>
                        </tr>
                        <?php $no++; ?>
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

<!-- Modal -->
<div class="modal" id="ubah" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content animated zoomIn">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Ubah Data</h4>
      </div>
      <div class="data">
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    $('#ubah').on('show.bs.modal', function(e){
      var id = $(e.relatedTarget).data('jurusan');
      $.ajax({
        type: 'GET',
        url: "{{ url('admin/jurusan/ubah') }}/"+id,
        success: function(url){
          $('.data').html(url);
        }
      });
    });
  });
</script>
@stop