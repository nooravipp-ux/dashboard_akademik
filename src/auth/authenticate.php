<?php 

session_start();
$base_dir = $_SERVER['DOCUMENT_ROOT'].'/dashboard_akademik';
$base_url = '/dashboard_akademik';
include $base_dir.'/src/database/database.php';

if ( !isset($_POST['username'], $_POST['password']) ) {
	exit('Please fill both the username and password fields!');
}
$username = $_POST['username'];
$password = md5($_POST['password']);

$db = new database();
$cek_auth = $db->cek_user($username, $password);
if($cek_auth == true){
    $data_user = $db->get_data_user($username, $password);
    $semester_aktif = $db->cek_semester_aktif();
    $_SESSION['loged_in'] = true;
    $_SESSION['id_group'] = $data_user['id_group'];
    $_SESSION['id_user'] = $username; 
    $_SESSION['username'] = $data_user['first_name'];
    $_SESSION['kode_jurusan'] = $data_user['kode_jurusan'];
    $_SESSION['smt'] = $semester_aktif['semester'];
    $_SESSION['smt_aktif'] = $semester_aktif['smt_name'];
    header("Location: /dashboard_akademik");
}else{
    $_SESSION['login_failed'] = 'GAGAL LOGIN !';
    $_SESSION['loged_in'] = false;
    header("Location: /dashboard_akademik");
}
?>