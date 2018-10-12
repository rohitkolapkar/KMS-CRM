<?php
include('database/db_conection.php');
if(!empty($_POST["country_id"])) {
	$qry ="SELECT * FROM states WHERE country_id = '" . $_POST["country_id"] . "'";
	$run=mysqli_query($dbcon,$qry);
?>
	<option value="">Select State</option>
<?php
	while($row=mysqli_fetch_array($run))
	{
?>
 	<option value="<?php echo $row['state_id']; ?>"><?php echo $row['state_name']; ?></option>
<?php
   }
} 

if(!empty($_POST["company_id"])) {
	$qry ="SELECT * FROM category_details WHERE company_id = '" . $_POST["company_id"] . "'";
	$run=mysqli_query($dbcon,$qry);
?>
	<option value="">Select Category</option>
<?php
	while($row=mysqli_fetch_array($run))
	{
?>
 	<option value="<?php echo $row['category_id']; ?>"><?php echo $row['category_name']; ?></option>
<?php
   }
}





if(!empty($_POST["customer_mobile1"])) {
	$qry ="SELECT * FROM customer_details WHERE customer_mobile = '" . $_POST["customer_mobile1"] . "'";
	$run=mysqli_query($dbcon,$qry);
?>
<?php
	while($row=mysqli_fetch_array($run))
	{
?>
	<input type="text" name="name" class="form-control" value="<?php echo $row['customer_name']; ?>" readonly/>
<?php
   }
}

if(!empty($_POST["customer_mobile2"])) {
	$qry ="SELECT * FROM customer_details WHERE customer_mobile = '" . $_POST["customer_mobile2"] . "'";
	$run=mysqli_query($dbcon,$qry);
?>
<?php
	while($row=mysqli_fetch_array($run))
	{
?>
	<input type="text" name="email" class="form-control" value="<?php echo $row['customer_email']; ?>" readonly/>
<?php
   }
}

if(!empty($_POST["customer_mobile3"])) {
	$qry ="SELECT * FROM customer_details WHERE customer_mobile = '" . $_POST["customer_mobile3"] . "'";
	$run=mysqli_query($dbcon,$qry);
?>
<?php
	while($row=mysqli_fetch_array($run))
	{
?>
	<input type="text" name="address" class="form-control" value="<?php echo $row['customer_address']; ?>" readonly/>
<?php
   }
}

?>
