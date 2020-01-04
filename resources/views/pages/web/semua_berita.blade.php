@extends('under')

@section('main')
<style type="text/css">
	.panel-body img{
		max-width: 100%;
	}
	.col-md-3, .col-md-6{
		padding: 5px;
	}
	.link{
		font-weight: bold;
		color: #000;
		text-decoration: none;
	}
	.link:hover{
		font-weight: bold;
		color: #ffa500;
		text-decoration: none;
	}
	.judul{
	    font-size: 15px;
	    font-weight: bold;
	    color: #000;
	}
</style>
<div class="container">
		<h1 align="center" style="margin-top: 80px;">Berita & Informasi</h1>
		<div class="col-md-12 col-xs-12">
		    <div class="col-md-3 col-xs-12 col-sm-3 " style="margin-left: -15px;">
				
			</div>
		    <div class="col-md-3 pull-right" style="margin-right: -15px;">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search By Name" name="search" id="info" value="{{ @$search }}">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-default" style="padding: 10.5px 12px;" id="search"><i class="fa fa-search"></i></button>
                    </span>
                </div>
            </div>
		</div> <br> <br> <br>
		    <div style="clear:both;"></div>

	<div class="col-md-12">
		<div class="row">
		@foreach($info_list as $info)
		  <div class="col-md-2 col-xs-6 col-sm-4" style="margin-bottom: 100px;">
		  	 <a href="{{ route('web.berita', $info->id_info) }}">
                <div class="thumbnail panel-penting" style="max-height: 230px;">
                  @if(empty($info->foto_utama))
                  <img src="{{asset('images/info.png')}}" style="width: 100%; height: 230px;">
                  @else
                  <img src="{{ asset('images/info/'.$info->foto_utama) }}" style="width: 100%; height: 230px; " class="sampul">
                  @endif
                  <div class="caption" align="center" style="min-height: 100px; ">
                    {{$info->judul_info}}
                  </div>
                </div>
            </a>
		  </div>
		@endforeach
		</div>
	</div>
</div>
<style>
    @media only screen and (max-width : 400px) {
    /* Styles */
        .sampul{
            max-height: 130px;
        }
    }
</style>


@stop