<?php
include('database/db_conection.php');
if(!empty($_POST["state_id"])) {
	$qry ="SELECT * FROM cities WHERE state_id = '" . $_POST["state_id"] . "'";
	$run=mysqli_query($dbcon,$qry);
?>
	<option value="">Select City</option>
<?php
	while($row=mysqli_fetch_array($run))
	{
?>
 	<option value="<?php echo $row['city_id']; ?>"><?php echo $row['city_name']; ?></option>
<?php
   }
}
?>

