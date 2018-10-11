<?php  
//export.php  
$connect = mysqli_connect("localhost", "root", "root", "kalika");
$output = '';
if(isset($_POST["export"]))
{
 $query = "SELECT * FROM employee";
 $result = mysqli_query($connect, $query);
 if(mysqli_num_rows($result) > 0)
 {
  $output .= '
   <table class="table" border="1">  
                    <tr>  
                         <th>Company ID</th>  
                         <th>Company Name</th>  
                         <th>Mobile No.</th>  
						 <th>Email ID</th> 
						 <th>Address</th> 
						 <th>City ID</th> 
						 <th>Date of Birth</th>
						 <th>Gender</th> 
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
						 <td>'.$row["city_id"].'</td>  
						 <td>'.$row["dob"].'</td>  
						 <td>'.$row["gender"].'</td>  						 
                    </tr>
   ';
  }
  $output .= '</table>';
  header('Content-Type: application/xls');
  header('Content-Disposition: attachment; filename=Report.xls');
  echo $output;
 }
}
?>