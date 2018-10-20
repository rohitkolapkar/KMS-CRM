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
if($role!="admin" || $role=="dep")
{
  header("Location : main.php");
}

if(isset($_POST['submit_employee'])){
  $emp_name=$_POST['name'];
  $emp_mob=$_POST['mobile'];
  $emp_email=$_POST['email'];
  $emp_add=$_POST['address'];
  $emp_country=$_POST['country'];
  $emp_state=$_POST['state'];
  $emp_city=$_POST['city'];
  $emp_dob=$_POST['dob'];
  $emp_gender=$_POST['gender'];

$query= @"INSERT INTO `employee`(`employee_name`, 
                                  `mobile_no`, `email_id`, 
                                  `address`, `city_id`, `dob`, 
                                  `gender`) 
                                  VALUES ('$emp_name','$emp_mob','$emp_email','$emp_add','$emp_city','$emp_dob','$emp_gender')";
if(mysqli_query($dbcon,$query))
{
  echo "<script>alert('Employee details has been saved!')</script>";
  $emp_qry = "SELECT * FROM `employee` ORDER BY employee_id DESC LIMIT 1";
  $run=mysqli_query($dbcon,$emp_qry);
  while($row=mysqli_fetch_array($run))
  {
    $emp_id=$row[0];
  }
  echo "<script>window.open('create_user.php?emp_id=$emp_id','_self')</script>";
}
else
{
  echo "<script>alert('Employee details not saved!')</script>";
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
  
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/favicon.png" />
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

</script>
</head>

<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
        <a class="navbar-brand brand-logo" href="#">
          <img src="images/logo.png" alt="logo" />
        </a>
        <a class="navbar-brand brand-logo-mini" href="#">
          <img src="images/logo-mini.png" alt="logo" />
        </a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center">

        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item dropdown d-none d-xl-inline-block">
            <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
              <span class="profile-text">Hello, <?php echo $name;?>!</span>
              <img class="img-xs rounded-circle" src="images/faces-clipart/pic-1.png" alt="Profile image">
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
              <a class="dropdown-item p-0">

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
              <i class="menu-icon fa fa-dashboard"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
        <?php
      if($role=="dep"|| $role=="admin")
      {
        echo @"<li class='nav-item'>
            <a class='nav-link' data-toggle='collapse' href='#customer' aria-expanded='false' aria-controls='ui-basic'>
              <i class='menu-icon fa fa fa-user-circle-o'></i>
              <span class='menu-title'>Customer Management</span>
              <i class='menu-arrow'></i>
            </a>
            <div class='collapse' id='customer'>
              <ul class='nav flex-column sub-menu'>
                <li class='nav-item'>
                  <a class='nav-link' href='add_customer.php'>Add Customer</a>
                </li>
                <li class='nav-item'>
                  <a class='nav-link' href='view_customers.php'>View Customer</a>
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
              <i class='menu-icon fa fa-pencil-square-o'></i>
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
        echo @"<li class='nav-item active'>
            <a class='nav-link' data-toggle='collapse' href='#employee' aria-expanded='false' aria-controls='ui-basic'>
              <i class='menu-icon fa fa-id-badge'></i>
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
                <li class='nav-item active'>
                  <a class='nav-link' href='manage_user.php'>
                  <span class='menu-title'>Manage Users</span>
                  </a>
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
              <i class='menu-icon fa fa-fire'></i>
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
              <i class='menu-icon fa fa-sitemap'></i>
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
              <i class='menu-icon fa fa-cubes'></i>
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
              <i class='menu-icon fa fa-bar-chart-o'></i>
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
          </li>
          <!--<li class='nav-item'>
            <a class='nav-link' href='my_account.php'>
              <i class='menu-icon fa fa-users'></i>
              <span class='menu-title'>Manage Users</span>
            </a>
          </li>-->
          ";
      }?>
          <li class="nav-item">
            <a class="nav-link" href="my_account.php">
              <i class="menu-icon fa fa-gears"></i>
              <span class="menu-title">Manage my account</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">
              <i class="menu-icon fa fa-power-off"></i>
              <span class="menu-title">Logout</span>
            </a>
          </li>
        </ul>
      </nav>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
    
             <div class="col-12 grid-margin" >
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">My Details</h4>
                  <form class="form-sample" method="POST" action="add_employee.php" >

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Full Name *</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="name" value="" required />
                          </div>
                        </div>
                      </div>
            <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Mobile No. *</label>
                          <div class="col-sm-9">
                            <input type="number" minlength=10 maxlength=12 class="form-control" name="mobile" value="" required />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Email *</label>
                          <div class="col-sm-9">
                            <input type="email" class="form-control" name="email" value="" required />
                          </div>
                        </div>
                      </div> 
            <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Address *</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" value="" name="address" required />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row country">
                          <label class="col-sm-3 col-form-label">Country *</label>
                          <div class="col-sm-9">
                            <select class="form-control" name="country" id="country-list" onChange="getState(this.value);" required >
                              <option selected="selected" >Select Country</option>
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
                          <label class="col-sm-3 col-form-label">State *</label>
                          <div class="col-sm-9">
                            <select class="form-control" name="state" id="state-list" onChange="getCity(this.value);" required >
                              <option selected="selected">Select State</option>
                            </select>
                          </div>
                        </div>
                      </div>
            <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Select City *</label>
                          <div class="col-sm-9">
                            <select class="form-control" name="city" id="city-list" required >
                              <option selected="selected">Select City</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Date of Birth *</label>
                          <div class="col-sm-9">
                            <input class="form-control" type="date" placeholder="dd/mm/yyyy"  name="dob" value="" required />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">                  
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Gender *</label>
                          <div class="col-sm-4">
                            <div class="form-radio">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="gender" id="membershipRadios1" value="male" required="required"> Male
                              </label>
                            </div>
                          </div>
                          <div class="col-sm-5">
                            <div class="form-radio">
                              <label class="form-check-label">
                                <input type="radio" class="form-check-input" name="gender" id="membershipRadios2" value="female" required="required"> Female
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
                        <button type="submit" class="btn btn-success btn-rounded btn-md "name="submit_employee">Save</button>
                        <a href="main.php" class="btn btn-warning btn-rounded btn-md">Cancel</a> 
          </div>
                  </form>
                </div>
              </div>
            </div>
    
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        <footer class="footer">
          <div class="container-fluid clearfix">
            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2018
              <a href="#">Kalika Multiservices</a>. All rights reserved.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with
              <i class="mdi mdi-heart text-danger"></i>
            </span>
          </div>
        </footer>
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