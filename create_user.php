<!DOCTYPE html>
<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();//session starts here
$session_id = $_SESSION['username'];



include("database/db_conection.php");
$emp_id = $_GET['emp_id'];
$gen_pass = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 5);


if(isset($_POST['save_user']))
{
  $username = $_POST['username'];
  $password = md5($_POST['password']);
  $role = $_POST['role'];
  $sql = "INSERT INTO user (employee_id, password,user_role) VALUES ('$username', '$password','$role')";
  if(mysqli_query($dbcon, $sql)){
    echo "<script>alert('Employee has been created!')</script>";
     echo "<script>window.open('add_employee.php','_self')</script>";
  } else{
    echo "<script>alert('Employee is not created!')</script>";
    //echo "ERROR: Could not able to execute $sql. " . mysqli_error($dbcon);
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
              <form action="create_user.php" method="post">
                <div class="form-group">
                   <span><h3 style="text-align: center;">KALIKA MULTISERVICES</h3></span>
				    <span><h5 style="text-align: center">Create User</h5></span>
                </div>

                        <div class="form-group row">
                          <label class="col-sm-4 col-form-label">Employee Id</label>
                          <div class="col-sm-12">
                            <input type="text" class="form-control" name="username" placeholder="Username" value="<?php echo $_GET['emp_id']?>" readonly/>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-4 col-form-label">Password</label>
                          <div class="col-sm-12">
                            <input type="text" class="form-control" name="password" placeholder="Username" value="<?php echo $gen_pass;?>" required/>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-4 col-form-label">Role</label>
                          <div class="col-sm-12">
                            <select class="form-control" name="role" id="role-list">
                              <option selected="selected" value="dep">Data Entry Operator</option>
                              <option value="technician">Technician</option>
                            </select>
                          </div>
                        </div>
                
                <div class="form-group">
                 <button type="submit" class="btn btn-success btn-rounded btn-md "name="save_user">Save</button>
                 <a href="main.php" class="btn btn-warning btn-rounded btn-md">Cancel</a>
                </div>
              </form>
            </div>

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

