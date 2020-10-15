<!DOCTYPE html>
<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();//session starts here

include("database/db_conection.php");


if(isset($_POST['update_change']))
{
  $emp_id = $_POST['username'];
  $sec_key = $_POST['question'];
  $sec_ans = $_POST['answer'];
  $password = md5($_POST['password']);  
  $emp_qry = "SELECT `security_key`,`security_ans` FROM `user` where `employee_id`='$emp_id'";
  $run=mysqli_query($dbcon,$emp_qry);
  while($row=mysqli_fetch_array($run))
  {
    $fetch_key=$row[0];
    $fetch_ans=$row[1];
  }
  //echo "<script>window.open('forgot.php?key=$fetch_key&&ans=$fetch_ans','_self')</script>";
  if($sec_key==$fetch_key && $sec_ans==$fetch_ans)
  {

    $query2="UPDATE `user` SET
          `password`='$password'
          WHERE `employee_id` = '$emp_id'";
    if(mysqli_query($dbcon,$query2)){
      echo "<script>alert('Password Has Been Updated!')</script>";
      echo "<script>window.open('index.php','_self')</script>";
    }
    else
    {
      echo "<script>alert('Password not changed!')</script>";
    }
  }
else
  {
   echo "<script>alert('Details not matched!')</script>"; 
  }
}  
?>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
 <title>Kalika Multiservices</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/iconfonts/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.addons.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/favicon.png" />
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper auth-page">
      <div class="content-wrapper d-flex align-items-center auth auth-bg-1 theme-one">
        <div class="row w-100">
          <div class="col-lg-4 mx-auto">
            <div class="auto-form-wrapper">
              <form method="POST" action="forgot.php">
                <div class="form-group">
                   <span><h3 style="text-align: center;">KALIKA MULTISERVICES</h3></span>
				   <span><h5 style="text-align: center">Forgot Password</h5></span>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Username *</label>
                  <input type="text" class="form-control" name="username" placeholder="Enter Username" required>
                </div>
				<div class="form-group">
                    <label for="exampleFormControlSelect2">Security Question *</label>
                    <select class="form-control" name="question">
                      <option>What is your favorite food?</option>
                      <option>In what city were you born?</option>
                      <option>What is your father's middle name?</option>
                      <option>What is your nick name?</option>
                    </select>
                </div>
				<div class="form-group">
                  <label for="exampleInputEmail1">Answer *</label>
                  <input type="text" class="form-control" name="answer" placeholder="Enter Answer" required>
                </div>
                <div class="form-group">
                  <label class="label">New Password *</label>
                  <input type="password" class="form-control" name="password" placeholder="Enter New Password" required>
                </div><br>
                <div class="form-group">
				  <button type="submit" class="btn btn-success mr-2" name="update_change">Save</button>
				  <!--<input class="btn btn-success mr-2" type="submit"name="update" value="Save"/>-->
                  <a href="index.php" class="btn btn-light">Cancel</a>
                </div>
              </form>
            </div>
            <!--<ul class="auth-footer">
              <li>
                <a href="#">Conditions</a>
              </li>
              <li>
                <a href="#">Help</a>
              </li>
              <li>
                <a href="#">Terms</a>
              </li>
            </ul>-->
            <!--<p class="footer-text text-center">Copyright © 2020 Bootstrapdash. All rights reserved.</p>-->
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <script src="vendors/js/vendor.bundle.addons.js"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/misc.js"></script>
  <!-- endinject -->
</body>

</html>

