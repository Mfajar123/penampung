@extends('template')

@section('main')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Profil
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Profil</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
      	<div class="col-xs-12">
          @if (Session::has('flash_message'))
            <div class="alert alert-danger alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              {{ Session::get('flash_message') }}
            </div>
          @endif
      		<div class="box box-default">
      			<div class="box-header with-border">
      				<h3 class="box-title">Data Dosen
              </h3>
                <a href="" class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-target="#tambahDosen" data-tooltip="tooltip" data-placement="top" title="Tambah"><i class="fa fa-plus"></i></a>
      			</div>
            
      			<div class="box-body">
      				<div class="row">
                <div class="col-xs-12 table-responsive">
                    <table class="table table-striped table-responsive DataTable">
                      <thead>
                        <tr>
                          <th>NIDN</th>
                          <th>NIP</th>
                          <th>Nama Dosen</th>
                          <th>Tempat, Tanggal Lahir</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>

                      <tbody>
                        @foreach($list_dsn as $dsn)
                        <tr>
                          <td>{{ $dsn->nidn }}</td>
                          <td>{{ $dsn->nip }}</td>
                          <td>{{ $dsn->nama }}</td>
                          <td>
                            @if($dsn->tgl_lahir == null)
                              {{ $dsn->tmp_lahir }}
                            @else
                              {{ $dsn->tmp_lahir.", ".date('d F Y', strtotime($dsn->tgl_lahir)) }}
                            @endif
                          </td>
                          <td><a href="#" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#id_{{ $dsn->nip }}" data-tooltip="tooltip" data-placement="top" title="Ubah"><i class="fa fa-edit"></i></a> <a href="{{ route('dosen.delete', $dsn->nip) }}" class="btn btn-danger btn-sm" data-tooltip="tooltip" data-placement="top" title="Hapus"><i class="fa fa-trash-o"></i></a></td>
                        </tr>
                        <!-- Modal -->
                          <div class="modal" id="id_{{ $dsn->nip }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content animated zoomIn">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                  <h4 class="modal-title" id="myModalLabel">Ubah Data Dosen</h4>
                                </div>
                                {!! Form::model($dsn, ['method' => 'POST', 'route' => ['dosen.ubah', $dsn->id_users], 'files' => true]) !!}
                                <div class="modal-body">

                                      {!! Form::label('nip', 'NIP *', ['class' => 'control-label']) !!}
                                      {!! Form::number('nip', null, ['class' => 'form-control', 'placeholder' => 'NIP', 'disabled']) !!}

                                      {!! Form::label('nidn', 'NIDN *', ['class' => 'control-label']) !!}
                                      {!! Form::number('nidn', null, ['class' => 'form-control', 'placeholder' => 'NIDN', 'disabled']) !!}


                                      {!! Form::label('nama', 'Nama Dosen *', ['class' => 'control-label']) !!}
                                      {!! Form::text('nama', null, ['class' => 'form-control', 'placeholder' => 'Nama Lengkap', 'autocomplete' => 'off']) !!}

                                      {!! Form::label('id_matkul', 'Matakuliah', ['class' => 'control-label']) !!}
                                      {!! Form::select('id_matkul', $Matkul, null, ['class' => 'form-control', 'placeholder' => '-- Pilih Matakuliah --']) !!}

                                      {!! Form::label('tmp_lahir', 'Tempat Lahir', ['class' => 'control-label']) !!}
                                      {!! Form::text('tmp_lahir', null, ['class' => 'form-control', 'placeholder' => 'Tempat Lahir', 'autocomplete' => 'off']) !!}

                                      {!! Form::label('tgl_lahir', 'Tanggal Lahir', ['class' => 'control-label']) !!}
                                      {!! Form::text('tgl_lahir', null, ['class' => 'form-control date', 'placeholder' => 'Tanggal Lahir', 'autocomplete' => 'off']) !!}

                                      {!! Form::label('jenkel', 'Jenis Kelamin', ['class' => 'control-label']) !!}
                                      {!! Form::select('jenkel', ['Pria' => 'Pria', 'Wanita' => 'Wanita'], null, ['class' => 'form-control']) !!}

                                      {!! Form::label('alamat', 'Alamat', ['class' => 'control-label']) !!}
                                      {!! Form::textarea('alamat', null, ['class' => 'form-control', 'placeholder' => 'Alamat', 'rows' => '2', 'autocomplete' => 'off']) !!}

                                      {!! Form::label('no_telp', 'Nomor Telepon', ['class' => 'control-label']) !!}
                                      {!! Form::number('no_telp', null, ['class' => 'form-control', 'placeholder' => 'Nomor Telepon', 'autocomplete' => 'off']) !!}

                                      <input type="hidden" name="nip" value="{{ $dsn->nip }}">
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                  {!! Form::submit('Ubah Data', ['class' => 'btn btn-primary']) !!}
                                </div>
                                {!! Form::close() !!}
                              </div>
                            </div>
                          </div>
                        @endforeach
                      </tbody>
                    </table>
                </div>
              </div>
      			</div>
            <!-- Modal -->
          <div class="modal" id="tambahDosen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content animated zoomIn">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel">Tambah Data</h4>
                </div>
                {!! Form::open(['method' => 'post', 'route' => 'dosen.tambah', 'files' => true]) !!}
                <div class="modal-body">

                      {!! Form::label('nip', 'NIP *', ['class' => 'control-label']) !!}
                      {!! Form::number('nip', null, ['class' => 'form-control', 'placeholder' => 'NIP', 'autocomplete' => 'off']) !!}

                      {!! Form::label('nidn', 'NIDN *', ['class' => 'control-label']) !!}
                      {!! Form::number('nidn', null, ['class' => 'form-control', 'placeholder' => 'NIDN', 'autocomplete' => 'off']) !!}

                      {!! Form::label('nama', 'Nama Dosen *', ['class' => 'control-label']) !!}
                      {!! Form::text('nama', null, ['class' => 'form-control', 'placeholder' => 'Nama Lengkap', 'autocomplete' => 'off']) !!}

                      {!! Form::label('no_telp', 'Nomor Telepon', ['class' => 'control-label']) !!}
                      {!! Form::number('no_telp', null, ['class' => 'form-control', 'placeholder' => 'Nomor Telepon', 'autocomplete' => 'off']) !!}

                      {!! Form::label('foto_profil', 'Foto', ['class' => 'control-label']) !!}
                      {!! Form::file('foto_profil', ['class' => 'form-control', 'accept' => 'image/*']) !!}
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  {!! Form::submit('Tambah Data', ['class' => 'btn btn-primary']) !!}
                </div>
                
                {!! Form::close() !!}
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