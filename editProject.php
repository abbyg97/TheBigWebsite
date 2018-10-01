<?php
	require_once("included_functions.php");
  require_once("session.php");
	//set header
	new_header("Here is your project Information", "editProject.php");
	//connect to database
	$mysqli = db_connection();
	//output message set by later conditions
	if (($output = message()) !== null) {
		echo $output;
	}
	if (isset($_POST["submit"])) {
		//ID set to be the volunteer number (primary key)
		$num = $_GET["project"];

    $restriction = "";
    foreach($_POST['restrict'] as $selected){
      $restriction .= $selected.", ";
    }

		//create query to update database
		$query = "UPDATE Projects SET ";
		$query.="address = '".$_POST["address"]."', ";
		$query.="min_volunteers = ".$_POST["min"].", ";
		$query.="max_volunteers = ".$_POST["max"].", ";
		$query.="category = (Select number from proj_category WHERE cat = '".$_POST["cat"]."'), ";
		$query.="description = '".$_POST["descrip"]."', ";
    $query.="tools = '".$_POST["tools"]."', ";
		$query.="additional_comments = '".$_POST["comments"]."', ";
    $query.="rain = '".$_POST["rain"]."', ";
		$query.="rain_proj = '".$_POST["rain_proj"]."', ";
		$query.="restriction_violation = '".$restriction."' ";
		$query.="WHERE Project_Number = ".$num;

		//Output query results and return to volunteers.php
		$result = $mysqli->query($query);

		//check that $result was successful
		if($result) {
			$_SESSION["message"] = "Project information has been changed";
		}
		else {
			// $_SESSION["message"] = "Error! Could not make updates";
      echo $query;
		}
		//back to volunteer chart
		header("Location: editProject.php");
		exit;
	}
	else {
		//if there is a vol_number passed select the values associated with that ID
		if(isset($_GET["project"]) && $_GET["project"] !== ""){
			$num=$_GET["project"];
			$query = "select * from Projects where Project_Number=".$num;
			$result = $mysqli->query($query);
		}

		//Process query
		if ($result && $result->num_rows > 0)  {
			$row = $result->fetch_assoc();
			echo "<div class='row'>";
			echo "<label for='left-label' class='left inline'>";

			echo "<h3>Edit Your Project Information</h3>";

			//create form to update Query
			//set textboxes to already be filled with current value in order for person to see what they previously entered
			echo "<p><form action= 'editProject.php?project={$num}' method='post'>";

              echo "Address:<input type='text' name='address' value='".$row["address"]."' />";

              echo "Minimum Volunteers Needed:<input type='text' name='min' value='".$row["min_volunteers"]."' />";

              echo "Maximum Volunteers Needed:<input type='text' name='max' value='".$row["max_volunteers"]."' />";

              echo "Select your category:<select name='cat'>";
                // options for organizations to select gathered from the database
                  $query2 = "Select cat from proj_category";
                  $result2 = $mysqli->query($query2);
                  if($result2 && $result2->num_rows >= 1){
                    while($row2=$result2->fetch_assoc()){
                      echo "<option value = '".$row2['cat']."'>".$row2['cat']."</option>";
                    }
                  }
              echo "</select>";

                echo "Description:<input type='text' name='descrip' value='".$row["description"]."' />";

                echo "Tools Requested:<input type='text' name='tools' value='".$row["tools"]."' />";

                echo "Additional Comments:<input type='text' name='comments' value='".$row["additional_comments"]."' />";

                echo "Do you have a project volunteers can do if it rains?:<select name='rain'>";
                  echo "<option value='yes'>Yes</option>";
                  echo "<option value='no'>No</option>";
                echo "</select>";

                echo "Description of the project that will happen if it rains:<input type='text' name='rain_proj' value='".$row["rain_proj"]."' />";

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

          echo "<input type='submit' name='submit' class='button tiny round' value='Update'>";


		echo "</form>";

///////////////////////////////////////////////////////////////////////////////////////////


			echo "<br /><p>&laquo:<a href='bigevent.php'>Back to Main Page</a>";
			echo "</label>";
			echo "</div>";

		}
		//Query failed to exit. Return to volunteer.php and output error
		else {
			$_SESSION["message"] = "Did update but still in this loop";
			header("Location: bigevent.php");
			exit;
      $query;
		}
	}

?>
<?php  new_footer("projects", $mysqli); ?>