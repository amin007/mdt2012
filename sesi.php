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
	$nama_anda = (isset($_SESSION['user']) ) ? $_SESSION['user'] : null;
	$pass_anda = (isset($_SESSION['pass']) ) ? $_SESSION['pass'] : null;
	$level_anda = (isset($_SESSION['level']) ) ? $_SESSION['level'] : null;
	$sql =(isset($_SESSION['sql']) ) ? $_SESSION['sql'] : null;
	$rekod = (isset($_SESSION['rekod']) ) ? $_SESSION['rekod'] : null;
	$jumlah = (isset($_SESSION['jumlah']) ) ? $_SESSION['jumlah'] : null;


if($_SESSION['user']==null): header('Location:../logout.php'); endif; 
$masaGunaSistem = 28800; // 1 jam = 3600 = 60 saat X 60 minit
$masaTinggal = time() - $_SESSION['tamatXtvt'];
if ( $masaTinggal > $masaGunaSistem) 
{//clear session, logout 
	header('Location:../logout.php'); 
}
?>