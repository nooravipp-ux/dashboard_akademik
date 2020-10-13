<?php
header('Content-Type: application/json');
require_once('database/database.php');
session_start();
$db = new Database();

$data_krs = $db->data_persetujuan_krs($_SESSION['kode_jurusan'], $_SESSION['smt']);
echo $data_krs;

?>