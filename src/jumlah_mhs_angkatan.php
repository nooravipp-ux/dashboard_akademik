<?php
header('Content-Type: application/json');
require_once('database/database.php');
$db = new Database();

$jumlah_mhs_pertahun = $db->jumlah_mhs_per_tahun('55201');
echo $jumlah_mhs_pertahun;

?>