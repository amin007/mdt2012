<?php
/* untuk senarai unit dalam jadual nama_pegawai - mula*/
function senarai_unit($url,$bil)
{ 
	$myTable='nama_pegawai'; 
	$id=$bil+1;
	$query  = "\tSELECT unit, count(*) as Jum FROM $myTable
	GROUP BY unit ORDER BY 2 ";

	$result = mysql_query($query) or diehard4('unit',$query);
	$fields = mysql_num_fields($result); $rows  = mysql_num_rows($result);
		// nak papar bil $rows
		if ($rows=='0'): 
			echo "<li><a href='#'>|</a><li>";
		else: // kalau jumpa
			echo "<a href='link_tambah.php?jadual=$myTable".
			"&id=$id'>Tambah Org ke($id)</a>\r\t\t<ul>\r";
			while($row = mysql_fetch_array($result,MYSQL_NUM))
			{
				echo "\t\t<li><a href='link_tambah.php?" .
				"jadual=mdt_$myTable&id=$id&unit=$row[0]'>" .
				$row[1] . " org)" . $row[0] . "</a></li>\r";
			}
		endif; //tamat jika jumpa
		echo "\t\t</ul>\r";
}/* untuk senarai unit dalam jadual nama_pegawai - tamat*/
/* untuk fail daftar_keluar.php - mula */
function senarai_kakitangan()
{
	$cari="SELECT fe,count(*) as Jum from mdt_rangka 
	WHERE fe is not null and fe<>'semak2'
	GROUP BY fe ORDER BY fe";
	$lihat = mysql_query($cari) or diehard4(0,$cari);
	while($lihat2 = mysql_fetch_array($lihat,MYSQL_NUM))
	{$pegawai[]=$lihat2[0];}//echo $pegawai;
	$w0=' style="background-color: black; color:yellow" ';
	//echo "<pre $wo>", print_r($pegawai)."</pre>";
	return $pegawai;
}
function jadual_bulanan()
{	
	$s=''; $t='12'; $bulan = array($s.'rangka',
	$s.'jan'.$t, $s.'feb'.$t, $s.'mac'.$t, $s.'apr'.$t, 
    $s.'mei'.$t, $s.'jun'.$t, $s.'jul'.$t, $s.'ogo'.$t, 
    $s.'sep'.$t, $s.'okt'.$t, $s.'nov'.$t, $s.'dis'.$t);

	$p=( !isset($_GET['p']) || $_GET['p']==null)? '':'&p='.$_GET['p'];
	$fe=( !isset($_GET['fe']) || $_GET['fe']==null)? '':'&fe='.$_GET['fe'];
	$item=( !isset($_GET['item']) || $_GET['item']==null)? '&item=30':'&item='.$_GET['item'];
	$jadual='<ul class="tabset_tabs">';
	
	foreach ($bulan as $key => $nama_bulan)
	{$jadual.= "\n".'<li><a href="./?jadual='.
	$nama_bulan.$p.$fe.$item.'">'.
	ucwords($nama_bulan).'</a></li>';
	}$jadual.= "\n</ul>";
	return $jadual;
}
function lihat($tab,$kini,$papar,$pegawai) 
{	
	$p=($papar==null)? '':'&p='.$papar;
	$item=($_GET['item']==null)? '&item=30':'&item='.$_GET['item'];
	$i=1;foreach ($pegawai as $value) 
	{$selit.=$tab.'<li><a href="./?'.
	$kini.$p.'&fe='.$value.$item.'&susun=1">'.
	$i++.'-'.$value.'</a></li>'."\r";}
	echo "\r".$selit.$tab;
}
function lihat1($tab,$kini,$papar,$pegawai) 
{	
	$p=($papar==null)? '':'&p='.$papar;
	$item=($_GET['item']==null)? '&item=30':'&item='.$_GET['item'];
	$i=1;foreach ($pegawai as $value) 
	{$selit.=$tab.'<li class="link"><span><a href="./?'.
	$kini.$p.'&fe='.$value.$item.'&susun=1">'.
	$i++.'-'.$value.'</a></span></li>'."\r";}
	echo "\r".$selit.$tab;
}
function lihat2($kini,$papar,$pegawai,$item) 
{	
	$i=1;foreach ($pegawai as $value) 
	{$selit.="\t\t<li><a href='./?$kini&p=$papar".
	"&fe=$value&item=$item&susun=1'>".
	$i++.". ".$value."</a></li>\r";}
	echo "\r$selit\t";
}
function lihatUtama($tab,$kini,$papar,$pegawai) 
{	
	$p=($papar==null)? '':'&p='.$papar;
	$A1=($papar==null)? '':'&p='.$papar.'_A1';
	$XA1=($papar==null)? '':'&p='.$papar.'_XA1';
	$item=($_GET['item']==null)? '&item=30':'&item='.$_GET['item'];
	$i=1;foreach ($pegawai as $value) 
	{
		$selit.=$tab.'<li><a href="./?'.
		$kini.$p.'&fe='.$value.$item.'&susun=1">'.
		$i++.'-'.$value.'</a>'."\r\t".$tab.
			'<ul>'."\r\t".$tab.
			'<li><a href="./?'.$kini.$A1.'&fe='.
			$value.$item.'&susun=1">'.
			'A1</a></li>'."\r\t".$tab.
			'<li><a href="./?'.$kini.$XA1.'&fe='.
			$value.$item.'&susun=1">'.
			'XA1</a></li>'."\r\t".$tab.
			'</ul>'."\r\t".$tab.
		'</li>'."\r";
	}
	echo "\r".$selit.$tab;
}
/* untuk fail daftar_keluar.php - tamat */
/* untuk sql pada fail index.php - mula */
function diehard4($bil,$sql) 
{
	$w0=' style="background-color: #fffaf0; color:black" ';
	$w1='<span style="background-color: #fffaf0; color:black">';$w2="</span>";
	echo $w1.mysql_error().'<hr><pre'.$w0.'>'.$bil.'->'.$sql.'</pre><hr>';
}
function paparan($result,$fields,$rows,$myTable,$bil) 
{// function paparan() - mula
	echo "\n".'<table border="1" class="excel" id="example">'.
	"<thead><tr>\n<th>#</th>\n";
	
	for($f=0;$f < $fields;$f++)
	{
		echo '<th>' . mysql_field_name($result,$f) .
		'&nbsp;</th>' . "\n";
	}
	
	echo "</tr></thead>\n<tbody>\n";
	while($row = mysql_fetch_array($result,MYSQL_NUM))
	{// mula papar 
			$link1=')<a target="_blank" href="kawal_';
			$link2=')<a target="_blank" href="link_';
			$level=$_SESSION['level'];
			$p=$_GET['p'];
	
		$nom="\n<td>" . $bil++;
		$nom.=($level=='kawal')?
		( ($p=='Laporan_Bulanan')||($p=='Laporan_Utama')?'':
			( $myTable=='semak' ? 
			$link1 . 'alamat.php?cari='.$row[0].'">Semak</a>'
			:$link1 . 'edit.php?cari='.$row[0].'">Kawal</a>'
			)
		)
		:	(	($level=='admin')?
			($link2 . 'ubah.php?cari='.$row[0].'">Ubah</a>')
			:($link1 . 'edit.php?cari='.$row[0].'">Semak</a>')
			);
		$nom.="</td>\n";
		//$nom.='<td><input type="checkbox"></td>';
	
	echo '<tr>'.$nom;
		for($f=0;$f<$fields;$f++)
		{
			echo '<td align=right>'.$row[$f]."&nbsp;</td>\n";
		}
	echo "</tr>\n";
	}// tutup papar
	echo "</tbody>\n</table>\n";
}// function paparan() - tamat
	function halaman($mula,$tamat,$page,$bil_semua,$muka_surat,$myTable,$baris_max)
{// function halaman() - mula
	$senarai_medan="jadual=$myTable&p=".$_GET['p']."&item=$baris_max";
	echo "\n<div align=left>$mula\nJadual : $myTable | " .
		"Bil Kes : ($bil_semua) Papar halaman "; 
	if($page > 1) // Bina halaman sebelum
		{echo "\r<a href='?page=".($page-1)."&$senarai_medan'>Sebelum</a> |";}
	for($i = 1; $i <= $muka_surat; $i++) // Bina halaman terkini
		{echo ($page==$i)? " ($i) |":"\r<a href='?page=$i&$senarai_medan'>$i</a>|";}
	if($page < $muka_surat) // Bina halaman akhir
		{echo "\r<a href='?page=".($page+1)."&$senarai_medan'>Lagi</a>";}
	echo "\n$tamat</div>\n";
}// function halaman() - tamat
/* untuk sql pada fail index.php - tamat */