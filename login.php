<?php 

	include 'includes/connection.php';


	$username = $_POST['username'];
	$password = $_POST['password'];

	// cleaning data to avoid injection
	$username = stripslashes($username);
	$password = stripslashes($password);
	$username = mysql_real_escape_string($username);
	$password = mysql_real_escape_string($password);

	// mysql query
	$query = "SELECT * 
		FROM admin 
		WHERE username='$useranme' 
		AND password='$password'";
	$result = mysql_query($query);

	// mysql num_rows to check affected rows
	$count = mysql_num_rows($result);

	// if match username and password count returns 1
	if ($count == 1) {
		// store username and password in session
		$_SESSION['username'] = $username;
		$_SESSION['password'] = $password;
		header("location: login_success.php");

	} else {
		echo "Login Failed! check username and password combination";
	}


 ?>