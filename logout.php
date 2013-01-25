<?php ;


	// 1. Start the session
	session_start();

	// 2. Unset all session variables
	$_SESSION = array();
	// unset($_SESSION)

	// 3. Destroy the cookie
	if (isset($_COOKIE[session_name()])) {
		setcookie(session_name(), '', time()-42000, '/'); 
	}

	// 4. destroy the session
	session_destroy();

	header("location: index.php?logout=1");


 ?>