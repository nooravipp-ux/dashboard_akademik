<?php
header('Content-Type: application/json');
require_once('database/database.php');
session_start();
$db = new Database();

$data_ip_sementara = $db->get_data_ip_sementara($_SESSION['id_user']);
echo $data_ip_sementara;

?>