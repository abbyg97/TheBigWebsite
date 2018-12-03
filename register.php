<?php
	require_once("./included_functions.php");
  require_once("session.php");
	require_once("/home/agarrett/DBgarrett.php");
	new_header("Volunteer Registration", "");
	//outputs message letting you know if it worked or not
	$mysqli = db_connection();
	if (($output = message()) !== null) {
		echo $output;
	}

	//stores webID in variable $webID
	$webID=$_GET['id'];

	//puts in headers on web page
	echo "<div style='width: 65%; padding-left: 35%;'>";
	echo "<center>";
	echo "<h3>Register to Volunteer</h3>";
	echo "</center>";
	echo "<div style='text-align: left;'>";

	//condition to check if you submited something
  if (isset($_POST["submit"])) {
		//makes sure you filled in all boxes
		if( (isset($_POST["studentID"]) && $_POST["studentID"] !== "") && (isset($_POST["webID"]) && $_POST["webID"] !== "") && (isset($_POST["fname"]) && $_POST["fname"] !== "") && (isset($_POST["lname"]) && $_POST["lname"] !== "") &&(isset($_POST["email"]) && $_POST["email"] !== "") &&(isset($_POST["transport"]) && $_POST["transport"] !== "") && (isset($_POST["phone"]) && $_POST["phone"] !== "")){

				$restriction = "";
				foreach($_POST['restrict'] as $selected){
					$restriction .= $selected.", ";
				}
				//insert volunteer into database
				//create query to insert the person into the database
				//(no project number assigned because that does not occur at registration)
				$query = "INSERT INTO volunteers ";
				$query .= "(umID, webID, first_name, last_name, email, provide_transport, restrictions, phone_numbers, organization) ";
				$query.="VALUES (";
				//uses ? in keeping with PDo notation
				//$query.="VALUES (?, ?, ?, ?, ?, ";
        $query.=$_POST["studentID"].", ";
				$query.="'".$_POST["webID"]."', ";
				$query.="'".$_POST["fname"]."', ";
				$query.="'".$_POST["lname"]."', ";
        $query.="'".$_POST["email"]."', ";
				$query.="'".$_POST["transport"]."', ";
				$query.="'".$restriction."', ";
				$query.=preg_replace('/[^0-9]/', '', $_POST["phone"]).", ";
				$query.="(Select number from Organization WHERE name = '".$_POST["org"]."'))";

				//execute query
				$result = $mysqli->query($query);
				// $stmt = $mysqli->prepare($query);
				// $stmt -> execute([$_POST["studentID"], $_POST["webID"], $_POST["fname"], $_POST["lname"], $_POST["email"]]);

				//checks if there is a result
		if($result) {
		// if($stmt) {
			//if added to the database posts and redirects to volunteer table
			$_SESSION["message"] = $_POST["fname"]." ".$_POST["lname"]." has been registered";
				header("Location: index.php");
				exit;

			}
			else {
				//if a problem occured with adding to the database
				$_SESSION["message"] = "Error! Could not add ".$_POST["fname"]." ".$_POST["lname"];
				header("Location: register.php");
				exit;
			}
		}
		else {
			//sets message to remind you to fill in all boxes if you forgot one
			$_SESSION["message"] = "Unable to add person. Fill in all information!";
			header("Location: register.php");
			exit;
		}
	}
	else {
		//creates form
			echo "<form method='POST' action='register.php'>";

						echo "StudentID Number:<input type='text' name='studentID' value='' />";

						echo "WebID:<input type='text' name='webID' value='".$webID."' />";

						echo "First Name:<input type='text' name='fname' value='' />";

						echo "Last Name:<input type='text' name='lname' value='' />";

						echo "Email:<input type='text' name='email' value='' />";

						echo "Phone Number:<input type='text' name='phone' value='' />";

            echo "Can you provide transportation:<select name='transport'>";
              echo "<option></option>";
              echo "<option value='yes'>Yes</option>";
              echo "<option value='no'>No</option>";
            echo "</select>";

						echo "<br />";
						echo "<br />";

            echo "Physical restrictions:";
						echo "<br />";
							// options for organizations to select gathered from the database
								echo "<INPUT TYPE='checkbox' Name='restrict[]' value = 'allergies'>Outdoor Allergies";
								echo "<br />";
								echo "<INPUT TYPE='checkbox' Name='restrict[]' value = 'disable'>Physical Disability";
								echo "<br />";
								echo "<INPUT TYPE='checkbox' Name='restrict[]' value = 'no heights'>Not comfortable with heights";
								echo "<br />";
								echo "<INPUT TYPE='checkbox' Name='restrict[]' value = 'no tools'>Uncomfortable with power tools";
								echo "<br />";

						echo "</select>";

						echo "<br />";

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
