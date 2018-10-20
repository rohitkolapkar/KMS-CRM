<?php  
//export.php  
$connect = mysqli_connect("localhost", "root", "root", "kalika");
$output = '';
if(isset($_POST["export"]))
{
 $query = "SELECT
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
 $result = mysqli_query($connect, $query);
 if(mysqli_num_rows($result) > 0)
 {
  $output .= '
   <table class="table" border="1">  
                    <tr>
                    <th colspan="8" align="center">Kallika Multi Services Aurangabad</th>
                    <tr><th colspan="8" align="center">Employee Details</th></tr>
                    </tr>
                    <tr>  
                         <th>Employee ID</th>  
                         <th>Name</th>  
                         <th>Mobile No.</th>  
						 <th>Email ID</th> 
						 <th>Address</th> 
						 <th>Date of Birth</th>
						 <th>Gender</th> 
						 <th>City</th> 
                    </tr>
  ';
  while($row = mysqli_fetch_array($result))
  {
   $output .= '
					<tr>  
                         <td>'.$row["employee_id"].'</td>  
                         <td>'.$row["employee_name"].'</td>  
                         <td>'.$row["mobile_no"].'</td>  
						 <td>'.$row["email_id"].'</td>  
						 <td>'.$row["address"].'</td>  
						  
						 <td>'.$row["dob"].'</td>  
						 <td>'.$row["gender"].'</td>
						 <td>'.$row["city_name"].'</td>   						 
                    </tr>
   ';
  }
  $output .= '</table>';
  header('Content-Type: application/xls');
  header('Content-Disposition: attachment; filename=KMS_Employee_Report.xls');
  echo $output;
 }
}
?>