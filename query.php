<?php require_once 'includes/session.php' ?>
<?php confirm_logged_in(); ?>


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
          
        <form action="query-process.php" method="post" class="form-horizontal employee-status">

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
              <input type="text" id="start_date" class="datepicker" name="start-date"  placeholder="Start Date" />
            </div>
          </div>

          <!-- control group for end data -->
          <div class="control-group">
            <label for="endDate" class="control-label">End Date</label>
            <div class="controls">
              <input type="text" id="end_date" class="datepicker" name="end-date"  placeholder="End Date" />
            </div>
          </div>

          <!-- control group for submit -->
          <div class="control-group">
            <div class="controls">
              <input type="submit" value="Submit" name="submit" class="btn btn-primary" id="submit_btn" />
            </div>
          </div>


        </form>

        </div>
      </div>
    </div>

 <?php include_once('includes/footer.php'); ?>