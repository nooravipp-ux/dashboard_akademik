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
    function get_data_user($username){
        $query = "SELECT * FROM view_0005_list_user WHERE username = '$username'";
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
        $query = "SELECT nama_mk_mhs, hari_nama_pagi, wkt_kul_deskripsi_pagi, dosen_nama_pagi, hari_nama_sore, wkt_kul_deskripsi_sore, dosen_nama_sore FROM `view_0016_krs_mhs` WHERE  semester_mhs = '$tahun_ajar' AND kode_jurusan = '$kode_prodi' AND nim = '$semester'";
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
        $query = "SELECT * FROM (SELECT YEAR(tgl_masuk_sp) AS tahun_angkatan, COUNT(*) AS jumlah_mhs FROM view_0022_daftar_mhs_aktif WHERE kode_jurusan = '$kode_prodi' GROUP BY YEAR(tgl_masuk_sp) ORDER BY tgl_masuk_sp DESC LIMIT 4) mhs_pertahun ORDER BY tahun_angkatan ASC";
        $result = mysqli_query($this->conn, $query);
        $data = array();

        foreach($result as $row){
            $data[] = $row;
        }
		return json_encode($data);
    }

    function data_persetujuan_krs($kode_prodi, $tahun_ajar){
        $query = "SELECT status_krs_nama, COUNT(status_krs_nama) AS jumlah_krs FROM `view_0016_krs_mhs` WHERE semester_mhs = '20201' AND kode_jurusan = '55201' GROUP BY status_krs_nama";
        $result = mysqli_query($this->conn, $query);
        $data = array();

        foreach($result as $row){
            $data[] = $row;
        }
		return json_encode($data);
    }
    function data_persetujuan_krs_array($kode_prodi, $tahun_ajar){
        $query = "SELECT status_krs_nama, COUNT(status_krs_nama) AS jumlah_krs FROM `view_0016_krs_mhs` WHERE semester_mhs = '20201' AND kode_jurusan = '55201' GROUP BY status_krs_nama";
        $result = mysqli_query($this->conn, $query);
        $data = array();

        foreach($result as $row){
            $data[] = $row;
        }
		return $data;
    }

    function jumlah_dosen($kode_prodi){
        $query = "SELECT COUNT(DISTINCT nama_dosen) AS jumlah_dosen FROM ajar_dosen WHERE kode_jurusan = '$kode_prodi'";
        $result = mysqli_query($this->conn, $query);
        $row = mysqli_fetch_array($result);
        $hasil = $row['jumlah_dosen'];

		return $hasil;
    }
    function jumlah_mhs_pagi_sore($kode_prodi, $kelas){
        $query = "SELECT COUNT(id_group) AS jml_mhs FROM `view_0005_list_user` WHERE id_group = $kelas AND kode_jurusan = '$kode_prodi'";
        $result = mysqli_query($this->conn, $query);
        $row = mysqli_fetch_array($result);
        $jml = $row['jml_mhs'];

		return $jml;
    }

    function jumlah_krs($kode_prodi, $tahun_ajar){
        $query = "SELECT COUNT(*) AS jumlah_krs FROM `view_0016_krs_mhs` WHERE semester_mhs = '$tahun_ajar' AND kode_jurusan = '$kode_prodi'";
        $result = mysqli_query($this->conn, $query);
        $row = mysqli_fetch_array($result);
        $krs = $row['jumlah_krs'];

		return $krs;
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
    
    function data_mhs_per_matkul($kode_prodi, $tahun_ajar){
        $query = "SELECT kode_mk_mhs, nama_mk_mhs, nama_kelas, COUNT(nim) AS jml_mhs, dosen_nama_pagi, hari_nama_pagi, wkt_kul_deskripsi_pagi, dosen_nama_sore, hari_nama_sore, wkt_kul_deskripsi_sore FROM `view_0016_krs_mhs` WHERE kode_jurusan = '$kode_prodi' AND semester_mhs = '$tahun_ajar' GROUP BY kode_mk_mhs";
        $result = mysqli_query($this->conn, $query);
        $data = array();

        foreach($result as $row){
            $data[] = $row;
        }
		return $data;
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