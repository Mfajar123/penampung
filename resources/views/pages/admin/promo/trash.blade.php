@extends('template')

@section('main')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Trash Promo
      </h1>
      <ol class="breadcrumb">
        <li>Home</li>
        <li>Promo</li>
        <li class="active">Trash Promo</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
      	<div class="col-xs-12">
          @include('_partials.flash_message')
      		<div class="box box-default">
      			<div class="box-header with-border">
      				<h3 class="box-title"><a href="{{ route('admin.promo') }}" class="text-primary">Data Promo </a>| Trash
              </h3>
      			</div>

      			<div class="box-body">
      				<div class="row">
                <div class="col-xs-12 table-responsive">
                    <table class="table table-striped promo">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Nama Promo</th>
                          <th>Diskon</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>

                      <tbody>

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
    <script type="text/javascript">
      $(document).ready(function(){
        $(".promo").DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.promo.trash.datatable') }}",
            columns: [
                {'data': 'no'},
                {'data': 'nama_promo'},
                {'data': 'diskon'},
                {'data': 'aksi'},
            ]
        });
      });
    </script>
@stop
