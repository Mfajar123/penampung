<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Akademik Portal</title>
    <link rel="shortcut icon" href="../images/logo/ppi.png">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/font-awesome/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/animate.css') }}" integrity="sha384-OHBBOqpYHNsIqQy8hL1U+8OXf9hH6QRxi0+EODezv82DfnZoV7qoHAZDwMwEJvSw"
  crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">

    <link href="{{ url('https://fonts.googleapis.com/css?family=Raleway:100,600')}}" rel="stylesheet" type="text/css">

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/akademik.js') }}"></script>
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
     <div class="navbar-header">
      @if(Request::segment(1) == 'mahasiswa')
        <a class="navbar-brand " href="#" style="margin: 0px; padding: 0px;">
            <img src="{{ asset('images/logo/logo.png') }}" style="width: 60%;">
        </a>
      @elseif(Request::segment(1) == 'dosen')
        <a class="navbar-brand " href="#" style="margin: 0px; padding: 0px;">
            <img src="{{ asset('images/logo/logo.png') }}" style="width: 60%;">
        </a>
      @elseif(Request::segment(1) == 'admin')
        <a class="navbar-brand " href="#" style="margin: 0px; padding: 0px;">
            <img src="{{ asset('images/logo/logo.png') }}" style="width: 60%;">
        </a>
      @elseif(Request::segment(1) == 'admin_smk')
        <a class="navbar-brand " href="#" style="margin: 0px; padding: 0px;">
            <img src="{{ asset('images/logo/smk.png') }}" style="width: 60%;">
        </a>
      @elseif(Request::segment(1) == 'admin_smp')
        <a class="navbar-brand " href="#" style="margin: 0px; padding: 0px;">
            <img src="{{ asset('images/logo/smp.png') }}" style="width: 60%;">
        </a>  
      @endif  


    </div>
  </div><!-- /.container-fluid -->
</nav>

<div class="col-md-12 bg-login">
    <div class="container">
        <div class="row">
            <div class="col-md-12 login">

                <div class="col-md-offset-1 col-md-10 box-login">
                    <div class="row">
                        <div class="col-md-6 hidden-sm hidden-xs side-login">
                            <h3 class="text-center">Pengumuman</h3>
                            <hr>

                            <h4 class="text-center" style="margin-top: 100px; margin-bottom:-20px;"></h4>
                            
                            <a href="{{ asset('stieppi-alpha.apk') }}"><img src="{{ asset('images/get_mobile.png') }}" class="img-responsive"/></a>
                        </div>
                        <div class=" col-md-6 form-login ">
                            {!! Form::open(['method' => 'POST', 'route' => $route]) !!}
                                <h3 style="font-size: 16px; margin-top:0px; ">PLEASE LOG IN</h3>
                                @include('_partials.flash_message')
                                @if(Request::segment(1) == 'mahasiswa')
                                    <div class="form-group">
                                        {!! Form::text('nim', null, ['class' => 'form-control', 'placeholder' => 'NIM', 'autocomplete' => 'off']) !!}
                                    </div>
                                @elseif(Request::segment(1) == 'dosen')
                                    <div class="form-group">
                                        {!! Form::text('nip', null, ['class' => 'form-control', 'placeholder' => 'NIP', 'autocomplete' => 'off']) !!}
                                    </div>
                                @elseif(Request::segment(1) == 'admin')
                                    <div class="form-group">
                                        {!! Form::text('username', null, ['class' => 'form-control', 'placeholder' => 'Username', 'autocomplete' => 'off']) !!}
                                    </div>
                                @elseif(Request::segment(1) == 'wali')
                                    <div class="form-group">
                                        {!! Form::text('nim', null, ['class' => 'form-control', 'placeholder' => 'NIM', 'autocomplete' => 'off']) !!}
                                    </div>
                                 @elseif(Request::segment(1) == 'admin_smk')
                                    <div class="form-group">
                                        {!! Form::text('username', null, ['class' => 'form-control', 'placeholder' => 'Username', 'autocomplete' => 'off']) !!}
                                    </div>
                                @elseif(Request::segment(1) == 'admin_smp')
                                    <div class="form-group">
                                        {!! Form::text('username', null, ['class' => 'form-control', 'placeholder' => 'Username', 'autocomplete' => 'off']) !!}
                                    </div>
                                @endif

                                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }} input-group">
                                    {!! Form::password('password', ['class' => 'form-control showPassword', 'placeholder' => 'Password', 'id' => 'getShow']) !!}
                                    <span class="input-group-btn">
                                        <button class="btn btn-default btn-show" type="button" id="hideshow"><i class="fa fa-eye" id="icon_show"></i></button>
                                    </span>
                                    @if ($errors->has('password'))
                                        <span class="help-block">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    {!! Form::submit('Log In', ['class' => 'btn btn-primary btn-login btn-block']) !!}
                                </div>
                                <!--
                                <div class="form-group">
                                <a href="{{ asset('stieppi-alpha.apk') }}" class="btn btn-primary btn-login btn-block">Reset password</a>
                                </div
                                -->
                                @if(Request::segment(1) == 'dosen')
                                    <a href="http://resetpassword.yayasanppi.net" style="display:block; text-align: center;">Reset Password</a>
                                @else
                                    <a href="{{ asset('stieppi-alpha.apk') }}" style="display:block; text-align: center;">Get Mobile App</a>
                                @endif
                                
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                    $(document).ready(function(){
                        $('#hideshow').click(function(){
                            if ($('#getShow').attr('class') == 'form-control showPassword') {

                                $('#getShow').attr('type', 'text');
                                $('#icon_show').prop('class', 'fa fa-eye-slash');
                                $('#getShow').attr('class', 'form-control hidePassword');

                            }else if($('#getShow').attr('class') == 'form-control hidePassword'){

                                $('#getShow').attr('type', 'password');
                                $('#icon_show').prop('class', 'fa fa-eye');
                                $('#getShow').attr('class', 'form-control showPassword');

                            }
                        })
                    })
                </script>
            </div>
        </div>
        <br>
        <!--<center><a href="{{ asset('stieppi-alpha.apk') }}" style="color: #fff; text-shadow: 0 0 10px #000; font-size: 20px;">GET APPS</a></center>-->
    </div>
</div>
</body>
</html>
