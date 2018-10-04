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
?>

<?php
//Insert Code for company details
include("database/db_conection.php");
if(isset($_POST['submit']))
{
$companyname=$_POST['compname'];
$companycontact=$_POST['compcont'];

if($companyname==''){
echo "<script>alert('Please Enter Company Name !!')</script>";
exit();
}
if($companycontact==''){
echo "<script>alert('Please Enter Contact Number !!')</script>";
exit();
}
$query="insert into company_details(company_name,company_contact) values('$companyname','$companycontact')";
if(mysqli_query($dbcon,$query)){
		echo "<script>window.open('add_company.php?Inserted Successfully','_self')</script>";
	}

}
//Insert code end's
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
        <!--<ul class="navbar-nav navbar-nav-left header-links d-none d-md-flex">
          <li class="nav-item">
            <a href="#demo" class="nav-link">Schedule
              <span class="badge badge-primary ml-1">New</span>
            </a>
          </li>
          <li class="nav-item active">
            <a href="#" class="nav-link">
              <i class="mdi mdi-elevation-rise"></i>Reports</a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="mdi mdi-bookmark-plus-outline"></i>Score</a>
          </li>
        </ul>-->
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
            <div class='collapse active' id='company'>
              <ul class='nav flex-column sub-menu'>
                <li class='nav-item'>
                  <a class='nav-link active' href='add_company.php'>Add Company</a>
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
        <div class="content-wrapper">

			<div class="row">
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Adding New Company</h4>
                  <form class="form-sample" action='add_company.php' method='post'>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Company Name</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="compname" />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Company Contact</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="compcont" />
                          </div>
                        </div>
                      </div>
                    </div>
<<<<<<< HEAD
                    
                   
					<button type="submit" value="Submit" class="btn btn-success btn-rounded btn-md" name="submit">Submit</button>
=======


					<input type="submit" value="Submit" name="submit">
>>>>>>> bdce83b8c7f32927f6ad53adc7d71166a73fc237

                  </form>
                </div>
              </div>
            </div>


			 <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Company Details</h4>

                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>
                            Serial No.
                          </th>
                          <th>
                            Company Name
                          </th>
                          <th>
                            Contact Number
                          </th>
                          <th>

                          </th>

                        </tr>
                      </thead>
                      <tbody>
					  <?php
							$query3="select * from company_details";
							$run3=mysqli_query($dbcon,$query3);
$count=1;
while($row3=mysqli_fetch_array($run3))
{
	$cid=$row3[0];
	$cname=$row3[1];
	$ccontact=$row3[2];


?>
                        <tr>
                          <td>
                            <?php echo $count; $count++; ?>
                          </td>
                          <td>
                            <?php echo $cname; ?>
                          </td>
                          <td>
                             <?php echo $ccontact; ?>
                          </td>
                          <td>
                            <button type="button" class="btn btn-dark btn-fw" onclick="window.location.href='edit_company.php?edt=<?php echo $cid; ?>'">
                          <i class="mdi mdi-cloud-download"></i>Edit</button>
						   <button type="button" class="btn btn-danger btn-fw" onclick="window.location.href='delete_company.php?delt=<?php echo $cid; ?>'">
                          <i class="mdi mdi-alert-outline"></i>Delete</button>
                          </td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
		  </div>

        </div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        <footer class="footer">
          <div class="container-fluid clearfix">
            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2018
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
  <!--
  <script>
  function myFunction() {
    if(confirm('Are you sure you want to delete the company ?'))
	{
	window.location.href='delete_company.php?delt=<?php echo $cid; ?>';
	}
	else{

	}
	}
  </script>
  -->
</body>

</html>
