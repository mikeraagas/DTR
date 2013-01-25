<?php require_once 'includes/session.php' ?>
<?php require_once 'includes/connection.php' ?>
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

<div class="container">
  <div class="row">
    <div class="span9">

      <?php 
      
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
      
                $query = "SELECT *  FROM bio_dtr 
                    WHERE user_id= '" . $employee . "' 
                    AND (date BETWEEN '" . $start_date . "' AND '" . $end_date . "')";
                $result = mysql_query($query);
                if (!$result) {
                  die('Mysql query failed! ' . mysql_error());
                }
                if (mysql_num_rows($result) == 0) {
                  $message = "No rows returned";
                } else {
      
                  echo "<table class='table table-striped table-bordered'>";
                  echo "<tr>
                          <th>User id</th>
                          <th>Late</th>
                          <th>Total Hours of work</th>
                          <th>Date</th>
                        </tr>";
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
      
                }
      
                // echo "query submitted!";
              }
      
            }
          }
       ?>

     </div> <!-- end of span9 -->
     <div class="span3"></div>
  </div> <!-- end of row -->
 </div> <!-- end of container -->

 <div class="container">
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
     </div>
   </div>
 </div>

<?php include_once('includes/footer.php'); ?>