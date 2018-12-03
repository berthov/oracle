<?php
session_start();
include("doconnect_php.php");
include("session.php");
include("../query/cek_employee.php");

$INVOICE_ID = $_REQUEST['INVOICE_ID']; 
$DATE = date('Y-m-d');

	$user_check_sql = "SELECT * FROM ap_invoices_header WHERE INVOICE_ID = '".$INVOICE_ID."'";
	$result = mysqli_query($conn_php,$user_check_sql);
	$existing_user = mysqli_fetch_assoc($result);


	if ($existing_user) { 
	    if ($existing_user['STATUS'] === 'C') {
	        echo 'C';
	    }
	    else if ($existing_user['STATUS'] === 'A') {
			echo 'A';
	    }
    	else{
		// HEADER
			$sql_php = 
			"UPDATE ap_invoices_header 
			SET LAST_UPDATE_DATE= '".$DATE."', 
			LAST_UPDATED_BY ='".$employee_id."',
			STATUS = 'C'
			WHERE INVOICE_ID = '".$INVOICE_ID."'";

			if (mysqli_query($conn_php, $sql_php)) { 
				// header("Location:../summary_request.php");
				echo "New record created successfully";
			} else {
			    echo "Error: " . $sql_php . "<br>" . mysqli_error($conn_php);
			}
		// END OF HEADER
		}
	}
?>