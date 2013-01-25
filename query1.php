<?php require_once 'includes/session.php' ?>
<?php require_once 'includes/functions.php' ?>
<?php confirm_logged_in(); ?>

<?php 

  // Generating the dropdown-menu
  $employees = array(
      '2' => 'Jeffrey Dino',
      '3' => 'Enrique Joaquin',
      '4' => 'Allan Cataga',
      '5' => 'Serjohn Yapchiongco',
      '6' => 'Kristiansen Del Castillo',
      '7' => 'Mark Bandilla',
      '8' => 'Jen Bandilla'
    );

  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Just display the form if the request is a GET
    display_form(array());
  } else {
    // The request is a POST, validate form
    $errors = validate_query_form();
    if (count($errors)) {
      // If there were errors redisplay the form with the errors
      display_form($errors);
    } else {
      // The form data was valid, redirect
      print 'The form is submitted!';
    }
  }

 ?>


<?php include 'includes/header.php'; ?>
    <header>
      <div class="container">
        <h1 class="left">Simple DTR App</h1>

        <div class="welcome-message right">
          <p>Welcome <?php echo ucfirst($_SESSION['username']); ?></p>
          <a href="logout.php" class="btn btn-primary">Logout</a>
        </div>
      </div>
    </header>

    <div class="container both">
      <div class="row">
        <div class="span12">
          
        <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="post" class="form-horizontal employee-status">

          <!-- control group for employee name -->
          <div class="control-group">
            <label for="empName" class="control-label">Employee Name</label>
            <?php print_error('employee_name', $errors); ?>
            <div class="controls">
              <select name="employee">
                <option value="default">-- Select an employee --</option>
                <?php 
                  foreach ($employees as $key => $employee) {
                    echo "<option $defaults[$employees][$key][$employee]'>$employee</option>\n";
                  }
                 ?>
              </select>
            </div>
          </div>

          <!-- control group for start data -->
          <div class="control-group">
            <label for="startDate" class="control-label">Start Date</label>
            <?php print_error('required', $errors); ?>
            <?php print_error('date', $errors); ?>
            <div class="controls">
              <input type="text" class="datepicker" name="start-date" placeholder="Start Date" />
            </div>
          </div>

          <!-- control group for end data -->
          <div class="control-group">
            <label for="endDate" class="control-label">End Date</label>
            <?php print_error('required', $errors); ?>
            <?php print_error('date', $errors); ?>
            <div class="controls">
              <input type="text" class="datepicker" name="end-date" placeholder="End Date" />
            </div>
          </div>

          <!-- control group for submit -->
          <div class="control-group">
            <div class="controls">
              <input type="submit" value="Submit" name="submit" class="btn btn-primary" />
            </div>
          </div>


        </form>

        </div>
      </div>
    </div>

 <?php include_once('includes/footer.php'); ?>