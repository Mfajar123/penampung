@extends('template')

@section('main')
	<section class="content-header">
		<h1>Jadwal</h1>
	</section>

	<section class="content">
            @foreach ($data_skpi as $data)
            <div class="col-md-4">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Sertifikat Ospek</small></h3>
                </div>
                <div class="box-body">
                    <?php echo $data->sertifikat_ospek; ?>
                    @if (! empty($data->sertifikat_ospek))
                        @if (pathinfo($data->sertifikat_ospek, PATHINFO_EXTENSION) != 'pdf')
                            <img src="{{ asset('images/skpi/'.$data->sertifikat_ospek) }}" class="img-responsive">
                        @else
                            <p>
                                <a href="#" download class="btn btn-danger"><i class="fa fa-file-pdf-o"></i> Download PDF</a>
                            </p>
                        @endif
                    @endif
                </div>
            </div>
        
            <div class="col-md-4">
                    <div class="box box-danger">
                        <div class="box-header with-border">
                            <h3 class="box-title">Sertifikat Seminar</small></h3>
                        </div>
                        <div class="box-body">
                            <?php echo $data->sertifikat_seminar; ?>
                            @if (! empty($data->sertifikat_seminar))
                                @if (pathinfo($data->sertifikat_seminar, PATHINFO_EXTENSION) != 'pdf')
                                    <img src="{{ asset('images/skpi/'.$data->sertifikat_seminar) }}" class="img-responsive">
                                @else
                                    <p>
                                        <a href="#" download class="btn btn-danger"><i class="fa fa-file-pdf-o"></i> Download PDF</a>
                                    </p>
                                @endif
                            @endif
                        </div>
                    </div>
                
                    <div class="col-md-4">
                            <div class="box box-danger">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Sertifikat BNSP</small></h3>
                                </div>
                                <div class="box-body">
                                    <?php echo $data->sertifikat_bnsp; ?>
                                    @if (! empty($data->sertifikat_bnsp))
                                        @if (pathinfo($data->sertifikat_bnsp, PATHINFO_EXTENSION) != 'pdf')
                                            <img src="{{ asset('images/skpi/'.$data->sertifikat_bnsp) }}" class="img-responsive">
                                        @else
                                            <p>
                                                <a href="#" download class="btn btn-danger"><i class="fa fa-file-pdf-o"></i> Download PDF</a>
                                            </p>
                                        @endif
                                    @endif
                                </div>
                            </div></div>
            @endforeach
	</section>
@stop