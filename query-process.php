<?php require_once 'includes/session.php' ?>
<?php require_once 'includes/connection.php' ?>
<?php require_once 'includes/functions.php' ?>
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
      
            // check for valid employee name 
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

                $row = mysql_num_rows($result); // total number of rows
                // global $row;

                if ($row == 0) {
                  $message = "No rows returned";
                } else {



                  /**
                   * Pagination
                   **/


                  // number of rows per page
                  $rowsperpage = 10; 
                  // find out total pages
                  $totalpages = ceil($row / $rowsperpage);

                  // get the current page or set a default
                  if (isset($_GET['currentpage']) && is_numeric($_GET['currentpage']) ) {
                    // cast var as int
                    $currentpage = (int) $_GET['currentpage'];
                   } else {
                    // default page num
                    $currentpage = 1;
                   }

                   // if current page is greater than total pages
                   if ($currentpage > $totalpages) {
                     // set current page to last page
                    $currentpage = $totalpages;
                   }

                   // if current page is less than first page
                   if ($currentpage < 1) {
                     // set current page to first page
                    $currentpage = 1;
                   }

                   // the offset of the list, based on the current page
                   $offset = ($currentpage - 1) * $rowsperpage;

                   // get the info from the db
                   $sql = "SELECT user_id, late, total_hours_work, date FROM bio_dtr
                        WHERE user_id= '" . $employee . "' AND (date BETWEEN '" . $start_date . "' AND '" . $end_date . "')
                        LIMIT $offset, $rowsperpage";
                   $result = mysql_query($sql) or trigger_error("SQL", E_USER_ERROR);

                   // succes fetching rows
                  $table = "<table class='table table-striped table-bordered'>";
                  $table .= "<tr>
                          <th>User id</th>
                          <th>Late</th>
                          <th>Total Hours of work</th>
                          <th>Date</th>
                        </tr>";
                        
                  // Fetch row until the last one
                  while ($rows = mysql_fetch_assoc($result)) {
                    // Print out the contents of each row into a table
                    $table .= "<tr><td>";
                    $table .= $rows['user_id'];
                    $table .= "</td><td>";
                    $table .= $rows['late'];
                    $table .= "</td><td>";
                    $table .= $rows['total_hours_work'];
                    $table .= "</td><td>";
                    $table .= $rows['date'];
                    $table .= "</td></tr>";
                  }
                  $table .= "</table>";

                  /******  build the pagination links  *****/
                  // range of num links to show
                  $range = 5;

                  $paginate = "<div class='pagination pagination-right'>";
                  $paginate .= "<ul>";
                    // if not on page 1, dont show back links
                    if ($currentpage > 1) {
                      // show << link to go back to page 1
                      $paginate .= "<li><a href='{$_SERVER[PHP_SELF]}?currentpage=1'><<<</a></li>";
                      // get previous page number
                      $prevpage = $currentpage - 1;
                      // show link to go back to 1 page
                      $paginate .= "<li><a href='{$_SERVER[PHP_SELF]}?currentpage=$prevpage'><</a></li>";
                    }

                    // loop to show links to range of pages around current page
                    for ($x=($currentpage - $range); $x < (($currentpage + $range) + 1); $x++) { 
                      // if it's a valid page number
                      if (($x > 0) && ($x <= $totalpages)) {
                        // if we're on current page
                        if ($x == $currentpage) {
                          // 'highlight' it but don't make a link
                          $paginate .= " <li><a href='#' class='disable active'><b>$x</b></a></li>";
                        // if not current page
                        } else {
                          // make it a link
                          $paginate .= " <li><a href='{$_SERVER['PHP_SELF']}?currentpage=$x'>$x</a></li>";
                        } // end else
                      } // end if
                    } // end for


                    // if not on last page, show forward and last page links
                    if ($currentpage != $totalpages) {
                      // get next page
                      $nextpage = $currentpage + 1;
                      // $paginate .= forward link for next page
                      $paginate .= " <li><a href='{$_SERVER['PHP_SELF']}?currentpage=$nextpage'>></a></li> ";
                      // $paginate .= forward link for lastpage
                      $paginate .= " <li><a href='{$_SERVER['PHP_SELF']}?currentpage=$totalpages'>>></a></li> ";
                    } // end if

                   $paginate .= "</ul>"; 
                   $paginate .= "</div>";
      
                  /****** end build pagination links ****/
      
                }
              }
            }
          }
       ?>

    <div class="container">
      <div class="row">
        <div class="span8">
          <?php 
            if ((isset($table) && $paginate)) {
              echo $table;
              echo $paginate;
            }
           ?>
        </div> <!-- end of span9 -->
        <div class="span4">
      <?php 

        $employee = $_POST['employee'];
        $start_date = $_POST['start-date'];
        $end_date = $_POST['end-date'];

        $query = "SELECT *  FROM bio_dtr 
            WHERE user_id= '" . $employee . "' 
            AND (date BETWEEN '" . $start_date . "' AND '" . $end_date . "')";
        $result = mysql_query($query);
        if (!$result) {
          die('Mysql query failed! ' . mysql_error());
        }

        $row = mysql_num_rows($result);

        if ($row >= 1) {
          echo "<h3>DTR Report of " . get_employee_name(isset($_POST['employee'])) . "</h3>";


          
          $sum_query = "SELECT SUM(total_hours_work), SUM(late) FROM bio_dtr
              WHERE user_id= '" . $employee . "' 
              AND (date BETWEEN '" . $start_date . "' AND '" . $end_date . "')";
          $sum_result = mysql_query($sum_query);
          $sum_row = mysql_fetch_array($sum_result);

          echo "<p>total hours of work: " . $sum_row[0] . "</p>";
          echo "<p>total hours of late: " . $sum_row[1] ."</p>";

        } else {
          echo "";
        }

       ?>

       
        <?php 

          // Display evaluation of fetched values

         ?>

     </div>
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