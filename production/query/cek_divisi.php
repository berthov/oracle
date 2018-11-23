<?php
		$sql_divisi = 
		"SELECT divisi 
		FROM employee
		where name = '".$user_check."'";

		$result_divisi = mysqli_query($conn_php,$sql_divisi);
		$existing_divisi = mysqli_fetch_assoc($result_divisi);
		$divisi = $existing_divisi['divisi'];
?>