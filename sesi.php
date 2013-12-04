<?php
########################
#include"../sesi.php"; #
########################
/* dtg dari login
$_SESSION['login'] = "Yes"; 
$_SESSION[user] = $medan[nama]; 
$_SESSION[pass] = $medan[kataLaluan];
$_SESSION[status] = $medan[status]; 
*/
date_default_timezone_set('Asia/Kuala_Lumpur');
session_start();
$nama_anda= $_SESSION['user'];
$pass_anda= $_SESSION['pass'];
$level_anda= $_SESSION['level'];
$sql = $_SESSION['sql'];
$rekod = $_SESSION['rekod'];
$jumlah = $_SESSION['jumlah'];

if($_SESSION['user']==null): header('Location:../logout.php'); endif; 
$masaGunaSistem = 28800; // 1 jam = 3600 = 60 saat X 60 minit
$masaTinggal = time() - $_SESSION['tamatXtvt'];
if ( $masaTinggal > $masaGunaSistem) 
{//clear session, logout 
	header('Location:../logout.php'); 
}
?>