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
                  @foreach($view as $pwd)
                    @if(Request::segment(1) == 'mahasiswa')
                      <?php $var = $pwd->nim ?>
                    @endif
                    {!! Form::model($pwd, ['method' => 'POST', 'route' => ['mahasiswa.password.ubah', $var]]) !!}
                      @include('_partials.flash_message')
                      <div class="form-group">
                        {!! Form::label('password_lama', 'Password Lama', ['class' => 'control-label']) !!}
                        {!! Form::password('password_lama', ['class' => 'form-control', 'placeholder' => 'Password']) !!}
                        @if ($errors->has('password_lama'))
                          <span class="help-block">{{ $errors->first('password_lama') }}</span>
                        @endif
                      </div>

                      <a href="javascript:void(0)" id="showPassword">Show / Hide Password Lama :</a>
                      <p id="getPassword" class="hide">{{ $password }}</p>

                      <div class="form-group">
                        {!! Form::label('password_baru', 'Password Baru', ['class' => 'control-label']) !!}
                        {!! Form::password('password_baru', ['class' => 'form-control', 'placeholder' => 'Password Baru']) !!}
                        @if ($errors->has('password_baru'))
                          <span class="help-block">{{ $errors->first('password_baru') }}</span>
                        @endif
                      </div>
                      
                      <div class="form-group">
                        {!! Form::label('konfirmasi_password', 'Konfirmasi Password Baru', ['class' => 'control-label']) !!}
                        {!! Form::password('konfirmasi_password', ['class' => 'form-control', 'placeholder' => 'Konfirmasi Password Baru']) !!}
                        @if ($errors->has('konfirmasi_password'))
                          <span class="help-block">{{ $errors->first('konfirmasi_password') }}</span>
                        @endif
                      </div>
                      <div class="form-group">
                        {!! Form::submit('Perbarui Password', ['class' => 'btn btn-primary']) !!}
                        @if(Request::segment(1) == 'mahasiswa')
                          {!! link_to('/mahasiswa/', 'Batal', ['class' => 'btn btn-default']) !!}
                        @endif
                      </div>
                    {!! Form::close() !!}

                    @section('script')
                      <script type="text/javascript">
                        $('#showPassword').click(function(){
                          if ($('#getPassword').attr('class') == 'hide') {

                            $('#getPassword').attr('class', 'show');
                          }else if($('#getPassword').attr('class') == 'show') {

                            $('#getPassword').attr('class', 'hide');
                          }
                        })
                      </script>
                    @endsection
                  @endforeach
                </div>
              </div>
      			</div>
      		</div>
      	</div>
      </div>
    </section>
    <!-- /.content -->

@stop