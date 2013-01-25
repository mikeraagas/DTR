<?php require_once 'includes/session.php' ?>
<?php require_once 'includes/connection.php' ?>

<?php 

	$employee = $_POST['employee'];
	$start_date = $_POST['start-date'];
	$end_date = $_POST['end-date'];

	$employees = array(
	    '2' => 'Jeffrey Dino',
	    '3' => 'Enrique Joaquin',
	    '4' => 'Allan Cataga',
	    '5' => 'Serjohn Yapchiongco',
	    '6' => 'Kristiansen Del Castillo',
	    '7' => 'Mark Bandilla',
	    '8' => 'Jen Bandilla'
	  );

	// check required fields
	if (! (isset($_POST['start-date'], $_POST['end-date']) && strlen($_POST['start-date']) && strlen($_POST['end-date']))) {
		echo "All fields are required";
	} else {

		// Validate form for required fields
		if (! (isset($_POST['employee']) && array_key_exists($_POST['employee'], $employees) )) {
			echo "Must Select a valid employee";
		}

		// parsing start_date and end-date format
		$valid_date = date_parse_from_format("Y.j.n", $start_date);
		$valid_date1 = date_parse_from_format("Y.j.n", $end_date);
		
		// check if date is valid
		if (! checkdate(
			$valid_date['month'] && $valid_date1['month'], 
			$valid_date['day'] && $valid_date1['day'], 
			$valid_date['year'] && $valid_date1['year'] )) {
			echo "Invalid Date!";
		}
	

	}

	



 ?>