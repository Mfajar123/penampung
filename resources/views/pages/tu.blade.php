@extends('template')

@section('main')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        TU
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">TU</li>
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
      				<h3 class="box-title">Data TU
              </h3>
                <a href="" class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-target="#tambahTU">Tambah</a>
      			</div>
            
      			<div class="box-body">
      				<div class="row">
                <div class="col-xs-12 table-responsive">
                    <table class="table table-striped table-responsive DataTable">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Nama Lengkap</th>
                          <th>Tempat, Tanggal Lahir</th>
                          <th>Jenis Kelamin</th>
                          <th>Agama</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>

                      <tbody>
                        <?php $no = 1; ?>
                        @foreach($list_tu as $tu)
                        <tr>
                          <td>{{ $no }}</td>
                          <td>{{ $tu->nama }}</td>
                          <td>
                            @if($tu->tgl_lahir == null)
                              {{ $tu->tmp_lahir }}
                            @else
                              {{ $tu->tmp_lahir.", ".date('d M Y', strtotime($tu->tgl_lahir)) }}
                            @endif
                          </td>
                          <td>{{ $tu->jenkel }}</td>
                          <td>{{ $tu->agama }}</td>
                          <td><a href="#" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#id_{{ $tu->id_users }}">Ubah</a> <a href="{{ route('tu.delete', $tu->id_users) }}" class="btn btn-danger btn-sm">Hapus</a></td>
                        </tr>
                        <?php $no++; ?>
                        <!-- Modal -->
                          <div class="modal" id="id_{{ $tu->id_users }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content animated zoomIn">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                  <h4 class="modal-title" id="myModalLabel">Ubah Data TU</h4>
                                </div>
                                {!! Form::model($tu, ['method' => 'POST', 'route' => ['tu.ubah', $tu->id_users], 'files' => true]) !!}
                                <div class="modal-body">
                                      {!! Form::label('id_login', 'ID', ['class' => 'control-label']) !!}
                                      {!! Form::text('id_login', null, ['class' => 'form-control', 'disabled']) !!}

                                      {!! Form::label('nama', 'Nama Lengkap', ['class' => 'control-label']) !!}
                                      {!! Form::text('nama', null, ['class' => 'form-control', 'placeholder' => 'Nama Lengkap']) !!}
                                      @if ($errors->has('nama'))
                                        <span class="help-block">{{ $errors->first('nama') }}</span>
                                      @endif

                                      {!! Form::label('tmp_lahir', 'Tempat Lahir', ['class' => 'control-label']) !!}
                                      {!! Form::text('tmp_lahir', null, ['class' => 'form-control', 'placeholder' => 'Tempat Lahir']) !!}

                                      {!! Form::label('tgl_lahir', 'Tanggal Lahir', ['class' => 'control-label']) !!}
                                      {!! Form::text('tgl_lahir', null, ['class' => 'form-control date', 'placeholder' => 'Tanggal Lahir']) !!}

                                      {!! Form::label('jenkel', 'Jenis Kelamin', ['class' => 'control-label']) !!}
                                      {!! Form::select('jenkel', ['Pria' => 'Pria', 'Wanita' => 'Wanita'], null, ['class' => 'form-control']) !!}

                                      {!! Form::label('agama', 'Agama', ['class' => 'control-label']) !!}
                                      {!! Form::text('agama', null, ['class' => 'form-control', 'placeholder' => 'Agama']) !!}

                                      {!! Form::label('orang_tua', 'Nama Orang Tua', ['class' => 'control-label']) !!}
                                      {!! Form::text('orang_tua', null, ['class' => 'form-control', 'placeholder' => 'Nama Orang Tua']) !!}

                                      {!! Form::label('alamat', 'Alamat', ['class' => 'control-label']) !!}
                                      {!! Form::textarea('alamat', null, ['class' => 'form-control', 'placeholder' => 'Alamat', 'rows' => '2']) !!}

                                      {!! Form::label('no_telp', 'Nomor Telepon', ['class' => 'control-label']) !!}
                                      {!! Form::number('no_telp', null, ['class' => 'form-control', 'placeholder' => 'Nomor Telepon']) !!}
                                      @if ($errors->has('no_telp'))
                                        <span class="help-block">{{ $errors->first('no_telp') }}</span>
                                      @endif

                                      <input type="hidden" name="id_users" value="{{ $tu->id_users }}">
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
          <div class="modal" id="tambahTU" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content animated zoomIn">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel">Tambah Data</h4>
                </div>
                {!! Form::open(['method' => 'post', 'route' => 'tu.tambah', 'files' => true]) !!}
                <div class="modal-body">
                      {!! Form::label('id_login', 'ID Login', ['class' => 'control-label']) !!}
                      <input type="text" name="id_login" class="form-control" value="{{ date('YHis') }}" readonly>
                      @if ($errors->has('id_login'))
                        <span class="help-block">{{ $errors->first('id_login') }}</span>
                      @endif

                      {!! Form::label('nama', 'Nama Lengkap', ['class' => 'control-label']) !!}
                      {!! Form::text('nama', null, ['class' => 'form-control', 'placeholder' => 'Nama Lengkap']) !!}
                      @if ($errors->has('nama'))
                        <span class="help-block">{{ $errors->first('nama') }}</span>
                      @endif
                      </select>

                      {!! Form::label('no_telp', 'Nomor Telepon', ['class' => 'control-label']) !!}
                      {!! Form::number('no_telp', null, ['class' => 'form-control', 'placeholder' => 'Nomor Telepon']) !!}
                      @if ($errors->has('no_telp'))
                        <span class="help-block">{{ $errors->first('no_telp') }}</span>
                      @endif

                      {!! Form::label('foto_profil', 'Foto', ['class' => 'control-label']) !!}
                      {!! Form::file('foto_profil', ['class' => 'form-control']) !!}
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