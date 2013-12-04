<div id="content" style="position:relative;height:100%;overflow:hidden" align="center">
<table border="0" align="center" bgcolor="#ffff00"
width="100%" height="100%">
<tr><td align=center><?php 
$ip  =$_SERVER['REMOTE_ADDR'];
$ip2 =substr($ip,0,10);
$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
$hostname2 = null; //$_SERVER['REMOTE_HOST'];
$server = $_SERVER['SERVER_NAME'];

echo "<br>Alamat IP : <font color='red'>".$ip."</font> |".
//"<br>Alamat IP2 : <font color='red'>".substr($ip,0,10)."</font> |".
"\r<br>Nama PC : <font color='red'>".$hostname."(".$hostname2.")</font> |".
//"\r<br>Server : <font color='red'>".$server."</font>".
"<br>\r";

$senaraiIP=array('192.168.1.', '10.69.112.', '127.0.0.1','fe80::211:');
if ( in_array($ip2,$senaraiIP) )
{?>
	<form method="post" action="./">
	<input name="username" type="hidden" tabindex="1" value="<?php echo $_GET['nama'] ?>">
	<label align="center" style="font-size: 20pt; background-color: #000000; 
	color:#ffffff">Masukkan kata laluan</label>
	<input name="password" type="password" size="20" tabindex="1" value="">
	<input type="submit" name="masuk" value="Masuk" class="masuk">
	</form>
<?php
}
else{echo 'ip anda '.$ip.', anda tiada kebenaran masuk sistem';}

?>	</td></tr>
</table>
</div>
