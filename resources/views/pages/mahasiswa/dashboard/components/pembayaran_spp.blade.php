<div class="box box-success">
    <div class="box-header with-border">
        <h5 class="box-title">
            Informasi Pembayaran SPP<br/>
            <small>{{ ! empty($tahun_akademik) ? $tahun_akademik->keterangan : '' }}</small>
        </h5>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Bulan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($list_pembayaran_spp as $pembayaran_spp)
                <tr>
                    <td>{{ $pembayaran_spp['bulan'] }}</td>
                    <td><?php echo $pembayaran_spp['status'] ?></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>