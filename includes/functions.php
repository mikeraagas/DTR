<?php 

	function get_employee_name($employee_name) {
		switch ($employee_name) {
			case 2:
				$name = "Jeffrey Dino";
				break;
			case 3:
				$name = "Enrique Joaquin";
				break;
			case 4:
				$name = "Allan Cataga";
				break;
			case 5:
				$name = "Serjohn Yapchiongco";
				break;
			case 6:
				$name = "Kristiansen Del Castillo";
				break;
			case 7:
				$name = "Mark Bandilla";
				break;
			case 8:
				$name = "Jen Bandilla";
				break;
		}
		return $name;
	}

	function day_to_time($date) {
		$timestamp = strtotime($date);

		$day = date('l', $timestamp);
		return $day;
	}

	function seperate_time($in_out) {
		$timestamp = strtotime($in_out);

		// $date = date('n.j.Y', $timestamp);
		$time = date('H:i:s', $timestamp);

		return $time;
	}

 ?>