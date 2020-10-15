<!DOCTYPE html>
<html lang="en">
<?php
include("database/db_conection.php");

$month = date('m');
$day = date('d');
$year = date('Y');
$today = $year . '-' . $month . '-' . $day;

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

$complaint_id=$_GET['complaint_id'];
$complaint_query="
					SELECT
						complaint_details.complaint_id,
						complaint_details.complaint_date,
						complaint_details.complaint_status,
						complaint_details.warranty_status,
						complaint_details.model_serial_no,
						complaint_details.problem_description,
						complaint_details.complaint_close_date,
						complaint_details.technician_remarks,
						complaint_details.service_charge,
						customer_details.customer_name,
						customer_details.customer_mobile,
						customer_details.customer_email,
						customer_details.customer_address,
						company_details.company_name,
						company_details.company_id,
						category_details.category_name,
						category_details.category_id,
						model_details.model_name,
						model_details.model_id,
						employee.employee_name,
						employee.employee_id
						
					FROM
						complaint_details
					LEFT JOIN customer_details ON complaint_details.customer_id = customer_details.customer_id
					LEFT JOIN company_details ON complaint_details.company_id = company_details.company_id
					LEFT JOIN category_details ON complaint_details.category_id = category_details.category_id
					LEFT JOIN model_details ON complaint_details.model_id = model_details.model_id
					LEFT JOIN employee ON complaint_details.employee_id = employee.employee_id
					WHERE
						complaint_details.complaint_id ='$complaint_id'
					";
			$complaint_run=mysqli_query($dbcon,$complaint_query);
			while($complaint_row=mysqli_fetch_array($complaint_run))
			{
				$complaint_id1=$complaint_row[0];
				$complaint_date=$complaint_row[1];
				$complaint_status=$complaint_row[2];
				$warranty_status=$complaint_row[3];
				$model_serial_no=$complaint_row[4];
				$problem_description=$complaint_row[5];
				$complaint_close_date1=$complaint_row[6];
				$technician_remark1=$complaint_row[7];
				$service_charge1=$complaint_row[8];
				$customer_name=$complaint_row[9];
				$customer_mobile=$complaint_row[10];
				$customer_email=$complaint_row[11];
				$customer_address=$complaint_row[12];
				$company_name=$complaint_row[13];
				$company_id=$complaint_row[14];
				$category_name=$complaint_row[15];
				$category_id=$complaint_row[16];
				$model_name=$complaint_row[17];
				$model_id=$complaint_row[18];
				$employee_name=$complaint_row[19];
				$employee_id=$complaint_row[20];
			}

//update code start
if(isset($_POST['update_complaint'])){
	
  $complaint_number=$_POST['complaint_ID1'];
  $company_id=$_POST['company'];
  $category_id=$_POST['category'];
  $model_id=$_POST['product'];
  $warrenty_status=$_POST['warranty'];
  $serial_no = $_POST['serial'];
  $problem = $_POST['problem'];
  $cdate = $_POST['cdate']; 
  $employee_id=$_POST['employee'];
  $technician_remark=$_POST['technician_remark'];
  $service_charge=$_POST['service_charge'];
  $closing_date=$_POST['closing_date'];
  $complaint_status=$_POST['complaint_status'];

 $query="UPDATE complaint_details SET
    company_id='$company_id',
    category_id='$category_id',
    model_id='$model_id',
    employee_id='$employee_id',
    complaint_status='$complaint_status',
    warranty_status='$warrenty_status',
    model_serial_no='$serial_no',
    problem_description='$problem',
    complaint_date='$cdate',
    complaint_close_date='$closing_date',
    technician_remarks='$technician_remark',
    service_charge='$service_charge'
WHERE
    complaint_id='$complaint_number'";
	
if(mysqli_query($dbcon,$query))
{
  echo "<script>alert('Complaint has been updated')</script>";
  echo "<script>window.open('search_complaint.php','_self')</script>";
}
else
{
 echo "<script>alert('Complaint update failed')</script>";
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
  <link href="css/jquery-editable-select.css" rel="stylesheet"/>
  <link href="css/w3.css" rel="stylesheet"/>
  <!-- endinject -->
  <link rel="shortcut icon" href="images/favicon.png" />
  <script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
<script>
function getProduct(val) {
  $.ajax({
  type: "POST",
  url: "get_city.php",
  data:'category_id='+val,
  success: function(data){
    $("#product-list").html(data);
  }
  });
}

function getCategory(val) {
  //alert(val);
  $.ajax({
  type: "POST",
  url: "get_state.php",
  data:'company_id='+val,
  success: function(data){
    $("#category-list").html(data);
  }
  });
}

function selectCompany(val) {
$("#search-box").val(val);
$("#suggesstion-box").hide();
}

    /*function getCustDetails(val)
    { 
      <?php
        $qry= "select * from customer_details ";
        
        $run=mysqli_query($dbcon,$qry);
        while($row=mysqli_fetch_array($run))
        {
          $fetched_mobile = $row['customer_mobile'];
          $fetched_email = $row['customer_email'];
          $fetched_add = $row['customer_address'];
        }
      ?>
       $("#mobile").val('<?php echo $fetched_mobile;?>');
       $("#email").val('<?php echo $fetched_email;?>');
       $("#address").val('<?php echo $fetched_add;?>');
    }*/


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
    
            <div class="col-12 grid-margin" >
              <div class="card">
                <div class="card-body">
                  <form class="form-sample" method="POST" action="update_complaint.php" >
                    <div class="row">
                      <div class="col-md-6">
                        <h4 class="card-title">
                              Cutomer Details &nbsp;&nbsp;   
							  
                        
                          <label class="col-sm-3 col-form-label">Complaint ID*</label>
                          
                            <select class="card-title" name="complaint_ID1" readonly >
								<option value="<?php echo $complaint_id; ?>"><?php echo $complaint_id; ?></option>
                            </select>
                          
                    
                        </h4>

                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Complaint Date*</label>
                          <div class="col-sm-9">
                            <input class="form-control" type="date" id="cdate"  name="cdate" value="<?php echo $complaint_date;?>"  />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Mobile No*</label>
                          <div class="col-sm-9">
                            <select class="form-control" name="mobile" id="mob-list" placeholder="Mobile Number" disabled>
								<option value="<?php echo $customer_id; ?>"><?php echo $customer_mobile; ?></option>
                            </select>
                          </div>
                        </div>
                      </div>
            <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Name*</label>
                          <div class="col-sm-9">
                            <div id="name">
                              <input type="text" class="form-control" name="name"  placeholder="Name" value="<?php echo $customer_name;?>" disabled />
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Email*</label>
                          <div class="col-sm-9" >
                           <div id="email">
                              <input type="text" class="form-control" name="email" placeholder="xyz@email.com" value="<?php echo $customer_email;?>" disabled />
                            </div>
                          </div>
                        </div>
                      </div> 
            <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Address*</label>
                          <div class="col-sm-9">
                            <div  id="address">
                            <input type="text" class="form-control" value="<?php echo $customer_address;?>" name="address" placeholder="Address" disabled />
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <h4 class="card-title">Product Details</h4>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row country">
                          <label class="col-sm-3 col-form-label">Company*</label>
                          <div class="col-sm-9">
                            <select class="form-control" name="company" id="company-list" onChange="getCategory(this.value);" >
                              <option selected="selected" value="<?php echo $company_id;?>"><?php echo $company_name;?></option>
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
            <div class="col-md-6">
                        <div class="form-group row state">
                          <label class="col-sm-3 col-form-label">Category*</label>
                          <div class="col-sm-9">
                            <select class="form-control" name="category" id="category-list" onChange="getProduct(this.value);"  >
                              <option selected="selected" value="<?php echo $category_id;?>" readonly ><?php echo $category_name;?></option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Product*</label>
                          <div class="col-sm-9">
                            <select class="form-control" name="product" id="product-list" >
                              <option selected="selected" value="<?php echo $model_id;?>" ><?php echo $model_name; ?></option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Warranty*</label>
                          <div class="col-sm-9">
                            <select class="form-control" name="warranty" id="product-list" >
                              <option selected="selected" value="<?php echo $warranty_status; ?>" readonly ><?php echo $warranty_status; ?></option>
                              <option value="OUT WARRANTY">OUT WARRANTY</option>
							  <option value="IN WARRANTY">IN WARRANTY</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Serial No*</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="serial" value="<?php echo $model_serial_no; ?>" placeholder="Serial No" required />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Problem*</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="problem" value="<?php echo $problem_description; ?>" placeholder="Description"  />
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row country">
                          <label class="col-sm-3 col-form-label">Tecnician*</label>
                          <div class="col-sm-9">
                            <select class="form-control" name="employee" id="employee-list" >
                              <option selected="selected" value="<?php echo $employee_id?>" readonly ><?php echo $employee_name?></option>
                              <?php
                              $qry= "select employee.employee_id,employee.employee_name
                                     from user
                                    join 
                                    employee
                                    on user.employee_id = employee.employee_id
                                    where user.user_role = 'technician'";
                              $run=mysqli_query($dbcon,$qry);
                              while($row=mysqli_fetch_array($run))
                              {
                              ?>
                              <option value="<?php echo $row['employee_id']; ?>"><?php echo $row['employee_name']; ?></option><?php
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                      </div>
					  
					  
					<div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Tecnician Remark*</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="technician_remark" value="<?php echo $technician_remark1; ?>" placeholder="Tecnician Remark*" />
                          </div>
                        </div>
                      </div>

                    </div>
          
          <div class="row">
				  <div class="col-md-6">
				  <div class="form-group row">
				  <label class="col-sm-3 col-form-label">Service Charge</label>
				  <div class="col-sm-9">
					<input type="number" class="form-control" name="service_charge" value="<?php echo $service_charge1; ?>" placeholder="Rs." />
				  </div>
				  </div>
				  </div>
				  
				  <div class="col-md-6">
				        
                        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Closing Date</label>
                          <div class="col-sm-9">
                            <input class="form-control" type="date" id="closing_date"  name="closing_date" value="<?php echo $complaint_close_date1; ?>" />
                          </div>
                        </div>
                      
				 
				  </div>
				  
				  <div class="col-md-6">
				        <div class="form-group row">
                          <label class="col-sm-3 col-form-label">Complaint Status*</label>
                          <div class="col-sm-9">
                            <select class="form-control" name="complaint_status" id="complaint_status"  >
                              <option selected="selected" value="<?php echo $complaint_status; ?>"><?php echo $complaint_status; ?></option>
                              <option value="PENDING">PENDING</option>
							  <option value="CLOSED">CLOSED</option>
							  <option value="CANCELED">CANCELED</option>
                            </select>
                        </div>
				  </div>
				</div>
				
				  <div class="col-md-6" align="right">
								<button type="submit" class="btn btn-success btn-rounded btn-md "name="update_complaint">Update Complaint</button>
								<a href="main.php" class="btn btn-warning btn-rounded btn-md">Cancel</a> 
								
				  </div>
              </form>
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