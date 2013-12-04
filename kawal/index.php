<?php include '../sesi.php'; include '../db_buka.php';?>
<html>
<head><title><?=$Tajuk_Muka_Surat?> [<?=$_GET['p'];?>]</title>
<script type="text/javascript" src="../../../js/filter/jquery-1.4.2.min.js"></script>
<link rel="stylesheet" type="text/css" href="../../../js/filter/susun.style.css" />
<script type="text/javascript" src="../../../js/filter/susun.application.js"></script>

<?php 
include '../css.txt'; echo "\n";
include '../css2.txt'; echo "\n";
include '../gambar_head.txt'; echo "\n";
include '../excel.txt'; echo "\n";
?>
</head>
<body background="../../../bg/bg/<?php include '../gambar2.php';?>">
<div id="content">
<?php
//echo "<pre>", print_r($_SESSION)."</pre>";
$w0=' style="background-color: black; color:yellow" ';
$s1='<span style="background-color: #fffaf0; color:black">';$s2='</span>';
$p1='<pre style="background-color: #fffaf0; color:black">';$p2='</pre>';
##################################
$myTable=$_GET['jadual'];
include '../daftar_fungsi.php';
$pegawai=senarai_kakitangan();
include '../daftar_keluar.php'; 
include '../sql.php';
##################################
#######------- Mula- Bina hyperlink untuk nombor halaman ----------##########
$semua = mysql_query($sql) or diehard4(1,$sql); 
$bil_semua = mysql_num_rows($semua);// Tentukan bilangan baris di dalam DB:
#######-------Tamat- Bina hyperlink untuk nombor halaman ----------##########
########### mula setkan pemboleh ubah untuk sql kedua ############
// ambil halaman semasa, jika tiada, cipta satu! 
$page =( !isset($_REQUEST['page']) )? 1: $_REQUEST['page'];
// berapa item dalam satu halaman
$baris_max = ( !isset($_REQUEST['item']) )? 40: $_REQUEST['item'];
// Tentukan had query berasaskan nombor halaman semasa.
$dari_baris = (($page * $baris_max) - $baris_max); 
// Tentukan bilangan halaman. 
$muka_surat = ceil($bil_semua / $baris_max);
// nak tentukan berapa bil baris dlm satu muka surat
$bil = $dari_baris+1; 
########### mula setkan pemboleh ubah untuk sql kedua ############
#####----- Mula- query (LIMIT ".$dari_baris.", ".$baris_max.") ---###
$query = $sql.' LIMIT '.$dari_baris.', '.$baris_max; 

$result= mysql_query($query) or diehard4(2,$query); 
$fields= mysql_num_fields($result); $rows = mysql_num_rows($result);
#####-----Tamat- query (LIMIT ".$dari_baris.", ".$baris_max.") ---###
#######------- Mula- papar jadual data dari sql -------------#############
halaman($s1,$s2,$page,$bil_semua,$muka_surat,$myTable,$baris_max);
// nak cari $rows
if ($rows=='0'): 	
	echo $p1.' Dah Habis Untuk '.$_GET['p'].$p2."\n";
else: // mula kalau jumpa
	paparan($result,$fields,$rows,$myTable,$bil);
endif; //tamat jika jumpa
// tamat - cari $rows
halaman($s1,$s2,$page,$bil_semua,$muka_surat,$myTable,$baris_max);
#######-------Tamat- papar jadual data dari sql -------------#############
//while($row = mysql_fetch_array($result,MYSQL_NUM)){echo "<pre>"; print_r($row)."</pre>"; }
?></div>
</body>
</html>