<?php
//echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">';
echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';
//echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">';
echo "\r"; ?><html><head><title><?=$Tajuk_Muka_Surat?></title>
<?php include 'gambar_head.txt'; 
$kotak[0]='login_fancybox.txt'; 
$kotak[1]='login_colorbox.txt'; 
include ($kotak[rand(0,1)]);
// setkan nilai $isi dan $isi2
$isi = null;
$isi2 = null;
?>
</head>
<body background="../../bg/bg/<?php include 'gambar.php';?>">
<div id="content">
<table border="0" height="90%" width="100%">
<tr><td align="center" valign="middle"> 
<!-- ------------------------------------------------------------------------------------ -->
<form method="post" action="./">
<table border="0" align="center">
<tr><td align="center" valign="top"  colspan=2>
	<a style="font-size: 20pt; text-decoration: overline underline; 
	background-color: #000000; color:#ffffff">Untuk Penyiasatan MDT 2012</a>
	<a class="zoom" title="Apa Kabar En Fareza" href="./login_syarikat.php"
	style="font-size: 30pt; background-color: #ffff00; color:#ff0000">
	Klik Sini</a>
	</td></tr>
<tr><td width="1000" align="center" valign="top">
	<a style="font-size: 20pt; text-decoration: overline underline; 
	background-color: #000000; color:#ffffff" class="zoom" 
	title="Apa Kabar Pentadbir" href="./login.php?nama=admin">Pentadbir</a>
	<a style="font-size: 15pt; text-decoration: overline underline; 
	background-color: #000000; color:#ffffff">Kawalan</a>
	<a class="zoom" title="Apa Kabar Amin" href="./login.php?nama=amin007"> 
	<img src="../../bg/kakitangan/amin.jpg"></a>
	<a class="zoom" title="Apa Kabar Suhaida" href="./login.php?nama=suhaida"> 
	<img src="../../bg/kakitangan/suhaida.jpg"></a> 
	<br><a style="font-size: 15pt; text-decoration: overline underline; 
	background-color: #000000; color:#ffffff">Prosesan</a><?php
$prosesan=array('azizah','rahima','zainap');
foreach ($prosesan as $key => $nama2)
{	
	$isi2.="\n\t".'<a class="zoom" title="Assalamualaikum ' . 
		ucwords($nama2) . '" ' . 'href="./login.php?nama=' . $nama2 . '">' . 
		"\n\t" . '<img src="../../bg/kakitangan/' . $nama2 . '.jpg" ' . //'width="12%" height="12%"></a>';
		'></a>';
		
	$isi2.=($key==10)? "<br>\n":"\n";
}
echo $isi2;
?>
	</td></tr>
<tr><td align="center" valign="top">
	<a style="font-size: 15pt; text-decoration: overline underline; 
	background-color: #000000; color:#ffffff">FE</a><?php 
unset($pegawai);	
$pegawai=array('adam','ali','ariff','azim','norita','fendi','khairi',
'musa','mustaffa','shukor');
foreach ($pegawai as $key => $nama)
{	
	$isi.="\n\t" . '<a class="zoom" title="Assalamualaikum ' .
	ucwords($nama) . '" ' .	'href="./login_automatik.php?nama=' . $nama . '">' .
	"\n\t" . '<img src="../../bg/kakitangan/' . $nama . '.jpg"></a>';
	
	$isi.=($key==5)? "<br>\n":"\n";
}
	echo $isi;
?>	
	</td></tr>
<tr><td align="center" valign="top"  colspan=2>
	<a style="font-size: 15pt; text-decoration: overline underline; 
	background-color: #000000; color:#ffffff">KUP</a><?php 
unset($kup);
$isi=null;
$kup=array('murad','sujana');
foreach ($kup as $key => $nama)
{	
	$isi.="\n\t" . '<a class="zoom" title="Assalamualaikum ' .
	ucwords($nama) . '" ' .	'href="./login.php?nama=' . $nama . '">' .
	"\n\t" . '<img src="../../bg/kakitangan/' . $nama . '.jpg"></a>';
	
	$isi.=($key==5)? "<br>\n":"\n";
}
	echo $isi;?><br>
	<a style="font-size: 15pt; text-decoration: overline underline; 
	background-color: #000000; color:#ffffff">PEGAWAI</a>
	<a class="zoom" title="Apa Kabar En Mohd Safie" href="./login_automatik.php?nama=safie">
	<img src="../../bg/kakitangan/en_safie.jpg" width="50%" height="50%"></a>
	<a class="zoom" title="Apa Kabar En Fareza" href="./login_automatik.php?nama=fareza"
	style="font-size: 20pt; background-color: #ffff00; color:#ff0000">
	Fareza</a>
	</td></tr>
</table>
</form>
<!-- ------------------------------------------------------------------------------------ -->
</td></tr></table>
</div>
</body>
</html>