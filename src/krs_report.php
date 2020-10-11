<?php
include "../../inc/fpdf.php";
include "../../inc/db_connect_mysqli.php";

$syarat =  $_GET['customvar'];

$query_cari_mahasiswa = 'SELECT *, jur.nama_jurusan FROM mhs INNER JOIN jurusan jur ON mhs.`kode_jurusan` = jur.kode_jurusan where nipd='.$syarat;
$result = mysqli_query($db, $query_cari_mahasiswa);
$cari_mahasiswa = $result->fetch_object();
    $npm = $cari_mahasiswa->nipd;
    $nama_mhs = $cari_mahasiswa->nm_pd;
    $kode_jurusan = $cari_mahasiswa->kode_jurusan;
    $id_kurikulum = $cari_mahasiswa->id_kurikulum;
    $jurusan = $cari_mahasiswa->nama_jurusan;

$query='SELECT dsn.dosen_nidn, dsn.dosen_nama, dsn.dosen_gelarblkg, dsntgs.dos_jabatan, tgs.tgs_tambahan_deskripsi, jur.nama_jurusan
                    FROM m_dosen_dgn_tgs_tambahan dsntgs
                    INNER JOIN m_dosen dsn ON dsntgs.dos_jab_nidn = dsn.dosen_id
                    INNER JOIN m_tgs_tambahan tgs ON dsntgs.dos_jabatan = tgs.tgs_tambahan_id
                    INNER JOIN jurusan jur ON dsntgs.dos_kode_jurusan = jur.kode_jurusan
                    WHERE dsntgs.dos_jabatan = 4 AND dsntgs.dos_kode_jurusan = '.$kode_jurusan;

// $data = $query->fetch(PDO::FETCH_OBJ);
$result = mysqli_query($db, $query);
$data = $result->fetch_object();
    $nama_gelar = $data->dosen_nama.' '.$data->dosen_gelarblkg;
    $nidn = $data->dosen_nidn;
    $mengetahui = $data->tgs_tambahan_deskripsi.' '.$data->nama_jurusan;

    try{
        $query = 'SELECT * from jurusan where kode_jurusan = '.$kode_jurusan;
        $result = mysqli_query($db, $query);
        $data = $result->fetch_object();
        $fakultas = $data->fakultas;
    }catch(Exception $e){
        echo "<script type='text/javascript'>
                alert('Data Fakultas Belum Terdaftar, Silahkan Hubungi Admin');
                history.back(self);
              </script>";
    }
class myPDF extends FPDF{
    function header(){

        $this->Image('../../assets/logo_bw.png',10,6,-400);
        $this->ln(2);
        $this->SetFont('Arial','B',14);
        $this->cell(197,5,'UNIVERSITAS NURTANIO BANDUNG',0,1,'C');
        $this->SetFont('Arial','',14);
        $this->cell(197,5,$GLOBALS['fakultas'],0,1,'C');
        $this->SetFont('Arial','',10);
        $this->cell(197,5,'Jl.Pajajaran No.219 Lanud Husein S.Bandung 40174 Telp.022 86061700/Fax 86061701',0,1,'C');
        $this->Line(10, 32, 210-10, 32);
        $this->ln(15);

        $this->SetFont('Arial','B',12);
        $this->cell(190,7,'KARTU HASIL STUDI',0,1,'C');

        $this->ln(5);

        $this->SetFont('Times','',10);
        $this->cell(10,7,'',0,0); // dummy
        $this->cell(15,7,'Nama',0,0,'L');
        $this->Cell(5,7,' : ' ,0,0,'L'); 
        $this->Cell(100,7,$GLOBALS['nama_mhs'] ,0,1,'L');

        $this->cell(10,7,'',0,0); // dummy
        $this->cell(15,7,'NPM',0,0,'L');
        $this->Cell(5,7,' : ' ,0,0,'L'); 
        $this->Cell(100,7,$GLOBALS['npm'] ,0,1,'L');

        $this->cell(10,7,'',0,0); // dummy
        $this->cell(15,7,'Jurusan',0,0,'L');
        $this->Cell(5,7,' : ' ,0,0,'L'); 
        $this->Cell(100,7,$GLOBALS['jurusan'] ,0,1,'L');

        $this->Ln(5);



        
    }
    function footer(){
        $this->SetY(-15);
        $this->SetFont('Arial','',8);
        $this->Cell(0,5,'Hal. '.$this->PageNo().' dari {nb}',0,1,'C');
        $this->Cell(0,5,'Tanggal Cetak : [' . date("d/m/yy h:m:s").']',0,0,'C');
    }
    function headerTable(){
       
        
    }

    function viewTable($db){
        
        //SEMESTER 1 

        $this->SetFont('Times','',9);
        $query_semester = $db->query("SELECT semester FROM krs WHERE nim = ".$GLOBALS['npm']." GROUP BY semester");
        $ipk = 0;
        $am_ipk = 0; 
        $sks_ipk = 0;
        while($semester = $query_semester->fetch_object()){
            // var_dump($semester);
            // die;
            $this->cell(10,10,'SMT',1,0,'C');
            $this->cell(7,10,'NO',1,0,'C');
            $this->cell(18,10,'KODE MK',1,0,'C');
            $this->cell(75,10,'Nama Mata Kuliah',1,0,'C');
            $this->cell(10,10,'SKS',1,0,'C');
            $this->cell(15,5,'NILAI','T',0,'C');
            $this->cell(15,10,'AM * SKS',1,0,'C');
            $this->cell(10,10,'',1,0,'C');
            $this->cell(10,10,'',1,0,'C');
            $this->cell(10,10,'',1,0,'C');
            $this->cell(10,10,'',1,0,'C');
            $this->cell(10,5,'',0,1,'C'); //dummy

            $this->cell(120,10,'',0,0); //dummy
            $this->cell(15,5,'(AM)','B',1,'C');

            $query=$db->query("SELECT k.nim, k.`kode_mk`, mk.`nama_mk`, k.`kode_jurusan`, k.`semester` AS semester_krs, (mk.`sks_tm`+mk.`sks_prak`+mk.`sks_prak_lap`+mk.`sks_sim`) as sks_tm, mk.`semester`,  k.`status_krs`,
                                (SELECT nilai_huruf FROM nilai WHERE nilai.kode_mk = k.`kode_mk` AND nilai.`semester` = k.`semester` AND nilai.`nim` = k.`nim` limit 1) AS nilai_huruf,
                                (SELECT nilai_indek FROM nilai WHERE nilai.kode_mk = k.`kode_mk` AND nilai.`semester` = k.`semester` AND nilai.`nim` = k.`nim` limit 1) AS nilai_indek,
                                (SELECT nilai_angka FROM nilai WHERE nilai.kode_mk = k.`kode_mk` AND nilai.`semester` = k.`semester` AND nilai.`nim` = k.`nim` limit 1) AS nilai_angka,
                                (SELECT nilai_kehadiran FROM nilai WHERE nilai.kode_mk = k.`kode_mk` AND nilai.`semester` = k.`semester` AND nilai.`nim` = k.`nim` limit 1) AS nilai_kehadiran,
                                (SELECT nilai_tugas FROM nilai WHERE nilai.kode_mk = k.`kode_mk` AND nilai.`semester` = k.`semester` AND nilai.`nim` = k.`nim` limit 1) AS nilai_tugas,
                                (SELECT nilai_uts FROM nilai WHERE nilai.kode_mk = k.`kode_mk` AND nilai.`semester` = k.`semester` AND nilai.`nim` = k.`nim` limit 1) AS nilai_uts,
                                (SELECT nilai_uas FROM nilai WHERE nilai.kode_mk = k.`kode_mk` AND nilai.`semester` = k.`semester` AND nilai.`nim` = k.`nim` limit 1) AS nilai_uas
                                FROM krs k
                                LEFT JOIN mat_kurikulum mk ON mk.`kode_jurusan` = k.`kode_jurusan` AND mk.`kode_mk` = k.`kode_mk` AND id_kurikulum = ".$GLOBALS['id_kurikulum']." 
                                WHERE k.`nim`= ".$GLOBALS['npm']." AND k.`semester` = ".$semester->semester." AND k.`status_krs` = 1 order by semester_krs asc, mk.semester asc, mk.nama_mk asc ") ;
            
            $i=1;
            $sks_1=0; $am_sks_1=0;
            while($data = $query->fetch_object()){
                $this->cell(10,6,$data->semester,1,0,'C');
                $this->cell(7,6,$i.'.',1,0,'C');
                $this->cell(18,6,$data->kode_mk,1,0,'C');
                $this->cell(75,6,$data->nama_mk,1,0,'L');
                $this->cell(10,6,$data->sks_tm,1,0,'C');
                $this->cell(15,6,$data->nilai_huruf,1,0,'C');
                $this->cell(15,6,$data->sks_tm*floatval($data->nilai_indek),1,0,'C');
                $this->cell(10,6,'',1,0,'C');
                $this->cell(10,6,'',1,0,'C');
                $this->cell(10,6,'',1,0,'C');
                $this->cell(10,6,'',1,1,'C');
                if($data->nilai_huruf =='A' or $data->nilai_huruf=='B' or $data->nilai_huruf=='C' or $data->nilai_huruf=='D' or $data->nilai_huruf=='E')
                {   $sks_1=$sks_1+$data->sks_tm;
                    $am_sks_1 = $am_sks_1 + $data->sks_tm*$data->nilai_indek;
                }

                $i=$i+1;
            }

            $this->cell(110,5,'Jumlah Sks Yang Diambil : ',1,0,'C');
            $this->cell(10,5,$sks_1,1,0,'C');
            $this->cell(15,5,'',1,0,'C');
            $this->cell(15,5,$am_sks_1,1,0,'C');
            $this->cell(10,5,'IPS :',1,0,'C');
            
        
            if($sks_1<>0){$this->cell(10,5,substr($am_sks_1/$sks_1,0,4),1,0,'C');} else {$this->cell(10,5,'',1,0,'C');}
            $this->cell(10,5,'IPK :',1,0,'C');
            if($ipk == 0){
                $am_ipk += $am_sks_1;
                $sks_ipk += $sks_1;
                $ipk = ($am_ipk/$sks_ipk);
            }else{
                $am_ipk += $am_sks_1;
                $sks_ipk += $sks_1;
                $ipk = ($am_ipk/$sks_ipk);
            }
            if($sks_1<>0){$this->cell(10,5,substr($ipk,0,4),1,1,'C');} else {$this->cell(10,5,'',1,1,'C');}
            $this->ln(10);
        }
    }
    function signTable(){
        
        $this->SetFont('Times','',10);

        $this->cell(320,10,$GLOBALS['mengetahui'],0,1,'C');
        $this->cell(320,15,'',0,1,'C'); //dummy
        $this->cell(320,10,$GLOBALS['nama_gelar'],0,1,'C');
        $this->cell(320,2,'NIDN.'.$GLOBALS['nidn'],0,1,'C');
    }
}
$pdf = new myPDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->headerTable();
$pdf->viewTable($db);
//$pdf->footerTable($db);
$pdf->signTable();
$pdf->Output();

?>