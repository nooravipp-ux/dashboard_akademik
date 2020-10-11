<?php
header('Content-Type: application/json');
require_once('database/database.php');
$db = new Database();

$data_ip_sementara = $db->get_data_ip_sementara('55201117008');
echo $data_ip_sementara;

?>