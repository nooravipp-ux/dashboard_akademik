<?php 
class Database { 
    var $conn = "";
	function __construct(){
		$this->conn = mysqli_connect("103.134.19.227", "userpmb", "dodolgarut", "sistemik");

        if (mysqli_connect_errno()) {
            echo "Koneksi database gagal : " . mysqli_connect_error();
        }
          
    }
    //LOGIN
    function get_data_user($usr, $pass){
        $query = "SELECT * FROM sys_users WHERE username = '$usr' AND password = '$pass'";
        $result = mysqli_query($this->conn, $query);
        $data = mysqli_fetch_array($result);
        return $data;
    }
    function cek_user($usr, $pass){
        $query = "SELECT count(*) AS jml_user FROM sys_users WHERE username = '$usr' AND password = '$pass'";
        $result = mysqli_query($this->conn, $query);
        $row = mysqli_fetch_array($result);
        $count = $row['jml_user'];
        if($count > 0){
            return true;
        }else{
            return false;
        }
    }
    //dashboard Mahasiswa
    function get_data_nilai_mata_kuliah($nim){
        $query = "SELECT * FROM v_nilai_mk WHERE nim = '$nim' ORDER BY semester DESC";
        $data = mysqli_query($this->conn, $query);
        while($row = mysqli_fetch_array($data)){
			$hasil[] = $row;
		}
		return $hasil;
    }
    function count_sks_ditempuh($nim){
        $query = "SELECT SUM(sks) AS sks_ditempuh FROM v_nilai_mk WHERE nim = '$nim'";
        $result = mysqli_query($this->conn, $query);
        $row = mysqli_fetch_array($result);
        $count = $row['sks_ditempuh'];
        
        return $count;
    }
    function get_data_kalender_akademik(){
        $query = "SELECT * FROM view_0020_kalender_akademik WHERE t_kegiatan_status = 'Aktif' AND (CURDATE() >= t_kegiatan_tgl_awal AND CURDATE() <= t_kegiatan_tgl_akhir)";
        $data = mysqli_query($this->conn, $query);
        while($row = mysqli_fetch_array($data)){
			$hasil[] = $row;
		}
		return $hasil;
    }
    function count_ipk($nim){
        $query = "SELECT SUM(ip_sementara)/COUNT(semester) AS ipk FROM v_ip_sementara WHERE nim = '$nim'";
        $result = mysqli_query($this->conn, $query);
        $row = mysqli_fetch_array($result);
        $hasil = $row['ipk'];
		return $hasil;
    }
    function get_data_ip_sementara($nim){
        $query = "SELECT * FROM v_ip_sementara WHERE nim = '$nim'";
        $result = mysqli_query($this->conn, $query);
        $data = array();

        foreach($result as $row){
            $data[] = $row;
        }
		return json_encode($data);
    }

    function cek_spp_status($nim){
        $query = "SELECT cek_spp_nim, cek_spp_status_krs, cek_spp_status_uts, cek_spp_status_uas FROM t_cek_spp WHERE cek_spp_nim = '$nim'";
        $data = mysqli_query($this->conn, $query);
        while($row = mysqli_fetch_array($data)){
			$status_spp[] = $row;
		}
		return $status_spp;
    }

    function cek_spp_semester_mhs($nim, $tahun_ajaran){
        $query = "SELECT COUNT(*) AS status_spp FROM view_0013_cek_spp_semester_mhs WHERE cek_spp_nim = '$nim' AND semester = '$tahun_ajaran'";
        $result = mysqli_query($this->conn, $query);
        $row = mysqli_fetch_array($result);
        $hasil = $row['status_spp'];
        if($hasil > 0){
            return true;
        }else{
            return false;
        }

    }

    function jadwal_kuliah_mhs($kode_prodi, $tahun_ajar, $semester){
        $query = "select * from view_0011_jadwal_kuliah where view_0011_jadwal_kuliah.kode_jurusan= '$kode_prodi' AND view_0011_jadwal_kuliah.semester = '$tahun_ajar' AND view_0011_jadwal_kuliah.angka_semester = '$semester' order by hari_id asc, angka_semester asc, hari_nama asc";
        $data = mysqli_query($this->conn, $query);
        while($row = mysqli_fetch_array($data)){
			$status_spp[] = $row;
		}
		return $status_spp;
    }

    // prodi
    function jumlah_mhs_aktif($kode_prodi){
        $query = "select count(*) as jumlah_mhs from view_0022_daftar_mhs_aktif where kode_jurusan = '$kode_prodi'";
        $data = mysqli_query($this->conn, $query);
        $row = mysqli_fetch_array($data);
		$jumlah_mhs = $row['jumlah_mhs'];
		return $jumlah_mhs;
    }

    function jumlah_mhs_per_tahun($kode_prodi){
        $query = "select YEAR(tgl_masuk_sp) as tahun_angkatan, count(*) AS jumlah_mhs from view_0022_daftar_mhs_aktif where kode_jurusan = '$kode_prodi' group by year(tgl_masuk_sp)";
        $result = mysqli_query($this->conn, $query);
        $data = array();

        foreach($result as $row){
            $data[] = $row;
        }
		return json_encode($data);
    }

    function jumlah_dosen($kode_prodi){
        $query = "SELECT COUNT(DISTINCT nama_dosen) AS jumlah_dosen FROM ajar_dosen WHERE kode_jurusan = '$kode_prodi'";
        $result = mysqli_query($this->conn, $query);
        $row = mysqli_fetch_array($result);
        $hasil = $row['jumlah_dosen'];

		return $hasil;
    }

    function krs_di_setujui($kode_prodi, $tahun_ajar){
        $query = "SELECT COUNT(*) AS jml_krs_di_setujui FROM view_0016_krs_mhs WHERE status_krs = 1 AND kode_jurusan = '$kode_prodi' AND semester_mhs = '$tahun_ajar'";
        $result = mysqli_query($this->conn, $query);
        $row = mysqli_fetch_array($result);
        $krs_disetujui = $row['jml_krs_di_setujui'];

		return $krs_disetujui;
    }

    function mhs_krs($kode_prodi, $tahun_ajar){
        $query = "SELECT COUNT(DISTINCT nim) AS mhs_krs FROM view_0016_krs_mhs WHERE kode_jurusan = '55201' AND semester_mhs = '20201'";
        $result = mysqli_query($this->conn, $query);
        $row = mysqli_fetch_array($result);
        $mhs_krs = $row['mhs_krs'];

		return $mhs_krs;
    }
    
    function mata_kuliah_dosen_ajar($kode_prodi, $tahun_ajar){
        $query = "SELECT kode_mk, nama_mk, nama_dosen_pagi, nama_dosen_sore FROM v_dosen_ajar_real WHERE kode_jurusan = '$kode_prodi' AND semester = '$tahun_ajar' AND id_kurikulum = 11";
        $result = mysqli_query($this->conn, $query);
        $data = array();

        foreach($result as $row){
            $mk_dosen[] = $row;
        }
		return $mk_dosen;
    }

    //dosen
    function tampil_jadwal_ajar_dosen_pagi($nidn,$tahun_ajar){
        $query = "SELECT angka_semester, nama_mk, sks_tm,hari_nama,nama_kelas_pagi, wkt_kul_deskripsi_pagi FROM view_0011_jadwal_kuliah WHERE semester = '$tahun_ajar' AND dosen_nidn_pagi = '$nidn' ORDER BY angka_semester ASC";
        $data = mysqli_query($this->conn, $query);
        while($row = mysqli_fetch_array($data)){
			$jadwal[] = $row;
		}
		return $jadwal;
    }

    function tampil_jadwal_ajar_dosen_sore($nidn,$tahun_ajar){
        $query = "SELECT angka_semester, nama_mk, sks_tm,hari_nama,nama_kelas_sore, wkt_kul_deskripsi_sore FROM view_0011_jadwal_kuliah WHERE semester = '$tahun_ajar' AND dosen_nidn_sore = '$nidn' ORDER BY angka_semester ASC";
        $data = mysqli_query($this->conn, $query);
        while($row = mysqli_fetch_array($data)){
			$jadwal[] = $row;
		}
		return $jadwal;
    }

    //
    function cek_semester_aktif(){
        $query = "SELECT * FROM semester WHERE status = 'Aktif'";
        $data = mysqli_query($this->conn, $query);
        $semester = mysqli_fetch_array($data);
		return $semester;
    }
}

?>