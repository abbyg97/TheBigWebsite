<?php
	require_once("./included_functions.php");
  require_once("session.php");
	new_header("Volunteer Registration", "");
	//outputs message letting you know if it worked or not
	$mysqli = db_connection();
	if (($output = message()) !== null) {
		echo $output;
	}

	//puts in headers on web page
	echo "<h3>Register</h3>";
	echo "<div class='row'>";
	echo "<label for='left-label' class='left inline'>";

	//condition to check if you submited something
  if (isset($_POST["submit"])) {
		//makes sure you filled in all boxes
		if( (isset($_POST["studentID"]) && $_POST["studentID"] !== "") && (isset($_POST["fname"]) && $_POST["fname"] !== "") && (isset($_POST["lname"]) && $_POST["lname"] !== "") &&(isset($_POST["email"]) && $_POST["email"] !== "") &&(isset($_POST["transport"]) && $_POST["transport"] !== "") && (isset($_POST["restrict"]) && $_POST["restrict"] !== "") && (isset($_POST["phone"]) && $_POST["phone"] !== "") && (isset($_POST["org"]) && $_POST["org"] !== "")){

				//creates query to find the max volunteer number in order to later increment it
        $max = "Select max(vol_number) AS max from volunteers";
        $result2 = $mysqli->query($max);
				//sets max2 to max+ 1 so that that will be the new volunteer number
        if($result2 && $result2->num_rows >= 1){
          while($row=$result2->fetch_assoc()){
            $max2 = $row['max'] + 1;
          }
        }
				//create query to insert the person into the database
				//(no project number assigned because that does not occur at registration)
				$query = "INSERT INTO volunteers ";
				$query .= "(vol_number, first_name, last_name, email, provide_transport, restrictions, phone_numbers, organization) ";
				$query.="VALUES (";
        $query.=$_POST["studentID"].", ";
				$query.="'".$_POST["fname"]."', ";
				$query.="'".$_POST["lname"]."', ";
        $query.="'".$_POST["email"]."', ";
				$query.="'".$_POST["transport"]."', ";
				$query.="'".$_POST["restrict"]."', ";
				$query.="'".$_POST["phone"]."', ";
				$query.="(Select number from Organization WHERE name = '".$_POST["org"]."'))";

				//execute query
				$result = $mysqli->query($query);

				//checks if there is a result
		if($result) {
			//if added to the database posts and redirects to volunteer table
			$_SESSION["message"] = $_POST["fname"]." ".$_POST["lname"]." has been registered";
				header("Location: volunteer.php");
				exit;

			}
			else {
				//if a problem occured with adding to the database
			$_SESSION["message"] = "Error! Could not change ".$_POST["fname"]." ".$_POST["lname"];
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

						echo "First Name:<input type='text' name='fname' value='' />";

						echo "Last Name:<input type='text' name='lname' value='' />";

						echo "Email:<input type='text' name='email' value='' />";

						echo "Phone Number:<input type='text' name='phone' value='' />";

            echo "Can you provide transportation:<select name='transport'>";
              echo "<option></option>";
              echo "<option value='yes'>Yes</option>";
              echo "<option value='no'>No</option>";
            echo "</select>";

            echo "Physical restrictions:<select name='restrict'>";
              echo "<option value='NA'>None</option>";
              echo "<option value='allergy'>Outdoor alergies</option>";
              echo "<option value='handicap'>Physical disability (prevents heavy lifting projects)</option>";
            echo "</select>";

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
	echo "</label>";
	echo "</div>";
	//adds link back to main page where you can navigate to what you want to do
	echo "<br /><p>&laquo:<a href='bigevent.php'>Back to Main Page</a>";
?>


<?php new_footer("Who's Who", $mysqli); ?>
