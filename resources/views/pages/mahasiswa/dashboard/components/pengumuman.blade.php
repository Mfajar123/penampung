<!-- <h3 class="content-title">Pengumuman</h3> -->
@foreach ($list_pengumuman as $pengumuman)
<div class="box box-danger">
    <div class="box-header with-border">
        <h3 class="box-title">{{ $pengumuman->judul_pengumuman }} <small>{{ $pengumuman->waktu_pengumuman }}</small></h3>
    </div>
    <div class="box-body">
        <?php echo $pengumuman->isi_pengumuman; ?>
        @if (! empty($pengumuman->foto_pengumuman))
            @if (pathinfo($pengumuman->foto_pengumuman, PATHINFO_EXTENSION) != 'pdf')
                <img src="{{ asset('images/pengumuman/'.$pengumuman->foto_pengumuman) }}" alt="{{ $pengumuman->judul_pengumuman }}" class="img-responsive">
            @else
                <p>
                    <a href="{{ asset('images/pengumuman/'.$pengumuman->foto_pengumuman) }}" download class="btn btn-danger"><i class="fa fa-file-pdf-o"></i> Download PDF</a>
                </p>
            @endif
        @endif
    </div>
</div>
@endforeach