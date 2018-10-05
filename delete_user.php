<?php
include("database/db_conection.php");
$employee_id=$_GET['emp_id'];
$query="delete from `user` where employee_id='$employee_id'";
if(mysqli_query($dbcon,$query)){
	echo "<script>alert('User Has Been Deleted!')</script>";
	echo "<script>window.open('manage_user.php','_self')</script>";
}
?>