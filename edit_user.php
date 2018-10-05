<!DOCTYPE html>
<?php

error_reporting(E_ALL ^ E_NOTICE);
session_start();//session starts here
$session_id = $_SESSION['username'];
include("database/db_conection.php");
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
if($role!="admin")
{
  header("Location : main.php");
}
$emp_id = $_GET['emp_id'];

$user_qry = @"SELECT `employee`.`employee_id`,`employee`.`employee_name`, 
                    `user`.`user_role` FROM
                    `user`
                    join 
                    `employee`
                    on
                    `employee`.`employee_id`=`user`.`employee_id`
                    where `user`.`employee_id`='$emp_id'";
                    $user_run = mysqli_query($dbcon,$user_qry); 
$user_run = mysqli_query($dbcon,$user_qry); 
while($row=mysqli_fetch_array($user_run))
{
  $emp_fname= $row[1];
  $emp_frole=$row[2];
}

//$gen_pass = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 5);

$emp_id = $_GET['emp_id'];

if(isset($_POST['edit_user']))
{
  $emp = $_POST['username'];
  //$password = md5($_POST['password']);
  $role = $_POST['role'];
  $sql = "UPDATE `user` SET `user_role`='$role' WHERE `employee_id`= '$emp'";
  //echo $sql;
 if(mysqli_query($dbcon, $sql)){
    echo "<script>alert('User role has been updated!')</script>";
     echo "<script>window.open('manage_user.php','_self')</script>";
  } else{
    echo "<script>alert('User is not updated!')</script>";
    echo "<script>window.open('manage_user.php','_self')</script>";
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
              <form action="edit_user.php" method="post">
                <div class="form-group">
                   <span><h3 style="text-align: center;">KALIKA MULTISERVICES</h3></span>
				    <span><h5 style="text-align: center">Edit User</h5></span>
                </div>

                        <div class="form-group row">
                          <label class="col-sm-4 col-form-label">Employee Id</label>
                          <div class="col-sm-12">
                            <input type="text" class="form-control" name="username" placeholder="User ID" value="<?php echo $_GET['emp_id']?>" readonly/>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-4 col-form-label">Name</label>
                          <div class="col-sm-12">
                            <input type="text" class="form-control" name="emp_name" placeholder="Employee Name" value="<?php echo $emp_fname;?>" readonly/>
                          </div>
                        </div>
                        <!--<div class="form-group row">
                          <label class="col-sm-4 col-form-label">Password</label>
                          <div class="col-sm-12">
                            <input type="text" class="form-control" name="password" placeholder="Username" value="<?php echo $gen_pass;?>" required/>
                          </div>
                        </div>-->
                        <div class="form-group row">
                          <label class="col-sm-4 col-form-label">Role</label>
                          <div class="col-sm-12">
                            <select class="form-control" name="role" id="role-list">
                              <?php 
                                if($emp_frole=="dep")
                                  echo "<option selected disabled value='dep'>Data Entry Operator</option>";
                                else if($emp_frole=="technician")
                                  echo "<option selected  disabled value='technician'>Technician</option>";
                                else
                                  echo "<option selected disabled value='admin'>Admin</option>";
                              ?>
                              <option value="dep">Data Entry Operator</option>
                              <option value="technician">Technician</option>
                            </select>
                          </div>
                        </div>
                
                <div class="form-group">
                 <button type="submit" class="btn btn-success btn-rounded btn-md "name="edit_user">Update</button>
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

