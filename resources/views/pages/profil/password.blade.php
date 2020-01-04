@extends('template')

@section('main')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Ubah Password
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Ubah Password</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
  	<div class="col-xs-12">
  		<div class="box box-default">
  			<div class="box-header with-border">
  				<h3 class="box-title">Ubah Pasword
          </h3>
  			</div>
        
  			<div class="box-body">
  				<div class="row">
            <div class="col-xs-12">
                {!! Form::model($profil, ['method' => 'POST', 'route' => [$route, $id]]) !!}
                  @include('_partials.flash_message')
                  <div class="form-group">
                    {!! Form::label('password_lama', 'Password Lama', ['class' => 'control-label']) !!}
                    <div class="input-group">
                      {!! Form::password('password_lama', ['class' => 'form-control password', 'placeholder' => 'Password', 'required']) !!}

                      <div class="input-group-addon" style="cursor: pointer" onclick="password(this)">
                        <i class="fa fa-eye"></i>
                      </div>
                    </div>
                  </div>

                  <a href="javascript:void(0)" id="showPassword">Show / Hide Password Lama :</a>
                  <p id="getPassword" class="hide">{{ $password }}</p>

                  <div class="form-group">
                    {!! Form::label('password_baru', 'Password Baru', ['class' => 'control-label']) !!}
                    <div class="input-group">
                      {!! Form::password('password_baru', ['class' => 'form-control password', 'placeholder' => 'Password Baru', 'required']) !!}

                      <div class="input-group-addon" style="cursor: pointer" onclick="password(this)">
                        <i class="fa fa-eye"></i>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    {!! Form::label('konfirmasi_password', 'Konfirmasi Password Baru', ['class' => 'control-label']) !!}
                    <div class="input-group">
                      {!! Form::password('konfirmasi_password', ['class' => 'form-control password', 'placeholder' => 'Konfirmasi Password Baru', 'required']) !!}

                      <div class="input-group-addon" style="cursor: pointer" onclick="password(this)">
                        <i class="fa fa-eye"></i>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    @if(Request::segment(1) == 'admin')
                      <a href="{{ route('admin.home') }}" class="btn btn-default btn-sm">Kembali</i></a>
                    @elseif(Request::segment(1) == 'mahasiswa')
                      <a href="{{ route('mahasiswa.home') }}" class="btn btn-default btn-sm">Kembali</i></a>
                    @elseif(Request::segment(1) == 'dosen')
                      <a href="{{ route('dosen.home') }}" class="btn btn-default btn-sm">Kembali</i></a>
                    @endif
                    {!! Form::submit('Perbarui Password', ['class' => 'btn btn-primary btn-sm']) !!}
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
    function password(obj)
    {
      var pwd = $(obj).parent().find('.password');
      if(pwd.prop('type') == 'password')
      {
        pwd.prop('type', 'text');
      }
      else
      {
        pwd.prop('type', 'password');
      }
    }

    $('#showPassword').click(function(){
      if ($('#getPassword').attr('class') == 'hide') {

        $('#getPassword').attr('class', 'show');
      }else if($('#getPassword').attr('class') == 'show') {

        $('#getPassword').attr('class', 'hide');
      }
    });
  </script>
@endsection