<table class="excel" border="0">
<?php
	$rangkaMDT = array('mdt_rangka');
	$medan='nota,respon,fe,tel,fax,responden,email,msic,msic08,' .
	'concat(substring(newss,1,3),\' \',substring(newss,4,3),\' \',' .
	'substring(newss,7,3),\' \',substring(newss,10,3),\' | \',' .
	'status,\' \',msic) as ' . '`id U M`,nama,sidap,status';
	//--------------------------------------------------------------------------------------
	foreach ($rangkaMDT as $key => $ubah)
	{// mula ulang table
		$query='SELECT ' . $medan . ' FROM ' . $ubah . ' WHERE newss like "' . $noID . '" ';

		$result = mysql_query($query) or diehard4($ubah,$query);
		$fields = mysql_num_fields($result); 
		$rows   = mysql_num_rows($result);

	// nak papar bil. brg
	if ($rows=='0'): echo '<tr><td valign="top" colspan="3">' .
		'<span style="background-color: black; color:yellow">' .
		'Maaflah, ' . $noID . ' tak jumpalah pada jadual:' . $ubah .
		'<font face=Wingdings size=5>L</font></span></td></tr>';

	else: // kalau jumpa
		while($row = mysql_fetch_array($result,MYSQL_NUM))
		{	
			for ( $f = 0; $f < $fields ; $f++ )
			{// masuk - mula
			/*senarai nama medan
			0-nota,1-respon,2-fe,3-tel,4-fax,		
			5-responden,6-email,7-msic,8-msic08,
			9-`id U M`,10-nama,11-sidap,12-status*/
				# mula set pembolehubah
				$p1='<label class="papan">';
				$p2='</label>';
				$industri=$row[7];
				$industriB=$row[8];
				$sidap=$row[11];
				$utama=$row[12];
				
				// nak gabungan 2 msic
				$msic78=$p1 . '7-' . mysql_field_name($result,7) .
				'<br>8-' . mysql_field_name($result,8) . $p2;
							
				// cari input berdasarkan nama
				$nama=mysql_field_name($result,$f);	
				$input=cariMedanInput($ubah,$f,$row,$nama);
				
				# tamat set pembolehubah
				# mula papar output
					//if (($f==7)or($f==10)or($f==11)or($f==12)){ echo '';}	
					if (in_array($f,array(7,10,11,12))) echo '';
					elseif ($f==8)// msic08
					{				
						echo "<tr>\r\t<td>$msic78</td>\r\t" .
						//'<td>' . $p1 . $industri . $p2 . $input . '</td>';
						'<td>' . $p1 . $industri . ' | ' . $industriB . $p2 . '</td>';
						msic($industri,$industriB);	
						echo "\r</tr>";
					}
					else
					{
						echo "<tr>\r\t<td>$p1$f-".$nama."$p2</td>".
						"\r\t<td>".$input."</td>".
						"\r\t<td>$p1".$row[$f]."$p2</td>\r</tr>";
					}
				# tamat papar output
			}// masuk - tamat
		}
	endif; //tamat jika jumpa
	}// tamat ulang table
	//--------------------------------------------------------------------------------------
	//$layout="layout:['BS_7_8_9_+@X','CE_4_5_6_-@U','CA_1_2_3_*@E','oo_0_._=_/']";
	$layout="layout:['@U_7_8_9_+BS','@X_4_5_6_-CE','@E_1_2_3_*CA','  oo_0_._=_/']";
?>
</table>
<script type="text/javascript">
$(function() {
	$.calculator.addKeyDef('oo', '00', $.calculator.digit, null, '', 'HUNDRED', '{');
<?php foreach ($bulanan as $tarikh2 => $tarikh )
  {// mula ulang tarikh ?>
	$('#mdt_<?=$tarikh?>12').datepick({dateFormat: 'yyyy-mm-dd'});
	$('#mdt_<?=$tarikh?>12-hasil').calculator(	{<?=$layout?>});
	$('#mdt_<?=$tarikh?>12-dptLain').calculator({<?=$layout?>});
	$('#mdt_<?=$tarikh?>12-stok').calculator(	{<?=$layout?>});
	$('#mdt_<?=$tarikh?>12-web').calculator(	{<?=$layout?>});
	$('#mdt_<?=$tarikh?>12-gaji').calculator(	{<?=$layout?>});
	$('#mdt_<?=$tarikh?>12-staf').calculator(	{<?=$layout?>});
<?php 
	}// tamat ulang tarikh ?>
});
</script>
<table class="excel" border="0">
<?php
	
	// lepas
	if (is_array($lepas))
	{
		$thnlepas = "\n<tr bgcolor='#e6e6fa'>";#LAVENDAR
		foreach ($lepas as $xx => $tahunan)
		{ 
			$thnlepas .= "\n<td>" . $tahunan . '</td>'; 
		}	
		$thnlepas .= "\n</tr>";

		echo $thnlepas;
	}
	// semasa
	$U='-<font size=5>' . $utama . '</font>';
	$brg='#ffffff';
	$r=array('msic','terima','bulan','hasil','dptLain','web','stok','staf','gaji','sebab','outlet','nota');
	
	$tajuk = "\n<tr bgcolor='$brg'>\n<td>kes $U</td>";
	foreach ($r as $rx => $x)
	//for ($x=0;$x < count($r);$x++)
	{ 
		$tajuk .= "\n<td>" . $x . '</td>'; 
	}	
	$tajuk .= "\n</tr>";

	echo $tajuk;
	
	foreach ($bulanan as $kunci => $bln)
	{// mula ulang table
		$bulan='mdt_'.$bln.'12';
		
		$medan='concat(substring(newss,1,3),\' \',substring(newss,4,3),\' \',' .
		'substring(newss,7,3),\' \',substring(newss,10,3))' . ' as sidap,' . "\r" .
		'nama,msic08,terima,hasil,dptLain,web,' .
		'stok,staf,gaji,sebab,outlet,\'' . $bln . '\'';

		$sql2[]='SELECT ' . $medan . "\r" . 'FROM ' . $bulan . 
		' WHERE newss="' . $noID . '" ';
	}// tamat ulang table
		$query=implode("\rUNION\r",$sql2);
		//echo '<pre>' . $query . '</pre>';
	// jalankan sql
		$result = mysql_query($query) or diehard4($bulan,$query);
		$fields = mysql_num_fields($result); 
		$rows   = mysql_num_rows($result);

# papar output - mula
// nak papar bil. brg
if ($rows=='0' or $_GET['cari']==null or $noID==null): 
	echo '<tr><td valign="top" colspan="' . (count($r)+1) . '">' .
	'<span style="background-color: black; color:yellow">
	Maaflah, ' . $noID . ' tak jumpalah pada jadual ' .
	$kira . '->' . $bln . '->' . $bulan . '
	<font face=Wingdings size=5>L</font></span></td></tr>';

else: // kalau jumpa
	//echo '<tr><td colspan='.(count($r)+1).'>'.$kira.'->'.$bln.'->'.$bulan.'</td></tr>'."\r";
	
    while($row = mysql_fetch_array($result,MYSQL_NUM)) 
    {// mula papar result
	## baris input #####################################################################
		$bln=$row[12];
		$bulan='mdt_' . $bln . '12';
		$kira++;
		
		$syarikat=$row[1];// nama syarikat
		$link='target="_blank" href="./cetak-kes.php?cari='.$noID.'&bln='.($kira).'"';
		$link2='target="_blank" href="../../mdt2011/kawal/kawal_edit.php?cari='.$noID.'"';
		
		echo "<tr>\n<td align=center bgcolor='$brg'>$kawan-" . 
		$row[0] . "$U</td>\n";
		//echo "<tr>\n<td align=center>".$kira.'->'.$bln.'->'.$bulan."</td>\n";
		
		for ( $f = 2 ; $f < $fields ; $f++ )	
		{ 	
			$medanB=mysql_field_name($result,$f);
			// istihar nama
			$namainput=" type='text' name='".$bulan."[$medanB]' ".
					   "value='".$row[$f]."' id='$bulan-$medanB'";
			$namainput2=" type='text' name='".$bulan."[$medanB]' ".
					   "value='".$row[$f]."' ";
			$namainput3=" name='".$bulan."[$medanB]' rows='1' cols='18' ";
			// semak nama medan		   
			switch ($f) 
			{// mula - semak nama medan
			case 2:// msic
				$input='<input'.$namainput2.' size=2 maxlength=5 '.
				'style="font-family:sans-serif;font-size:10px;">';
				break;
			case 3:// tarikh terima
				$input='<input'.$namainput2.' id="'.$bulan.'" size=7 readonly '.
				'style="font-family:sans-serif;font-size:9px;">';
				break;
			case 4:// jualan
				$jual[$kira]=$row[4]; $lain[$kira]=$row[5];
				@$hasil=$jual[$kira]+$lain[$kira];// kira hasil
				$input='<input'.$namainput.' size=8>';
				break;
			case 8:case 9:// 8-staf & 9-gaji
				$staf[$kira]=$row[8]; $gaji[$kira]=$row[9];
				$input='<input'.$namainput.' size=5>';
				break;
			case 10://sebab
				$input='<textarea'.$namainput3.'>'.$row[$f].'</textarea>';
				break;
			case 12://nota
				@$sumbang=($jual[$kira]+$lain[$kira])/$staf[$kira];// kira sumbang
				@$hari=($jual[$kira]+$lain[$kira])/30;// kira sehari
				$input='sbg:'.kira($sumbang).'<br>hari:'.kira($hari);
				break;
			default:
				$input='<input'.$namainput.' size=5>';
				break;
			}// tamat - semak nama medan
			
			//'<td>'.($kira+1).')<a '.$link.'>'.$bln.'</a></td>';
			 echo ($f==4) ?
				"\n".'<td bgcolor="' . $brg . '">' . ($kira) .
				')<a ' . $link . '>' . $row[12] . '</a>' .
				'<br><a ' . $link2 . '>lepas</a>' .
				'</td>' . "\n" . '<td align=right>'.$input.'</td>'
				:( ($f==$fields-1) ?
					"\n" . '<td align=right bgcolor="' . $brg . '">' . $input . '</td>' 
					:"\n" . '<td align=right>' . $input . '</td>'
				);
		}
		echo "\n".'</tr>';
	## baris input #####################################################################
	## baris papar #####################################################################
		$key++;
			
		echo "<tr bgcolor='bisque'>\n";
		for ($f=1; $f < 4 ;$f++)
		{	
			echo //($f==1)? "<tr>\n<td align=center>".$key.'->'.$bln.'->'.$bulan."</td>\n":
			"\n<td align=center>".$row[$f].'</td>';	
		}
		for ($f=4; $f < 10 ;$f++)
		{// kira jual
			if ($f==4)
			{
				$dulu=$jual[$key-1]; $kini=($row[4]);
				$papar=@kira($row[4]).'|'.kira2($dulu,$kini).'%';
			}
		// kira lain
			elseif ($f==5)
			{
				$dulu=$lain[$key-1]; $kini=($row[5]);
				$papar=@kira($row[5]).'|'.kira2($dulu,$kini).'%';
			}
		// kira staf
			elseif ($f==8)
			{
				$dulu=$staf[$key-1]; $kini=($row[8]);
				$papar=@kira($row[8]).'|'.kira2($dulu,$kini).'%';
			}
		// kira gaji
			elseif ($f==9)
			{
				$dulu=$gaji[$key-1]; $kini=($row[9]);
				$papar=@kira($row[9]).'|'.kira2($dulu,$kini).'%';
			}
		// kira lain2 data
			else {$papar=@kira($row[$f]);}
		// semak dah kira, baru papar
			$Dahulu=($jual[$key-1]+$lain[$key-1]);
			$Kemudian=($row[4]+$row[5]);
			$beza=kira2($Dahulu,$Kemudian); // ada koma
			$beza3=kira3($Dahulu,$Kemudian);// takde koma
			$sebab=($beza3 <= 30 && $beza3 >= -30)?
			$syarikat: $syarikat . (
				($beza3 > 0) ? ' naik ' :' turun '
			) . $beza3 . '%';
			$link3='target="_blank" href="../forum/sms.php?kawan=' . $kawan .
			//'&cari=' . urlencode($sebab) . '"';
			'&cari=' . ($sebab) . '"';
			$banding='<a ' . $link3 . '>' .
			(
				($beza <= 30 && $beza >= -30)? $beza
				:'<font size=4>' .$beza . '</font>'
			) . '%</a>';
			
			echo "\n".($f==4?'<td>'.$banding.'</td>'."\r":'').
			'<td align=right>'.($papar==0?'':$papar).'</td>';
		//kira purata
		@$purata=kira(($row[9]/$row[8]));// gaji/staf
		}
		echo "\n<td>" . $row[10] . '</td>'.
		"\n<td align=right>" . $row[11] . '</td>'.
		"\n<td align=right>1gaji=" . $purata . '</td>'.
        "\n</tr>";
	## baris papar #####################################################################
	}// tutup papar result
endif; //tamat jika jumpa
# papar output - tamat
?>
<tr><td valign="top" bgcolor="<?php echo $brg?>">
	<a name="bulan"></a>
<?php $ip=$_SERVER['REMOTE_ADDR'];
echo "\t".'<input type="hidden" name="ip" value="'.$ip."\">\n";
$pc = gethostbyaddr($_SERVER['REMOTE_ADDR']);
echo "\t".'<input type="hidden" name="pc" value="'.$pc."\">\n";
//echo "<pre>", print_r($syarikat)."</pre>";
//<input type="hidden" name="sidap" value="$sidap">?>
	<input type="hidden" name="pilihan" value="<?=$pilihan?>">
	<input type="hidden" name="carian" value="<?=$noID;?>">
	<input type="hidden" name="syarikat" value="<?=$syarikat?>">
	<input type="hidden" name="kawan" value="<?=$kawan?>">
	<input type="hidden" name="telkawan" value="<?=$telkawan?>">
	<font size="5" color="red"><?=$_GET['ralat']?>&rarr;</font>
	<input type="submit" value="Proses" name="semua" id="semua">
</td><td valign="top" colspan="<?php echo (count($r)); ?>">
	<label class="papan">
	<a target='_blank' href="../forum/sms.php?kawan=<?=$kawan?>&cari=<?=urlencode($syarikat)?>">Hantar sms</a> |
	<a target='_blank' href="./kawal_banding.php?jadual=<?=$kini?>&item=30">Bandingan Bulanan</a> | 
	<a target='_blank' href="./print-kes.php?cari=<?=$noID?>">Cetak Setahun</a> | 
	</label>
</td></tr>
</table>