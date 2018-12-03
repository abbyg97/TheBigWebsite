
<?php require_once("session.php"); ?>
<?php
	require_once("included_functions.php");
	//sets header -- function in included_functions
	new_header("Update password");
	//function in included_functions
	$mysqli = db_connection();

	//makes sure connected to the database
	if (($output = message()) !== null) {
		echo $output;
	}

if (isset($_POST["submit"])) {
  if (isset($_POST["username"]) && $_POST["username"] !== "" && isset($_POST["password"]) &&
      $_POST["password"] !== "") {
      //Grab posted values for username and password. Immediately encrypt the password so that
      // it is set up to compare with the encrypted password in the database Use password_encrypt
      $username = $_POST["username"];
      $password = password_encrypt($_POST["password"]);
      //Check to make sure user does not already exist
      $query = "SELECT * FROM ";
      $query .= "hostLogin WHERE ";
      $query .= "username = '".$username."' ";
      $query .= "LIMIT 1";
      $result = $mysqli->query($query);
      //User exists so output that the user already exists
      if ($result && $result->num_rows > 0) {
        $query = "UPDATE hostLogin set password = ".$password;
        redirect_to("hostLogin.php");
      }
      //User does not already exist so add to admins table
      else {
          $_SESSION["message"] = "Username does not exist";
          redirect_to("forgot.php");
      }
  }
}

else{
  echo "<div style='width: 65%; padding-left: 35%;'>";
	echo "<center>";
	echo "<h3>Change Password</h3>";
	echo "</center>";
	echo "<div style='text-align: left;'>";

  echo "<form action='forgot.php' method='post'>";
    echo "<p>Current Username:<input type='text' name='username' value='' /></p>";
    echo "<p>New Password:<input type='password' name='password' value='' /></p>";
    echo "<input type='submit' name='submit' class='button tiny round' value='Change Password'>";
  echo "</form>";
  echo "</div>";
}
