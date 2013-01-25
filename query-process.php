<?php require_once 'includes/session.php' ?>
<?php require_once 'includes/connection.php' ?>
<?php confirm_logged_in(); ?>


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



 ?>