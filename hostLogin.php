<?php require_once("session.php"); ?>
<?php
	require_once("included_functions.php");
  //require_once("session.php");
	new_header("Login", "");
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
if (isset($_POST["submithost"])) {
		if(isset($_POST["username"]) && $_POST["username"] !=="" && isset($_POST["password"]) && $_POST["password"] !== ""){
			$username = $_POST["username"];
			$password = $_POST["password"];

			$query = "SELECT * FROM ";
			$query .= "hostLogin WHERE ";
			$query .= "username = '".$username."' ";
			$query .= "LIMIT 1";
			$result = $mysqli->query($query);

			if($result && $result->num_rows > 0){
				$row = $result->fetch_assoc();
				if(password_check($password, $row["password"])){
					$_SESSION["username"]=$row["username"];
					redirect_to("viewHostProjects.php?id=".$row["host_num"]);
				}
				else{
					$_SESSION["message"]="Password not match";
					redirect_to("hostLogin.php");
        }
      }
      else{
        $_SESSION["message"]="Username/Password not found";
        redirect_to("registerHost.php");
      }
    }
    else{
      $_SESSION["message"]="Username/Password not found";
      redirect_to("hostLogin.php");
    }
  }



else{
    echo "<br />";
    echo "<center>";
    echo "<div class='tiles'>";
    echo "<label>";

        //echo "<div class='tile'>";
    		echo "<h3>Host Login!</h3>";

    		echo "<form action='hostLogin.php' method='post'>";
    			echo "<p>Username:<input type='text' name='username' value='' /></p>";
    			echo "<p>Password:<input type='password' name='password' value='' /></p>";
    			echo "<input type='submit' name='submithost' class='button tiny round' value='Host Login'>";
    		echo "</form>";
        //echo "</div>";

      echo "</label>";

    echo "</div>";
    echo "</center>";
}

?>

<?php  new_footer("Ole Miss Big Event", $mysqli); ?>
