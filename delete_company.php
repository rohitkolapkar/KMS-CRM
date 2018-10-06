<?php
include("database/db_conection.php");
$delete=$_GET['compid'];
$query="delete from company_details where company_id='$delete'";

if(mysqli_query($dbcon,$query)){
	echo "<script>window.open('view_companies.php','_self')</script>";
}
?>
