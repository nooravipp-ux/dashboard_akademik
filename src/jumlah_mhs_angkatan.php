<?php
header('Content-Type: application/json');
require_once('database/database.php');
session_start();
$db = new Database();

$jumlah_mhs_pertahun = $db->jumlah_mhs_per_tahun($_SESSION['kode_jurusan']);
echo $jumlah_mhs_pertahun;

?>