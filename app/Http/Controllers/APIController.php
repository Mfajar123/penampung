<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\KHS;
use App\TahunAkademik;
use App\Jadwal;
use App\Pembayaran_spp;

class APIController extends Controller
{
    public function index()
    {
        // echo 'Test 2';

        header('Content-Type: application/json');
        $action = $this->get('action');

        if(isset($_GET['auth'])){

            $user = $this->get('u');
            $pass = $this->get('auth');

            // $x = new SystemController();
            // echo $x->encrypt('123', $user, $user);

            if(substr($user, 0, 3) == 194){

                $user_type  = "DSN";
                $user_table = "m_dosen";
                $user_field = "nip";
                $photo_url  = url('')."/images/dosen/";
                $user_photo = "foto_profil";
                $pass_field     = "password";

                $query = DB::select(DB::raw("select nip, nidn, nama, email, $user_photo as foto from $user_table where $user_field = '$user' and $pass_field = '$pass'"));

            }else{
                
                $user_type      = "MHS";
                $user_table     = "m_mahasiswa";
                $user_field     = "nim";
                $pass_field     = "password";
                $photo_url      = url('')."/images/mahasiswa/";
                $user_photo     = "foto_profil";

                $query = DB::select(DB::raw("select nim, nama, email, $user_photo as foto from $user_table where $user_field = '$user' and $pass_field = '$pass'"));
            
            }

            if(count($query) > 0){
                $query[0]->user_type = $user_type;
                $query[0]->user_photo = $photo_url.$query[0]->foto;
                echo json_encode(array("data" => $query[0]), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            }else{
                echo "user_unknown";
            }

        }

        if($action == 'get_detail_dosen'){

            $user = $this->get('nip');

            $query = DB::select(DB::raw("select a.*, b.nama as jabatan, c.nama_prodi as prodi from m_dosen a 
            left join m_dosen_jabatan b on a.id_dosen_jabatan = b.id_dosen_jabatan
            left join tbl_prodi c on a.id_prodi = c.id_prodi
            where a.nip = '$user'"));

            if(count($query) > 0){
                echo json_encode(array("data" => $query[0]), JSON_UNESCAPED_SLASHES);
            }else{
                echo "user_unknown";
            }

        }

        if($action == 'pengumuman'){

            echo '
            <p style="border:1px solid #ff9393; background:#ffe0e0; text-align:center; padding:10px;" align="center">Under Development</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed vel odio et ante lacinia iaculis. Vivamus bibendum et turpis sed dictum. Nulla ac dignissim lectus, vitae dictum risus. Ut pharetra sapien augue, et efficitur nisi malesuada a. Proin in egestas urna, eu viverra lectus. Maecenas a nisi velit. Maecenas in ante est. Maecenas non hendrerit quam. Cras orci magna, pretium tempus viverra eget, posuere id mi.</p>

<p>Mauris nibh tortor, pulvinar quis mi sit amet, laoreet mattis nulla. Nam et semper nunc, suscipit egestas ante. Cras quam elit, congue vulputate tellus et, accumsan cursus sapien. Vestibulum lorem lorem, pharetra non massa non, malesuada hendrerit risus. Integer tristique aliquet porta. Phasellus pretium libero in placerat blandit. Donec diam ante, imperdiet sit amet convallis sed, gravida non diam. Etiam ac luctus massa.</p>';

        }

        if($action == 'get_detail_mahasiswa'){

            $user = $this->get('nim');

            $query = DB::select(DB::raw("select a.*, a.foto_profil as foto, a.tmp_lahir as tempat_lahir, d.nama_jenjang as jenjang, b.nama_prodi as prodi, c.semester_ke as semester
            from m_mahasiswa a 
            left join tbl_prodi b on a.id_prodi = b.id_prodi
            left join tbl_semester c on a.id_semester = c.id_semester
            left join tbl_jenjang d on a.id_jenjang = d.id_jenjang
            where nim = '$user'"));

            if(count($query) > 0){
                echo json_encode(array("data" => $query[0]), JSON_PRETTY_PRINT);
            }else{
                echo "user_unknown";
            }

        }

        if($action == 'get_tahun_akademik'){

            $query = DB::select(DB::raw("select id_tahun_akademik, tahun_akademik, semester, keterangan from t_tahun_akademik where is_delete = 'N' order by tahun_akademik desc"));

            if(count($query) > 0){

                $data = array();

                foreach($query as $list){
                    $data[] = $list;
                }

                echo json_encode(array("data" => $data), JSON_PRETTY_PRINT);
            }else{
                echo "";
            }

        }

        if($action == 'get_nilai'){

            $matkul = KHS::where(['t_khs.id_semester' => $this->get('semester'), 'nim' => $this->get('nim')])->leftjoin('m_matkul', 't_khs.kode_matkul', 'm_matkul.kode_matkul')->get();

            $count  = count($matkul);
            $no     = 0;
            $data   = array();

            if($count > 0){
                foreach($matkul as $list){
                        $data[$no]['no']             = $no;
                        $data[$no]['nama_matkul']    = $list->nama_matkul;
                        $data[$no]['sks']    = $list->sks;
                        $data[$no]['nama_prodi']     = $list->prodi->nama_prodi;
                        $data[$no]['semester_ke']    = $list->semester->semester_ke;
                        $data[$no]['nama_kelas']     = $list->kelas->nama_kelas;
                        $data[$no]['nilai']          = $list->total;
                    $no++;
                }
            }
            
            echo json_encode(array("data" => $data), JSON_PRETTY_PRINT);

        }

        if($action == 'jadwal_mahasiswa'){

            $bulan = date('m');
            if ($bulan >= 02 and $bulan <= 07) {
                $tahun_lalu = date("Y") - 1;
                $belakang = "20";
                $tahun = $tahun_lalu.$belakang;
            }else{
                $tahun_sekarang = date("Y");
                $belakang = "10";
                $tahun = $tahun_sekarang.$belakang;
            }

            $user = $this->get('nim');
            $tahun_akademik = (empty($this->get('tahun_akademik'))) ? $tahun : $this->get('tahun_akademik');

            $query = DB::select(DB::raw("
                        SELECT
                        
                            i.nama as nama_mahasiswa, b.nama_matkul, g.id_hari, a.hari, c.nama, DATE_FORMAT(a.jam_mulai, '%H:%i') as jam_mulai, DATE_FORMAT(a.jam_selesai, '%H:%i') as jam_selesai, d.nama_kelas, e.nama_ruang, f.nama_waktu_kuliah, h.tahun_akademik

                        FROM 
                            `t_jadwal` a

                            left join m_matkul b on a.id_matkul = b.id_matkul
                            left join m_dosen c on a.id_dosen = c.id_dosen
                            left join m_ruang e on a.id_ruang = e.id_ruang
                            left join tbl_waktu_kuliah f on a.id_waktu_kuliah = f.id_waktu_kuliah
                            left join m_hari g on a.hari = g.nama_hari
                            left join t_krs h on h.id_semester = a.id_semester
                            left join m_mahasiswa i on h.nim = i.nim
                            left join m_kelas_detail j on i.nim = j.nim
                            left join m_kelas d on d.id_kelas = j.id_kelas

                        where h.tahun_akademik = '$tahun_akademik'
                            and h.nim = '$user'
                            and a.id_matkul in (select id_matkul from t_krs_item x where x.id_krs = h.id_krs)
                        GROUP by a.id_matkul
                        order by 
                            id_hari, jam_mulai 
                        ASC"));

            if(count($query) > 0){
                
                $data = array();

                foreach($query as $list){
                    $data[] = $list;
                }
                
                echo json_encode(array("data" => $data), JSON_PRETTY_PRINT);
            
            }else{
                echo "";
            }

        }

        if($action == 'get_news'){

            $news = DB::select(DB::raw("
                select 
                    a.judul_info, date_format(a.waktu_info, '%d-%m-%Y') as waktu_info, ringkasan_info, isi_info, foto_info, sumber_info, b.kategori_info 
                from 
                    m_info a
                left join 
                    m_kategori_info b on a.id_kategori_info = b.id_kategori_info
                where a.id_kategori_info in (1,2,3) and a.is_delete = 'N'
                order by a.create_date desc
                limit 0, 20"));

            $count  = count($news);
            $no     = 0;
            $data   = array();

            if($count > 0){
                foreach($news as $list){
                        $data[$no]['no']            = $no;
                        $data[$no]['judul_info']    = $list->judul_info;
                        $data[$no]['waktu_info']    = $list->waktu_info;
                        $data[$no]['ringkasan_info']= $list->ringkasan_info;
                        $data[$no]['isi_info']      = $list->isi_info;
                        $data[$no]['foto_info']     = $list->foto_info;
                        $data[$no]['sumber_info']   = $list->sumber_info;
                        $data[$no]['kategori_info'] = $list->kategori_info;
                    $no++;
                }
            }
            
            echo json_encode(array("data" => $data), JSON_PRETTY_PRINT);

        }

        if($action == 'get_dosen'){

            $filter = "";

            if($this->get('s') != '')
                $filter = " and nama like '%$_GET[s]%'";

            $news = DB::select(DB::raw("select nama, no_hp, email from m_dosen where is_delete = 'N' $filter"));

            $count  = count($news);
            $no     = 0;
            $data   = array();

            if($count > 0){
                foreach($news as $list){
                        $data[$no]['no']   = $no;
                        $data[$no]['nama'] = $list->nama;
                        $data[$no]['no_hp']= $list->no_hp == '' ? '-' : $list->no_hp;
                        $data[$no]['email']= $list->email == '' ? '-' : $list->email;
                    $no++;
                }
            }
            
            echo json_encode(array("data" => $data), JSON_PRETTY_PRINT);

        }

        if($action == 'get_spp'){

            $filter = "";

            $tahun_akademik = TahunAkademik::select('semester')->where('id_tahun_akademik', $this->get('period'))->first();

            if ($tahun_akademik->semester == 'Ganjil') {
                $list_bulan = array(8, 9, 10, 11, 12, 1);
            } else {
                $list_bulan = array(2,3,4,5,6,7);
            }

            $bulan = array(1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember');

            $pembayaran_spp = Pembayaran_spp::where([
                    'nim' => $this->get('u'),
                    'id_tahun_akademik' => $this->get('period')
                ])->whereIn('bulan', $list_bulan)->get();

            $pembayaran = array();

            foreach ($pembayaran_spp as $value) {
                
                $pembayaran[$value->bulan]['bulan'] = $bulan[$value->bulan];
                $pembayaran[$value->bulan]['status'] = "LUNAS";
                $pembayaran[$value->bulan]['tanggal_bayar'] = $value->tanggal_pembayaran;
                $pembayaran[$value->bulan]['total_bayar'] = $value->bayar;
                $pembayaran[$value->bulan]['keterangan'] = $value->keterangan;
            }

            $data = array();

            $i = 0;
            foreach ($list_bulan as $d) {
                if(!isset($pembayaran[$d])){
                    $data[$i]['status'] = "-";
                    $data[$i]['bulan'] = $bulan[$d];
                    $data[$i]['tanggal_bayar'] = "-";
                    $data[$i]['total_bayar'] = "-";
                    $data[$i]['keterangan'] = "-";
                }else{
                    $data[$i]['status'] = $pembayaran[$d]['status'];
                    $data[$i]['bulan'] = $bulan[$d];
                    $data[$i]['tanggal_bayar'] = $pembayaran[$d]['tanggal_bayar'];
                    $data[$i]['total_bayar'] = $pembayaran[$d]['total_bayar'];
                    $data[$i]['keterangan'] = $pembayaran[$d]['keterangan'];
                }
                $i++;
            }
            
            echo json_encode(array("data" => $data), JSON_PRETTY_PRINT);

        }

        if($action == 'get_jadwal_dosen'){
            
            $data   = array();
     
            if ($this->get('tahun_akademik') != '')
            {

                $list_jadwal = Jadwal::where([
                    'id_dosen' => DB::raw("(select id_dosen from m_dosen where nip = ".$this->get('dsn').")"),
                    'tahun_akademik' => $this->get('tahun_akademik'),
                    'hari' => $this->get('hari')
                ])->orderBy('jam_mulai', 'asc')->get();

                $no     = 0;

                foreach($list_jadwal as $jadwal){
                    $data[$no]['no']   = $no;
                    $data[$no]['jam'] = (! empty($jadwal->jam_mulai) ? date('H:i', strtotime($jadwal->jam_mulai)) : '-').' s.d '.(! empty($jadwal->jam_selesai) ? date('H:i', strtotime($jadwal->jam_selesai)) : '-');
                    $data[$no]['ruang']= ! empty($jadwal->ruang->kode_ruang) ? $jadwal->ruang->kode_ruang : '-';
                    $data[$no]['kelas']= (! empty($jadwal->kelas->id_prodi) ? $jadwal->kelas->id_prodi : '-' ).' - '.(! empty($jadwal->kelas->kode_kelas) ? $jadwal->kelas->kode_kelas : '-');
                    $data[$no]['matkul']=  (! empty($jadwal->matkul->kode_matkul) ? $jadwal->matkul->kode_matkul : '-').' - '.(! empty($jadwal->matkul->nama_matkul) ? $jadwal->matkul->nama_matkul : '-');
                    $data[$no]['sks']   = (! empty($jadwal->matkul->sks) ? $jadwal->matkul->sks : '-').' SKS';
                    $no++;
                }

            }
            
            echo json_encode(array("data" => $data), JSON_PRETTY_PRINT);

        }
        
    }

    public function get($text){

        $t = @$_GET[$text];
        return str_replace("'", "''", $t);

    }

    public function post($text){

        $t = @$_POST[$text];
        return str_replace("'", "''", $t);

    }
}
