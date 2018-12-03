<?php
	require_once("./included_functions.php");
  require_once("session.php");
	//from session.php; checks to see if user is logged in
	verify_login();
	new_header("Transportation Assignment", "");
	//outputs message letting you know if it worked or not
	$mysqli = db_connection();
	if (($output = message()) !== null) {
		echo $output;
	}

	//tl_number
  $num=$_GET["num"];

	//centers content
	echo "<div style='width: 65%; padding-left: 35%;'>";
	//centers header
	echo "<center>";
	echo "<h3>Assign Project</h3>";
	echo "</center>";
	//aligns text to left of the centered div
	echo "<div style='text-align: left;'>";

	//condition to check if you submited something
  if (isset($_POST["submit"])) {
		//makes sure you filled in all boxes
		if(isset($_POST["project"])){
				$query="UPDATE Team_Leaders SET tl_project=".$_POST['project']." WHERE tl_number=".$num;
				//execute query
				$result = $mysqli->query($query);

				//checks if there is a result
  		if($result) {
  			//if added to the database posts and redirects to volunteer table
  			$_SESSION["message"] = "Has been updated";
  				redirect_to("teamleaders.php");
  				exit;
  			}
  			else {
  				//if a problem occured with adding to the database
  				$_SESSION["message"] = "Error! Could not update";
  			}
      }
		else {
			//sets message to remind you to fill in all boxes if you forgot one
			$_SESSION["message"] = "Unable to update!";
			header("Location: teamleaders.php");
			exit;
		}
  }

	else {
		//creates form to changes project number of a team leader
			echo "<form method='POST' action='assignTLProject.php?num=".$num."'>";

      echo "Select new project:<select name='project'>";
        // options for organizations to select gathered from the database
				$query2="select tl_project from Team_Leaders where tl_number=".$num;
				$result2 = $mysqli->query($query2);
				if($result2 && $result2->num_rows >= 1){
					while($row2=$result2->fetch_assoc()){
						$value = $row2["tl_project"];
					}
				}
					//selects all active project numbers
          $query = "Select Project_Number from Projects ORDER BY Project_Number";
          $result = $mysqli->query($query);
          if($result && $result->num_rows >= 1){
            while($row=$result->fetch_assoc()){
							if($value === $row['Project_Number']){
								echo"<option selected='selected'>".$row["Project_Number"]."</option>";
							}
							else{
								echo "<option value = '".$row['Project_Number']."'>".$row["Project_Number"]."</option>";
							}
            }
          }

          echo "<option value = ''>None</option>";
      echo "</select>";

			echo "<input type='submit' name='submit' class='button tiny round' value='Assign'>";


    echo "</form>";


	}
	echo "</div>";
	echo "</div>";
	//adds link back to main page where you can navigate to what you want to do
	echo "<br /><p>&laquo:<a href='execProjectView.php'>Back to Projects</a>";

	echo "<br /><p>&laquo:<a href='index.php'>Back to Main Page</a>";
?>


<?php new_footer("Who's Who", $mysqli); ?>
