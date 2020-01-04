@extends('template')

@section('main')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Semester
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Data Semester</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
      	<div class="col-xs-12">
          @include('_partials.flash_message')
      		<div class="box box-default">
      			<div class="box-header with-border">
      				<h3 class="box-title">Data Semester
              </h3>
                <a href="{{ route('admin.semester.tambah') }}" class="btn btn-primary btn-sm pull-right" title="Tambah"><i class="fa fa-plus"></i></a>
      			</div>
            
      			<div class="box-body">
      				<div class="row">
                <div class="col-xs-12 table-responsive">
                    <table class="table table-striped table-responsive DataTable">
                      <thead>
                        <tr>
                          <th>No.</th>
                          <th width="100">Kode Semester</th>
                          <th>Tanggal Mulai</th>
                          <th>Tanggal Mulai</th>
                          <th>Tahun</th>
                          <th>Tipe ( Ganjil / Genap )</th>
                          <th>Status</th>
                          <th width="100">Aksi</th>
                        </tr>
                      </thead>

                      <tbody>
                        @foreach($semester as $list)
                        <tr>
                          <td width="15" align="center">{{ $no++ }}</td>
                          <td>{{ $list->kode_semester }}</td>
                          <td>{{ $list->tgl_mulai }}</td>
                          <td>{{ $list->tgl_selesai }}</td>
                          <td>{{ $list->tahun }}</td>
                          <td>{{ $list->tipe }}</td>
                          <td>{{ $list->status }}</td>
                          <td align="center"><a href="{{ route('admin.semester.hapus', $list->id_semester) }}" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin akan menghapus semester {{ $list->tipe }} {{ $list->tahun }}')" title="Hapus"><i class="fa fa-trash-o"></i></a> @if($list->status == 'Aktif') <a href="javascript:void(0)" class="btn btn-success active btn-sm" disabled title="Aktif"><i class="fa fa-check"></i></a> @elseif($list->status == 'Tidak Aktif') <a href="{{ route('admin.semester.aktif', $list->id_semester) }}" class="btn btn-success btn-sm" title="Aktifkan"><i class="fa fa-check-circle"></i></a> @endif
                          
                        </td>
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
      $('.jurusan').change(function() {
          var id = $(this).val();
          var urlname = "{{ url('getProdi') }}/" + id;

          $.ajax({
              type: 'GET',
              url: urlname,
              success: function(data) {
                  $('.getProdi').html(data);
              }
          })
      })
  </script>
@endsection