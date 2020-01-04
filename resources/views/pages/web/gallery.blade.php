@extends('under')

@section('main')
<!-- Content Header (Page Header) -->
<div class="container">
	<section class="container-header col-md-12">
		<h1 class="pala">
			Gallery
		</h1>
	</section>
	<section class="content col-md-12" style="margin-top: 20px;">
		<div class="row">
			@if(!empty($gallery_list))
			<?php foreach($gallery_list as $gallery): ?>
				<div class="col-xs-12 col-md-4">
					<a href="#" data-toggle="modal" data-target="#image-gallery{{$gallery->id_info}}">
						<img class="img-responsive image" src="{{asset('images/info/'.$gallery->foto_utama)}}" style="height: 250px;margin: 10px;">
					</a>
				</div>
				<div class="modal fade" id="image-gallery{{$gallery->id_info}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-heading">
								<h4 style="margin:10px;">{{$gallery->judul_info}}</h4>
							</div>
							<div class="modal-body">
								<img id="foto_utama{{$gallery->id_info}}" src="{{ asset('images/info/'.$gallery->foto_utama) }}" class="img-responsive col-md-12 image ependi_kecut{{$gallery->id_info}}" src="" style="height: 400px;"><br>
								<table class="table">

									<?php 
									$foto_from_gallery_list = DB::table('m_info')
									->join('m_foto_pendukung','m_info.id_info','m_foto_pendukung.id_info')
									->where('m_info.id_kategori_info',5)
									->where('m_info.id_info',$gallery->id_info)
									->get();
									?>
									<img title="{{ asset('images/info/'.$gallery->foto_utama) }}" onclick="$('.ependi_kecut{{$gallery->id_info}}').attr('src', $(this).attr('src'))" src="{{ asset('images/info/'.$gallery->foto_utama) }}" class="col-sm-3" style="margin-top: 10px;height: 150px;">

									@foreach($foto_from_gallery_list as $list_foto_pendukung)
									<img title="{{ asset('images/info/'.$list_foto_pendukung->nama_foto) }}" id="foto_js{{$list_foto_pendukung->id_foto_pendukung}}" onclick="$('.ependi_kecut{{$gallery->id_info}}').attr('src', $(this).attr('src'))" src="{{ asset('images/info/'.$list_foto_pendukung->nama_foto) }}" class="col-sm-3" style="margin-top: 10px;height: 150px;">

                 <!--    <script type="text/javascript">
                   function replace_image{{$gallery->id_info}}(){
                    var name_image = document.getElementById("foto_js{{$list_foto_pendukung->id_foto_pendukung}}").src;
                    
                    var reset = document.getElementsById("foto_utama{{$gallery->id_info}}");
                    for (var i=reset.length; i--;) {
                      reset[i].src = "{{$list_foto_pendukung->nama_foto}}";
                      alert(reset[i]);
                   }
                                        //$('.ependi_kecut').attr('src', $(this).attr('src'))
                  }
              </script> -->
              @endforeach

          </table>
      </div>

  </div>
</div>
</div>

<?php endforeach ?>
<div class="col-md-12">
	<div class="" align="center">{{$gallery_list->links()}}</div>
</div>
@endif
</div>

</section>
</div>
@stop