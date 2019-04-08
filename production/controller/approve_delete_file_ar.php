<?php
session_start();
include("doconnect_php.php");
include("session.php");
include("../query/cek_employee.php");

$id = $_REQUEST['id']; 
$DATE = date('Y-m-d');

	$sql_php = 
	"UPDATE approval_list_ar 
	SET last_update_date= '".$DATE."', 
	approval_date= '".$DATE."', 
	last_update_by ='".$employee_id."', 
	status ='A'
	WHERE ID = '".$id."'";

	if (mysqli_query($conn_php, $sql_php)) { 
		header("Location:../approval_pending_admin.php");
	} else {
	    echo "Error: " . $sql_php . "<br>" . mysqli_error($conn_php);
	}

?>