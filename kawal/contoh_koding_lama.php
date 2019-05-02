<?php
$conn = mysqli_connect('localhost:3306', 'root', 'root');
if(! $conn ) die('Could not connect: ' . mysqli_error());
?>
<html>
<head><title>Contoh koding style lama</title>
</head>
<body>
<?php
#---------------------------------------------------------#
$sql = 'SELECT nama FROM senarai_awek';
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0)
{
	while($row = mysqli_fetch_assoc($result))
	{
		echo '<br>Nama:' . $row['nama'];
	}
}
else echo '<br>Tidak jumpa daa';
mysqli_close($conn);
#---------------------------------------------------------#
?>
</body>
</html>