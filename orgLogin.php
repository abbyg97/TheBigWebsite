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

if (isset($_POST["submitorg"])) {
    if(isset($_POST["username"]) && $_POST["username"] !=="" && isset($_POST["password"]) && $_POST["password"] !== ""){
      $username = $_POST["username"];
      $password = $_POST["password"];

			//queries for login information
      $query = "SELECT * FROM ";
      $query .= "orgLogin WHERE ";
      $query .= "username = '".$username."' ";
      $query .= "LIMIT 1";
      $result = $mysqli->query($query);

      if($result && $result->num_rows > 0){
        $row = $result->fetch_assoc();
				//checks to see if password matches stored hashed one
        if(password_check($password, $row["password"])){
          $_SESSION["username"]=$row["username"];
					$_SESSION["permission"]=$row["permissions"];
          redirect_to("viewGroup.php?org=".$row['org']);
        }
        else{
          $_SESSION["message"]="Incorrect password";
          redirect_to("orgLogin.php");
        }
      }
      else{
        $_SESSION["message"]="Username/Password not found";
        redirect_to("orgLogin.php");
      }
    }
    else{
      $_SESSION["message"]="Please fill out all fields";
      redirect_to("orgLogin.php");
    }
  }

else{
  echo "<br />";
  echo "<center>";
    echo "<div class='tiles'>";
    echo "<label>";
        //echo "<div class='tile'>";
    		echo "<h3>Organization Login!</h3>";

    		echo "<form action='orgLogin.php' method='post'>";
    			echo "<p>Username:<input type='text' name='username' value='' /></p>";
    			echo "<p>Password:<input type='password' name='password' value='' /></p>";
    			echo "<input type='submit' name='submitorg' class='button tiny round' value='Organization Login'>";
    		echo "</form>";
        //echo "</div>";

    echo "</label>";
    echo "</div>";
  echo "</center>";

}

?>

<?php  new_footer("Ole Miss Big Event", $mysqli); ?>
