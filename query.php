<?php require_once 'includes/session.php' ?>
<?php require_once 'includes/connection.php' ?>
<?php confirm_logged_in(); ?>

<?php 

  if (isset($_POST['submit'])) {

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
      $message = "All fields are required";
    } else {

      // Validate form for required fields
      if (! (isset($_POST['employee']) && array_key_exists($_POST['employee'], $employees) )) {
        $message = "Must Select a valid employee";
      } else {


          $employee = $_POST['employee'];
          $start_date = $_POST['start-date'];
          $end_date = $_POST['end-date'];


        // parsing start_date and end-date format
        $valid_date = date_parse_from_format("Y.j.n", $start_date);
        $valid_date1 = date_parse_from_format("Y.j.n", $end_date);
        
        // check if date is valid
        if (! checkdate(
          $valid_date['month'] && $valid_date1['month'], 
          $valid_date['day'] && $valid_date1['day'], 
          $valid_date['year'] && $valid_date1['year'] )) {
          $message = "Invalid Date!";


        } else {

          $query = "SELECT user_id, late, total_hours_work, date  FROM bio_dtr 
              WHERE user_id='$employee' AND date BETWEEN '" . $start_date . "' AND '" . $end_date . "' 
              ORDER BY  date DESC";
          $result = mysql_query($query);
          if (!$result) {
            die('Mysql query failed! ' . mysql_error());
          }

          echo "<table border='1'>";
          echo "<tr><th>User Id</th> <th>Late</th> <th>Total Hours of work</th> <th>Date</th></tr>";
          // Fetch row until the last one
          while ($rows = mysql_fetch_array($result)) {
            // Print out the contents of each row into a table
            echo "<tr><td>";
            echo $rows['user_id'];
            echo "</td><td>";
            echo $rows['late'];
            echo "</td><td>";
            echo $rows['total_hours_work'];
            echo "</td><td>";
            echo $rows['date'];
            echo "</td></tr>";
          }
          echo "</table>";


          // $message = "query submitted!";
        }

      }
    }
  } else {
    $_POST['employee'] = "";
    $_POST['start-date'] = "";
    $_POST['end-date'] = "";
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

          <?php 
            if (!empty($message)) {
                $alert_message = "<div id='errorMessage' class='alert alert-success hide alert-error error-message' data-alert='alert' style='top:0'><br>";
                $alert_message .= "<a class='close' data-dismiss='alert' href='#'>x</a>";
                $alert_message .= "<p>". $message ."</p>";
                $alert_message .= "</div>";

                echo $alert_message;
              }
           ?>
          
        <form action="query.php" method="post" class="form-horizontal employee-status">

          <!-- control group for employee name -->
          <div class="control-group">
            <label for="empName" class="control-label">Employee Name</label>
            <div class="controls">
              <?php 

                // Generating the menu
                $employees = array(
                    '2' => 'Jeffrey Dino',
                    '3' => 'Enrique Joaquin',
                    '4' => 'Allan Cataga',
                    '5' => 'Serjohn Yapchiongco',
                    '6' => 'Kristiansen Del Castillo',
                    '7' => 'Mark Bandilla',
                    '8' => 'Jen Bandilla'
                  );

                echo "<select name='employee'>\n";
                echo "<option selected value='default'>-- Select an employee --</option>\n";
                foreach ($employees as $key => $employee) {
                  echo "<option value='$key'>$employee</option>\n";
                }
                echo "</select>"

               ?>
            </div>
          </div>

          <!-- control group for start data -->
          <div class="control-group">
            <label for="startDate" class="control-label">Start Date</label>
            <div class="controls">
              <input type="text" class="datepicker" name="start-date" value="<?php echo $_POST['start-date']; ?>"  placeholder="Start Date" />
            </div>
          </div>

          <!-- control group for end data -->
          <div class="control-group">
            <label for="endDate" class="control-label">End Date</label>
            <div class="controls">
              <input type="text" class="datepicker" name="end-date" value="<?php echo $_POST['end-date']; ?>"  placeholder="End Date" />
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