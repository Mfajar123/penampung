@extends('template')
@section('main')
    <section class="content-header">
        <h1>Data Pendaftar</h1>
    </section>

    <section class="content">
        @include('_partials.flash_message')
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="box-title">Data</div>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered datatable" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>                                
                                <th>Alamat</th>
                                <th>Tempat Lahir</th>
                                <th>Tanggal Lahir</th>
                                <th>Jenis Kelamin</th>
                                <th>Provinsi</th>
                                <th>No Telp</th>
                                <th>Asal Sekolah</th>                                                 
                                <th>Prodi</th>
                                <th>Waktu Kuliah</th>
                                <th>Tanggal Daftar</th>
                                <th>ID Daftar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($list_pendaftar as $pendaftar)
                                <tr>
                                    <td>{{ $pendaftar->kd_daftar }}</td>
                                    <td>{{ $pendaftar->nama }}</td>
                                    <td>{{ $pendaftar->alamat }}</td>
                                    <td>{{ $pendaftar->tempat_lahir }}</td>
                                    <td>{{ $pendaftar->tgl_lahir }}</td>
                                    <td>{{ ($pendaftar->jenis_kelamin == 'L' ? 'Laki - Laki' : 'Perempuan') }}</td>
                                    <td>{{ $pendaftar->provinsi->nama_provinsi }}</td>
                                    <td>{{ $pendaftar->no_telp }}</td>  
                                    <td>{{ $pendaftar->asal_sekolah }}</td>                             
                                    <td>{{ @$pendaftar->prodi->nama_prodi }}</td>
                                    <td>{{ @$pendaftar->waktu_kuliah->nama_waktu_kuliah }}</td>
                                    <td>{{ $pendaftar->tgl_daftar }}</td>
                                    <td>{{ ($pendaftar->id_daftar ?? '-') }}</td>
                                    <td>
                                        @if (empty($pendaftar->id_daftar))
                                            <a href="{{ route('pendaftar.transfer', $pendaftar->kd_daftar) }}" class="btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i> Pendaftaran</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="transferModal" tabindex="-1" role="dialog" aria-labelledby="transferModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="transferModalLabel"><i class="fa fa-plus-circle"></i> Pendaftaran</h4>
        </div>
        <div class="modal-body">
            {!! Form::open(['method' => 'POST']) !!}
                <div class="form-group">

                </div>
            {!! Form::close() !!}
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
        </div>
        </div>
    </div>
    </div>
@endsection
