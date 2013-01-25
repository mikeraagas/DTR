
<?php require_once 'includes/session.php' ?>
<?php require_once 'includes/connection.php' ?>

<?php 

  if (logged_in()) {
    header("location: query.php");
  }

  if (isset($_POST['submit'])) {
  
    if (!strlen($_POST['username']) || !strlen($_POST['password'])) {
      $message = "<strong>Login Failed!</strong> both fields are required";
    } else {

      // clean data to prevent SQL injection
      $username = trim(mysql_real_escape_string($_POST['username']));
      $password = trim(mysql_real_escape_string($_POST['password']));

          
      // check database to see if username and password exist
      $query = "SELECT id, username 
          FROM admin 
          WHERE username='$username' 
          AND password='$password' LIMIT 1";
      $result = mysql_query($query);
      if (mysql_num_rows($result) == 1) {
        // username and password authenticated 
        // and only 1 match
        $found_user = mysql_fetch_array($result);
        $_SESSION['user_id'] = $found_user['id'];
        $_SESSION['username'] = $found_user['username'];

        header("location: query.php");
      } else {
        $message = "<strong>Login Failed!</strong> username and password did not match!";
      }

    }

  } else { //form was not been submitted
    if (isset($_GET['logout']) && $_GET['logout'] == 1) {
      $message = "You are now logged out!";
    }


    $username = "";
    $password = "";
  }

 ?>


<?php include_once('includes/header.php'); ?>
  <header>
    <div class="container">
      <h1>Simple DTR App</h1>
    </div>
  </header>

  <div class="container">

        <form action="index.php" method="post" class="form-signin">
          <h3 class="form-signin-heading">Sign in as Admin</h3>
          <?php 
            if (!empty($message)) {
                $alert_message = "<div id='errorMessage' class='alert alert-success hide alert-error' data-alert='alert' style='top:0'><br>";
                $alert_message .= "<a class='close' data-dismiss='alert' href='#'>x</a>";
                $alert_message .= "<p>". $message ."</p>";
                $alert_message .= "</div>";

                echo $alert_message;
              }
           ?>
          <input type="text" name="username" class="input-block-level" placeholder="Username">
          <input type="password" name="password" class="input-block-level" placeholder="Password">
          
          <button class="btn btn-large btn-primary" name="submit" type="submit">Sign in</button>
        </form>
    
  </div>

<?php include_once('includes/footer.php'); ?>

