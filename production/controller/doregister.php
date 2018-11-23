<?php
	include("doconnect_php.php");
	session_start();

	if($_SERVER["REQUEST_METHOD"]=="POST"){

		$usernameregister = mysqli_escape_string($conn_php, $_POST['username']);
		$passwordregister = md5(mysqli_escape_string($conn_php, $_POST['password']));
		$cpasswordregister = md5(mysqli_escape_string($conn_php, $_POST['cpassword']));
		$emailregister = mysqli_escape_string($conn_php, $_POST['email']);
		$divisi = mysqli_escape_string($conn_php, $_POST['divisi']);
		$created = date("Y-m-d");

		$user_check_sql = "SELECT * FROM employee WHERE name = '$usernameregister' OR email='$emailregister' ";
		$result = mysqli_query($conn_php,$user_check_sql);
		$existing_user = mysqli_fetch_assoc($result);

		if($passwordregister == $cpasswordregister){
			if ($existing_user) { 
			    if ($existing_user['name'] === $usernameregister) {
			      echo 'Username already exist';
			    }

			    else if ($existing_user['email'] === $emailregister) {
					echo 'Email already exist';
			    }
			}

			else {


				$sql = "INSERT INTO employee (name, email, password, divisi , created_date) VALUES ('$usernameregister', '$emailregister', '$passwordregister' , '$divisi', '$created')";
	  			$result = mysqli_query($conn_php, $sql);

				header("location: ../login.php");
			}

		} else {
			echo 'password did not match';
		}
		
	}
?>