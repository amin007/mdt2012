<?php
#################################
#include"../daftar_keluar.php"; #
#################################
$respon_bulanan=jadual_bulanan();
$TajukBesar='Sistem MDT 2011';
switch ($level_anda) 
{// mula - level user
case "admin": ?>
<!-- Paras Admin ========================================================================================== -->
<?php echo "$rangka $respon_bulanan"; $kini=$_GET['jadual'];?>
<div id="myslidemenu" class="jqueryslidemenu">
<ul>
<li><a target='_top' href='../'>Anjung</a>
	<ul>
	<li><a href='link_cari.php?jadual=nama_pegawai'>Cari</a>
	<li><?php senarai_unit($url,$bil_semua);?>
	</li>
	</ul>
</li>
<li><a href='../forum/'>Bantuan</a></li>
<li>&nbsp;<a href='../admin/?jadual=nama_pegawai&item=30'>User</a></li>
<li>&nbsp;<a href='../admin/?jadual=alog_user&item=30'>Login</a></li>
<li>&nbsp;<a href='../admin/?jadual=alog_xtvt&item=30'>Xtvt</a></li>
<li>&nbsp;<a href='../mesej.php'>mesej</a></li>
<li><a href='../logout.php'>Keluar Aplikasi</a></li>
</ul>
<br style="clear: left" />
</div>
<h1 align=center><?=$TajukBesar?> - Paras Admin </h1>
<!-- Paras Admin ========================================================================================== -->
<?php break; case "awam":?>
<!-- Paras Awam ========================================================================================== -->
<fieldset>
<?php echo $respon_bulanan; $kini='jadual='.$_GET['jadual'];?><br>
<div id="myslidemenu" class="jqueryslidemenu">
<ul>
<li><a href="../">1. Pengguna : <?php echo $_SESSION['user'] ?></a>
	<ul>
	<li><a href='../logout.php'>Keluar</a></li>
	<li><a href='./'>Anjung</a></li>
	<li><a href='../forum/'>Bantuan</a></li>
	</ul>
</li>
<li><a href="../logout.php">6. Keluar</a></li>
</ul>
<br style="clear: left" />
</div>
</fieldset>
<h1 align=center><?=$TajukBesar?> - Paras Awam</h1>
<!-- Paras Awam ========================================================================================== -->
<?php break; case "kawal":?>
<!--  Paras Kawal ============================================================================================= -->
<!--<span style="background-color: black; color:yellow"><?=$TajukBesar?> - Paras Kawal</span>-->
<?php echo $respon_bulanan; $kini='jadual='.$_GET['jadual']; $j=$_GET['jadual'];?>
<div id="myslidemenu" class="jqueryslidemenu">
<ul>
<li><a href="../">1. Pengguna : <?php echo $_SESSION['user'] ?></a>
	<ul>
	<li><a href='../logout.php'>Keluar</a></li>
	<li><a href='./'>Anjung</a></li>
	<li><a target="_blank" href="laporan_rangka.php">Rangka MDT2011</a></li>
	<li><a href="./?<?=$kini?>&p=Jualan&item=300&susun=1">Jualan Tertinggi</a></li>
	<li><a target="_blank" href="../sql_backup.php">Simpan DB</a></li>
	</ul>
</li>
<li><a href="../#">2. Respon <?=$j?></a>
	<ul>
	<li><a href="?<?=$kini?>&p=Kawal_Semua&item=300&susun=1">2.1. Kes Semua</a>
		<ul><?php lihat("\t\t",$kini,'Kawal_Semua',$pegawai);?></ul>
	</li>
	<li><a href="?<?=$kini?>&p=Kawal_Selesai&item=30&susun=1">2.2. Kes A1</a>
		<ul><?php lihat("\t\t",$kini,'Kawal_Selesai',$pegawai);?></ul>
	</li>
	<li><a href="?<?=$kini?>&p=Kawal_Belum&item=30&susun=1">2.3. Kes Belum A1</a>
		<ul><?php lihat("\t\t",$kini,'Kawal_Belum',$pegawai);?></ul>
	</li>
	<li><a href="?<?=$kini?>&p=Kawal_B1&item=30&susun=1">2.4. Kes B1</a>
		<ul><?php lihat("\t\t",$kini,'Kawal_B1',$pegawai);?></ul>
	</li>
	<li><a href="?<?=$kini?>&p=Kawal_Tegar&item=40&susun=1">2.5. Kes Tegar</a>
		<ul><?php lihat("\t\t",$kini,'Kawal_Tegar',$pegawai);?></ul>
	</li>
	<li><a href="./?<?=$kini?>&p=BBU&item=100&susun=1">2.6. Kes BBU</a>
		<ul>
		<li><a href="./?<?=$kini?>&p=BBU_A1&item=100&susun=1">A1</a></li>
		<li><a href="./?<?=$kini?>&p=BBU_XA1&item=100&susun=1">XA1</a></li>
		<li><a href="./?<?=$kini?>&p=BBU_TEGAR&item=100&susun=1">TEGAR</a></li>
		</ul>
	</li>
	<li><a href="./?<?=$kini?>&p=SBU&item=30&susun=1">2.7. Kes SBU</a>
		<ul>
		<li><a href="./?<?=$kini?>&p=SBU_A1&item=30&susun=1">A1</a></li>
		<li><a href="./?<?=$kini?>&p=SBU_XA1&item=30&susun=1">XA1</a></li>
		<li><a href="./?<?=$kini?>&p=SBU_TEGAR&item=30&susun=1">TEGAR</a></li>
		</ul>
	</li>
	</ul>
</li>
<li><a href="./?<?=$kini?>&p=Laporan_Bulanan&item=30&susun=1">4. Laporan</a>
	<ul>
	<li><a href="./?<?=$kini?>&p=Laporan_Bulanan&item=30&susun=1">4.1. Bulanan</a>
		<ul>
		<li><a href="./?<?=$kini?>&p=Laporan_Utama&item=60&susun=1">Keutamaan</a></li>
		<li><a target="_blank" href="./kawal_banding.php?<?=$kini?>&beza=ya&msic=">Bandingan</a></li>
		<li><a href="./?<?=$kini?>&p=Jualan&item=300&susun=1">Jualan Tertinggi</a></li>
		<li><a target="_blank" href="laporan_bulanan.php">Bulanan</a></li>
		<li><a target="_blank" href="laporan_bulanan.php?respon=tegar">Bulanan Tegar</a></li>
		<li><a target="_blank" href="laporan_bulanan.php?<?=$kini?>">Bulan <?=$j?></a></li>
		</ul>
	</li>
	<li><a href='carian.php?<?=$kini?>&item=30&susun=1&u=6'>4.2. Cari</a></li>
	<li><a href='carian.php?jadual=msic&item=300&susun=1&u=6'>4.3. MSIC</a></li>
	<li><a href="./?<?=$kini?>&p=BBU&item=30&susun=1">4.4. BBU</a>
		<ul><?php lihatUtama("\t\t",$kini,'BBU',$pegawai);?></ul>
	</li>
		<li><a href="./?<?=$kini?>&p=SBU&item=30&susun=1">4.5. SBU</a>
		<ul><?php lihatUtama("\t\t",$kini,'SBU',$pegawai);?></ul>
	</li>
	<li><a href="#">Lihat</a>
		<ul>
		<li><a href="./?<?=$kini?>&p=BandingKawal&item=30&susun=1">BandingKawal</a>
			<ul><?php lihat("\t\t\t",$kini,'BandingKawal',$pegawai);?></ul>
		</li>
		<li><a href="nilai.php?item=300">Nilai</a></li>
		<li><a href="laporan_belum.php">Belum Respon Lagi</a></li>
		<li><a target="_blank" href="print-respon.php">Print Respon</a></li>
		<li><a href="./?<?=$kini?>&p=SemakTarikh&item=30&susun=1">Semak Tarikh</a></li>
		<li><a href="./?<?=$kini?>&p=SemakRespon&item=30&susun=1">Semak Respon</a></li>		
		<li><a href="./?<?=$kini?>&p=SemakResponTarikh&item=30&susun=1">Semak Respon Tarikh</a></li>		
		<li><a href="./?<?=$kini?>&p=SemakFE&item=30&susun=1">Semak FE</a></li>
		<li><a href="./?<?=$kini?>&p=SemakHasil&item=30&susun=1">Semak Hasil</a></li>
		<li><a href="./?<?=$kini?>&p=SemakHasilTarikh&item=30&susun=1">Semak Hasil Tarikh</a></li>
		<li><a href="./?<?=$kini?>&p=SemakMsic08&item=30&susun=1">Semak MSIC08</a></li>
		<li><a href="./?<?=$kini?>&p=SemakM&item=30&susun=1">Semak M</a></li>
		<li><a href="./?<?=$kini?>&p=SemakAlamat&item=30&susun=1">Semak Alamat</a></li>
		<li><a href="./?<?=$kini?>&p=SemakRangkaBaru&item=30&susun=1">SemakRangkaBaru</a></li>
		<li><a href="./?<?=$kini?>&p=SemakPBBU&item=30&susun=1">Semak P BBU</a></li>
		<li><a href="./?<?=$kini?>&p=SemakPSBU&item=30&susun=1">Semak P SBU</a></li>
		</ul>
	</li>
	</ul>
</li>
<li><a href="#">5. Bantuan</a>
	<ul>
	<li><a href="#">5.1. Sistem</a></li>
	<li><a target="_blank" href="../forum">5.2. Forum</a></li>
	<li><a target="_blank" href="../forum/mesej.php">5.3. Mesej Peribadi</a></li>
	</ul>
</li>
<li><a href="../logout.php">6. Keluar</a></li>
</ul><br style="clear: left" />
</div>
<!--  Paras Kawal ============================================================================================= -->
<?php break; case "fe":?>
<!-- Paras FE ========================================================================================== -->
<?php $fe=$_SESSION['user']; $kini='jadual='.$_GET['jadual']; $bln=$_GET['jadual']; 
//<div class="container_12 fixheight"><!-- utama1 mula --> ?>
<!-- ############################################################################################### -->		
<!-- menu atas bermula -->	
<div class="grid_12 alpha omega mainhead">
	<!-- carian bermula -->
	<div class="grid_6 alpha"><!-- 1 - grid_6 alpha -->
		<!-- menu kiri mula -->
		<ul class="leftmenu">
			<li><img src="<?=$fb?>/images/agent.png" alt="user" />
				<ul><li><h1 class="titler"><?php echo $bln;?></h1></li></ul>
			</li>
			<li><img src="<?=$fb?>/images/apple.png" alt="apple" />
				<ul><li>Belum Siap</li></ul>
			</li>
			<li><img src="<?=$fb?>/images/bird.png" alt="bird" />
				<ul><li>Dah Siap</li></ul>
			</li>
		</ul>
		<!-- menu kiri tamat -->
		<div class="search"><!-- 2 - search -->
		<input class="search" type="text" name="search" size="10" />
			<div class="searchbox hidden"><!-- 3 - searchbox hidden -->
				<h1 class="titler pad7 bottom-border">Carian</h1>
					<div id="search-result" class="clearfix mart5">
					<p class="text-center"><img src="<?=$fb?>/images/loader.gif" alt="loading" /></p>
					</div>
				<div class="replies"><!-- 4 - searchbox hidden -->
					<div class="reply"><p class="strong center">
					i perform your request... Please wait...</p>
					</div>
				</div><!-- 4 - searchbox hidden -->

			</div><!-- 3 - searchbox hidden -->
		</div><!-- 2 - search -->
	</div><!-- 1 - grid_6 alpha -->
	<!-- carian berakhir -->
	<!-- menu kanan mula -->
	<div class="grid_4 omega">
		<ul class="menu">
		<li><a href="../">Anjung</a></li>
		<li><a href="#" class="ico-down">2. Kes</a>
			<ul>
			<li class="link"><span>
			<a href="./?<?=$kini?>&p=Kawal_Selesai&fe=<?=$fe?>&item=30&susun=1">
			2.1. Kes Telah Selesai</a></span></li>
			<li class="link"><span>
			<a href="./?<?=$kini?>&p=Kawal_Belum&fe=<?=$fe?>&item=30&susun=1">
			2.2. Kes Belum Selesai</a></span></li>
			<li class="link"><span>
			<a href="./?<?=$kini?>&p=Kawal_Tegar&fe=<?=$fe?>&item=30&susun=1">
			2.3. Kes Tegar</a></span></li>
			</ul>
		</li>
		<li><a class="ico-down" href="#">Biodata</a>
			<ul>
				<li class="userinfo">
					<img class="left" src="../../../bg/kakitangan/<?=$fe?>.jpg" alt="user" />
					<span class="title"><?=$fe?></span>   
				</li>
				<li class="link"><span><a href="../#">Account Settings</a></span></li>
				<li class="link"><span><a href="../#">Sistem</a></span></li>
				<li class="link"><span><a href="../#">Forum</a></span></li>
				<li class="link"><span><a href="../mesej.php">Email/Mesej Peribadi</a></span></li>
				<li class="link"><span><a href="../logout.php">Keluar</a></span></li>
			</ul>
		</li>
		<li><a href="../logout.php">Keluar</a></li>
		</ul>
	</div>
	<!-- menu kanan tamat -->
</div>
<!-- menu atas berakhir --><br><br><br>
<?php echo $respon_bulanan;?><br>
<!-- Paras FE ========================================================================================== -->
<?php break; case "pegawai":?>
<!-- Paras Pegawai ========================================================================================== -->
<?php $fe=$_SESSION['user']; $kini='jadual='.$_GET['jadual']; 
$bln=$_GET['jadual']; $z='&item=30&susun=1';
//<div class="container_12 fixheight"><!-- utama1 mula --> ?>
<!-- ############################################################################################### -->		
<!-- menu atas bermula -->
<div class="grid_12 alpha omega mainhead">
	<div class="grid_2 alpha"><!-- 1 - grid_6 alpha -->
		<div class="search"><!-- 2 - search -->
		<input class="search" type="text" readonly name="search" 
		value="<?=$TajukBesar?> - Paras Pegawai" size="30" />
		</div><!-- 2 - search -->
	</div><!-- 1 - grid_6 alpha -->
	<div class="grid_9 omega">
	<ul class="menu">
		<li><a class="ico-down" href="#"><?php echo $fe ?></a>
		<ul>
		<li class="userinfo">
			<img class="left" src="../../../bg/kakitangan/en_<?=$fe?>.jpg" alt="user" />
			<span class="title"><?=$fe?></span>   
		</li>
		<li class="link"><span><a href='../logout.php'>Keluar</a></span></li>
		<li class="link"><span><a href='../'>Anjung</a></span></li>
		</ul>
	</li>
	<li><a class="ico-down" href="#"><?=$bln?></a>
		<ul>
		<li class="link"><span><a href="./?<?=$kini?>&p=Kawal_Selesai<?=$z?>">2.1. Kes Telah Selesai</a></span></li>
		<li class="link"><span><a href="./?<?=$kini?>&p=Kawal_Belum<?=$z?>">2.2. Kes Belum Selesai</a></span></li>
		<li class="link"><span><a href="./?<?=$kini?>&p=Kawal_Tegar<?=$z?>">2.3. Kes Tegar</a></span></li>
		</ul>
	</li>
	<li><a class="ico-down" href="#">FE</a>
		<ul><?php lihat1("\t\t",$kini,$_GET['p'],$pegawai);?></ul>
	</li>
	<li><a class="ico-down" href="#">Laporan</a>
		<ul>
		<li class="link"><span>
		<a class="ico-down" href="./?<?=$kini?>&p=Laporan_Bulanan<?=$z?>">4.1. Laporan Bulanan</a>
			<ul>
			<li class="link"><span><a href="./?<?=$kini?>&p=Laporan_Utama&item=60&susun=1">Keutamaan</a></span></li>
			<li class="link"><span><a target="_blank" href="./kawal_banding.php?<?=$kini?>&beza=ya&msic=">Bandingan</a></span></li>
			<li class="link"><span><a href="./?<?=$kini?>&p=Jualan<?=$z?>">Jualan Tertinggi</a></span></li>
			<li class="link"><span><a target="_blank" href="laporan_bulanan.php">Bulanan</a></span></li>
			<li class="link"><span><a target="_blank" href="laporan_bulanan.php?respon=tegar">Bulanan Tegar</a></span></li>
			<li class="link"><span><a target="_blank" href="laporan_bulanan.php?<?=$kini?>">Bulan <?=$j?></a></span></li>
			</ul>
		</span></li>
		<li class="link"><span><a href='carian.php?<?=$kini?><?=$z?>&u=6'>4.2 Cari</a></span></li>
		<li class="link"><span><a href='carian.php?jadual=msic&item=300&susun=1'>4.3 MSIC</a></span></li>
		<li class="link"><span><a class="ico-down" href="./?<?=$kini?>&p=BBU<?=$z?>">4.4 BBU</a></span></li>
		<li class="link"><span><a class="ico-down" href="./?<?=$kini?>&p=SBU<?=$z?>">4.5 SBU</a></span></li>
		</ul>
	</li>
	<li><a class="ico-down" href="#">Bantuan</a>
		<ul>
		<li class="link"><span><a href="#">5.1. Sistem</a></span></li>
		<li class="link"><span><a href="../forum">5.2. Forum</a></span></li>
		<li class="link"><span><a href="../mesej.php">5.3. Email/Mesej Peribadi</a></span></li>
		</ul>
	</li>
	<li><a href="../logout.php">Keluar</a></li>
	</ul>
	</div>
</div>
<!-- menu atas berakhir --><br><br><br>
<?php echo $respon_bulanan;?><br>
<!-- Paras Pegawai ========================================================================================== -->
<?php break; default:?>
<h1 align=center><?=$TajukBesar?> - Paras Entah</h1>
<fieldset>
<div id="myslidemenu" class="jqueryslidemenu">
<ul>
<li><a href="../"><?php echo $parasPengguna ?></a></li>
<li><a href="logout.php">Pandai2 aje masuk. pintu keluar di sini</a></li>
</ul>
<br style="clear: left" />
</div>
</fieldset>
<?php
}// tamat - level user
?>