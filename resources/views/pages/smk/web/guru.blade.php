@extends('pages.smk.smk')



@section('main')

	<div class="container ">
	  	<section class="content-header col-md-12"  >

	        <h1 class="pala">
	          Struktur Guru & Staff

	        </h1> 

	        <ol class="breadcrumb">

	          <li>Beranda</li>

	          <li>Profil</li>

	          <li >Struktur Guru & Staff</li>

	        </ol>

	      </section>
	  	
	  	<section class="content col-md-12" >
		
		<h3> Struktur Guru & Staff</h3>

	        <div class="row" style="text-align: center;">
			@foreach($kepala_sekolah as $kepsek  )
	        	<div class="col-md-12">
	        		<img src="{{ asset('images/info/'.$kepsek->foto_info ) }}" alt="">
					<p>{{ $kepsek->isi_info }}</p>
					<h4>{{ $kepsek->judul_info }}</h4>
	        	</div>
			@endforeach
	        </div><br><br>

	        <div class="row" style="text-align: center;">
	        @foreach($tata_usaha as $tu)
	        	<div class="col-md-4">
	        		<img src="{{ asset('images/info/'.$tu->foto_info ) }}" alt="">
					<p>{{ $tu->isi_info }}</p>
					<h4>{{ $tu->judul_info }}</h4>
	        	</div>
	        @endforeach
	        </div><br><br>

	        <div class="row" style="text-align: center;">
	        @foreach($wakasek as $ws)
	        	<div class="col-md-3">
	        		@if(empty($ws->foto_info))
	        		<img src="{{ asset('images/default-avatar-circle.png') }}" alt="">
	        		@else
	        		<img src="{{ asset('images/info/'.$ws->foto_info ) }}" alt="">
	        		@endif
					<p>{{ $ws->isi_info }}</p>
					<h4>{{ $ws->judul_info }}</h4>
	        	</div>
	        @endforeach
	        </div><br><br>

	        <div class="row" style="text-align: center;">
	        @foreach($kepala_bagian as $ka)
	        	<div class="col-md-4">
	        		@if(empty($ka->foto_info))
	        		<img src="{{ asset('images/default-avatar-circle.png') }}" alt="">
	        		@else
	        		<img src="{{ asset('images/info/'.$ka->foto_info ) }}" alt="">
	        		@endif
					<p>{{ $ka->isi_info }}</p>
					<h4>{{ $ka->judul_info }}</h4>
	        	</div>
	        @endforeach
	        </div><br><br>

	         <div class="row" style="text-align: center;">
	        @foreach($kaprog as $kp)
	        	<div class="col-md-4">
	        		@if(empty($kp->foto_info))
	        		<img src="{{ asset('images/default-avatar-circle.png') }}" alt="">
	        		@else
	        		<img src="{{ asset('images/info/'.$kp->foto_info ) }}" alt="">
	        		@endif
					<p>{{ $kp->isi_info }}</p>
					<h4>{{ $kp->judul_info }}</h4>
	        	</div>
	        @endforeach
	        </div><br><br>

	        <div class="row" style="text-align: center;">
	        @foreach($wali_kelas as $wk)
	        	<div class="col-md-2">
	        		@if(empty($wk->foto_info))
	        		<img src="{{ asset('images/default-avatar-circle.png') }}" alt="">
	        		@else
	        		<img src="{{ asset('images/info/'.$wk->foto_info ) }}" alt="">
	        		@endif
					<p>{{ $wk->isi_info }}</p>
					<h4>{{ $wk->judul_info }}</h4>
	        	</div>
	        @endforeach
	        </div><br><br>

	        <div class="row" style="text-align: center;">
	        @foreach($guru as $gr)
	        	<div class="col-md-2">
	        		@if(empty($gr->foto_info))
	        		<img src="{{ asset('images/default-avatar-circle.png') }}" alt="">
	        		@else
	        		<img src="{{ asset('images/info/'.$gr->foto_info ) }}" alt="">
	        		@endif
					<p>{{ $gr->isi_info }}</p>
					<h4>{{ $gr->judul_info }}</h4>
	        	</div>
	        @endforeach
	        </div>

	    </section>

    </div>



@stop