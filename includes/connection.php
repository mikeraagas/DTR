<?php 

	// connect to server and select db
	$connect = mysql_connect('localhost', 'root', '') or die('couldnt connect to server: ' . mysql_error());
	$select_db = mysql_select_db('dtr_db', $connect);
	if (!$select_db) {
		die('Databse connection failed: ' . mysql_error());
	}




 ?>