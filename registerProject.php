<?php
	require_once("./included_functions.php");
  require_once("session.php");
	//verify_login();
	//puts in headers on web page
	new_header("Project Registration", "");
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

	//host number
	$host=$_GET["host"];

	echo "<div style='width: 65%; padding-left: 35%;'>";
	echo "<center>";
	echo "<h3>Register a Project</h3>";
	echo "</center>";
	echo "<div style='text-align: left;'>";
	//echo "<div class='row'>";
	//echo "<label for='left-label' class='left inline'>";

// && (isset($_POST["descrip"]) && $_POST["descrip"] !== "") && (isset($_POST["tools"]) && $_POST["tools"] !== "") && (isset($_POST["comments"]) && $_POST["comments"] !== "") && (isset($_POST["rain_proj"]) && $_POST["rain_proj"] !== "")
	//condition to check if you submited something
  if (isset($_POST["submit"])) {
		//makes sure you filled in all boxes
		//(isset($_POST["fname"]) && $_POST["fname"] !== "") && (isset($_POST["lname"]) && $_POST["lname"] !== "") &&
		if( (isset($_POST["address"]) && $_POST["address"] !== "") &&(isset($_POST["min"]) && $_POST["min"] !== "") && (isset($_POST["max"]) && $_POST["max"] !== "") && (isset($_POST["cat"]) && $_POST["cat"] !== "") && (isset($_POST["rain"]) && $_POST["rain"] !== "")){

				//sets variable to hold string representing any restrictions you specified
				$restriction = "";
				foreach($_POST['restrict'] as $selected){
					$restriction .= $selected.", ";
				}

				//create query to insert the person into the database
				//(no project number assigned because that does not occur at registration)
				$query = "INSERT INTO Projects ";
				$query .= "(Host, address, min_volunteers, max_volunteers, transportation, category, description, tools, additional_comments, rain, rain_proj, restriction_violation) ";
				$query.="VALUES (";
        $query.=$host.", ";
				$query.="'".$_POST["address"]."', ";
				//$query.="?, ";
				$query.="".$_POST["min"].", ";
        $query.="".$_POST["max"].", ";
				$query.="NULL, ";
				$query.="(Select number from proj_category WHERE cat = '".$_POST["cat"]."'), ";
        $query.="'".$_POST["descrip"]."', ";
        $query.="'".$_POST["tools"]."', ";
				$query.="'".$_POST["comments"]."', ";
				//$query.="?, ?, ?, ";
        $query.="'".$_POST["rain"]."', ";
        $query.="'".$_POST["rain_proj"]."', ";
				//$query.="?, ";
				$query.="'".$restriction."')";

				//execute query
				$result = $mysqli->query($query);

				// $stmt = $mysqli->prepare($query);
				// $stmt -> execute([$_POST["address"], $_POST["descrip"], $_POST["tools"], $_POST["comments"], $_POST["rain_proj"]]);
				//
				$query3="Select max(Project_Number) from Projects";
				$result3 = $mysqli->query($query3);
				if($result3 && $result3->num_rows >= 1){
					while($row=$result3->fetch_assoc()){
						$query2 = "INSERT INTO Approvals ";
						$query2.="VALUES (";
						$query2.=$row['max(Project_Number)'].", 2, 'no', 'none', ".$row['max(Project_Number)'].")";

						//execute query
						$result2 = $mysqli->query($query2);
					}
				}
				//checks if there is a result
		if($result) {
		//if($stmt) {
			//if added to the database posts and redirects to volunteer table
			// $_SESSION["message"] = "Project was registered";
				// header("Location: registerProject.php");
				// exit;
				redirect_to("viewHostProjects.php?id=".$host);
				exit;
			}
			else {
				//if a problem occured with adding to the database
			$_SESSION["message"] = "Error! Could not register project.";
			}
		}
		else {
			//sets message to remind you to fill in all boxes if you forgot one
			$_SESSION["message"] = "Unable to add person. Fill in all information!";
			header("Location: registerProject.php?host=".$host);
			exit;
		}
	}
	else {
		//creates form
			echo "<form method='POST' action='registerProject.php?host=".$host."'>";

						// echo "Host First Name:<input type='text' name='fname' value='' />";
						//
						// echo "Host Last Name:<input type='text' name='lname' value='' />";

            echo "Address (required):<input type='text' name='address' value='' />";

						echo "Minimum Volunteers Needed (required):<input type='text' name='min' value='' />";

						echo "Maximum Volunteers Needed (required):<input type='text' name='max' value='' />";

						echo "Select your category:<select name='cat'>";
              // options for organizations to select gathered from the database
                $query = "Select cat from proj_category";
                //$result = $mysqli->prepare($query);
								//$result-> execute();
								$result = $mysqli->query($query);
                if($result && $result->num_rows >= 1){
                  while($row=$result->fetch_assoc()){
									//while($row=$result->fetch(PDO::FETCH_ASSOC)){
                    echo "<option value = '".$row['cat']."'>".$row['cat']."</option>";
                  }
                }
            echo "</select>";

            echo "Description:<input type='text' name='descrip' value='' />";

						echo "Tools Requested:<input type='text' name='tools' value='' />";

						echo "Additional Comments:<input type='text' name='comments' value='' />";

						echo "Do you have a project volunteers can do if it rains?:<select name='rain'>";
							echo "<option value='yes'>Yes</option>";
							echo "<option value='no'>No</option>";
						echo "</select>";

            echo "Description of the project that will happen if it rains:<input type='text' name='rain_proj' value='' />";

						echo "Select any physical restrictions we may need to consider:";
						echo "<br />";
              // options for organizations to select gathered from the database
                $query = "Select restriction from proj_restriction";
                $result = $mysqli->query($query);
                if($result && $result->num_rows >= 1){
                  while($row=$result->fetch_assoc()){
										echo "<INPUT TYPE='checkbox' Name='restrict[]' value = '".$row['restriction']."'>".$row['restriction'];
										echo "<br />";
                    //echo "<option value = '".$row['restriction']."'>".$row['restriction']."</option>";
                  }
                }
            echo "</select>";

					echo "<input type='submit' name='submit' class='button tiny round' value='Register'>";


    echo "</form>";


	}
	//echo "</center>";
	//echo "</label>";
	echo "</div>";
	echo "</div>";
	//adds link back to main page where you can navigate to what you want to do
	echo "<br /><p>&laquo:<a href='/~agarrett/viewHostProjects.php?id=".$host."'>Back to My Projects</a>";
	echo "<br /><p>&laquo:<a href='index.php'>Back to Main Page</a>";
?>


<?php new_footer("Who's Who", $mysqli); ?>
