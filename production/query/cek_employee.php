<?php

// CEK EMPLOYEE ID
		$sql_employee = 
		"SELECT * 
		FROM employee
		where name = '".$user_check."'";

		$result_id = mysqli_query($conn_php,$sql_employee);
		$existing_id = mysqli_fetch_assoc($result_id);
		$employee_id = $existing_id['employee_id'];
		$employee_name = $existing_id['name'];
// END OF CEK EMPLOYEE ID

// CEK DIVISI
		$sql_divisi = 
		"SELECT divisi 
		FROM employee
		where name = '".$user_check."'";

		$result_divisi = mysqli_query($conn_php,$sql_divisi);
		$existing_divisi = mysqli_fetch_assoc($result_divisi);
		$divisi = $existing_divisi['divisi'];
// END OF CEK DIVISI

// CEK PENDING TRANSAKTI
		$sql_count = 
		"SELECT count(invoice_id) as count
		FROM ap_invoices_header ai
		where created_by = '".$employee_id."'
		and status = 'P'";

		$result_count = mysqli_query($conn_php,$sql_count);
		$existing_count = mysqli_fetch_assoc($result_count);
		$count = $existing_count['count'];
// END OF CEK PENDING TRANSAKTI

$today = strtotime(date('Y-m-d'));
?>