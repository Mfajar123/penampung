@extends ('template')

@section ('main')
    <section class="content-header">
        <h1>Daftar Agenda</h1>
        <ol class="breadcrumb">
            <li>Home</li>
            <li class="active">Daftar Agenda</li>
        </ol>
    </section>

    <section class="content">
        @include('_partials.flash_message')
        <div class="box box-primary">
            <div class="box-header with-border">
                <a href="{{ route('admin.agenda.create') }}" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Tambah</a>
            </div>
            <div class="box-body">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </section>
@stop

@section('script')
    <script type="text/javascript">
        function confirm_delete() {
            return confirm('Anda yakin ingin menghapus data tersebut?');
        }

        var table = $(".table").DataTable({
			processing: true,
			serverSide: true,
			ajax: "{{ route('admin.agenda.datatable') }}",
			columns: [
                {'data': 'no'},
				{'data': 'judul'},
				{'data': 'tanggal_mulai'},
				{'data': 'tanggal_selesai'},
				{'data': 'action'},
			]
		});

        table.on('draw.dt', function () {
            var info = table.page.info();
            table.column(0, { search: 'applied', order: 'applied', page: 'applied' }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1 + info.start;
            });
        });
    </script>
@stop