<?php
include("database/db_conection.php");
$delete=$_GET['delt'];
$query="delete from company_details where company_id='$delete'";
if(mysqli_query($dbcon,$query)){
	
	echo "<script>window.open('add_company.php','_self')</script>";
}
?>