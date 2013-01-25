<?php 

	function validate_query_form() {
		global $employees;

		// Start with no errors
		$errors = array();

		// check required fields
		if (! (isset($_POST['start-date'], $_POST['end-date']) && strlen($_POST['start-date']) && strlen($_POST['end-date']))) {
			$errors['required'] = "Required Field!";
		} else {

			// Validate form for required fields
			if (! (isset($_POST['employee']) && array_key_exists($_POST['employee'], $employees) )) {
				$errors['employee_name'] = "Must be a valid Employee Name";
			}

			// parsing start_date and end-date format
			$valid_date = date_parse_from_format("Y.j.n", $start_date);
			$valid_date1 = date_parse_from_format("Y.j.n", $end_date);
			
			// check if date is valid
			if (! checkdate(
				$valid_date['month'] && $valid_date1['month'], 
				$valid_date['day'] && $valid_date1['day'], 
				$valid_date['year'] && $valid_date1['year'] )) {
				$errors['date'] = "Invalid Date";
			}

			return $errors;
		}
	}

	function display_form($errors) {
		global $employees;

		// Set up defaults
		$defaults['start-date'] = isset($_POST['start-date']) ? htmlentities($_POST['start-date']) : '';
		$defaults['end-date'] = isset($_POST['end-date']) ? htmlentities($_POST['end-date']) : '';
		foreach ($employees as $key => $employee) {
			if (isset($_POST['employee']) && ($_POST['employee']) == $employees) {
				$defaults['employees'][$key][$employee] = "selected='selected'";
			} else {
				$defaults['employees'][$key][$employee] = '';
			}
		}
	}

	// helper function to generate error message
	function print_error($key, $errors) {
		if (isset($errors[$key])) {
			print "<p class='error'>{$errors[$key]}</p>";
		}
	}

 ?>