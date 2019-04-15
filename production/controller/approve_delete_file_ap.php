<?php
session_start();
include("doconnect_php.php");
include("session.php");
include("../query/cek_employee.php");

$PR_NUMBER = $_REQUEST['pr_number'];
$ap_approval_id = $_REQUEST['ap_approval_id']; 
$nama_file = $_REQUEST['file_name'];
$DATE = date('Y-m-d');

$dirx = "../uploads/AP/$PR_NUMBER/$nama_file";

	$sql_php = 
	"UPDATE approval_list_ap 
	SET last_update_date= '".$DATE."', 
	delete_approval_date= '".$DATE."', 
	last_update_by ='".$employee_id."', 
	status ='DELETED'
	WHERE ap_approval_id = '".$ap_approval_id."'";

	if (mysqli_query($conn_php, $sql_php)) { 
		
		$dirx;
		if (file_exists($dirx))
		{
			unlink($dirx);
		}
		else {
			echo 'File Not Found';
		}
		header("Location:../approval_pending_admin.php");
	} else {
	    echo "Error: " . $sql_php . "<br>" . mysqli_error($conn_php);
	}

?>
