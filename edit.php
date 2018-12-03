<?php
	require_once("included_functions.php");
  require_once("session.php");
	//set header
	//verify_login();
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

		//creates string from checked boxes to populate the restrictions column
		$restriction = "";
		foreach($_POST['restrict'] as $selected){
			$restriction .= $selected.", ";
		}

		//create query to update database
		$query = "UPDATE volunteers SET ";
		$query.="umID = '".$_POST["studentID"]."', ";
		$query.="webID = '".$_POST["webID"]."', ";
		$query.="first_name = '".$_POST["fname"]."', ";
		$query.="last_name = '".$_POST["lname"]."', ";
		$query.="email = '".$_POST["email"]."', ";
		$query.="provide_transport = '".$_POST["transport"]."', ";
		$query.="restrictions = '".$restriction."', ";
		$query.="phone_numbers = '".$_POST["phone"]."', ";
    $query.="organization = (Select number from Organization WHERE name = '".$_POST["org"]."') ";
		$query.="WHERE vol_number = ".$ID;

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
		//Need this back later
		if(isset($_GET["vol_number"]) && $_GET["vol_number"] !== ""){
			$ID=$_GET["vol_number"];
			$query = "select * from volunteers where vol_number=".$ID;
			$result = $mysqli->query($query);
		}

		//Process query
		if ($result && $result->num_rows > 0)  {
			$row = $result->fetch_assoc();
			echo "<div style='width: 65%; padding-left: 35%;'>";
			echo "<center>";
			echo "<h3 style='padding-left: 3%;'>".$row["first_name"]." ".$row["last_name"]."'s Profile</h3>";
			echo "</center>";
			echo "<div style='text-align: left;'>";

			//create form to update Query
			//set textboxes to already be filled with current value in order for person to see what they previously entered
			echo "<p><form action= 'edit.php?vol_number={$ID}' method='post'>";

						//echo "StudentID Number:<input type='text' name='studentID' value='".$row["vol_number"]."' />";
						echo "StudentID Number:<input type='text' name='studentID' value='".$row["umID"]."' />";

						echo "WebID:<input type='text' name='webID' value='".$row["webID"]."' />";

            echo "First Name:<input type='text' name='fname' value='".$row["first_name"]."' />";

            echo "Last Name:<input type='text' name='lname' value='".$row["last_name"]."' />";

            echo "Email:<input type='text' name='email' value='".$row["email"]."' />";

            echo "Phone Number:<input type='text' name='phone' value='".$row["phone_numbers"]."' />";

            echo "Can you provide transportation:<select name='transport'> ";
              echo "<option></option>";
							if($row['provide_transport'] === 'yes'){
								echo"<option selected='selected'>Yes</option>";
								echo "<option value = 'no'>No</option>";
							}
							else{
								echo"<option selected='selected'>No</option>";
								echo "<option value = 'yes'>Yes</option>";
							}
            echo "</select>";

						echo "<br />";echo "<br />";

						echo "Physical restrictions:";
						echo "<br />";
						//$restict=$row["restrictions"];
							//if the boxes were previously selected check checkbox
							//does this by checking if the option is a substring of the string used to populate restriction
								if(strpos($row["restrictions"], 'allergies') !== false){
									echo "<INPUT TYPE='checkbox' Name='restrict[]' value = 'allergies' checked>Outdoor Allergies";
								}
								else{
									echo "<INPUT TYPE='checkbox' Name='restrict[]' value = 'allergies'>Outdoor Allergies";
								}
								echo "<br />";
								if(strpos($row["restrictions"], 'disable') !== false){
									echo "<INPUT TYPE='checkbox' Name='restrict[]' value = 'disable' checked>Physical Disability";
								}
								else{
									echo "<INPUT TYPE='checkbox' Name='restrict[]' value = 'disable'>Physical Disability";
								}
								echo "<br />";
								if(strpos($row["restrictions"], 'no heights') !== false){
									echo "<INPUT TYPE='checkbox' Name='restrict[]' value = 'no heights' checked>Not comfortable with heights";
								}
								else{
									echo "<INPUT TYPE='checkbox' Name='restrict[]' value = 'no heights'>Not comfortable with heights";
								}
								echo "<br />";
								if(strpos($row["restrictions"], 'no tools') !== false){
									echo "<INPUT TYPE='checkbox' Name='restrict[]' value = 'no tools' checked>Uncomfortable with power tools";
								}
								else{
									echo "<INPUT TYPE='checkbox' Name='restrict[]' value = 'no tools'>Uncomfortable with power tools";
								}
								echo "<br />";

						echo "</select>";

						echo "<br />";

            echo "Select your organization:<select name='org'>";
              //user selects organization they want to be registered with
                $query2 = "Select name, number from Organization";
                $result2 = $mysqli->query($query2);
                if($result2 && $result2->num_rows >= 1){
                  while($row2=$result2->fetch_assoc()){
										if($row['organization'] === $row2['number']){
											echo"<option selected='selected'>".$row2['name']."</option>";
										}
										else{
											echo "<option value = '".$row2['name']."'>".$row2['name']."</option>";
										}
                }
							}
            echo "</select>";

          echo "<input type='submit' name='submit' class='button tiny round' value='Register'>";


		echo "</form>";

///////////////////////////////////////////////////////////////////////////////////////////

			echo "</div>";
			echo "</div>";
			echo "<br /><p>&laquo:<a href='index.php'>Back to Main Page</a>";
			//echo "</label>";


		}
		//Query failed to exit. Return to volunteer.php and output error
		else {
			$_SESSION["message"] = "Volunteer could not be found!";
			header("Location: index.php");
			exit;
		}
	}

?>
<?php  new_footer("volunteers", $mysqli); ?>
