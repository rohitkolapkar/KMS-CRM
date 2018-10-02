<?php
include("database/db_conection.php");
$delete=$_GET['delt'];
$query="delete from model_details where model_id='$delete'";
if(mysqli_query($dbcon,$query)){
	
	echo "<script>window.open('add_product.php?Deleted Successfully !!','_self')</script>";
}
?>