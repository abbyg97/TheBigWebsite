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

if (isset($_POST["submithost"])) {
		if(isset($_POST["username"]) && $_POST["username"] !=="" && isset($_POST["password"]) && $_POST["password"] !== ""){
			$username = $_POST["username"];
			$password = $_POST["password"];

			//check for login information
			$query = "SELECT * FROM ";
			$query .= "hostLogin WHERE ";
			$query .= "username = '".$username."' ";
			$query .= "LIMIT 1";
			$result = $mysqli->query($query);

			//if username exists
			if($result && $result->num_rows > 0){
				$row = $result->fetch_assoc();
				//check to see if password matches the stored hashed password
				if(password_check($password, $row["password"])){
					$_SESSION["username"]=$row["username"];
					$_SESSION["permission"]=$row["permissions"];
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
					echo "<br /><br /><a href='forgot.php'>Forgot Password?</a>";
    		echo "</form>";


        //echo "</div>";

      echo "</label>";

    echo "</div>";
    echo "</center>";
}

?>

<?php  new_footer("Ole Miss Big Event", $mysqli); ?>
