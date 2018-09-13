<?php
	require_once("./included_functions.php");
	new_header("Volunteer Registration", "");
	$mysqli = db_connection();
	// if (($output = message()) !== null) {
	// 	echo $output;
	// }

	echo "<h3>Register</h3>";
	echo "<div class='row'>";
	echo "<label for='left-label' class='left inline'>";

  if (isset($_POST["submit"])) {
		if( (isset($_POST["fname"]) && $_POST["fname"] !== "") && (isset($_POST["lname"]) && $_POST["lname"] !== "") &&(isset($_POST["email"]) && $_POST["email"] !== "") &&(isset($_POST["transport"]) && $_POST["transport"] !== "") && (isset($_POST["restrict"]) && $_POST["restrict"] !== "") && (isset($_POST["phone"]) && $_POST["phone"] !== "") && (isset($_POST["org"]) && $_POST["org"] !== "")){

//////////////////////////////////////////////////////////////////////////////////////////////////
			//STEP 2.
				//Create query to insert information that has been posted
        $max = "Select max(vol_number) AS max from volunteers";
        $result2 = $mysqli->query($max);
        if($result2 && $result2->num_rows >= 1){
          while($row=$result2->fetch_assoc()){
            $max2 = $row['max'] + 1;
          }
        }
				$query = "INSERT INTO volunteers ";
				$query .= "(vol_number, first_name, last_name, email, provide_transport, restrictions, phone_numbers, organization) ";
				$query.="VALUES (";
        $query.=$max2.", ";
				$query.="'".$_POST["fname"]."', ";
				$query.="'".$_POST["lname"]."', ";
        $query.="'".$_POST["email"]."', ";
				$query.="'".$_POST["transport"]."', ";
				$query.="'".$_POST["restrict"]."', ";
				$query.="'".$_POST["phone"]."', ";
				$query.="(Select number from Organization WHERE name = '".$_POST["org"]."'))";

        echo $query;

				$result = $mysqli->query($query);

				// Execute query

//////////////////////////////////////////////////////////////////////////////////////////////////


		if($result) {

			$_SESSION["message"] = $_POST["fname"]." ".$_POST["lname"]." has been registered";
				header("Location: register.php");
				exit;

			}
			else {

			$_SESSION["message"] = "Error! Could not change ".$_POST["fname"]." ".$_POST["lname"];
			}
		}
		else {
			$_SESSION["message"] = "Unable to add person. Fill in all information!";
			header("Location: milestone4.php");
			exit;
		}
	}
	else {
			echo "<form method='POST' action='milestone4.php'>";

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
              // echo "<option value='NA'>None</option>";
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

					// Part b.  Include <input> tags for each of the attributes in person:
					//                  First Name, Last Name, Birthdate, Birth City, Birth State, Region



//////////////////////////////////////////////////////////////////////////////////////////////////

	}
	echo "</label>";
	echo "</div>";
	echo "<br /><p>&laquo:<a href='milestone4.php'>Back to Main Page</a>";
?>


<?php new_footer("Who's Who", $mysqli); ?>
