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
		if( (isset($_POST["fname"]) && $_POST["fname"] !== "") && (isset($_POST["lname"]) && $_POST["lname"] !== "") && (isset($_POST["number"]) && $_POST["number"] !== "") &&(isset($_POST["sec_num"]) && $_POST["sec_num"] !== "") && (isset($_POST["email"]) && $_POST["email"] !== "") && (isset($_POST["alt_fname"]) && $_POST["alt_fname"] !== "") && (isset($_POST["alt_lname"]) && $_POST["alt_lname"] !== "") && (isset($_POST["alt_phone"]) && $_POST["alt_phone"] !== "") && (isset($_POST["alt_email"]) && $_POST["alt_email"] !== "")){

				//creates query to find the max volunteer number in order to later increment it
        $max = "Select max(host_number) AS max from Host";
        $result2 = $mysqli->query($max);
				//sets max2 to max+ 1 so that that will be the new volunteer number
        if($result2 && $result2->num_rows >= 1){
          while($row=$result2->fetch_assoc()){
            $max2 = $row['max'] + 1;
          }
        }
				//create query to insert the person into the database
				//(no project number assigned because that does not occur at registration)
				//https://stackoverflow.com/questions/6278296/extract-numbers-from-a-string -- for formatting phone number
				$query = "INSERT INTO Host ";
				$query .= "(host_number, first_name, last_name, phone, second_phone, email, alt_first_name, alt_last_name, alt_phone, alt_email) ";
				$query.="VALUES (";
        $query.=$max2.", ";
				$query.="'".$_POST["fname"]."', ";
				$query.="'".$_POST["lname"]."', ";
        $query.="".preg_replace('/[^0-9]/', '', $_POST["number"]).", ";
				$query.="".preg_replace('/[^0-9]/', '', $_POST["sec_num"]).", ";
				$query.="'".$_POST["email"]."', ";
        $query.="'".$_POST["alt_fname"]."', ";
        $query.="'".$_POST["alt_lname"]."', ";
				$query.="".preg_replace('/[^0-9]/', '', $_POST["alt_phone"]).", ";
				$query.="'".$_POST["alt_email"]."')";

				//execute query
				$result = $mysqli->query($query);

				//checks if there is a result
		if($result) {
			//if added to the database posts and redirects to volunteer table
			// $_SESSION["message"] = $_POST["fname"]." ".$_POST["lname"]." has been registered";
				redirect_to("viewHostProjects.php?id=".$max2);
				exit;
			}
			else {
				//if a problem occured with adding to the database
			$_SESSION["message"] = "Error! Could not register ".$_POST["fname"]." ".$_POST["lname"];
			}
		}
		else {
			//sets message to remind you to fill in all boxes if you forgot one
			$_SESSION["message"] = "Unable to add person. Fill in all information!";
			header("Location: registerHost.php");
			exit;
		}
	}
	else {
		//creates form
			echo "<form method='POST' action='registerHost.php'>";

						echo "First Name:<input type='text' name='fname' value='' />";

						echo "Last Name:<input type='text' name='lname' value='' />";

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
	echo "</label>";
	echo "</div>";
	//adds link back to main page where you can navigate to what you want to do
	echo "<br /><p>&laquo:<a href='bigevent.php'>Back to Main Page</a>";
?>


<?php new_footer("Who's Who", $mysqli); ?>
