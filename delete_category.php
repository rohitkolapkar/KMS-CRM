<?php
include("database/db_conection.php");
$delete=$_GET['delt'];
$query="delete from category_details where category_id='$delete'";
if(mysqli_query($dbcon,$query)){
	
	echo "<script>window.open('add_category.php?Deleted Successfully !!','_self')</script>";
}
?>