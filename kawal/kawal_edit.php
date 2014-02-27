<?php 
include '../sesi.php'; include '../db_buka.php';# buka pangkalan data
if (!isset($_POST['semua'])) { ?><?php 
	function papartajuk($fields,$result,$myTable)
{// function papartajuk() - mula
	echo "\n<tr>\n" . '<td>#</td><td>id pertubuhan</td>';
	for ($f=1;$f < $fields;$f++)
		{ echo (mysql_field_name($result,$f)=='nama'
		||mysql_field_name($result,$f)=='nama syarikat') ?
		'<td>nama(Jadual:'.$myTable.')</td>'."\n":
		'<td>'.mysql_field_name($result,$f).',</td>'."\n"; }
	echo '</tr>';
}// function papartajuk() - tamat
	function paparisi($myTable,$row,$result,$fields,$rows,$bil)
{// function paparisi() - mula
	echo($bil%'2'=='0')?"\n<tr bgcolor='#ffffe0'>":"\n<tr bgcolor='#ffe4e1'>";
	
		$p = ($myTable=='mdt_rangka') ?
		'href="kawal_tambah.php?cari='.$row[2].'"':
		'href="kawal_edit.php?cari='.$row[1].'"';
		
	echo "\n<td><a $p>".$bil."</a></td>";
	for($f=0;$f<$fields;$f++)
	{
		echo "\n<td>".$row[$f]."</td>";
	}
	echo "\n</tr>";
}// function paparisi() - tamat
	function paparisi2($myTable,$row,$result,$fields,$rows,$bil)
{// function paparisi2() - mula
	echo($bil%'2'=='0')?"\n\t\t<tr bgcolor='#ffffe0'>":"\n\t\t<tr bgcolor='#ffe4e1'>";
	echo "\n\t\t<td>".$bil."</td>";
	
	for($f=0;$f<$fields;$f++)
	{
		echo "\n\t\t<td>".$row[$f]."</td>";
	}
	echo "\n\t\t</tr>\n";
}// function paparisi2() - tamat
	function msic($industri,$industriB)
{// function msic() - mula	
	echo "\r\t<td>\r".
	'<!-- ################################################################### -->';
	
	$MSIC = array('msic','msic2008','msic_v1','msic_nota_kaki','msic_bandingan');
	foreach ($MSIC as $key2 => $jadual)
	{// $MSIC ulang jadual-mula
	$m=($jadual!='msic2008')?'*':
	"seksyen S,bahagian B,kumpulan Kpl,kelas Kls,msic2000,msic,keterangan,notakaki";
	$sql2="SELECT $m\rFROM $jadual WHERE msic='".$industri."' OR msic='".$industriB."'";

	$result = mysql_query($sql2) or die(mysql_error()."<hr>$sql2<hr>"); 
	$fields = mysql_num_fields ($result); $rows = mysql_num_rows ($result);
	
	// nak papar bil. brg
	if ($rows=='0' or $industri==null): echo "\r\t\t" .
	'<span style="background-color: black; color:yellow">' .
	":( $jadual:MSIC=$industri $industriB</span><br>\r";
	else: // kalau jumpa
		$nama_jadual='<span style="background-color: black; color:yellow">' . $jadual . '</span>';
		echo "\r\t\t<table border=1 class='excel' bgcolor='#ffffff'>" .
		"\n\t\t<tr>"."\n\t\t<td>#</td>";
		
		for ( $f = 0 ; $f < $fields ; $f++ )
		{ 
			echo (mysql_field_name($result,$f)=='keterangan') ?
			"\n\t\t<td>keterangan - $nama_jadual</td>":
			"\n\t\t<td>".mysql_field_name($result,$f).",</td>"; 
		}
		
		echo "\n\t\t</tr>";

		$bil=1;
		while($row = mysql_fetch_array($result,MYSQL_NUM))
		{
			paparisi2($jadual,$row,$result,$fields,$rows,$bil);
			$bil++;
		}

		echo "\t\t</table>\r";
		
	endif; //tamat jika jumpa
	}//$MSIC ulang jadual-tamat
	echo "\t".'</td>
<!-- ################################################################### -->';		
}// function msic() - tamat
function cariMedanInput($ubah,$f,$row,$nama) 
{//function cariMedanInput($f,$nama,$input)  - mula
	/*senarai nama medan
	0-nota,1-respon,2-fe,3-tel,4-fax,		
	5-responden,6-email,7-msic,8-msic08,
	9-`id U M`,10-nama,11-sidap,12-status
	*/// papar medan yang terlibat
	$cariMedan=array(0,1,2,3,4,5);
	$cariText=array(0);// papar jika nota ada
	$cariMsic=array(8); //papar input text msic sahaja 
	$medanR=$ubah.'['.$nama.']';
		
	// tentukan medan yang ada input
	$input=in_array($f,$cariMedan)? 
	(@in_array($f,$cariMsic)? // tentukan medan yang ada msic
		'<input type="text" name="'.$medanR.'" value="'.$row[$f].'" size=6>'
		:(@in_array($f,$cariText)? // tentukan medan yang ada input textarea
			'<textarea name="'.$medanR.'" rows=2 cols=23>'.$row[$f].'</textarea>':
			'<input type="text" name="'.$medanR.'" value="'.$row[$f].'" size=30>')
	):'<label class="papan">'.$row[$f].'</label>';
	
	return $input;

}//function cariMedanInput($f,$nama,$input)  - tamat
function kira($kiraan)
{
	return number_format($kiraan,0,'.',',');
}
//@$kiraan=(($kini-$dulu)/$dulu)*100; 
function kira2($dulu,$kini)
{
	return @number_format((($kini-$dulu)/$dulu)*100,0,'.',',');
}
function kira3($dulu,$kini)
{
	return @number_format((($kini-$dulu)/$dulu)*100,0,'.','');
}
//@$kiraan=(($kini-$dulu)/$dulu)*100;
function diehard4($bil,$sql) 
{
	$w0=' style="background-color: #fffaf0; color:black" ';
	$w1='<span style="background-color: #fffaf0; color:black">';$w2='</span>';
	echo $w1.mysql_error().$w2.'<hr><pre'.$w0.'>'.$bil."->\r".$sql.'</pre><hr>';
}
function bersih($papar) 
{
	# lepas lari aksara khas dalam SQL
	//$papar = mysql_real_escape_string($papar);
	# buang ruang kosong (atau aksara lain) dari mula & akhir 
	$papar = trim($papar);
	
	return $papar;
}
$pilihan='newss';
$carian=bersih($_GET['cari']);
$_GET['cari']=bersih($_GET['cari']);
# semak bulan semasa
$bln = getdate();
$semakBln = $bln['mon'];
$bulanan = array('jan', 'feb', 'mac', 'apr', 
	'mei', 'jun', 'jul', 'ogo', 
	'sep', 'okt', 'nov', 'dis'); 
$semakBulan = $bulanan[$semakBln-1];
$caripapar = //$semakBln . $semakBulan . '=' . 
$_GET['cari'];
?>
<html>
<head><title>Kes MDT 2012:<?=$caripapar?></title>
<script type="text/javascript" src="../../../js/datepick/jquery.js"></script>
<!-- pilih tarikh - mula -->
<link rel="stylesheet" href="../../../js/datepick/datepick.css" type="text/css" />
<link rel="stylesheet" href="../../../js/datepick/flora.datepick.css" type="text/css" />
<script type="text/javascript" src="../../../js/datepick/datepick.js"></script>
<script type="text/javascript" src="../../../js/datepick/datepick-ms.js"></script>
<!-- pilih tarikh - tamat -->
<!-- mesin kira - mula -->
<link rel="stylesheet" href="../../../js/calc/calc.alt.css" type="text/css" />
<script type="text/javascript" src="../../../js/calc/calc.min.js"></script>
<script type="text/javascript" src="../../../js/calc/calc.my.js"></script>
<!-- mesin kira - tutup -->

<?php 
//include '../css.txt'; 
//include '../gambar_head.txt';
include '../excel.txt';
include '../autocomplete.txt';
?>
</head>
<body background="../../../bg/bg/<?php include '../gambar2.php';?>">
<div id="content">
<fieldset><legend>
<span style="background-color: black; color:yellow">
(Cari Kes MDT 2012<?=$caripapar?>)</span></legend>
<?php
$s1='<span style="background-color: black; color:yellow">';
$hr=')<hr>';$s2='</span>';
#------------------------------------------------------------------------------#
//$myJadual=array('mdt_rangka');
$blnlepas='pom_bln11.mdt_' . $semakBulan . '11';
$rgklepas='pom_bln11.mdt_rangka';
$id = 'concat(substring(newss,1,3),\' \',substring(newss,4,3),\' \','.
	'substring(newss,7,3),\' \',substring(newss,10,3)'.
	') as id,';
//$myJadual=array('dtsample3','mdt_johor','dtkawal',
//	$rgklepas,$blnlepas,'mdt_pom','mdt_rangka');
$myJadual=array('mdt_pom');
// medan dtsample3 $medanSemak[]= $id . 'newss,nama,ng,dp,sv,msic,status,indeks';
/* medan mdt_johor $medanSemak[]= $id . 'newss,concat(nama,\'<br>\',sidap) `nama syarikat`,'.
	'operator,alamat1,alamat2,poskod,ngdbbp,status,sv,msic,label,'.
	'catatan11,catatan12,fe11,fe';
	*/
/* medan dtkawal $medanSemak[]= $id . 'concat(nama,\'<br>\',sidap2009) `nama syarikat`,' .
	'operator,alamat1a,alamat2b,poskod,NGDBBP,utama,' .
	'penyiasatan jenis,kod_sv_baru,msic,bil,fe,cek,cek2 ' .
	'`STATE_NAME_MS`,`EB ID PO_ORGUNIT_NAME`,`DISTRICT_NAME_MS`,' .
	'';*/
/* medan $rgklepas $medanSemak[]= $id . 'concat(nama,\'<br>\',sidap) `nama syarikat`,' .
	'operator,alamat1,alamat2,poskod';*/
/* medan $blnlepad $medanSemak[]= $id . "\r" . 
	'nama,msic08,terima,"bln'.$semakBln.'",hasil,dptLain,web,' .
	'stok,staf,gaji,sebab,outlet,""';*/
/* medan mdt_pom */	
$medanSemak[]= $id . 'newss,concat(nama,\'<br>\',sidap) `nama syarikat`,'.
	'operator,concat_ws(\'<br>\',alamat1,alamat2,poskod) alamat,ngdbbp,status,sv,msic,label,'.
	'catatan11,catatan12,/*fe11,*/fe';
/* medan mdt_rangka 	
$medanSemak[]= $id . 'newss,nama,concat(operator,\'<br>\',sidap) `operator`,ssm,' .
	'R.status as U,sv,msic,msic08,alamat1,alamat2,poskod,fe,label';*/
//------------------------------------------------------------------------------
$myJoin='nama_pegawai';
foreach ($myJadual as $key => $myTable)
{// mula ulang table
	$sql="\tSELECT ".$medanSemak[$key]." FROM 
	".$myTable." R /*LEFT JOIN ".$myJoin." J
	ON R.fe = J.namaPegawai */
	WHERE concat(newss,nama) like '%".$carian."%' ";
	//echo $s1.$hr.$sql.$s2;

	$result = mysql_query($sql) or diehard4($myTable,$sql);
	//die($s1.mysql_error().$hr.$sql.$s2);
	$fields = mysql_num_fields($result);
	$baris = mysql_num_rows($result);

	// nak papar bil. brg
	if ($baris=='0' or $_GET['cari']==null): 
		echo '<span style="background-color: black; color:white">'.
		'Maaflah, ' . $_GET['cari'] . ' tak jumpalah pada jadual :' .
		$myTable . '|<font face=Wingdings size=5>L</font></span><br>';

	elseif($baris=='1'): // kalau jumpa
		echo '<table border=0 class="excel" bgcolor="#ffffff">';
		echo '<caption>Jumpa Sebaris</caption>';
		papartajuk($fields,$result,$myTable);
		
		//$bil=1;while($row = mysql_fetch_array($result,MYSQL_NUM))
		$bil=1;while($row = mysql_fetch_array($result))
		{// mula papar 
			paparisi($myTable,$row,$result,$fields,$baris,$bil);
			$bil++;
				$noID=$row['newss'];
				$kawan=(!isset ($row['fe'])) ? null : $row['fe'];
				$telkawan=(!isset ($row['nohpfe'])) ? null : $row['nohpfe'];
				$survey=(!isset ($row['sv'])) ? null : $row['sv'];
				//echo '$blnlepas=' . $blnlepas;
			/*
			if ($myTable==$blnlepas) 
			{
				for ( $c = 1 ; $c < $fields ; $c++ )
				{
					$namamedan=mysql_field_name($result,$c);
					$lepas[$namamedan]=$row[$namamedan];
				}
			}*/
		}// tutup papar
		echo "\n</table>\n";
	else : 
		echo '<span style="background-color: black; color:red">'.
		'banyak pulak datanya. pilih satu sahaja</span>'."\n".
		'<table border=0 class="excel" bgcolor="#ffffff">';
		papartajuk($fields,$result,$myTable);
			
		$bil=1;while($row = mysql_fetch_array($result,MYSQL_NUM))
		{
			paparisi($myTable,$row,$result,$fields,$rows,$bil);
			$bil++;
		}
		echo "\n</table>\n";
	endif; //tamat jika jumpa
}// tamat ulang table
//------------------------------------------------------------------------------
//echo '<pre>$lepas->'; print_r($lepas) . '</pre>';
$lepas = null;
//style="position: relative; top: -12px; left: 80px;" ?>
</fieldset>
<div align="center"><form method="GET" action="">
<font size="5" color="red"><?=( !isset($_GET['ralat']) ? '':$_GET['ralat'] )?>&rarr;</font><br>
<input type="text" name="cari" size="40" value="<?=$carian;?>" 
id="inputString" onkeyup="lookup(this.value);" onblur="fill();">
<input type="submit" value="mencari">
<div class="suggestionsBox" id="suggestions" style="display: none; " >
	<img src="../../../js/autocomplete/upArrow.png" alt="upArrow" 
	style="display: block; margin-left: auto; margin-right: auto"	/>
	<div class="suggestionList" id="autoSuggestionsList">&nbsp;</div>
</div>
</form></div>
<!-- ----------------------------------------------------------------------------------------------------- -->
<form action="kawal_edit.php?cari=<?=$_GET['cari'];?>#bawah" enctype="multipart/form-data" method="POST">
<?php
if ($baris!=1)
{
	echo '<span style="background-color: black; color:red">
	<font size=5>Tak Jumpa Daa</font></span>';
}
else 
{
	include 'kawal_edit_borang.php';
} 
?>
</form>
</div>
</body></html><?php
} else {
// Mula Isytihar Fungsi ********************************************************************************** -->
function update_table( $the_table, $data, $pilihMedan ) 
{
	// cek $data dan $the_table
	//echo '<pre>$data['.$the_table.']', print_r($data) . '</pre>';
	
	// set blank values
	$primary_id = null;
	$fields = array();

	// find fields from table
	$sql = "SHOW COLUMNS FROM $the_table";
	$res = mysql_query($sql) or diehard4('papar medan-',$sql);

	while ($field = mysql_fetch_array($res)) 
	{
		if ($field['Key'] == 'PRI')
			$primary_key = $field['Field'];
		else
			$fields[] = $field['Field'];
	}
 
	$fields = array_flip( $fields ); // flip db field array
	$filtered = array_intersect_key( $data, $fields );// remove non exist array on post data
	array_walk($filtered, create_function('&$val', '$val = mysql_real_escape_string(trim($val));') ); // clean up value 
	
	// tentukan pilihan nak buat $papar==null atau tidak
	if ($pilihMedan=='kosong')
	{
		foreach ($filtered as $medan => $papar)
		{
			//$senarai[]=($papar==null || $papar=='0') 
			$senarai[]=($papar==null) ? " $medan=null" : " $medan='$papar'"; 
		}
		
		$statment=implode(",\r",$senarai);
	}
	else
	{
		$satu=implode( "='%s',\r", array_keys( $filtered ) );
		$statment = vsprintf( 
		$satu . "='%s'", array_values( $filtered ) 
		); // create statement update
	}	
	
	// check if primary key exists
	if ($primary_key && $data[$primary_key])
		$where = "$primary_key = '$data[$primary_key]'";
	 
	$full_sql = " UPDATE $the_table SET \r" .
	"$statment \r WHERE $where";
		
	return $full_sql;
}
function bersih($papar) 
{
	# lepas lari aksara khas dalam SQL
	$papar = mysql_real_escape_string($papar);
	# buang ruang kosong (atau aksara lain) dari mula & akhir 
	$papar = trim($papar);

	return $papar;
}
function diehard4($bil,$sql) 
{
	$w0=' style="background-color: #fffaf0; color:black" ';
	$w1='<br><span style="background-color: #fffaf0; color:black">';
	$w2='</span>';
	echo $w1 . mysql_error() . $w2 . '<hr><pre' . $w0 . '>' .
	$bil . "->\r" . $sql . '</pre><hr>';
}
function ubah($ubah,$masalah,$nama_anda) 
{
	$result = mysql_query($ubah) or diehard4($masalah,$ubah);
	//logxtvx($nama_anda,$ubah);
}
function logxtvx($nama_anda,$ubah)
{# nak log aktiviti user=========================
	$_POST['user'] = $nama_anda;
	$_POST['aktiviti'] = 'kemaskini mdt2012';
	$_POST['arahan_sql'] = "<pre>($ubah)</pre>";
	include '../log_xtvt.php';
}#===============================================
function sms_kawan($myTable)
{
	// bersihkan pembolehubah
	$m['kes']    = bersih($_POST['syarikat']);
	$m['kawan']  = bersih($_POST['kawan']);
	// mula parameter sms
	$p['userid'] = 'amin77';
	$p['passwd'] = 'amin@@7';
	$p['message']= $m['kawan'] . ', kes ' . $m['kes'] .
	' sudah sampai pada ' .	date('j \hb M Y, \j\a\m g:i a') .
	' hari ini.'; //Cepat sampai kes??? Harap2 dapat anugerah cemerlang tahun ini. ';
	$p['mobile_no']='6' . bersih($_POST['telkawan']);
	$p['token']='i1d04568126feca38d0d7957abc377f6d';
	//$p['mobile_no']='60122159410';// amin punya hp
	$url='http://202.171.45.205/blast/sms_gwy.php?' . data_get($p);
	
	//echo '<pre>', print_r($p) . '</pre><br>' . $url . '<br>';
	return $papar = file_get_contents($url);
}
function data_get($data)
{
	$dataGet = '';
	foreach($data as $key=>$val)
	{
		if (!empty($dataGet)) $dataGet .='&';
		$dataGet .=$key . '=' . urlencode($val);
	}

	return $dataGet;
}
// Tamat Isytihar Fungsi ********************************************************************************** -->

// Mula Proses Kawalan ****************************************************************************** -->
	//echo '<pre>'; print_r($_POST) . '</pre>';
	# buat peristiharan
	$_POST['mdt_rangka']['respon']=strtoupper($_POST['mdt_rangka']['respon']);
	$_POST['mdt_rangka']['fe']=strtolower($_POST['mdt_rangka']['fe']);
	$_POST['mdt_rangka']['email']=strtolower($_POST['mdt_rangka']['email']);
	$_POST['mdt_rangka']['responden']=mb_convert_case($_POST['mdt_rangka']['responden'], MB_CASE_TITLE);
	$m['pilih'] = bersih($_POST['pilihan']);
	$m['cari']  = bersih($_POST['carian']);

	$bulan = array('rangka',
		'jan', 'feb', 'mac', 'apr', 
		'mei', 'jun', 'jul', 'ogo', 
		'sep', 'okt', 'nov', 'dis');
		
	# if ($m['cari']==null) - mula -----------------------------------------------------------
	if ($m['cari']==null) :
		echo '<br><font color=blue>Maaflah,(newss=' . $m['cari'] . ') tak isi <br>' .
		'<font face=Wingdings size=5>L</font><a href="../">Menu Utama</a></font>';
	else :
	#-- Mula Lihat Dlm Kawalan  
		#ulang jadual
		foreach ($bulan as $key => $bln)
		{// mula ulang jadual -------------------------------------------------------
			#set primary key
			$myTable=($bln=='rangka')?'mdt_' . $bln : 'mdt_' . $bln . '12';
				$data=$_POST[$myTable];
				$data[$m['pilih']] = $m['cari'];
			//echo "<pre>$myTable-", print_r($data) . '</pre>';
			
			$ubah=update_table($myTable, $data, 'kosong');
			//diehard4('$ubah',$ubah); // papar $ubah
			ubah($ubah,'ubah ' . $myTable,$nama_anda);
		}// tamat ulang jadual -------------------------------------------------------
	#-- Tamat Lihat Dlm Kawalan dan pergi ke borang kawal_edit.php
	$ralat='Selesai';#$ralat=sms_kawan($myTable);
	header('Location:./kawal_edit.php?cari=' . $m['cari'] . '&ralat=' . $ralat . '#bulan');
	endif;
	# if ($m['cari']==null) - tamat -----------------------------------------------------------
// Tamat Proses Kawalan ****************************************************************************** -->
}?>