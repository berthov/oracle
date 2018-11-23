<?php
	date_default_timezone_set('Asia/Jakarta');	

    $servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "cba";
	
	$conn_php = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn_php) {
    die("Connection failed: " . mysqli_connect_error());
}


?>