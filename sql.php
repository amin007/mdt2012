<?php
$_GET['susun']=( !isset($_GET['susun']) || $_GET['susun']==1)? 'fe,nama':'1'.$_GET['susun'];
##############################################
// nak buat tab - mula 
$tab = array('mdt_rangka', 
'mdt_jan', 'mdt_feb', 'mdt_mac', 'mdt_apr', 
'mdt_mei', 'mdt_jun', 'mdt_jul', 'mdt_ogo', 
'mdt_sep', 'mdt_okt', 'mdt_nov', 'mdt_dis');
//unset($tab[0]);
$bulan = array('rangka',
'jan', 'feb', 'mac', 'apr', 
'mei', 'jun', 'jul', 'ogo', 
'sep', 'okt', 'nov', 'dis');
//unset($bulan[0]);
##############################################	
$p=( !isset($_REQUEST['p']) || $_GET['p']==null)? null : $_REQUEST['p'];
$fe=( !isset($_REQUEST['fe']) || $_GET['fe']==null)? null : $_REQUEST['fe'];
switch ($p) 
{// mula - semak $_REQUEST['p']
case "SemakUtama":
	////////////////////////////////////////////////////////
	// setkan pembolehubah
	$bil_jadual=count($tab); 
	$r="status";
	$thn='12';//tahun semasa
	// ulang medan
	for($i=0;$i < $bil_jadual;$i++)
	{$kodA.= " ".$tab[$i]."$thn.$r as ".$bulan[$i]."12";
	$kodA.=($i==$bil_jadual-1) ? "\r" : ",\r";} 
	// ulang kurungan
	for($i=0;$i < $bil_jadual-1;$i++)
	{$kodB.=($i==$bil_jadual-1) ? "" : "(";} 
	// ulang inner join
	for($i=0;$i < $bil_jadual-1;$i++)
	{$kodC.= "INNER JOIN " . $tab[$i+1] . "$thn ".
	"ON " . $tab[$i] . "$thn.newss = " . $tab[$i+1] . "$thn.newss ";
	$kodC.=($i==$bil_jadual-1) ? "\r" : ")\r";} 
	// ulang medan
	////////////////////////////////////////////////////////
	$sql ="SELECT s.newss, s.nama, s.utama U,".
	"$kodA FROM $kodB (dtsample s \r".
	"INNER JOIN mdt_rangka ON s.newss = mdt_rangka.newss ) \r".
	"$kodC ".
	"WHERE (mdt_rangka.status='bbu' and s.utama='bukan kes utama') ".
	"ORDER BY 3,2 ";
	//echo $p1.'-bil:'.$bil_jadual.'-'.$sql.$p2;
	break;
case "BandingKawal":
	$msic='if(semasa.msic08 is null,semasa.msic08,semasa.msic08)';
	if (isset($myTable)){$sebelum = (array_search($myTable,$bulan))-1;}
	echo $warna1.'Bandingan Antara Bulan '.$myTable.' Dan '.$bulan[$sebelum].$warna2;
	// hasil+lain
	$lepas="lepas.terima as `terima lepas`,format(lepas.hasil,0) as `hasil lepas`,".
	"format(lepas.dptLain,0) as `dptLain lepas`";
	$semasa="semasa.terima as `terima semasa`,format(semasa.hasil,0) as `hasil semasa`,".
	"format(semasa.dptLain,0) as `dptLain semasa`";
	$peratus="format((((semasa.hasil-lepas.hasil)/lepas.hasil)*100),2)";
	$peratus2="format(((( (semasa.hasil+semasa.dptLain)-(lepas.hasil+lepas.dptLain) )".
	"/lepas.hasil+lepas.dptLain)*100),2)";
	// gaji
	$gajilepas="format(lepas.gaji,0) as `gaji lepas`";
	$gajisemasa="format(semasa.gaji,0) as ` gaji semasa`";
	$gajiperatus="format((((semasa.gaji-lepas.gaji)/lepas.gaji)*100),2)";
	// staf
	$staflepas="format(lepas.staf,0) as `staf lepas`";
	$stafsemasa="format(semasa.staf,0) as ` staf semasa`";
	$stafperatus="format((((semasa.staf-lepas.staf)/lepas.staf)*100),2)";
	//sql
	$sql="SELECT semasa.newss,semasa.nama,\r".
	"$msic msic,\rsemasa.status,semasa.fe,\r".
	"$lepas,\r$semasa,\r$peratus as `peratus`,\r".
	"$peratus2 as `peratus2`,\r".
	"$gajilepas,\r$gajisemasa,\r$gajiperatus as `gaji%`,\r".
	"$staflepas,\r$stafsemasa,\r$stafperatus as `staf%`,\r".
	"semasa.sebab\r".
	"FROM mdt_".$bulan[$sebelum]." lepas, mdt_$myTable semasa\r".
	"WHERE lepas.newss=semasa.newss ";
	$sql.=$_SESSION['level']=='fe' ? "and lepas.fe='".$_SESSION['user']."' "
	:(($fe==null) ? '': "and lepas.fe='".$fe."' ");
	$sql.="\rORDER BY ".$_GET['susun']." ";
	//echo $p1.$sql.$p2;
	break;
case "BBU": case "SBU":
	$msic='if(b.msic08 is null,c.msic,b.msic08)';
	$r="b.newss,b.sidap,b.nama,c.batch B,c.respon R,b.terima,".
	"format(b.hasil,0) as hasil,format(b.dptlain,0) as dptlain,\r".
	"format(b.stok,0) as stok,b.staf,format(b.gaji,0) as gaji,".
	"b.outlet,b.sebab,b.status U ,$msic msic08,c.fe ";
	$sql="SELECT $r \rFROM mdt_$myTable b, mdt_rangka as c
	WHERE (b.newss=c.newss and b.status='".$_GET['p']."') ";
	$sql.=$_SESSION['level']=='fe' ? "and c.fe='".$_SESSION['user']."' "
	:(($fe==null) ? '': "and c.fe='".$fe."' ");
	$sql.="\rAND c.fe<>'batal'\rORDER BY ".$_GET['susun']." ";
	//echo $p1.$sql.$p2;
	break;
case "BBU_A1": case "SBU_A1":
	$utama=substr(''.$_GET['p'].'',0,3);
	$msic='if(b.msic08 is null,c.msic,b.msic08)';
	$r="b.newss,concat(B.nama,'<br>',B.sidap) as nama,c.respon R,b.terima,".
	"format(b.hasil,0) as hasil,format(b.dptlain,0) as dptlain,\r".
	"format(b.stok,0) as stok,b.staf,format(b.gaji,0) as gaji,".
	"b.outlet,b.sebab,b.status U ,$msic msic08,c.fe ";
	$sql="SELECT $r \rFROM mdt_$myTable b, mdt_rangka as c
	WHERE (b.newss=c.newss and b.status='$utama' and 
	c.respon='A1' and b.terima like '20%') ";
	$sql.=$_SESSION['level']=='fe' ? "and c.fe='".$_SESSION['user']."' "
	:(($fe==null) ? '': "and c.fe='".$fe."' ");
	$sql.=" \r\tAND c.fe<>'batal' \r\tORDER BY ".$_GET['susun']." ";
	//echo $p1.$sql.$p2;
	break;
case "BBU_XA1": case "SBU_XA1":
	$utama=substr($_GET['p'],0,3);
	$msic='if(b.msic08 is null,c.msic,b.msic08)';
	$r="b.newss,concat(B.nama,'<br>',B.sidap) as nama,c.respon R,b.terima,".
	"format(b.hasil,0) as hasil,format(b.dptlain,0) as dptlain,\r".
	"format(b.stok,0) as stok,b.staf,format(b.gaji,0) as gaji,".
	"b.outlet,b.sebab,b.status U ,$msic msic08,c.fe ";
	$sql="SELECT $r \rFROM mdt_$myTable b, mdt_rangka as c
	WHERE (b.newss=c.newss and b.status='$utama' and 
	b.terima is null) ";
	$sql.=$_SESSION['level']=='fe' ? "and c.fe='".$_SESSION['user']."' "
	:(($fe==null) ? '': "and c.fe='".$fe."' ");
	$sql.=" \r\tAND c.fe<>'batal' \r\tORDER BY ".$_GET['susun']." ";
	//echo $p1.$sql.$p2;
	break;
case "BBU_TEGAR": case "SBU_TEGAR":
	$utama=substr($_GET['p'],0,3);
	$msic='if(b.msic08 is null,c.msic,b.msic08)';
	$A=array('A2','A3','A4','A5','A6','A7','A8','A9','A10','A11','A12','A13','X');
	
	$r=//'/*concat(alamat1,' ',alamat2,' ',poskod) as alamat,*/'.
	'c.newss,c.status U,c.nama,respon R,b.terima ' .
	$myTable. ',c.nota,c.batch B,c.msic,fe';	
	$A=array('A2','A3','A4','A5','A6','A7','A8','A9','A10','A11','A12','A13','X');
	
	$sql="SELECT $r FROM `mdt_$myTable` b, `mdt_rangka` as c \r" .
	"WHERE c.newss=b.newss AND b.status='$utama'\r" .
	"AND(`respon` IN ('".implode("','",$A)."')) \r";
	$sql.=$_SESSION['level']=='fe' ? "and fe='".$_SESSION['user']."' "
		:(($fe==null) ? '': "and fe='".$fe."' ");
	$sql.="\rand fe<>'batal'\r ORDER BY respon,c.nama ";
	//echo $p1.$sql.$p2;	
	break;

case "Kawal_Semua":
	// pecah $myTable kepada huruf dan nombor
		$pattern = '/([a-zA-Z]*)([0-9]*)/';
		preg_match($pattern, $myTable , $pecah);
		list($semua,$bln,$thn)=$pecah; 
		if (isset($myTable))
		{
			$sebelum = (array_search($bln,$bulan)-1);
		}
		$bulan_sebelum = $bulan[$sebelum].$thn;
	#echo $s1.'Tak Respon Pada Bulan ' . $myTable . ' Dan ' . 
	#$bulan_sebelum . $s2 . '<br>';
	$msic2='if(msic08 is null,msic,msic08)';
	$msic='if(b.msic08 is null,c.msic,b.msic08)';
	// pilih $myTable
	if($myTable=='rangka')
	{
		$r="/*if($myTable=='rangka')*/\r" .
		'newss,nama,'.$msic2.' msic08,status U,fe,c.respon as r,tel,'.
		'c.responden as org,alamat1,alamat2,poskod';
		
		$gabungjadual="mdt_rangka as c";
		$gabungid='c.fe<>"batal"';
	}
	elseif($myTable=='jan12')
	{
		$r="/*if($myTable=='jan12')*/\r" .
		"b.newss,b.nama,c.fe,b.status U,c.batch B,$msic msic08," . "\r" . 
		"c.respon as L,c.tel,c.responden as org,b.terima as `$myTable`," . "\r" . 
		"format(b.hasil,0) as `hasil`,format(b.dptLain,0)as `dptLain`," . "\r" . 
		"format(b.stok,0) as stok,b.staf,format(b.gaji,0) as gaji,".
		"b.outlet,b.sebab,c.fe";
		
		$gabungjadual="mdt_$myTable b, mdt_rangka as c";
		$gabungid='c.fe<>"batal" and c.newss=b.newss ';
	}
	else
	{	
		$r="/*else*/\r" .
		"a.newss,a.nama,c.fe,a.status U,c.sv,$msic msic08," . "\r" . 
		"c.respon as L,c.tel,c.responden as org," . "\r" . 
		"a.terima as `" . $bulan_sebelum . "`, format(a.hasil,0) as `hasil`," . "\r" . 
		"b.terima as `$myTable`,format(b.hasil,0) as `hasil`," . "\r" . 
		"format(b.dptLain,0)as `dptLain`,".
		"format(b.stok,0) as stok,b.staf,format(b.gaji,0) as gaji,".
		"b.outlet,b.sebab,c.fe";
		
		$gabungjadual="mdt_" . $bulan_sebelum . " a,mdt_$myTable b, mdt_rangka as c";
		$gabungid='c.fe<>"batal" and a.newss=b.newss and c.newss=b.newss';
	}

	$sql="SELECT $r\rFROM $gabungjadual\rWHERE $gabungid ";
	$sql.=$_SESSION['level']=='fe' ? "\rand c.fe='".$_SESSION['user']."' "
	:(($_GET['fe']==null) ? '': "\rand c.fe='".$_GET['fe']."' ");
	$sql.="\rORDER BY " . $_GET['susun'] . " ";
	//echo $p1.$sql.$p2;
	break;
case "Kawal_Selesai":
	$msic='if(b.msic08 is null,c.msic,b.msic08)';
	$m="b.newss,b.sidap,b.nama,/*c.batch B,*/c.respon R,b.terima,".
	"format(b.hasil,0) as hasil,format(b.dptlain,0) as dptlain,\r".
	"format(b.stok,0) as stok,b.staf,format(b.gaji,0) as gaji,".
	"b.outlet,b.sebab,b.status U ,$msic msic08,c.fe ";
	$sql="SELECT $m FROM \r mdt_$myTable b, mdt_rangka as c
	WHERE (b.newss=c.newss and c.respon='A1' and b.terima like '20%') ";
	$sql.=$_SESSION['level']=='fe' ? "and c.fe='".$_SESSION['user']."' "
		:(($fe==null) ? '': "and c.fe='".$fe."' ");
	$sql.="\rAND c.fe<>'batal'\r" .
	'ORDER BY  c.fe,b.nama ';
	//'ORDER BY  b.terima,c.respon ';
	//echo $p1.$sql.$p2;
	break;
case "Kawal_Belum":
	// pecah $myTable kepada huruf dan nombor
		$pattern = '/([a-zA-Z]*)([0-9]*)/';
		preg_match($pattern, $myTable , $pecah);
		list($semua,$bln,$thn)=$pecah; 
		if (isset($myTable))
		{
			$sebelum = (array_search($bln,$bulan)-1);
		}
		$bulan_sebelum = $bulan[$sebelum].$thn;
	#echo $s1.'Tak Respon Pada Bulan ' . $myTable . ' Dan ' . 
	#$bulan_sebelum . $s2 . '<br>';
	$msic='if(b.msic08 is null,c.msic,b.msic08)';
	// pilih $myTable
	if($myTable=='rangka')
	{
		$r="/*if($myTable=='rangka')*/\r" .
		'c.newss,c.nama,c.fe,c.status U,c.kelas,c.sv,' . "\r" . 
		'if(c.msic08 is null,c.msic,c.msic08) msic08,' . "\r" . 
		'c.respon as L,c.tel,c.responden as org,' . "\r" . 
		'c.terima,format(c.hasil,0) as hasil';
		
		$gabungjadual="mdt_rangka as c";
		$gabungid='c.fe<>"batal"';
	}
	elseif($myTable=='jan12')
	{
		$r="/*if($myTable=='jan12')*/\r" .
		"b.newss,b.nama,c.fe,b.status U,c.batch B,c.sv,$msic msic08," . "\r" . 
		"c.respon as L,c.tel,c.responden as org,b.terima as `$myTable`," . "\r" . 
		"format(b.hasil,0) as `hasil`,format(b.dptLain,0)as `dptLain`," . "\r" . 
		"b.stok,b.staf,b.gaji,b.sebab";
		
		$gabungjadual="mdt_$myTable b, mdt_rangka as c";
		$gabungid='c.fe<>"batal" and c.newss=b.newss' .
		"\rand (b.terima is null or b.terima like '0000%')";
	}
	else
	{	
		$r="/*else*/\r" .
		"a.newss,a.nama,c.fe,a.status U,c.batch B,c.sv,$msic msic08," . "\r" . 
		"c.respon as L,c.tel,c.responden as org," . "\r" . 
		"b.terima as `$myTable`, format(b.hasil,0) as `hasil`," . "\r" . 
		"a.terima as `" . $bulan_sebelum . "`,format(a.hasil,0) as `hasil`," . "\r" . 
		"format(a.dptLain,0)as `dptLain`,a.stok,a.staf,a.gaji,a.sebab";
		
		$gabungjadual="mdt_" . $bulan_sebelum . " a,mdt_$myTable b, mdt_rangka as c";
		$gabungid='c.fe<>"batal" and a.newss=b.newss and c.newss=b.newss' .
		"\rand (b.terima is null or b.terima like '0000%')";
	}

	$sql="SELECT $r\rFROM $gabungjadual\rWHERE $gabungid ";
	$sql.=$_SESSION['level']=='fe' ? "\rand c.fe='".$_SESSION['user']."' "
		:(($fe==null) ? '': "\rand c.fe='".$fe."' ");
	$sql.="\rORDER BY " . $_GET['susun'] . " ";
	//echo $p1.$sql.$p2;
	break;
case "Kawal_B1":
	// pecah $myTable kepada huruf dan nombor
		$pattern = '/([a-zA-Z]*)([0-9]*)/';
		preg_match($pattern, $myTable , $pecah);
		list($semua,$bln,$thn)=$pecah; 
		if (isset($myTable))
		{
			$sebelum = (array_search($bln,$bulan)-1);
		}
		$bulan_sebelum = $bulan[$sebelum].$thn;
	#echo $s1.'Tak Respon Pada Bulan ' . $myTable . ' Dan ' . 
	#$bulan_sebelum . $s2 . '<br>';
	$msic='if(b.msic08 is null,c.msic,b.msic08)';
	// pilih $myTable
	if($myTable=='rangka')
	{
		$r="/*if($myTable=='rangka')*/\r" .
		'c.newss,c.nama,c.fe,c.status U,c.kelas,c.sv,' . "\r" . 
		'if(c.msic08 is null,c.msic,c.msic08) msic08,' . "\r" . 
		'c.respon as L,c.tel,c.responden as org,' . "\r" . 
		'c.terima,format(c.hasil,0) as hasil';
		
		$gabungjadual="mdt_rangka as c";
		$gabungid='c.fe<>"batal"';
	}
	elseif($myTable=='jan12')
	{
		$r="/*if($myTable=='jan12')*/\r" .
		"b.newss,b.nama,c.fe,b.status U,c.batch B,c.sv,$msic msic08," . "\r" . 
		"c.respon as L,c.tel,c.responden as org,b.terima as `$myTable`," . "\r" . 
		"format(b.hasil,0) as `hasil`,format(b.dptLain,0)as `dptLain`," . "\r" . 
		"b.stok,b.staf,b.gaji,b.sebab";
		
		$gabungjadual="mdt_$myTable b, mdt_rangka as c";
		$gabungid='c.fe<>"batal" and c.newss=b.newss' .
		"\rand (c.respon = 'B1')";
	}
	else
	{	
		$r="/*else*/\r" .
		"a.newss,a.nama,c.fe,a.status U,c.batch B,c.sv,$msic msic08," . "\r" . 
		"c.respon as L,c.tel,c.responden as org," . "\r" . 
		"b.terima as `$myTable`, format(b.hasil,0) as `hasil`," . "\r" . 
		"a.terima as `" . $bulan_sebelum . "`,format(a.hasil,0) as `hasil`," . "\r" . 
		"format(a.dptLain,0)as `dptLain`,a.stok,a.staf,a.gaji,a.sebab";
		
		$gabungjadual="mdt_" . $bulan_sebelum . " a,mdt_$myTable b, mdt_rangka as c";
		$gabungid='c.fe<>"batal" and a.newss=b.newss and c.newss=b.newss' .
		"\rand (c.respon = 'B1')";
	}

	$sql="SELECT $r\rFROM $gabungjadual\rWHERE $gabungid ";
	$sql.=$_SESSION['level']=='fe' ? "\rand c.fe='".$_SESSION['user']."' "
		:(($fe==null) ? '': "\rand c.fe='".$fe."' ");
	$sql.="\rORDER BY " . $_GET['susun'] . " ";
	//echo $p1.$sql.$p2;
	break;
case "Kawal_Tegar":
	$r=//'/*concat(alamat1,' ',alamat2,' ',poskod) as alamat,*/'.
	'c.newss,c.status U,c.nama,respon,b.terima ' .
	$myTable. ',c.nota,c.batch B,c.msic,fe';	
	$A=array('A2','A3','A4','A5','A6','A7','A8','A9','A10','A11','A12','A13','X');
	
	$sql="SELECT $r FROM `mdt_$myTable` b, `mdt_rangka` as c \r" .
	"WHERE c.newss=b.newss \r" .
	"AND(`respon` IN ('".implode("','",$A)."')) \r";
	$sql.=$_SESSION['level']=='fe' ? "and fe='".$_SESSION['user']."' "
		:(($fe==null) ? '': "and fe='".$fe."' ");
	$sql.="\rand fe<>'batal'\r ORDER BY respon,c.nama ";
	//echo $p1.$sql.$p2;	
	break;
case "SemakFE":
	/*
	000 000 439 987	329	45101	C00000030303730011	PENGURUS	
	ANG TRADING & MOTOR CREDIT SDN BHD		
	NO. 33,34 & 35,	JALAN SULAIMAN,	84000 MUAR	
	243	01018002	BBU
	*/
	$m='concat(substring(c.newss,1,3),\' \',substring(c.newss,4,3),\' \','.
	'substring(c.newss,7,3),\' \',substring(c.newss,10,3)'.
	') as id,c.sv,c.msic,c.sidap,"PENGURUS",c.nama,c.operator,' .
	'c.alamat1,c.alamat2,c.poskod,"",c.status U,c.fe';
	
	$sql="SELECT $m FROM \r mdt_rangka as b, dtsample3 c
	WHERE (b.newss=c.newss ";
	$sql.="and c.fe is null";
	$sql.=")\r".'ORDER BY 1 ';
	//echo $p1.$sql.$p2;
	break;	
case "SemakRangkaBaru":
	$m=//'concat(substring(c.newss,1,3),\' \',substring(c.newss,4,3),\' \','.
	//'substring(c.newss,7,3),\' \',substring(c.newss,10,3)' . ') as id,' .
	'b.newss,b.sidap,b.nama,b.fe,b.status U,b.msic,b.msic08,b.alamat1,b.alamat2,b.poskod';
	
	$sql="\tSELECT $m FROM \r mdt_rangka as b, dtsample3 c
	WHERE c.newss=b.newss ";
	$sql.='ORDER BY b.nama ';
	//echo $p1.$sql.$p2;
	break;	
case "SemakRespon":
	$m="b.newss,b.sidap,b.nama,c.batch B,c.respon R,b.terima,".
	"format(b.hasil,0) as hasil,format(b.dptlain,0) as dptlain,\r".
	"format(b.stok,0) as stok,b.staf,format(b.gaji,0) as gaji,".
	"b.outlet,b.sebab,b.status U ,b.msic08,c.fe ";
	
	$sql="SELECT $m FROM \r mdt_$myTable b, mdt_rangka as c
	WHERE (b.newss=c.newss and c.respon is null) ";
	$sql.=$_SESSION['level']=='fe' ? "and c.fe='".$_SESSION['user']."' "
	:(($fe==null) ? '': "and c.fe='".$fe."' ");
	$sql.="\rAND c.fe<>'batal'\r".'ORDER BY b.msic08 ';
	//echo $p1.$sql.$p2;
	break;
case "SemakResponTarikh":
	$m="b.newss,b.sidap,b.nama,c.batch B,c.respon R,b.terima,".
	"format(b.hasil,0) as hasil,format(b.dptlain,0) as dptlain,\r".
	"format(b.stok,0) as stok,b.staf,format(b.gaji,0) as gaji,".
	"b.outlet,b.sebab,b.status U ,b.msic08,c.fe ";
	
	$sql="SELECT $m FROM \r mdt_$myTable b, mdt_rangka as c
	WHERE (b.newss=c.newss ".
	" and c.respon is null and b.terima like '20%') ";
	$sql.=$_SESSION['level']=='fe' ? "and c.fe='".$_SESSION['user']."' "
	:(($fe==null) ? '': "and c.fe='".$fe."' ");
	$sql.="\rAND c.fe<>'batal'\r".'ORDER BY b.msic08 ';
	//echo $p1.$sql.$p2;
	break;
case "SemakHasil":
	$m="b.newss,b.sidap,b.nama,c.batch B,c.respon R,b.terima,".
	"format(b.hasil,0) as hasil,format(b.dptlain,0) as dptlain,\r".
	"format(b.stok,0) as stok,b.staf,format(b.gaji,0) as gaji,".
	"b.outlet,b.sebab,b.status U ,b.msic08,c.fe ";
	
	$sql="SELECT $m FROM \r mdt_$myTable b, mdt_rangka as c
	WHERE (b.newss=c.newss and b.hasil is not null and b.terima is null) ";
	$sql.=$_SESSION['level']=='fe' ? "and c.fe='".$_SESSION['user']."' "
	:(($fe==null) ? '': "and c.fe='".$fe."' ");
	$sql.="\rAND c.fe<>'batal'\r".'ORDER BY b.msic08 ';
	//echo $p1.$sql.$p2;
	break;
case "SemakHasilTarikh":
	$m="b.newss,b.sidap,b.nama,c.batch B,c.respon R,b.terima,".
	"format(b.hasil,0) as hasil,format(b.dptlain,0) as dptlain,\r".
	"format(b.stok,0) as stok,b.staf,format(b.gaji,0) as gaji,".
	"b.outlet,b.sebab,b.status U ,b.msic08,c.fe ";
	
	$sql="SELECT $m FROM \r mdt_$myTable b, mdt_rangka as c
	WHERE (b.newss=c.newss and b.hasil is null and b.terima is not null) ";
	$sql.=$_SESSION['level']=='fe' ? "and c.fe='".$_SESSION['user']."' "
	:(($fe==null) ? '': "and c.fe='".$fe."' ");
	$sql.="\rAND c.fe<>'batal'\r".'ORDER BY b.msic08 ';
	//echo $p1.$sql.$p2;
	break;
case "SemakMsic08":
	$m="b.newss,b.sidap,b.nama,c.batch B,c.respon R,b.terima,".
	"format(b.hasil,0) as hasil,format(b.dptlain,0) as dptlain,\r".
	"format(b.stok,0) as stok,b.staf,format(b.gaji,0) as gaji,".
	"b.outlet,b.sebab,b.status U ,b.msic08,c.fe ";
	
	$sql="SELECT $m FROM \r mdt_$myTable b, mdt_rangka as c
	WHERE (b.newss=c.newss ".
	" and b.msic08 is null and terima like '20%') ";
	$sql.=$_SESSION['level']=='fe' ? "and c.fe='".$_SESSION['user']."' "
	:(($fe==null) ? '': "and c.fe='".$fe."' ");
	$sql.="\rAND c.fe<>'batal'\r".'ORDER BY b.msic08 ';
	//echo $p1.$sql.$p2;
	break;
case "SemakIndustri":
	$sql="SELECT `seksyen` S, `kelas` K, `msic` M08, `msic2000` M00, `keterangan` , `notakaki`
	FROM `msic2008` WHERE `keterangan` LIKE '%jualan%kenderaan%'
	AND c.fe<>'batal'";
	//echo $p1.$sql.$p2;
	break;
case "SemakPendua":
	$m='concat(substring(newss,1,3),\' \',substring(newss,4,3),\' \','.
	'substring(newss,7,3),\' \',substring(newss,10,3)'.
	') as id,sidap,nama,batch,mdt_rangka.status as status,'.
	'msic,msic08,alamat1,alamat2,poskod,fe,respon';
	$sql="SELECT $m FROM mdt_$myTable
	WHERE `nama` in ('CHOP ENG HUAT','GEE HAR SERVIS',
	'UNION SERVICE STATION SDN. BERHAD.') ";
	//echo $p1.$sql.$p2;
	break;
case "SemakTarikh":
	if ($_GET['jika']=='A1') {$cari="c.respon='A1' and b.terima is not null ";}
	else {$cari="c.respon IS NULL and b.terima is not null ";}
	// mula cari sql berasaskan respon	
	$sql="SELECT b.newss,b.sidap,b.nama,
	b.status,c.respon,b.terima,b.hasil
	FROM mdt_".$myTable." b INNER JOIN mdt_rangka c ON 
	b.newss=c.newss
	WHERE $cari
	AND c.fe<>'batal'
	ORDER BY nama"; 
	//echo $p1.$sql.$p2;
	break;
case "SemakPBBU":
	$msic='if(c.msic08 is null,c.msic,c.msic08)';
	if (isset($myTable)){$sebelum = (array_search($myTable,$bulan))-1;}
	//echo $warna1.'Tak Respon Pada Bulan '.$myTable.' Dan '.$bulan[$sebelum].$warna2;
	$r=($myTable=='jan11')?
	's.newss,s.nama,c.kelas,c.sv,'.$msic.' msic08,c.fe,b.status U':
	//'b.terima,format(b.hasil,0) as hasil,':
	"s.newss, s.nama, c.status U,c.sv,$msic msic08, c.respon as R, c.fe/*,
	b.terima as `$myTable`,format(b.hasil,0) as `hasil`,
	format(b.dptLain,0)as `dptLain`,b.stok,b.staf,b.gaji,b.sebab*/";

	$sql="SELECT $r\rFROM ".
	"(dtsample s LEFT JOIN mdt_rangka c\r".
	"on c.newss=s.newss) WHERE c.fe<>'batal' ";
	$sql.=$_SESSION['level']=='fe' ? "\rand c.fe='".$_SESSION['user']."' "
	:(($fe==null) ? '': "\rand c.fe='".$fe."' ");
	$sql.="\rand s.UTAMA='KES UTAMA' ";
	$sql.=" ORDER BY c.fe desc ";
	//echo $p1.$sql.$p2;
	break;
case "SemakPSBU":
	$msic='if(c.msic08 is null,c.msic,c.msic08)';
	if (isset($myTable)){$sebelum = (array_search($myTable,$bulan))-1;}
	//echo $warna1.'Tak Respon Pada Bulan '.$myTable.' Dan '.$bulan[$sebelum].$warna2;
	$r=($myTable=='jan11')?
	's.newss,s.nama,c.kelas,c.sv,'.$msic.' msic08,c.fe,b.status U':
	//'b.terima,format(b.hasil,0) as hasil,':
	"s.newss, s.nama, c.status U,c.sv,$msic msic08, c.respon as R, c.fe/*,
	b.terima as `$myTable`,format(b.hasil,0) as `hasil`,
	format(b.dptLain,0)as `dptLain`,b.stok,b.staf,b.gaji,b.sebab*/";

	$sql="SELECT $r\rFROM ".
	"(dtsample s LEFT JOIN mdt_rangka c\r".
	"on c.newss=s.newss) WHERE c.fe<>'batal' ";
	$sql.=$_SESSION['level']=='fe' ? "\rand c.fe='".$_SESSION['user']."' "
	:(($fe==null) ? '': "\rand c.fe='".$fe."' ");
	$sql.="\rand s.UTAMA='BUKAN KES UTAMA' ";
	$sql.=" ORDER BY c.fe desc ";
	//echo $p1.$sql.$p2;
	break;
case "SemakM":
	$r=($myTable=='rangka')? 'newss,nama,msic,msic08,status U,batch,fe,respon as respon_lepas,tel,'.
	''."\n rtrim(alamat1)&' '&rtrim(alamat2)&' '&rtrim(poskod) as alamat"
	:'newss,nama,batch B,status U,terima,format(hasil,0) as hasil, format(stok,0) as stok,
	staf,format(gaji,0) as gaji,outlet,sebab,msic08,fe';
	$sql="SELECT $r FROM `mdt_".$myTable."` ";
	$sql.='WHERE batch is null ';
	$sql.=$_SESSION['level']=='fe' ? "and fe='".$_SESSION['user']."' "
	:(($fe==null) ? '': "and fe='".$fe."' ");
	$sql.="\r ORDER BY nama ";
	//echo $p1.$sql.$p2;
	break;	
case "SemakAlamat":
	$myTable='semak';
	echo $warna1.'<a target="_blank" href="kawal_alamat.php">'.
	'Semak Alamat</a>'.$warna2;
	$r='newss,concat(nama,\'<br>\',sidap) `nama syarikat`,'.
	'msic,msic08,alamat1,alamat2,poskod,poskodNewss,nota,masalah';
	$sql="SELECT $r FROM `mdt_".$myTable."` ";
	$sql.='WHERE masalah="ya" ';
	$sql.=$_SESSION['level']=='fe' ? "and fe='".$_SESSION['user']."' "
	:(($fe==null) ? '': "and fe='".$fe."' ");
	$sql.="\r ORDER BY nama ";
	//echo $p1.$sql.$p2;
	break;	
case "Jualan":
	echo $warna1.'<a target="_blank" href="print-respon.php">Jualan Tertinggi Di Alam Maya</a>'.$warna2;
	$sql="SELECT newss,nama,(format(hasil,0)) as jual,batch B,status U,msic08,fe
	FROM `mdt_".$myTable."` ";
	$sql.="WHERE hasil is not null ";
	$sql.="ORDER BY hasil DESC ";
	//echo $p1.$sql.$p2;
	break;
case "Laporan_Bulanan":
	$r='respon'; $mesej=($myTable=='rangka')?'bukan laa':'';
	// nak groupkan respon
	$tgk="SELECT $r,kod FROM (mdt_rangka INNER JOIN f2 ".
	"ON $r = f2.kod) GROUP BY 1 ORDER BY no,$r";
	$hasil = mysql_query($tgk) or die(mysql_error()."(1)<hr>$tgk<hr>"); 
	while($papar=mysql_fetch_array($hasil))
	{$kumpul.=",\rcount(if($r='".$papar[0]."' and b.terima is not null,$r,null)) as `".$papar[0]."`";
	$jumlah_kumpul.="+count(if($r='".$papar[0]."' and b.terima is not null,$r,null))\r";}
	// pembolehubah yg terlibat
	$ALL="count(*)";
	$A1="count(if($r='A1' and b.terima is not null,$r,null))";
	///////////////////////////////////////////////////////////////////////////////////////////////////
	// a1 bahagi (jumlah rangka - (a2-a6)
	$sasaran=array('A2','A3','A4','A5','A6'); //
	$SSR="count(if($r IN ('".implode("','",$sasaran)."') and b.terima is not null,$r,null))"; // kpi negatif
	$KPI="($A1 / (286 - $SSR) )*100";
	///////////////////////////////////////////////////////////////////////////////////////////////////
	$AN="count(if($r<>'A1' and b.terima is not null,$r,null))";
	$BBU="count(if(b.status='BBU',b.status,null))";
	$BBU1="count(if(b.status='BBU' and $r='A1' and b.terima is not null,`$r`,null))";
	$BBUX="count(if(b.status='BBU' and $r<>'A1' and b.terima is not null,`$r`,null))";
	$SBU="count(if(b.status='SBU',b.status,null))";
	$SBU1="count(if(b.status='SBU' and $r='A1' and b.terima is not null,`$r`,null))";
	$SBUX="count(if(b.status='SBU' and $r<>'A1' and b.terima is not null,`$r`,null))";
	$dpt="format(sum(if($r='A1' and b.terima is not null,b.hasil,null)),0)";
	$p="if (format(((($jumlah_kumpul)/$ALL)*100),2)=100.00,'Ya',':(' )";
	// mula cari sql berasaskan respon
	$sql="	SELECT c.fe, $p as `Habis`,
	$dpt AS `Hasil`,
	$ALL as Kes,$ALL-($jumlah_kumpul) as `He3` $kumpul,
	($jumlah_kumpul) as `Siap`,
	format(((($jumlah_kumpul)/count(*))*100),2) as `% Siap`,
	format((($A1/count(*))*100),2) as `% A1`,
	format($KPI,2) as `% KPI`,
	$AN `A-`, format((($AN/count(*))*100),2) as `% A-`,
	$BBU as `BBU`,\r($BBU-$BBU1-$BBUX) as `:(`,\r
	$BBUX as `A-`,\r$BBU1 as `A1`,
	format((($BBU1/$BBU)*100),2) as `%`,
	$SBU as `SBU`,\r($SBU-$SBU1-$SBUX) as `:(`,\r
	$SBUX as `A-`,\r$SBU1 as `A1`,\r
	format((($SBU1/$SBU)*100),2) as `%`
	FROM mdt_rangka as c INNER JOIN mdt_$myTable as b
	ON c.newss=b.newss
	AND c.fe<>'batal'
	GROUP BY fe with rollup "; 
	//echo $p1.$sql.$p2;
	break;
case "Laporan_Utama":
	$r='respon'; $mesej=($myTable=='rangka')?'bukan laa':'';
	// nak groupkan respon
	$tgk="SELECT $r,kod FROM (mdt_rangka INNER JOIN f2 ".
	"ON $r = f2.kod) GROUP BY 1 ORDER BY no,$r";
	$hasil = mysql_query($tgk) or die(mysql_error()."(1)<hr>$tgk<hr>"); 
	while($papar=mysql_fetch_array($hasil))
	{$kumpul.=",\rcount(if($r='".$papar[0]."' and b.terima is not null,$r,null)) as `".$papar[0]."`";
	$jumlah_kumpul.="+count(if($r='".$papar[0]."' and b.terima is not null,$r,null))\r";}
	// pembolehubah yg terlibat
	$ALL="count(*)";
	$A1="count(if($r='A1' and b.terima is not null,$r,null))";
	$AN="count(if($r<>'A1' and b.terima is not null,$r,null))";
	$TP="count(if(b.status='BBU',b.status,null))";
	$TP1="count(if(b.status='BBU' and $r='A1' and b.terima is not null,`$r`,null))";
	$TPX="count(if(b.status='BBU' and $r<>'A1' and b.terima is not null,`$r`,null))";
	$dpt="format(sum(if($r='A1' and b.terima is not null,b.hasil,null)),0)";
	$p="if (format(((($jumlah_kumpul)/$ALL)*100),2)=100.00,'Ya',':(' )";
	// mula cari sql berasaskan respon
	$sql="SELECT b.status U,c.fe, $p as `SiapKer`,
	$dpt AS `Hasil`,
	$ALL as Kes $kumpul,
	($jumlah_kumpul) as `Siap`,$ALL-($jumlah_kumpul) as `He3`,
	format(((($jumlah_kumpul)/count(*))*100),2) as `% Siap`,
	format((($A1/count(*))*100),2) as `% A1`,
	$AN `A-`, format((($AN/count(*))*100),2) as `% A-`
	FROM mdt_".$myTable." as b INNER JOIN mdt_rangka as c 
	ON b.newss=c.newss
	AND c.fe<>'batal'
	GROUP BY b.status,c.fe with rollup "; 
	//echo $p1.$sql.$p2;
	break;
case "Laporan_Status": 
	$utama=array('c.respon','c.status');
	$BBU="count(if(".$utama[1]."='BBU',".$utama[1].",null))";
	$SBU="count(if(".$utama[1]."='SBU',".$utama[1].",null))";
	// mula cari sql berasaskan status
	$sql=" SELECT c.respon, $BBU as BBU,\n $SBU as SBU, \n$BBU+\n$SBU as JUMLAH
	FROM `mdt_".$myTable."` as b INNER JOIN mdt_rangka as c 
	ON 	b.newss=c.newss \rAND c.fe<>'batal'\r
	GROUP BY respon with rollup ";
	//echo $p1.$sql.$p2;
	break;
default:
##################################################################################################
	if ($myTable=='nama_pegawai')
	{
		$sql='SELECT * FROM nama_pegawai ';
	}
	else
	{	
		$myTable = ($myTable==null) ? 'rangka' :$myTable;
		$r=($myTable=='rangka')?'c.newss,c.nama,c.msic,c.msic08,c.status U,' .
		'c.fe,c.respon as respon_lepas,c.tel,c.alamat1,c.alamat2,c.poskod':
		'b.newss,b.nama,b.status U,c.respon R,b.terima,format(b.hasil,0) as hasil, ' .
		'format(b.dptLain,0) as dptLain, format(b.stok,0) as stok,
		b.staf,format(b.gaji,0) as gaji,b.outlet,b.sebab,b.msic08,c.fe';
		$sql  = 'SELECT ' . $r. ' FROM mdt_' . $myTable . ' b, mdt_rangka as c ';
		$sql .= 'WHERE b.newss=c.newss ';
		$sql .= 'and c.fe<>"batal" ';
		$sql .= $_SESSION['level']=='fe' ? "and c.fe='" . $_SESSION['user'] . "' "
			:(($fe==null) ? '': "and c.fe='$fe' ");
		$sql .= "\rORDER BY b.nama";
	}
##################################################################################################
	//echo $p1.$sql.$p2;
	break;	
}// tamat - semak $_REQUEST['p']