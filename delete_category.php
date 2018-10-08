<?php
include("database/db_conection.php");
$delete=$_GET['delt'];
$query="delete from category_details where category_id='$delete'";
if(mysqli_query($dbcon,$query)){
	echo "<script>alert('Category Deleted Successfully !!')</script>";
	echo "<script>window.open('view_categories.php?Deleted Successfully !!','_self')</script>";
}
?>