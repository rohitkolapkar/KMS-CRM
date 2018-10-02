<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "kalika";
$dbcon = mysqli_connect($servername, $username, $password);
mysqli_select_db($dbcon,"kalika");
if(!$dbcon)
	echo "not connected";
//else
	//echo "connected";

?>