<?php
	require_once("included_functions.php");
  require_once("session.php");
	//set header
	new_header("Here are the volunteers", "edit.php");
	//connect to database
	$mysqli = db_connection();
	//output message set by later conditions
	if (($output = message()) !== null) {
		echo $output;
	}
	if (isset($_POST["submit"])) {
		//ID set to be the volunteer number (primary key)
		$ID = $_GET["vol_number"];

		//create query to update database
		$query = "UPDATE volunteers SET ";
		$query.="first_name = '".$_POST["fname"]."', ";
		$query.="last_name = '".$_POST["lname"]."', ";
		$query.="email = '".$_POST["email"]."', ";
		$query.="provide_transport = '".$_POST["transport"]."', ";
		$query.="restrictions = '".$_POST["restrict"]."', ";
		$query.="phone_numbers = '".$_POST["phone"]."', ";
    $query.="organization = (Select number from Organization WHERE name = '".$_POST["org"]."') ";
		$query.="WHERE vol_number = ".$ID;

// $query= "update volunteers set first_name='".$_POST["fname"]."', ";
// $query.="last_name='".$_POST["lname"]."', ";
// $query.="email='".$_POST["email"]."', ";
// $query.="provide_transport='".$_POST["transport"]."', ";
// $query.="restrictions='".$_POST["restrict"]."', ";
// $query.="organization = (select number from Organization where name = '".$_POST['org']."') "
// $query.="WHERE vol_number=".$ID;

		//Output query results and return to volunteers.php
		$result = $mysqli->query($query);

		//check that $result was successful
		if($result) {
			$_SESSION["message"] = $_POST["fname"]." ".$_POST["lname"]." has been changed";
		}
		else {
			$_SESSION["message"] = "Error! Could not change ".$_POST["fname"]." ".$_POST["lname"];
		}
		//back to volunteer chart
		header("Location: volunteer.php");
		exit;
	}
	else {
		//if there is a vol_number passed select the values associated with that ID
		if(isset($_GET["vol_number"]) && $_GET["vol_number"] !== ""){
			$ID=$_GET["vol_number"];
			$query = "select * from volunteers where vol_number=".$ID;
			$result = $mysqli->query($query);
		}

		//Process query
		if ($result && $result->num_rows > 0)  {
			$row = $result->fetch_assoc();
			echo "<div class='row'>";
			echo "<label for='left-label' class='left inline'>";

			echo "<h3>".$row["first_name"]." ".$row["last_name"]."'s Profile</h3>";

			//create form to update Query
			//set textboxes to already be filled with current value in order for person to see what they previously entered
			echo "<p><form action= 'edit.php?vol_number={$ID}' method='post'>";

						//echo "StudentID Number:<input type='text' name='studentID' value='".$row["vol_number"]."' />";

            echo "First Name:<input type='text' name='fname' value='".$row["first_name"]."' />";

            echo "Last Name:<input type='text' name='lname' value='".$row["last_name"]."' />";

            echo "Email:<input type='text' name='email' value='".$row["email"]."' />";

            echo "Phone Number:<input type='text' name='phone' value='".$row["phone_numbers"]."' />";

            echo "Can you provide transportation:<select name='transport' value='".$row["provide_transport"]."'> ";
              echo "<option></option>";
              echo "<option value='yes'>Yes</option>";
              echo "<option value='no'>No</option>";
            echo "</select>";

            echo "Physical restrictions:<select name='restrict' value='".$row["restrictions"]."'>";
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

///////////////////////////////////////////////////////////////////////////////////////////


			echo "<br /><p>&laquo:<a href='bigevent.php'>Back to Main Page</a>";
			echo "</label>";
			echo "</div>";

		}
		//Query failed to exit. Return to volunteer.php and output error
		else {
			$_SESSION["message"] = "Volunteer could not be found!";
			header("Location: volunteer.php");
			exit;
		}
	}

?>
<?php  new_footer("volunteers", $mysqli); ?>
