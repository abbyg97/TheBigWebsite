<?php
	require_once("./included_functions.php");
  require_once("session.php");
	new_header("Approval Status Edits", "");
	//makes sure user is logged in -- sessions.php
	verify_login();
	$mysqli = db_connection();
	//outputs message letting you know if it worked or not
	if (($output = message()) !== null) {
		echo $output;
	}

	//grabs the project number passed over
  $num=$_GET["project"];

	//centers content
	echo "<div style='width: 65%; padding-left: 35%;'>";
	//centers header
	echo "<center>";
	echo "<h3>Edit Approval Status</h3>";
	echo "</center>";
	//aligns text to left of the centered div
	echo "<div style='text-align: left;'>";

	//condition to check if you submited something
  if (isset($_POST["submit"])) {
		//makes sure you filled in all boxes
		if( (isset($_POST["status"]) && $_POST["status"] !== "") && (isset($_POST["comments"]))){
				$query="UPDATE Approvals SET status='".$_POST["status"]."' WHERE project=".$num;
				//execute query
				$result = $mysqli->query($query);

        $query2="UPDATE Approvals SET additional_comments='".$_POST["comments"]."' WHERE number=".$num;
				//execute query
				$result2 = $mysqli->query($query2);

			//checks if there is a result
  		if($result) {
  			//if added to the database posts and redirects to volunteer table
  			$_SESSION["message"] = "Has been updated";
  				redirect_to("execProjectView.php");
  				exit;
  			}
  			else {
  				//if a problem occured with adding to the database
  				$_SESSION["message"] = "Error! Could not update";
          redirect_to("execProjectView.php");
  				exit;
  			}
      }
		else {
			//sets message to remind you to fill in all boxes if you forgot one
			$_SESSION["message"] = "Unable to update!";
			header("Location: approvals.php");
			exit;
		}
  }

	else {
		//creates form
			echo "<form method='POST' action='approvals.php?project=".$num."'>";

      $query="Select status, additional_comments from Approvals where project=".$num;
      $result = $mysqli->query($query);
      while ($row = $result->fetch_assoc())  {
				echo "Have you approved your Project?:<select name='status'>";
	        // options for organizations to select gathered from the database
					if($row['status'] === 'yes'){
						echo"<option selected='selected'>Yes</option>";
						echo "<option value = 'no'>No</option>";
					}
					else{
						echo"<option selected='selected'>No</option>";
						echo "<option value = 'yes'>Yes</option>";
					}
	      echo "</select>";
        echo "Comments:<input type='text' name='comments' value='".$row["additional_comments"]."' />";
      }

			echo "<input type='submit' name='submit' class='button tiny round' value='Update'>";


    echo "</form>";


	}
	echo "</div>";
	echo "</div>";
	//adds link back to main page where you can navigate to what you want to do
	echo "<br /><p>&laquo:<a href='execProjectView.php'>Back to Projects</a>";
?>


<?php new_footer("Big Event", $mysqli); ?>
