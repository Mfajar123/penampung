@extends('template')

@section('main')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Kelas
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Kelas</li>
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
      				<h3 class="box-title">Data Kelas
              </h3>
                <a href="" class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-target="#tambahKelas">Tambah</a>
      			</div>
            
      			<div class="box-body">
      				<div class="row">
                <div class="col-xs-12 table-responsive">
                    <table class="table table-striped table-responsive DataTable">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Nama Kelas</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>

                      <tbody>
                        <?php $no = 1; ?>
                        @foreach($kelas as $list)
                        <tr>
                          <td>{{ $no }}</td>
                          <td>{{ $list->nama_kelas }}</td>
                          <td><a href="#" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#id_{{ $list->id_kelas }}">Ubah</a> <a href="{{ route('kelas.delete', $list->id_kelas) }}" class="btn btn-danger btn-sm">Hapus</a></td>
                        </tr>
                        <?php $no++; ?>
                        <!-- Modal -->
                          <div class="modal" id="id_{{ $list->id_kelas }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content animated zoomIn">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                  <h4 class="modal-title" id="myModalLabel">Ubah Kelas</h4>
                                </div>
                                {!! Form::model($list, ['method' => 'POST', 'route' => ['kelas.ubah', $list->id_kelas], 'files' => true]) !!}
                                <div class="modal-body">
                                      {!! Form::label('nama_kelas', 'Nama Kelas', ['class' => 'control-label']) !!}
                                      {!! Form::text('nama_kelas', null, ['class' => 'form-control', 'placeholder' => 'Nama Kelas']) !!}
                                      @if ($errors->has('nama_kelas'))
                                        <span class="help-block">{{ $errors->first('nama_kelas') }}</span>
                                      @endif

                                      <input type="hidden" name="id_kelas" value="{{ $list->id_kelas }}">
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
          <div class="modal" id="tambahKelas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content animated zoomIn">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel">Tambah Data</h4>
                </div>
                {!! Form::open(['method' => 'post', 'route' => 'kelas.tambah', 'files' => true]) !!}
                <div class="modal-body">
                      {!! Form::label('nama_kelas', 'Nama Kelas', ['class' => 'control-label']) !!}
                      {!! Form::text('nama_kelas', null, ['class' => 'form-control', 'placeholder' => 'Nama Kelas']) !!}
                      @if ($errors->has('nama_kelas'))
                        <span class="help-block">{{ $errors->first('nama_kelas') }}</span>
                      @endif

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