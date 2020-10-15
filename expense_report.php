<!DOCTYPE html>
<?php
include("database/db_conection.php");

error_reporting(E_ALL ^ E_NOTICE);
session_start();
if(!$_SESSION['username'])
    header("Location: branchlogin.php");//redirect to login page to secure the welcome page without login access.
else
  $session_idb = $_SESSION['usernameb'];

$qry= "SELECT 
    user.user_role, employee.employee_name
     FROM 
    user
     INNER JOIN 
    employee 
     ON
    user.employee_id=employee.employee_id
    WHERE 
    user.employee_id='$session_idb'";
 
$run=mysqli_query($dbcon,$qry);
while($row=mysqli_fetch_array($run))
{
  $role=$row[0];
  $name=$row[1];
}
if($role!="admin")
{
  echo "<script>window.open('main.php','_self')</script>";
}
/*
$emp_qry= "SELECT * FROM `employee`"; 
$run=mysqli_query($dbcon,$emp_qry);
while($row=mysqli_fetch_array($run))
{
  $emp_id=$row[0];
  $emp_name=$row[1];
  $emp_mob=$row[2];
  $emp_email=$row[3];
  $emp_dob=$row[6];
  $emp_add=$row[4];
}
*/

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
  <link rel="stylesheet" href="vendors/iconfonts/font-awesome/css/font-awesome.css">
  
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/favicon.png" />
  <script type="text/javascript">
    function deleteCmp(compid) {
    if(confirm('Are you sure you want to delete?\n'+'Employee ID : '+compid+"\nClick ok to delete"))
    {
      window.location.href='delete_company.php?compid='+compid;
    }
    else{

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
              <img class="img-xs rounded-circle" src="images/faces/face1.jpg" alt="Profile image">
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
			  echo @"<li class='nav-item'>
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
          </li>";
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
		
			     <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Employee Details</h4>
				  
				   <form class="form-sample" action="report_employee_back.php" method="post">				
						<input type="submit" value="Export Data" class="btn btn-success btn-rounded btn-md" name="export"><br>
					</form>
				  
                  <?php
                    $emp_qry= "SELECT
									employee.employee_id,
									employee.employee_name,
									employee.mobile_no,
									employee.email_id,
									employee.address,
									employee.dob,
									employee.gender,
									cities.city_name
								FROM
									employee
								INNER JOIN cities ON employee.city_id = cities.city_id"; 
                    $run=mysqli_query($dbcon,$emp_qry);
                    $count=1;
                  ?>
                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th style="padding-left: 5px; padding-right: 0px;">
                            Sr. No.
                          </th>
                          <th>
                            Employee ID
                          </th>
                          <th>
                            Employee Name
                          </th>
						  <th>
                            Mobile No.
                          </th>
						  <th>
                            Email ID
                          </th>
						  <th>
                            Address
                          </th>
						  <th>
                            Date of Birth
                          </th>
						  <th>
                            Gender
                          </th>
						  <th>
                            City
                          </th>
						
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          $tbl_color = array("table-danger", "table-success", "table-primary","table-info","table-warning");
                          $color_count = 0;
						  $count = 1;
                          while($row=mysqli_fetch_array($run))
                          {
                           
                      $c1=$row[0];
                      $c2=$row[1];
					  $c3=$row[2];
					  $c4=$row[3];
					  $c5=$row[4];
					  $c6=$row[5];
					  $c7=$row[6];
					  $c8=$row[7];
					  $c9=$row[8];
					  

                      if($color_count>4)
                        $color_count=0;
                        ?>
                        <tr class="<?php echo $tbl_color[$color_count]; $color_count++;?>">
                           <td>
                            <?php echo $count; $count++;?>
                          </td>
						  <td>
                            <?php echo $c1;?>
                          </td>
                          <td>
                            <?php echo $c2;?>
                          </td>
						  <td>
                            <?php echo $c3;?>
                          </td>
						  <td>
                            <?php echo $c4;?>
                          </td>
						  <td>
                            <?php echo $c5;?>
                          </td>
						  <td>
                            <?php echo $c6;?>
                          </td>
						  <td>
                            <?php echo $c7;?>
                          </td>
						  <td>
                            <?php echo $c8;?>
                          </td>
                        </tr>
                        <?php 
                         
                          }
                        ?>
                      </tbody>
                    </table>
                  </div>					
                </div>
              </div>
            </div>
		  
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        <footer class="footer">
          <div class="container-fluid clearfix">
            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2020
              <a href="http://www.bootstrapdash.com/" target="_blank">Bootstrapdash</a>. All rights reserved.</span>
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

