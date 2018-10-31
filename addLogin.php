
<?php require_once("session.php"); ?>
<?php
	require_once("final_functions.php");
	// verify_login();
	//new_header("Organization President - Add Login", "/addOrgLogin.php");
	$mysqli = db_connection();

	if (($output = message()) !== null) {
		echo $output;
	}

///////////////////////////////////////////////////////////////////////////////////////////////
//  Step 4.  Check to see if username and password text boxes are filled in.
//           If they are, then first check to see if the username already exists
//           If the user name does not exist, then add the username and their hashed password
//               to the admins table in your database

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
					$query .= "VALUES ('".$username."', '".$password."', 4, 2)";
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


	if (isset($_POST["submitvol"])) {
		if (isset($_POST["username"]) && $_POST["username"] !== "" && isset($_POST["password"]) &&
				$_POST["password"] !== "") {
				//Grab posted values for username and password. Immediately encrypt the password so that
				// it is set up to compare with the encrypted password in the database Use password_encrypt
				$username = $_POST["username"];
				$password = password_encrypt($_POST["password"]);
				//Check to make sure user does not already exist
				$query = "SELECT * FROM ";
				$query .= "volLogin WHERE ";
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
					$query = "INSERT INTO volLogin ";
					$query .= "(username, password, permissions, vol_number) ";
					$query .= "VALUES ('".$username."', '".$password."', 2, (Select vol_number from volunteers where first_name = '".$username."'))";
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

	if (isset($_POST["submithost"])) {
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
					$_SESSION["message"] = "The username already exists";
					redirect_to("addLogin.php");
				}
				//User does not already exist so add to admins table
				else {
					$query = "INSERT INTO hostLogin ";
					$query .= "(username, password, permissions, host_num) ";
					$query .= "VALUES ('".$username."', '".$password."', 3, (Select host_number from Host where first_name = '".$username."'))";
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
?>

		<div class='row'>
		<label for='left-label' class='left inline'>

		<h3>Add an Organization President</h3>

<!--//////////////////////////////////////////////////////////////////////////////////////////////// -->
<!--    Step 2. Create a form with textboxes for adding both a username and password -->
			<form action="addLogin.php" method="post">
				<p>Username:<input type="text" name="username" value="" /></p>
				<p>Password:<input type="password" name="password" value="" /></p>
				<input type="submit" name="submitorg" class="button tiny round" value="Add President">
			</form>

<!--///////////////////////////////////////////////////////////////////////////////////////////////// -->

<h3>Add a Volunteer Login</h3>

<!--//////////////////////////////////////////////////////////////////////////////////////////////// -->
<!--    Step 2. Create a form with textboxes for adding both a username and password -->
	<form action="addLogin.php" method="post">
		<p>Username:<input type="text" name="username" value="" /></p>
		<p>Password:<input type="password" name="password" value="" /></p>
		<input type="submit" name="submitvol" class="button tiny round" value="Add Volunteer">
	</form>

<!--//////////////////////////////////////////////////////////////////////////////////////////////// -->

<h3>Add a Host Login</h3>

<!--//////////////////////////////////////////////////////////////////////////////////////////////// -->
<!--    Step 2. Create a form with textboxes for adding both a username and password -->
	<form action="addLogin.php" method="post">
		<p>Username:<input type="text" name="username" value="" /></p>
		<p>Password:<input type="password" name="password" value="" /></p>
		<input type="submit" name="submithost" class="button tiny round" value="Add Host">
	</form>


	<h3>Add a Administrator Login</h3>

	<!--//////////////////////////////////////////////////////////////////////////////////////////////// -->
	<!--    Step 2. Create a form with textboxes for adding both a username and password -->
		<form action="addLogin.php" method="post">
			<p>Username:<input type="text" name="username" value="" /></p>
			<p>Password:<input type="password" name="password" value="" /></p>
			<input type="submit" name="submitexec" class="button tiny round" value="Add Admin">
		</form>

  	  <?php echo "<br /><p>&laquo:<a href='index.php'>Back to Main Page</a>"; ?>

	</div>
	</label>

<?php  new_footer("Administrators", $mysqli); ?>
