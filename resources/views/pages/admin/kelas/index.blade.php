@extends('template')

@section('main')
    <section class="content-header">
        <h1>Data Kelas</h1>
    </section>

    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="box-title">
                    <a href="{{ route('admin.kelas.tambah') }}" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Tambah</a>
                    <a class="btn btn-primary" data-toggle="modal" href='#modal-filter'><i class="fa fa-filter"></i> Filter</a>                  
                </div>
            </div>
            <div class="box-body">
                <table class="table table-striped table-bordered" width="100%">
                    <thead>
                        <tr>
                            <th width="30">No.</th>
                            <th nowrap>Tahun Akademik</th>
                            <th nowrap>Program Studi</th>
                            <th nowrap>Kode Kelas</th>
                            <th nowrap>Nama Kelas</th>
                            <th nowrap>Waktu Kuliah</th>
                            <th nowrap>Kapasitas</th>
                            <th nowrap>Terisi</th>
                            <th width="200">Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </section>

    <div class="modal fade" id="modal-filter">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Filter</h4>
                </div>
                {!! Form::open(['id' => 'form_filter', 'method' => 'POST']) !!}
                    <div class="modal-body">
                        <div class="form-group">
                            {!! Form::label('id_tahun_akademik', 'Tahun Akademik', ['class' => 'control-label']) !!}
                            {!! Form::select('id_tahun_akademik', $list_tahun_akademik, null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('id_prodi', 'Program Studi', ['class' => 'control-label']) !!}
                            {!! Form::select('id_prodi', $list_prodi, null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">OK</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop

@section('script')
    <script type="text/javascript">
        var modalFilter = $("#modal-filter");

        var table = $(".table").DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.kelas.datatable') }}",
            columns: [
                {'data': 'no'},
                {'data': 'tahun_akademik'},
                {'data': 'nama_prodi'},
                {'data': 'kode_kelas'},
                {'data': 'nama_kelas'},
                {'data': 'nama_waktu_kuliah'},
                {'data': 'kapasitas'},
                {'data': 'terisi'},
                {'data': null}
            ],
            columnDefs: [{
                targets: -1,
                data: null,
                defaultContent: '\
                    <button type="button" class="btn btn-info btn-detail btn-sm"><i class="fa fa-search"></i> Detail</button>\
                    <button type="button" class="btn btn-success btn-absen btn-sm"><i class="fa fa-users"></i> Buat Absen</button>\
                    <button type="button" class="btn btn-warning btn-edit btn-sm"><i class="fa fa-edit"></i> Edit</button>\
                    <button type="button" class="btn btn-danger btn-hapus btn-sm"><i class="fa fa-trash"></i> Hapus</button>\
                '
            }]
        });

        $("#form_filter").on("submit", function (e) {
            var formData = $(this).serialize();

            table.ajax.url("{{ route('admin.kelas.datatable') }}?" + formData).load();
            
            modalFilter.modal('hide');

            e.preventDefault();
        });

        $(".table tbody").on("click", ".btn-detail", function () {
            var data = table.row($(this).parents('tr')).data();
            
            document.location="{{ route('admin.kelas') }}/"+data.id_kelas+"/detail";
        });
        
         $(".table tbody").on("click", ".btn-absen", function () {
            var data = table.row($(this).parents('tr')).data();
            
            document.location="{{ route('admin.kelas') }}/"+data.id_kelas+"/no_absen";
        });
        
        $(".table tbody").on("click", ".btn-edit", function () {
            var data = table.row($(this).parents('tr')).data();
            
            document.location="{{ route('admin.kelas') }}/"+data.id_kelas+"/ubah";
        });

        $(".table tbody").on("click", ".btn-hapus", function () {
            var data = table.row($(this).parents('tr')).data();

            if (confirm("Anda yakin ingin menghapus data kelas?")) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('admin.kelas') }}/"+data.id_kelas+"/hapus",
                    success: function (data) {
                        alert("Data kelas berhasil dihapus.");
                        table.ajax.reload();
                    }
                });
            }
        });
    </script>
@stop