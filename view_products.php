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
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Kalika Multi Services</title>
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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
<!--Ajax functions for fetching category data according to company_id-->
<script>
function getCategory(val) {
  $.ajax({
  type: "POST",
  url: "get_state.php",
  data:'company_id='+val,
  success: function(data){
    $("#category-list").html(data);
  }
  });
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
                <li class='nav-item'>
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

			          <div class="row">


            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h2 class="card-title">Search Product/Model</h2>
                  <form class="form-sample" method="post" action="view_products.php">

                    <div class="row">
                      <!--select company-->
                      <div class="col-md-6">
                        <div class="form-group row country">
                          <label class="col-sm-3 col-form-label">Company Name *</label>
                          <div class="col-sm-9">
                            <select class="form-control" name="companyname" id="company" onChange="getCategory(this.value);" required>
                              <option selected="selected">Select Company</option>
                              <?php
                              $qry= "select * from company_details";
                              $run=mysqli_query($dbcon,$qry);
                              while($row=mysqli_fetch_array($run))
                              {
                              ?>
                              <option value="<?php echo $row['company_id']; ?>"><?php echo $row['company_name']; ?></option><?php
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                      </div>

                <!--select Category-->
                      <div class="col-md-6">
                       <div class="form-group row">
                         <label class="col-sm-3 col-form-label">Category Name *</label>
                         <div class="col-sm-9">

                           <select class="form-control" id="category-list"  name="categoryid" required >
                           <!--  <option  value="">Select Model Name</option> -->
                           </select>
                         </div>
                       </div>
                     </div>
                    </div>

					<button type="submit" value="Submit" class="btn btn-success btn-rounded btn-md" name="submit">Search</button>
                  </form>
                </div>
              </div>
            </div>

<?php
include 'database/db_conection.php';
//Adding Category Details, Code
if(isset($_POST['submit']))
{
		$companyname=$_POST['companyname'];
$categoryid=$_POST['categoryid'];

$query5="select * from category_details where category_id='$categoryid'";
$run5=mysqli_query($dbcon,$query5);
$row5=mysqli_fetch_array($run5);
$vcat_id=$row5[0];
		
	echo "		
			<div class='col-lg-12 grid-margin stretch-card'>
              <div class='card'>
                <div class='card-body'>
                  <h4 class='card-title'>Product Model Details</h4>

                  <div class='table-responsive'>
                    <table class='table table-bordered'>
                      <thead>
                        <tr>
                          <th>
                            Serial No.
                          </th>
                          <th>
                            Product
                          </th>
                          <th>
                            Category
                          </th>
                          <th>
							Company
                          </th>
						  <th>
							Action
                          </th>

                        </tr>
                      </thead>
                      <tbody> ";
					 
							$query=
							"SELECT model_details.model_id,model_details.model_name,category_details.category_name, company_details.company_name 
							FROM model_details LEFT JOIN category_details ON category_details.category_id=model_details.category_id 
							LEFT JOIN company_details ON category_details.company_id=company_details.company_id where category_details.category_id='$vcat_id'";
							
							$run=mysqli_query($dbcon,$query);
							$tbl_color = array("table-danger", "table-success", "table-primary","table-info","table-warning");
							$color_count = 0;
							$count=1;
							while($row=mysqli_fetch_array($run))
							{
							$mid=$row[0];    //model id variable
							$mname=$row[1]; //category name variable
							$catid=$row[2]; //compname variable
							$vcompname=$row[3];
							
							if($color_count>4)
							$color_count=0;
					 
                      echo "  <tr class='"; echo $tbl_color[$color_count]; $color_count++; echo "'>
                          <td style='padding-top: 0px; padding-bottom: 0px;'> ";
                             echo $count; $count++; 
                     echo "     </td>
                          <td style='padding-top: 0px; padding-bottom: 0px;'> ";
                             echo $mname;
                     echo "     </td>
                          <td style='padding-top: 0px; padding-bottom: 0px;'> ";
                             echo $catid; 
                      echo "    </td>
						  <td style='padding-top: 0px; padding-bottom: 0px;'> ";
                             echo $vcompname;
                     echo "     </td>
                          <td style='padding-top: 0px; padding-bottom: 0px;'> ";
                           echo @"     <a href='edit_product.php?edt=$mid' class='btn btn-icons btn-rounded btn-warning'><i class='fa fa-pencil'></i></a>&nbsp;&nbsp; ";
						echo @"   <a href='delete_product.php?delt=$mid' class='btn btn-icons btn-rounded btn-danger'><i class='fa fa-trash-o'></i></a> ";
                     echo "     </td>
                        </tr> ";
                         } 
						 
                    echo "  </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
			";
	
	
}			
?>			

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
  <!--
  <script>
  function myFunction() {
    if(confirm('Are you sure you want to delete the category ?'))
	{
	window.location.href='delete_product.php?delt=';
	}
	else{

	}
	}
  </script>
  -->
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  
</body>
</html>

