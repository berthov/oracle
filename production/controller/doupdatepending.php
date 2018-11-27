<?php
session_start();
include("doconnect_php.php");
include("session.php");
include("doconnect.php");   
include("../query/cek_employee.php");   

$id = $_REQUEST['id']; 
$approve_date = date('Y-m-d');

$sql = "UPDATE ap_invoices_header SET STATUS='A', APPROVAL_DATE = '".$approve_date."', LAST_UPDATE_DATE = '".$approve_date."', LAST_UPDATED_BY = '".$employee_id."' WHERE INVOICE_ID='".$id."'";


if (mysqli_query($conn_php, $sql)) {
		    header("Location:../form_pending_req.php");
		} else {
		    echo "Error: " . $sql . "<br>" . mysqli_error($conn_php);
		}

?>