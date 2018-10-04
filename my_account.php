<!DOCTYPE html>
<html lang="en">
<?php
include("database/db_conection.php");

error_reporting(E_ALL ^ E_NOTICE);
session_start();
if(!$_SESSION['username'])
    header("Location: index.php");//redirect to login page to secure the welcome page without login access.
else
	$session_id = $_SESSION['username'];

$qry= "SELECT 
		user.user_role, employee.employee_name
	   FROM 
		user
	   INNER JOIN 
		employee 
	   ON
		user.employee_id=employee.employee_id
		WHERE 
		user.employee_id='$session_id'";
 
$run=mysqli_query($dbcon,$qry);
while($row=mysqli_fetch_array($run))
{
	$role=$row[0];
	$name=$row[1];
}

$qry1 = "SELECT security_key,security_ans FROM user where user_id='$session_id'";
$run=mysqli_query($dbcon,$qry1);
while($row=mysqli_fetch_array($run))
{
	$security_key=$row[0];
	$security_ans=$row[1];
}
if($security_key=="" || $security_ans=="")
{
   echo "<script>
				alert('Security Questions are not saved.\n go to Manage Account>Security Question!')
		 </script>";
	//echo "<script>alert('Please update your security settings \n Manage Account>Security Question!')</script>";
}

$qry1 = "SELECT security_key,security_ans FROM user where user_id='$session_id'";
$run=mysqli_query($dbcon,$qry1);
while($row=mysqli_fetch_array($run))
{
  $security_key=$row[0];
  $security_ans=$row[1];
}
if($security_key=="" || $security_ans=="")
{
   echo "<script>
        alert('Security Questions are not saved.\n go to Manage Account>Security Question!')
     </script>";
  //echo "<script>alert('Please update your security settings \n Manage Account>Security Question!')</script>";
}

$emp_qry = "SELECT * FROM employee where employee_id='$session_id'";
$run=mysqli_query($dbcon,$emp_qry);
while($row=mysqli_fetch_array($run))
{
  $emp_id=$row[0];
  $emp_name=$row[1];
  $emp_mob=$row[2];
  $emp_email=$row[3];
  $emp_add=$row[4];
  $emp_city_id=$row[5];
  $emp_dob=$row[6];
  $emp_gender=$row[7];
  $emp_pid=$row[8];
  $emp_photo=$row[9];
}
//to update profile details
if(isset($_POST['save_profile'])){
  $emp_id= $_POST['empid'];
  $emp_name=$_POST['name'];
  $emp_mob=$_POST['mobile'];
  $emp_email=$_POST['email'];
  $emp_add=$_POST['address'];
  $emp_country=$_POST['country'];
  $emp_state=$_POST['state'];
  $emp_city=$_POST['city'];
  $emp_dob=$_POST['dob'];
  $emp_gender=$_POST['gender'];

  $query2="UPDATE `employee` SET
          `employee_name`='$emp_name',
          `mobile_no`='$emp_mob',
          `email_id`='$emp_email',
          `address`='$emp_add',
          `city_id`='$emp_city',
          `dob`='$emp_dob',
          `gender`='$emp_gender'
          WHERE `employee_id` = '$emp_id'";
  if(mysqli_query($dbcon,$query2)){
    echo "<script>alert('Record Has Been Updated!')</script>";
    echo "<script>window.open('my_account.php','_self')</script>";
  }
}
//end update profile

if(isset($_POST['save_security']))
{
  $sec_key = $_POST['sec_key'];
  $sec_ans = $_POST['sec_ans'];
  $sec_qry= "UPDATE `user` SET `security_key`='$sec_key',`security_ans`='$sec_ans' WHERE `employee_id` = '$session_id'";
  if(mysqli_query($dbcon,$sec_qry)){
    echo "<script>alert('Security details has been updated!')</script>";
  }
}

if($security_key=="" || $security_ans=="")
{
   echo "<script>
        alert('Security Questions are not saved.\n go to Manage Account>Security Question!')
     </script>";
  //echo "<script>alert('Please update your security settings \n Manage Account>Security Question!')</script>";
}


$country_qry ="select `country_name` from country where country_id=
              (select country_id from states where state_id=(select state_id from cities where city_id='$emp_city_id'))";
  $run=mysqli_query($dbcon,$country_qry);
  while($row=mysqli_fetch_array($run))
  {
     $emp_country=$row[0];
  }
  $state_qry ="select `state_name` from states where state_id=(select state_id from cities where city_id='$emp_city_id')";
  $run=mysqli_query($dbcon,$state_qry);
  while($row=mysqli_fetch_array($run))
  {
     $emp_state=$row[0];
  }
  $city_qry ="select `city_name` from cities where city_id='$emp_city_id'";
  $run=mysqli_query($dbcon,$city_qry);
  while($row=mysqli_fetch_array($run))
  {
     $emp_city=$row[0];
  }
//echo $emp_city.",".$emp_state.",".$emp_country;
  if(isset($_POST['save_password']))
  {
    $old_pass = $_POST['old_password'];
    $new_pass = $_POST['new_password'];
    $cnf_pass = $_POST['confirm_password'];
    $qry1 = "SELECT  `password` FROM  `user` WHERE employee_id = '$session_id'";
    $run=mysqli_query($dbcon,$qry1);
    while($row=mysqli_fetch_array($run))
    {
     $fetched_pass=$row[0];
    }
    if($new_pass == $cnf_pass)
    {
      if($fetched_pass == md5($old_pass))
      {
        $new_pass = md5($new_pass);
        $sec_qry= "UPDATE `user` SET `password`='$new_pass' WHERE `employee_id` = '$session_id'";
        if(mysqli_query($dbcon,$sec_qry)){
          echo "<script>alert('Password has been updated!')</script>";
        }
      }
      else
      {
        echo "<script>alert('Old Password not matched!')</script>";
      }
    }
    else
    {
      echo "<script>alert('Entered Password not matched!')</script>";
    }
  }

?>
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Kalika Multiservices</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/iconfonts/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.addons.css">
  <link rel="stylesheet" href="vendors/iconfonts/font-awesome/css/font-awesome.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <!-- endinject -->
  
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/favicon.png" />
  
  <style>
.alert {
    padding: 20px;
    background-color: #f44336;
    color: white;
}

.closebtn {
    margin-left: 15px;
    color: white;
    font-weight: bold;
    float: right;
    font-size: 22px;
    line-height: 20px;
    cursor: pointer;
    transition: 0.3s;
}

.closebtn:hover {
    color: black;
}
</style>
<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
<script>
function getCity(val) {
  $.ajax({
  type: "POST",
  url: "get_city.php",
  data:'state_id='+val,
  success: function(data){
    $("#city-list").html(data);
  }
  });
}

function getState(val) {
  $.ajax({
  type: "POST",
  url: "get_state.php",
  data:'country_id='+val,
  success: function(data){
    $("#state-list").html(data);
  }
  });
}
function selectCountry(val) {
$("#search-box").val(val);
$("#suggesstion-box").hide();
}

function checkPass(){
         var pass  = document.getElementById("new_password").value;
         var cpass  = document.getElementById("confirm_password").value;
        if(pass != cpass){
            document.getElementById("save_password").disabled = true;
            //$('.missmatch').html("✖");
            document.getElementById('message').style.color = 'red';
            document.getElementById('message').innerHTML = '✖';
        }else{
            //$('.missmatch').html("✔");
            document.getElementById('message').style.color = 'green';
            document.getElementById('message').innerHTML = '✔';
            document.getElementById("save_password").disabled = false;
        }
}


</script>

</head>

<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
        <a class="navbar-brand brand-logo" href="#">
          <img src="images/logo.svg" alt="logo" />
        </a>
        <a class="navbar-brand brand-logo-mini" href="#">
          <img src="images/logo-mini.svg" alt="logo" />
        </a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center">
        <ul class="navbar-nav navbar-nav-left header-links d-none d-md-flex">
          <li class="nav-item">
            <a href="#security" class="nav-link">
              <i class="mdi mdi-elevation-rise"></i>Security</a>
          </li>
		  <li class="nav-item">
			<a href="#profile" class="nav-link">
			<i class="mdi mdi-bookmark-plus-outline"></i>Profile</a>
          </li>
          
        </ul>
        <ul class="navbar-nav navbar-nav-right">
          
          <li class="nav-item dropdown d-none d-xl-inline-block">
            <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
              <span class="profile-text">Hello, <?php echo $name;?>!</span>
              <img class="img-xs rounded-circle" src="images/faces/face1.jpg" alt="Profile image">
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
              <a class="dropdown-item p-0">
                <!--<div class="d-flex border-bottom">
                  <div class="py-3 px-4 d-flex align-items-center justify-content-center">
                    <i class="mdi mdi-bookmark-plus-outline mr-0 text-gray"></i>
                  </div>
                  <div class="py-3 px-4 d-flex align-items-center justify-content-center border-left border-right">
                    <i class="mdi mdi-account-outline mr-0 text-gray"></i>
                  </div>
                  <div class="py-3 px-4 d-flex align-items-center justify-content-center">
                    <i class="mdi mdi-alarm-check mr-0 text-gray"></i>
                  </div>
                </div>
              </a>-->
              <a class="dropdown-item mt-2" href="my_account.php">
                Manage Account
              </a>
			  <a class="dropdown-item" href="logout.php">
                Sign Out
              </a>
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
 	  <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="main.php">
              <i class="menu-icon mdi mdi-television"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <?php
		  if($role=="dep"|| $role=="admin")
		  {
			  echo @"<li class='nav-item'>
            <a class='nav-link' data-toggle='collapse' href='#customer' aria-expanded='false' aria-controls='ui-basic'>
              <i class='menu-icon mdi mdi-content-copy'></i>
              <span class='menu-title'>Customer Management</span>
              <i class='menu-arrow'></i>
            </a>
            <div class='collapse' id='customer'>
              <ul class='nav flex-column sub-menu'>
                <li class='nav-item'>
                  <a class='nav-link' href='register_complaint.php'>Add Customer</a>
                </li>
                <li class='nav-item'>
                  <a class='nav-link' href='search_complaint.php'>View Customer</a>
                </li>
              </ul>
            </div>
          </li>";
		  }?>
		  <?php
		  if($role=="dep"||$role=="admin")
		  {
			echo @"
			<li class='nav-item'>
            <a class='nav-link' data-toggle='collapse' href='#complaint' aria-expanded='false' aria-controls='ui-basic'>
              <i class='menu-icon mdi mdi-content-copy'></i>
              <span class='menu-title'>Complaint Management</span>
              <i class='menu-arrow'></i>
            </a>
            <div class='collapse' id='complaint'>
              <ul class='nav flex-column sub-menu'>
                <li class='nav-item'>
                  <a class='nav-link' href='register_complaint.php'>Register Complaint</a>
                </li>
                <li class='nav-item'>
                  <a class='nav-link' href='search_complaint.php'>Search Complaint</a>
                </li>
              </ul>
            </div>
          </li>";
		  }
		  else
		  {
			 echo @"<li class='nav-item'>
					<a class='nav-link' href='search_assignment.php'>
					<i class='menu-icon mdi mdi-table'></i>
					<span class='menu-title'>Check Assignments</span>
					</a>
					</li>";
		  }
		  ?>
		  <?php
		  if($role=="admin")
		  {
			  echo @"<li class='nav-item'>
            <a class='nav-link' data-toggle='collapse' href='#employee' aria-expanded='false' aria-controls='ui-basic'>
              <i class='menu-icon mdi mdi-content-copy'></i>
              <span class='menu-title'>Employee Management</span>
              <i class='menu-arrow'></i>
            </a>
            <div class='collapse' id='employee'>
              <ul class='nav flex-column sub-menu'>
                <li class='nav-item'>
                  <a class='nav-link' href='add_employee.php'>Add Employee</a>
                </li>
                <li class='nav-item'>
                  <a class='nav-link' href='view_employees.php'>View Employees</a>
                </li>
              </ul>
            </div>
          </li>";
		  }?>
		  
		  <?php
			if($role=="admin" ||$role=="dep")
			{
				echo @"<li class='nav-item'>
            <a class='nav-link' data-toggle='collapse' href='#company' aria-expanded='false' aria-controls='ui-basic'>
              <i class='menu-icon mdi mdi-content-copy'></i>
              <span class='menu-title'>Company Management</span>
              <i class='menu-arrow'></i>
            </a>
            <div class='collapse' id='company'>
              <ul class='nav flex-column sub-menu'>
                <li class='nav-item'>
                  <a class='nav-link' href='add_company.php'>Add Company</a>
                </li>
                <li class='nav-item'>
                  <a class='nav-link' href='view_companies.php'>View Companies</a>
                </li>
              </ul>
            </div>
          </li>
		  <li class='nav-item'>
            <a class='nav-link' data-toggle='collapse' href='#category' aria-expanded='false' aria-controls='ui-basic'>
              <i class='menu-icon mdi mdi-content-copy'></i>
              <span class='menu-title'>Category Management</span>
              <i class='menu-arrow'></i>
            </a>
            <div class='collapse' id='category'>
              <ul class='nav flex-column sub-menu'>
                <li class='nav-item'>
                  <a class='nav-link' href='add_category.php'>Add Category</a>
                </li>
                <li class='nav-item'>
                  <a class='nav-link' href='view_categories.php'>View Categories</a>
                </li>
              </ul>
            </div>
          </li>
		  <li class='nav-item'>
            <a class='nav-link' data-toggle='collapse' href='#product' aria-expanded='false' aria-controls='ui-basic'>
              <i class='menu-icon mdi mdi-content-copy'></i>
              <span class='menu-title'>Product Management</span>
              <i class='menu-arrow'></i>
            </a>
            <div class='collapse' id='product'>
              <ul class='nav flex-column sub-menu'>
                <li class='nav-item'>
                  <a class='nav-link' href='add_product.php'>Add Product</a>
                </li>
                <li class='nav-item'>
                  <a class='nav-link' href='view_products.php'>View Products</a>
                </li>
              </ul>
            </div>
          </li>
		  ";
			}
		  ?>	  
		  <?php
		  if($role=="admin")
		  {
			  echo @"<li class='nav-item'>
            <a class='nav-link' data-toggle='collapse' href='#report' aria-expanded='false' aria-controls='ui-basic'>
              <i class='menu-icon mdi mdi-content-copy'></i>
              <span class='menu-title'>Report</span>
              <i class='menu-arrow'></i>
            </a>
            <div class='collapse' id='report'>
              <ul class='nav flex-column sub-menu'>
                <li class='nav-item'>
                  <a class='nav-link' href='add_employee.php'>R1</a>
                </li>
                <li class='nav-item'>
                  <a class='nav-link' href='view_employees.php'>R2</a>
                </li>
              </ul>
            </div>
          </li>";
		  }?>
        </ul>
      </nav>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper" id="profile">
		<div class="row">
		
			<div class="col-md-6 grid-margin stretch-card" id="security">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">Change Password</h4>
                      
                      <form class="forms-sample" method="POST" action="my_account.php">
                        <div class="form-group row">
                          <label for="exampleInputEmail2" class="col-sm-3 col-form-label">Old</label>
                          <div class="col-sm-9">
                            <input type="password" class="form-control" name="old_password" id="old_password" placeholder="Old Password" required>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="exampleInputPassword2" class="col-sm-3 col-form-label">New</label>
                          <div class="col-sm-9">
                            <input type="password" class="form-control" name="new_password" id="new_password" placeholder="New Password" required onkeypress="checkPass();">
                          </div>
                        </div>
						<div class="form-group row">
                          <label for="exampleInputPassword2" class="col-sm-3 col-form-label">Retype</label>
                          <div class="col-sm-9">
                            <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required onkeypress="checkPass();">
                            <span id='message'></span>
                          </div>
                        </div>
                        <button type="submit" class="btn btn-success btn-rounded btn-md "name="save_password">Save</button>
                        <a href="main.php" class="btn btn-warning btn-rounded btn-md">Cancel</a> 
                      </form>
                    </div>
                  </div>
            </div>
			<div class="col-md-6 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">

                      <h4 class="card-title">Security Question</h4>
                      <form class="forms-sample" method="POST" action="my_account.php">
						<div class="form-group row">
							<label for="exampleInputSecurity" class="col-sm-3 col-form-label">Security</label>
							<div class="col-sm-9">
							<select class="form-control" id="exampleInputSecurity" name="sec_key">
								<option>What is your favorite food?</option>
								<option>In what city were you born?</option>
								<option>What is your father's middle name?</option>
								<option>What is your nick name?</option>
							</select>
							</div>
						</div>
                        <div class="form-group row">
                          <label for="exampleInputPassword2" class="col-sm-3 col-form-label">Answer</label>
                          <div class="col-sm-9">
                            <input type="password" class="form-control" id="exampleInputPassword2" name="sec_ans" placeholder="Password">

                          </div>
                        </div>
                        <button type="submit" class="btn btn-success btn-rounded btn-md "name="save_security">Save</button>
                        <a href="main.php" class="btn btn-warning btn-rounded btn-md">Cancel</a> 
                      </form>
                    </div>
                  </div>
            </div>
			<div class="col-12 grid-margin" >
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">My Details</h4>
                  <form class="form-sample" method="POST" action="my_account.php" >
                   <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Employee Id</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="empid" value="<?php echo $emp_id; ?>" readonly/>
                          </div>
                        </div>
                      </div>
					         </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Name</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="name" value="<?php echo $emp_name; ?>" required />
                          </div>
                        </div>
                      </div>
					  <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Mobile Name</label>
                          <div class="col-sm-9">
                            <input type="number" class="form-control" name="mobile" value="<?php echo $emp_mob; ?>" required/>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Email</label>
                          <div class="col-sm-9">
                            <input type="email" class="form-control" name="email" value="<?php echo $emp_email; ?>" required/>
                          </div>
                        </div>
                      </div> 
					  <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Address</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" value="<?php echo $emp_add; ?>" name="address"/>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row country">
                          <label class="col-sm-3 col-form-label">Country</label>
                          <div class="col-sm-9">
                            <select class="form-control" name="country" id="country-list" onChange="getState(this.value);">
                              <option selected="selected" ><?php echo $emp_country; ?></option>
                              <?php
                              $qry= "select * from country";
                              $run=mysqli_query($dbcon,$qry);
                              while($row=mysqli_fetch_array($run))
                              {
                              ?>
                              <option value="<?php echo $row['country_id']; ?>"><?php echo $row['country_name']; ?></option><?php
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                      </div>
					  <div class="col-md-6">
                        <div class="form-group row state">
                          <label class="col-sm-3 col-form-label">State</label>
                          <div class="col-sm-9">
                            <select class="form-control" name="state" id="state-list" onChange="getCity(this.value);">
                              <option selected="selected"><?php echo $emp_state; ?></option>
                            </select>
                          </div>
                        </div>
                      </div>
					  <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Select City</label>
                          <div class="col-sm-9">
                            <select class="form-control" name="city" id="city-list">
                              <option selected="selected"><?php echo $emp_city; ?></option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Date of Birth</label>
                          <div class="col-sm-9">
                            <input class="form-control" type="date" placeholder="dd/mm/yyyy"  name="dob" value="<?php echo $emp_dob; ?>" />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">                  
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Gender</label>
                          <div class="col-sm-4">
                            <div class="form-radio">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="gender" id="membershipRadios1" value="male" <?php if($emp_gender=="male"){echo "checked";} ?>> Male
                              </label>
                            </div>
                          </div>
                          <div class="col-sm-5">
                            <div class="form-radio">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="gender" id="membershipRadios2" value="female" <?php if($emp_gender=="female"){echo "checked";} ?>> Female
                              </label>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
					
					<div class="row">
					<div class="col-md-6">
					</div>
					<div class="col-md-6" align="right">
                        <button type="submit" class="btn btn-success btn-rounded btn-md "name="save_profile">Save</button>
                        <a href="main.php" class="btn btn-warning btn-rounded btn-md">Cancel</a> 
					</div>
                  </form>
                </div>
              </div>
            </div>
		</div>
			
		</div>
		
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->

        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <script src="vendors/js/vendor.bundle.addons.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/misc.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="js/dashboard.js"></script>
  <!-- End custom js for this page-->
</body>

</html>