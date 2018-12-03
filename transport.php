<?php
	require_once("./included_functions.php");
  require_once("session.php");
	new_header("Transportation Assignment", "");
	//outputs message letting you know if it worked or not
	$mysqli = db_connection();
	if (($output = message()) !== null) {
		echo $output;
	}

	//project number that you want to change the transportation assignment of
  $num=$_GET["project"];

	//puts in headers on web page
	echo "<div style='width: 65%; padding-left: 35%;'>";
	echo "<center>";
	echo "<h3>Assign Transportation</h3>";
	echo "</center>";
	echo "<div style='text-align: left;'>";

	//condition to check if you submited something
  if (isset($_POST["submit"])) {
		//makes sure you filled in all boxes
		if(isset($_POST["transport"]) && $_POST["transport"] !== ""){
				//create query to update transportation assignment of
        $query2 = "Select number from Transportation where type='".$_POST['transport']."'";
        $result2 = $mysqli->query($query2);
        if($result2 && $result2->num_rows >= 1){
          while($row=$result2->fetch_assoc()){
            $transportNum = $row['number'];
          }
        }
				$query="UPDATE Projects SET transportation=".$transportNum." WHERE Project_Number=".$num;
				//execute query
				$result = $mysqli->query($query);

				//checks if there is a result
  		if($result) {
  			//if added to the database posts and redirects to project table
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
		else{
			$query="UPDATE Projects SET transportation=NULL WHERE Project_Number=".$num;
			//execute query
			$result = $mysqli->query($query);

				//checks if there is a result
			if($result) {
				//if added to the database posts and redirects to project table
				$_SESSION["message"] = "Has been updated";
					redirect_to("execProjectView.php");
					exit;
				}
				else {
					//if a problem occured with adding to the database
					$_SESSION["message"] = "Error2! Could not update";
					redirect_to("execProjectView.php");
					exit;
				}

		}
		// else {
		// 	//sets message to remind you to fill in all boxes if you forgot one
		// 	$_SESSION["message"] = "Unable to update!";
		// 	header("Location: transport.php");
		// 	exit;
		// }
  }

	else {
		//creates form
			echo "<form method='POST' action='transport.php?project=".$num."'>";

      echo "Select transportation:<select name='transport'>";
			$query = "Select type, number from Transportation";
			$result = $mysqli->query($query);
			if($result && $result->num_rows >= 1){
				while($row=$result->fetch_assoc()){
					$query2 = "Select transportation from Projects where Project_Number=".$num;
					$result2 = $mysqli->query($query2);
					if($result2 && $result2->num_rows >= 1){
						while($row2=$result2->fetch_assoc()){
							if($row['number'] === $row2['transportation']){
								echo"<option selected='selected'>".$row['type']."</option>";
								echo "<option value = ''>None</option>";
							}
							else{
								echo "<option value = '".$row['type']."'>".$row['type']."</option>";
							}
							//option selected if that is what it was previously set to
							if($row2['transportation'] === null && $row['number'] == 2){
									echo"<option selected='selected'>None</option>";
							}

						}
					}
				}
			}




        // options for organizations to select gathered from the database
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
