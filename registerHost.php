<?php
	require_once("./included_functions.php");
  require_once("session.php");
	new_header("Host Registration", "");
	//outputs message letting you know if it worked or not
	$mysqli = db_connection();
	if (($output = message()) !== null) {
		echo $output;
	}

	// try{
	// 	$mysqli = new PDO('mysql:host=localhost;dbname=agarrett', USERNAME, PASSWORD);
	// 	$mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	// }
	//
	// catch (PDOException $e){
	// 	echo "Error: ".$e->getMessage();
	// }

	//puts in headers on web page
	echo "<div style='width: 65%; padding-left: 35%;'>";
	echo "<center>";
	echo "<h3>Register to be a Host</h3>";
	echo "</center>";
	echo "<div style='text-align: left;'>";

	//condition to check if you submited something
  if (isset($_POST["submit"])) {
		//makes sure you filled in all boxes
		if( (isset($_POST["fname"]) && $_POST["fname"] !== "") && (isset($_POST["lname"]) && $_POST["lname"] !== "") && (isset($_POST["number"]) && $_POST["number"] !== "") &&(isset($_POST["sec_num"]) && $_POST["sec_num"] !== "") && (isset($_POST["email"]) && $_POST["email"] !== "") && (isset($_POST["alt_fname"]) && $_POST["alt_fname"] !== "") && (isset($_POST["alt_lname"]) && $_POST["alt_lname"] !== "") && (isset($_POST["alt_phone"]) && $_POST["alt_phone"] !== "") && (isset($_POST["alt_email"]) && $_POST["alt_email"] !== "")){

				//create query to insert the person into the database
				//(no project number assigned because that does not occur at registration)
				//https://stackoverflow.com/questions/6278296/extract-numbers-from-a-string -- for formatting phone number
				$query = "INSERT INTO Host ";
				$query .= "(first_name, last_name, phone, second_phone, email, alt_first_name, alt_last_name, alt_phone, alt_email) ";
				$query.="VALUES ( ";//?, ?, ";
        // $query.=$max2.", ";
				$query.="'".$_POST["fname"]."', ";
				$query.="'".$_POST["lname"]."', ";
        $query.="".preg_replace('/[^0-9]/', '', $_POST["number"]).", ";
				$query.="".preg_replace('/[^0-9]/', '', $_POST["sec_num"]).", ";
				$query.="'".$_POST["email"]."', ";
        $query.="'".$_POST["alt_fname"]."', ";
        $query.="'".$_POST["alt_lname"]."', ";
				//$query.="?, ?, ?, ";
				$query.="".preg_replace('/[^0-9]/', '', $_POST["alt_phone"]).", ";
				$query.="'".$_POST["alt_email"]."')";
				//$query.="?)";

				// $stmt = $mysqli->prepare($query);
				// $stmt -> execute([$_POST["fname"], $_POST["lname"], $_POST["email"], $_POST["alt_fname"], $_POST["alt_lname"], $_POST["alt_phone"]]);

				//execute query
				$result = $mysqli->query($query);
				//$row=$result->fetch_assoc();
				//checks if there is a result
		//if($result) {
			//if added to the database posts and redirects to volunteer table
			// $_SESSION["message"] = $_POST["fname"]." ".$_POST["lname"]." has been registered";
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
						$query2="Select max(host_number) as 'host_number' from Host";
						$result2 = $mysqli->query($query2);
						while($row2=$result2->fetch_assoc()){
							$number = $row2['host_number'];
						}
							$query2 = "insert into hostLogin ";
							$query2 .= "(username, password, permissions, host_num) ";
							//ended here
							$query2 .= "VALUES ('".$username."', '".$password."', 3, ".$number.")";  //".$number."
							$result2 = $mysqli->query($query2);
						//}
						if ($result2) {
							$_SESSION['username']=$username;
							redirect_to("registerProject.php?host=".$number); //
							exit;
						}
						else {
							$_SESSION["message"] = "Could not add user!";
							redirect_to("addLogin.php");
							exit;
					}
				}
			//}
			// else{
			// 	$_SESSION["message"] = "Enter username and password";
			// 	redirect_to("registerHost.php");
			// 	exit;
			// }
		}
			else {
				//if a problem occured with adding to the database
				$_SESSION["message"] = "Error! Could not register ".$_POST["fname"]." ".$_POST["lname"];
				redirect_to("viewHostProjects.php?id=".$max2);
				exit;
			}
	}
		else {
			//sets message to remind you to fill in all boxes if you forgot one and keeps ones you have already filled in
			$_SESSION["message"] = "Unable to add person. Fill in all information!";

			echo "<form method='POST' action='registerHost.php'>";

						echo "First Name:<input type='text' name='fname' value='".$_POST['fname']."' />";

						echo "Last Name:<input type='text' name='lname' value='".$_POST['lname']."' />";

						echo "Username:<input type='text' name='username' value='".$_POST['username']."' />";

						echo "Password:<input type='password' name='password' value='' />";

						echo "Phone Number:<input type='text' name='number' value='".$_POST['number']."' />";

						echo "Second Number:<input type='text' name='sec_num' value='".$_POST['sec_num']."' />";

						echo "Email:<input type='text' name='email' value='".$_POST['email']."' />";

            echo "Please enter alternate contact information  <br></br>";

            echo "First Name:<input type='text' name='alt_fname' value='".$_POST['alt_fname']."' />";

						echo "Last Name:<input type='text' name='alt_lname' value='".$_POST['alt_lname']."' />";

						echo "Phone Number:<input type='text' name='alt_phone' value='".$_POST['alt_phone']."' />";

						echo "Email:<input type='text' name='alt_email' value='".$_POST['alt_email']."' />";

					echo "<input type='submit' name='submit' class='button tiny round' value='Register'>";


    echo "</form>";
		//header("Location: registerHost.php");
			//exit;

		}
	}

	else {
		//creates form

			echo "<form method='POST' action='registerHost.php'>";

						echo "First Name:<input type='text' name='fname' value='' />";

						echo "Last Name:<input type='text' name='lname' value='' />";

						echo "Username:<input type='text' name='username' value='' />";

						echo "Password:<input type='password' name='password' value='' />";

						echo "Phone Number:<input type='text' name='number' value='' />";

						echo "Second Number:<input type='text' name='sec_num' value='' />";

						echo "Email:<input type='text' name='email' value='' />";

            echo "Please enter alternate contact information  <br></br>";

            echo "First Name:<input type='text' name='alt_fname' value='' />";

						echo "Last Name:<input type='text' name='alt_lname' value='' />";

						echo "Phone Number:<input type='text' name='alt_phone' value='' />";

						echo "Email:<input type='text' name='alt_email' value='' />";

					echo "<input type='submit' name='submit' class='button tiny round' value='Register'>";


    echo "</form>";


	}
	//echo "</label>";
	echo "</div>";
	echo "</div>";
	//adds link back to main page where you can navigate to what you want to do
	echo "<br /><p>&laquo:<a href='index.php'>Back to Main Page</a>";
?>


<?php new_footer("Who's Who", $mysqli); ?>
