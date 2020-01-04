@extends('template')



@section('main')

    <section class="content-header">

        <h1>Ubah Jadwal</h1>

        <ol class="breadcrumb">

          <li>Home</li>

          <li>Jadwal</li>

          <li class="active">Ubah Jadwal</li>

        </ol>

    </section><!-- /.content-header -->



    <section class="content">

        @include('_partials.flash_message')

        <div class="box">

            <div class="box-header with-border">

                <h3 class="box-title">Form Ubah</h3>

            </div>

            <div class="box-body">

                {!! Form::model($jadwal, ['id' => 'frm_jadwal', 'method' => 'POST']) !!}

                    @include('pages.admin.jadwal.form', ['btnSubmit' => 'Ubah Data'])

                {!! Form::close() !!}

            </div>

        </div>

    </section><!-- /.content -->

@stop




@section('script')
    <script type="text/javascript">
        function get_kelas(id = null) {
            var tahun_akademik = $('.select_tahun_akademik').val();
            var id_prodi = $('.select_prodi').val();
            var id_waktu_kuliah = $('.select_waktu').val();
            var id_semester = $('.select_semester').val();
            var id_kelas = $(".select_kelas");

            var formData = new FormData();

            formData.append('tahun_akademik', tahun_akademik);
            formData.append('id_prodi', id_prodi);
            formData.append('id_waktu_kuliah', id_waktu_kuliah);
            formData.append('id_semester', id_semester);

            id_kelas.html('<option value="">- Pilih Kelas -</option>');

            $.ajax({
                type: "POST",
                url: "{{ route('admin.jadwal.get_kelas') }}",
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                success: function (data) {
                    if (data.status === 'success') {
                        $.each(data.data, function (key, val) {
                            if (id !== null) {
                                if (val.id_kelas === id) {
                                    id_kelas.append('<option value="'+val.id_kelas+'" selected>'+val.kode_kelas+'</option>');
                                } else {
                                    id_kelas.append('<option value="'+val.id_kelas+'">'+val.kode_kelas+'</option>');
                                }
                            }
                        });
                    }
                }
            });
        }
        
        $(document).ready(function(){
            get_kelas({{ $jadwal->id_kelas }});
            
            $('.select2').select2();

            $("#frm_jadwal").on("submit", function (e) {
                $.ajax({
                    type: "PATCH",
                    url: "{{ route('admin.jadwal.perbarui', $id) }}",
                    data: $("#frm_jadwal").serialize(),
                    success: function (data) {
                        if (data.status == 'success') {
                            document.location.href = "{{ route('admin.jadwal') }}";
                        } else if (data.status == 'error') {
                            alert(data.message);
                        }
                    },
                    error: function (error) {
                        alert("Mohon maaf, terjadi kesalahan.");
                        console.log(error);
                    }
                });

                e.preventDefault();
            });
        });
    </script>
@stop