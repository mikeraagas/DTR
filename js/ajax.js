
$(document).ready(function()) {
	// if submit button is clicked
	$('#submit').click(function()) {

		// Get data from all the fields 
		var employee = $('input[name=employee]')
		var start_date = $('input[name=start-date]');
		var end_date = $('input[name=end-date]');

		// Simple validation to make sure user entered something
		// If error found, add highlighting class to the text field
		if (employee.val() == '') {
			employee.addClass('higlight');
			return false;
		} else name.removeClass('highlight');

		if (start_date.val() == '') {
			start_date.
		}

	}
}