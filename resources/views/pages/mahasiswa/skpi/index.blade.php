@extends ('template')

@section ('main')

	<section class="content-header">
		<h1>Upload SKPI</h1>

		<ol class="breadcrumb">
			<li><a href="#">Home</a></li>
			<li class="active">Upload SKPI</li>
		</ol>
    </section>
    <p>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
            <form method="POST" enctype="multipart/form-data" id="upload_image_form" onsubmit="return validasi()" action="{{ route('mahasiswa.skpi.simpan') }}" >
                {{ csrf_field() }}   
            <section class="content">        
            <div class="<div class="input-group mb-3>  
            <div class="col-md-4">
                            <div class="form-group">
                                <input type="file" class="form-control" name="sertifikat_ospek" placeholder="Choose image" id="image1">
                                <span class="text-danger">{{ $errors->first('title') }}</span>
                            </div>
                        </div>

            <div class="col-md-4">
                    <div class="form-group">
                            <input type="file" class="form-control" name="sertifikat_seminar" placeholder="Choose image" id="image2">
                            <span class="text-danger">{{ $errors->first('title') }}</span>
                    </div>
            </div>

            <div class="col-md-4">
                    <div class="form-group">
                            <input type="file" class="form-control" name="sertifikat_bnsp" placeholder="Choose image" id="image3">
                            <span class="text-danger">{{ $errors->first('title') }}</span>
                    </div>
            </div>
        </div>



    <div class="col-md-4">
                <div class="box box-primary">
                <div class="box-primary with-border">
                <h4 class="box-title" align="center"><strong>Sertifikat Ospek</strong></h4>
                </div>
            <table class="table">
                <tbody>   
                    <tr align="center">
                    <td><img id="image_preview_container1" src="{{ asset('public/image/image-preview.png') }}"
                        alt="preview image1" style="max-height: 175px;"></td>
                    </tr>   
                </tbody>
            </table>     
            </div></div>

    <div class="col-md-4">
                <div class="box box-primary">
                <div class="box-primary with-border">
                <h4 class="box-title" align="center"><strong> Sertifikat Seminar/Pelatihan</strong></h4>
                </div>
            <table class="table">
                <tbody>   
                    <tr align="center">
                    <td><img id="image_preview_container2" src="{{ asset('public/image/image-preview.png') }}"
                        alt="preview image2" style="max-height: 175px;"></td>
                    </tr>   
                </tbody>
            </table>     
            </div></div>

    <div class="col-md-4">
            <div class="box box-primary">
            <div class="box-primary with-border">
            <h4 class="box-title" align="center"><strong> Sertifikat BNSP</strong></h4>
            </div>
        <table class="table">
            <tbody>   
                <tr align="center">
                <td><img id="image_preview_container3" src="{{ asset('public/image/image-preview.png') }}"
                    alt="preview image" style="max-height: 175px;"></td>
                </tr>   
            </tbody>
        </table>     
        </div></div>
                   
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>    
    </form>

    
    <!-- data skpi-->
</div>
<script>
        function validasi(){
            var sertifikat_ospek = document.getElementById('image1');
            var sertifikat_seminar = document.getElementById('image2');
            var sertifikat_bnsp = document.getElementById('image3');

            if (harusDiisi(sertifikat_ospek, "sertifikat ospek belum diisi!")) {
                if (harusDiisi(sertifikat_seminar, "sertifikat seminar belum diisi!")) {
                    if (harusDiisi(sertifikat_bnsp, "sertifikat bnsp belum diisi!")) {
                        return true;
                    };
                };
            };
            return false;
        }

        function harusDiisi(att, msg){
            if (att.value.length == 0) {
                alert(msg);
                att.focus();
                return false;
            }

            return true;
        }
    </script>

<script type="text/javascript">
  $(document).ready(function (b) {
  
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content2')
      }
  });

  $('#image1').change(function(a){
    
      let reader = new FileReader();
      reader.onload = (a) => { 
        $('#image_preview_container1').attr('src', a.target.result); 
      }
    reader.readAsDataURL(this.files[0]); 
  });

  $('#image2').change(function(b){
    
    let reader = new FileReader();
    reader.onload = (b) => { 
      $('#image_preview_container2').attr('src', b.target.result); 
    }
  reader.readAsDataURL(this.files[0]); 
});

$('#image3').change(function(c){
    
    let reader = new FileReader();
    reader.onload = (c) => { 
      $('#image_preview_container3').attr('src', c.target.result); 
    }
  reader.readAsDataURL(this.files[0]); 
});


  $('#upload_image_form').submit(function(a,b,c) {
      a,b,c.preventDefault();

      var formData = new FormData(this);

      $.ajax({
          type:'POST',
          url: "{{ url('save-photo')}}",
          data: formData,
          cache:false,
          contentType: false,
          processData: false,
          success: (data) => {
              this.reset();
              alert('Image has been uploaded successfully');
          },
          error: function(data){
              console.log(data);
          }
      });
  });
})
 
</script>
@stop