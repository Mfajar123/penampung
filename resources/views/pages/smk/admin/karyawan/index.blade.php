@extends('template')



@section('main')

<!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        Karyawan

      </h1>

      <ol class="breadcrumb">

        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

        <li class="active">Karyawan</li>

      </ol>

    </section>



    <!-- Main content -->

    <section class="content">

      <div class="row">

      	<div class="col-xs-12">

          @include('_partials.flash_message')

      		<div class="box box-default">

      			<div class="box-header with-border">

      				<h3 class="box-title">Data Karyawan | <a href="{{ route('smk.admin.karyawan.trash') }}" class="text-primary">Trash</a>

              </h3>

                <a href="{{ route('smk.admin.karyawan.tambah') }}" class="btn btn-primary btn-sm pull-right" title="Tambah"><i class="fa fa-plus"></i></a>

      			</div>

            

      			<div class="box-body">

      				<div class="row">

                <div class="col-xs-12 table-responsive">

                    <table class="table table-striped karyawan">

                      <thead>

                        <tr>

                          <th width="15">No</th>

                          <th>Username</th>

                          <th>Nama Karyawan</th>

                          <th width="200">Tempat, Tanggal Lahir</th>

                          <th width="100">Jenis Kelamin</th>

                          <th width="200">Alamat</th>

                          <th width="130">Aksi</th>

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

        $(".karyawan").DataTable({

            processing: true,

            serverSide: true,

            ajax: "{{ route('smk.admin.karyawan.datatable') }}",

            columns: [

                {'data': 'no'},

                {'data': 'username'},

                {'data': 'nama'},

                {'data': 'ttl'},

                {'data': 'jenkel'},

                {'data': 'alamat'},

                {'data': 'aksi'},

            ]

        });

      });

    </script>

@stop