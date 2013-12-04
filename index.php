<?php
session_start(); 
if (isset($_SESSION['user']) &&  isset($_SESSION['level']))
{
	$nama_anda=$_SESSION['user'];
	$level=$_SESSION['level'];
}
else
{
	$nama_anda=null;
	$level=null;
}

if ($level!=null) 
{
	include "db_level.php"; /*semak tahap keselamatan*/
}
elseif ( (! isset($_POST['masuk'])) and ($level==null) )
{ 
	$Tajuk_Muka_Surat='MDT 2012'; 
	include "login_gambar.php"; /*  masuk antaramuka kata laluan  */ 
} 
else 
{ 
	include "db_buka.php"; /* buka pangkalan data */
	$_POST['password']=md5($_POST['password']);

	$sql="select * from nama_pegawai where namaPegawai='{$_POST['username']}' 
	and kataLaluan='{$_POST['password']}'";

	$rslt  = mysql_query($sql) or die (mysql_error()."<hr>$sql<hr>");
	$medan = mysql_fetch_array($rslt); /*array utk $sql */
	$bil   = mysql_num_rows($rslt);

	//-------------------------------------------------------------------------------
		if($bil==1) 
		{
			$_SESSION['login'] = 'Yes'; 
			$_SESSION['tamatXtvt'] = time();
			$_SESSION['user'] = $medan['namaPegawai']; 
			$_SESSION['pass'] = $medan['kataLaluan'];
			$_SESSION['level'] = $medan['level']; 
			$_SESSION['nohp'] = $medan['nohp']; 
			$level = $medan['level']; 
			include "db_level.php";/*semak tahap keselamatan*/
		}
		else
		{ 
			$_SESSION['login'] = 'No'; 
###############################################################################################
?>
<html><head><title>-</title>
<?php include 'gambar_head.txt'; ?>
</head>
<body background="../../bg/bg/<?php include 'gambar.php';?>">
<table border="0" height="90%" width="100%">
<tr><td align=center valign=middle><div id="content">
<!-- ------------------------------------------------------------------------------------ -->
<form method="POST" action="./">
<span style='font-size: 20pt; background-color: black; color:yellow' >
Sila masukkan nama & kata laluan yang betul !!!</span>
<br><input type="submit" name="kembali" value="login semua" class="masuk">
</form>
<!-- ------------------------------------------------------------------------------------ -->
</div></td></tr></table>
</body>
</html>
<?php
###############################################################################################
		} // tamat $_SESSION['login'] = "No";  
	//-------------------------------------------------------------------------------

} #-- tamat - if (! isset($_POST['masuk'])) ?>
