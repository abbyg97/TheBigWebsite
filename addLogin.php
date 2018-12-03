
<?php require_once("session.php"); ?>
<?php
	require_once("included_functions.php");
	//function in session.php to make sur ethe user is logged in
	verify_login();
	//sets header -- function in included_functions
	new_header("Add Login");
	//function in included_functions
	$mysqli = db_connection();

	//makes sure connected to the database
	if (($output = message()) !== null) {
		echo $output;
	}

	//if you are trying to add an organization president login loop through here
	if (isset($_POST["submitorg"])) {
		if (isset($_POST["username"]) && $_POST["username"] !== "" && isset($_POST["password"]) &&
				$_POST["password"] !== "") {
				//Grab posted values for username and password. Immediately encrypt the password so that
				// it is set up to compare with the encrypted password in the database Use password_encrypt
				$username = $_POST["username"];
				$password = password_encrypt($_POST["password"]);
				//Check to make sure user does not already exist
				$query = "SELECT * FROM ";
				$query .= "orgLogin WHERE ";
				$query .= "username = '".$username."' ";
				$query .= "LIMIT 1";
				$result = $mysqli->query($query);
				//User exists so output that the user already exists
				if ($result && $result->num_rows > 0) {
					$_SESSION["message"] = "The username already exists";
					redirect_to("addLogin.php");
				}
				//User does not already exist so add to admins table
				else {
					$query = "INSERT INTO orgLogin ";
					$query .= "(username, password, permissions, org) ";
					$query .= "VALUES ('".$username."', '".$password."', 1, (Select number from Organization WHERE name = '".$_POST["org"]."'))";
					$result = $mysqli->query($query);
					if ($result) {
						$_SESSION["message"] = "User successfully added";
						//return to home page
						redirect_to("index.php");
					}
					else {
						$_SESSION["message"] = "Could not add user!";
						redirect_to("addLogin.php");
				}
			}
		}
	}

	//if you are trying to add an organization president login loop through here
	// if (isset($_POST["submitvol"])) {
	// 	if (isset($_POST["username"]) && $_POST["username"] !== "" && isset($_POST["password"]) &&
	// 			$_POST["password"] !== "") {
	// 			//Grab posted values for username and password. Immediately encrypt the password so that
	// 			// it is set up to compare with the encrypted password in the database Use password_encrypt
	// 			$username = $_POST["username"];
	// 			$password = password_encrypt($_POST["password"]);
	// 			//Check to make sure user does not already exist
	// 			$query = "SELECT * FROM ";
	// 			$query .= "volLogin WHERE ";
	// 			$query .= "username = '".$username."' ";
	// 			$query .= "LIMIT 1";
	// 			$result = $mysqli->query($query);
	// 			//User exists so output that the user already exists
	// 			if ($result && $result->num_rows > 0) {
	// 				$_SESSION["message"] = "The username already exists";
	// 				redirect_to("addLogin.php");
	// 			}
	// 			//User does not already exist so add to admins table
	// 			else {
	// 				$query = "INSERT INTO volLogin ";
	// 				$query .= "(username, password, permissions, vol_number) ";
	// 				$query .= "VALUES ('".$username."', '".$password."', 2, (Select vol_number from volunteers where webID = '".$username."'))";
	// 				$result = $mysqli->query($query);
	// 				if ($result) {
	// 					$_SESSION["message"] = "User successfully added";
	// 					redirect_to("index.php");
	// 				}
	// 				else {
	// 					$_SESSION["message"] = "Could not add user!";
	// 					redirect_to("addLogin.php");
	// 			}
	// 		}
	// 	}
	// }

	//if you are trying to add an host login loop through here
	// if (isset($_POST["submithost"])) {
	// 	if (isset($_POST["username"]) && $_POST["username"] !== "" && isset($_POST["password"]) &&
	// 			$_POST["password"] !== "") {
	// 			//Grab posted values for username and password. Immediately encrypt the password so that
	// 			// it is set up to compare with the encrypted password in the database Use password_encrypt
	// 			$username = $_POST["username"];
	// 			$password = password_encrypt($_POST["password"]);
	// 			//Check to make sure user does not already exist
	// 			$query = "SELECT * FROM ";
	// 			$query .= "hostLogin WHERE ";
	// 			$query .= "username = '".$username."' ";
	// 			$query .= "LIMIT 1";
	// 			$result = $mysqli->query($query);
	// 			//User exists so output that the user already exists
	// 			if ($result && $result->num_rows > 0) {
	// 				$_SESSION["message"] = "The username already exists";
	// 				redirect_to("addLogin.php");
	// 			}
	// 			//User does not already exist so add to admins table
	// 			else {
	// 				$query = "INSERT INTO hostLogin ";
	// 				$query .= "(username, password, permissions, host_num) ";
	// 				//last value queried to grab host number
	// 				$query .= "VALUES ('".$username."', '".$password."', 3, (Select host_number from Host where first_name = '".$username."'))";
	// 				$result = $mysqli->query($query);
	// 				if ($result) {
	// 					$_SESSION["message"] = "User successfully added";
	// 					//return to home page
	// 					redirect_to("index.php");
	// 				}
	// 				else {
	// 					$_SESSION["message"] = "Could not add user!";
	// 					redirect_to("addLogin.php");
	// 			}
	// 		}
	// 	}
	// }

	//if you are trying to add an exec login loop through here
	if (isset($_POST["submitexec"])) {
		if (isset($_POST["username"]) && $_POST["username"] !== "" && isset($_POST["password"]) &&
				$_POST["password"] !== "") {
				//Grab posted values for username and password. Immediately encrypt the password so that
				// it is set up to compare with the encrypted password in the database Use password_encrypt
				$username = $_POST["username"];
				$password = password_encrypt($_POST["password"]);
				//Check to make sure user does not already exist
				$query = "SELECT * FROM ";
				$query .= "execLogin WHERE ";
				$query .= "username = '".$username."' ";
				$query .= "LIMIT 1";
				$result = $mysqli->query($query);
				//User exists so output that the user already exists
				if ($result && $result->num_rows > 0) {
					$_SESSION["message"] = "The username already exists";
					redirect_to("addLogin.php");
				}
				//User does not already exist so add to admins table
				else {
					$query = "INSERT INTO execLogin ";
					$query .= "(username, password, permissions) ";
					$query .= "VALUES ('".$username."', '".$password."', 4)";
					$result = $mysqli->query($query);
					if ($result) {
						$_SESSION["message"] = "User successfully added";
						redirect_to("index.php");
					}
					else {
						$_SESSION["message"] = "Could not add user!";
						redirect_to("addLogin.php");
				}
			}
		}
	}

////////////////////////////////////////////////////////////////////////////////////////////////

//div login and div tiles make it so the logins are next to each other
echo "<div class='tiles'>";
	echo "<label class = 'logins'>";
		echo "<div class='tile'>";
		echo "<h3>Add Organization Login!</h3>";

		echo "<form action='addLogin.php' method='post'>";
			echo "<p>Username:<input type='text' name='username' value='' /></p>";
			echo "<p>Password:<input type='password' name='password' value='' /></p>";
			echo "Select your organization:<select name='org'>";
				// options for organizations to select gathered from the database
					$query = "Select name from Organization";
					$result = $mysqli->query($query);
					if($result && $result->num_rows >= 1){
						while($row=$result->fetch_assoc()){
							echo "<option value = '".$row['name']."'>".$row['name']."</option>";
						}
					}
			echo "</select>";
			echo "<input type='submit' name='submitorg' class='button tiny round' value='Organization Login'>";
		echo "</form>";
		echo "</div>";

		echo "<div class='tile'>";
		echo "<h3>Add Executive Login!</h3>";

		echo "<form action='addLogin.php' method='post'>";
			echo "<p>Username:<input type='text' name='username' value='' /></p>";
			echo "<p>Password:<input type='password' name='password' value='' /></p>";
			echo "<input type='submit' name='submitexec' class='button tiny round' value='Exec Login'>";
		echo "</form>";
		echo "</div>";

//echo "</div>";
echo "</label>";
?>

<?php
echo "<br /><p>&laquo:<a href='index.php'>Back to Main Page</a>";?>

<?php  new_footer("Administrators", $mysqli); ?>
