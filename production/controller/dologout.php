<?php
	session_start();
	session_destroy();
	setcookie("user", "", time() - 3600, "/");
	setcookie("pass", "", time() - 3600, "/");
	

	session_start();
    $logout = true;
	$_SESSION['logout'] = $logout;
	header("Location:../login.php");
?>