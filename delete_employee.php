<?php
include("database/db_conection.php");
$employee_id=$_GET['emp_id'];
$query="delete from `employee` where employee_id='$employee_id'";
if(mysqli_query($dbcon,$query)){
	echo "<script>alert('Employee Has Been Deleted!')</script>";
	echo "<script>window.open('view_employees.php','_self')</script>";
}
?>