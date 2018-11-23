<?php

	include("doconnect_php.php");
	session_start();

	if($_SERVER["REQUEST_METHOD"]=="POST"){

		$usernamelogin = mysqli_escape_string($conn_php, $_POST['username']);
		$passwordlogin = md5(mysqli_escape_string($conn_php, $_POST['password']));
		$firstLogin = false;

		$sql = "SELECT employee_id FROM employee WHERE BINARY name = '$usernamelogin' and password = '$passwordlogin'";
		$result = mysqli_query($conn_php,$sql);

      	$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      
      	$count = mysqli_num_rows($result);
      	
      	if($count == 1) {
        	$_SESSION['login_user'] = $usernamelogin;
        	$firstLogin = true;
        	$_SESSION['firstLogin'] = $firstLogin;
        	echo 'success';
      	} else {
      		echo 'error';
     	}
	}

	if (isset($_REQUEST['logstate'])) {
		if (ini_get("session.use_cookies")) {
		    $params = session_get_cookie_params();
		    setcookie(session_name(), '', time() - 42000,
		        $params["path"], $params["domain"],
		        $params["secure"], $params["httponly"]
		    );
		}  
      	session_destroy(); 

		session_start();
      	$logout = true;
		$_SESSION['logout'] = $logout;

	    header("location: login.php");
	}

?>