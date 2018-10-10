<?php
include("database/db_conection.php");
$cust_ID=$_GET['cust_id'];
$query="delete from `customer_details` where customer_id='$cust_ID'";
if(mysqli_query($dbcon,$query)){
	echo "<script>alert('Customer Has Been Deleted!')</script>";
	echo "<script>window.open('view_customers.php','_self')</script>";
}
?>