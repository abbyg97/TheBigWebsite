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

if (isset($_POST["submitadmin"])) {
  if(isset($_POST["username"]) && $_POST["username"] !=="" && isset($_POST["password"]) && $_POST["password"] !== ""){
    $username = $_POST["username"];
    $password = $_POST["password"];

    $query = "SELECT * FROM ";
    $query .= "execLogin WHERE ";
    $query .= "username = '".$username."' ";
    $query .= "LIMIT 1";
    $result = $mysqli->query($query);

    if($result && $result->num_rows > 0){
      $row = $result->fetch_assoc();
      if(password_check($password, $row["password"])){
        $_SESSION["username"]=$row["username"];
        redirect_to("execProjectView.php");
      }
      else{
        $_SESSION["message"]="Incorrect password";
        redirect_to("execLogin.php");
      }
    }
    else{
      $_SESSION["message"]="Username/Password not found";
      redirect_to("execLogin.php");
    }
  }
  else{
    $_SESSION["message"]="Please fill out all fields";
    redirect_to("execLogin.php");
  }
}


else{
  echo "<br />";
  echo "<center>";
    echo "<div class='tiles'>";
    echo "<label>";

    		echo "<h3>Executive Login!</h3>";

    		echo "<form action='execLogin.php' method='post'>";
    			echo "<p>Username:<input type='text' name='username' value='' /></p>";
    			echo "<p>Password:<input type='password' name='password' value='' /></p>";
    			echo "<input type='submit' name='submitadmin' class='button tiny round' value='Exec Login'>";
    		echo "</form>";

    echo "</label>";
    echo "</div>";
  echo "</center>";
}

?>

<?php  new_footer("Ole Miss Big Event", $mysqli); ?>
