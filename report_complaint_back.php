<?php  
//export.php  
$connect = mysqli_connect("localhost", "root", "root", "kalika");
$output = '';
if(isset($_POST["export"]))
{
  $start_date=$_POST['start_date'];
  $end_date=$_POST['end_date'];
  
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
					
					WHERE complaint_details.complaint_date >= '$start_date' 
					AND complaint_details.complaint_date <= '$end_date'";
  
  
 $result = mysqli_query($connect, $complaint_query);
 if(mysqli_num_rows($result) > 0)
 {
  $output .= '
   <table class="table" border="1">  
                    <tr>  
                         <th>Complaint ID</th>  
                         <th>Customer Name</th>  
                         <th>Customer Mobile</th>  
						 <th>Customer Email</th> 
						 <th>Customer Address</th>
						 <th>Complaint Date</th>
						 <th>Complaint Status</th>
						 <th>Company Name</th> 
						 <th>Category Name</th>
						 <th>Model Name</th> 
						 <th>Problem /th> 
						 <th>Technician Remark</th>
						 <th>Technician Name</th>
						 <th>Warranty Status</th>
						 <th>Serial No</th>				
						 <th>Service Charge</th>
						 <th>Close Date</th>
                    </tr>
  ';
  while($row = mysqli_fetch_array($result))
  {
   $output .= '
					<tr>  
                         <td>'.$row["complaint_id"].'</td>  
                         <td>'.$row["customer_name"].'</td>  
                         <td>'.$row["customer_mobile"].'</td>  
						 <td>'.$row["customer_email"].'</td>  
						 <td>'.$row["customer_address"].'</td>  
						  
						 <td>'.$row["complaint_date"].'</td>  
						 <td>'.$row["complaint_status"].'</td>
						 <td>'.$row["company_name"].'</td>   	
						<td>'.$row["category_name"].'</td>
						<td>'.$row["model_name"].'</td>
						<td>'.$row["problem_description"].'</td>
						<td>'.$row["technician_remarks"].'</td>
						<td>'.$row["employee_name"].'</td>
						<td>'.$row["warranty_status"].'</td>
						<td>'.$row["model_serial_no"].'</td>
						<td>'.$row["service_charge"].'</td>
						<td>'.$row["complaint_close_date"].'</td>
						
                    </tr>
   ';
  }
  $output .= '</table>';
  header('Content-Type: application/xls');
  header('Content-Disposition: attachment; filename=KMS_Complaint_Report.xls');
  echo $output;
 }
}
?>