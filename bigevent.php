<?php require_once("session.php"); ?>
<?php
	require_once("included_functions.php");
  //require_once("session.php");
	new_header("Volunteer Login", "");
	$mysqli = db_connection();
	if (($output = message()) !== null) {
	 	echo $output;
	 }

?>
<?php

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//     Step 7.  Check username and password.  If all is good then set $_SESSION and log in
//				NOTE:  some of your code may be taken from addLogin.php step for, but you
//					   will need to be sure and set the $_SESSION variables
if (isset($_POST["submitvol"])) {
  //Libby bigevent2018
		if(isset($_POST["username"]) && $_POST["username"] !=="" && isset($_POST["password"]) && $_POST["password"] !== ""){
      $username = $_POST["username"];
			$password = $_POST["password"];

			$query = "SELECT * FROM ";
			$query .= "volLogin WHERE ";
			$query .= "username = '".$username."' ";
			$query .= "LIMIT 1";
			$result = $mysqli->query($query);

			if($result && $result->num_rows > 0){
				$row = $result->fetch_assoc();

				if(password_check($password, $row["password"])){
					$_SESSION["username"]=$username;
					redirect_to("edit.php?vol_number=".$row["vol_number"]);
				}

				else{
					$_SESSION["message"]="Password not correct";
					redirect_to("bigevent.php");
        }
      }
    else{
      $_SESSION["message"]="Username/Password not found";
      redirect_to("register.php");
    }
  }
  else{
    $_SESSION["message"]="Username/Password not found";
    redirect_to("bigevent.php");
  }
}

else{
  echo "<br />";
  echo "<center>";
    echo "<div class='tiles'>";
    echo "<label>";
        //echo "<div class='tile'>";
    		echo "<h3>Volunteer Login!</h3>";

    		echo "<form action='bigevent.php' method='post'>";
    			echo "<p>Username:<input type='text' name='username' value='' /></p>";
    			echo "<p>Password:<input type='password' name='password' value='' /></p>";
    			echo "<input type='submit' name='submitvol' class='button tiny round' value='Volunteer Login'>";
    		echo "</form>";
        echo "</div>";

      echo "</label>";

    //echo "</div>";
    echo "</label>";
  echo "</div>";
  echo "</center>";
}

?>

<?php  new_footer("Ole Miss Big Event", $mysqli); ?>
