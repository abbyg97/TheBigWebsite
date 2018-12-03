<?php
//this page allows approval status to be updated
//page what is seen by specific committee members -- only see the projects they are expected to approve
	require_once("./included_functions.php");
  require_once("session.php");
	new_header("Approval Status Edits", "");
	//outputs message letting you know if it worked or not
	$mysqli = db_connection();
	if (($output = message()) !== null) {
		echo $output;
	}
	//grabs which approver's projects to select
  $approver=$_GET['approver'];
	//the project of which the approval status needs to be updated
  $num=$_GET["project"];

	if (isset($_POST["submit"])) {
		//makes sure you filled in all boxes
		if( (isset($_POST["status"]) && $_POST["status"] !== "")){
			$query="UPDATE Approvals SET status='".$_POST["status"]."', additional_comments='".$_POST["comments"]."' WHERE project=".$num;
			//execute query
			$result = $mysqli->query($query);

  		if($result) {
  			//if added to the database posts and redirects to volunteer table
  			$_SESSION["message"] = "Has been updated";
  			redirect_to("approverView.php?project=&approver=".$approver);
  			exit;
			}
			else {
				//if a problem occured with adding to the database
				$_SESSION["message"] = "Error! Could not update";
        redirect_to("approverView.php?project=&approver=".$approver);
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
	else if($num){
		//form to change the approval status of a given project
		echo "<form method='POST' action='approverView.php?project=".$num."&approver=".$approver."'>";

		$query="Select status, additional_comments from Approvals where project=".$num;
		$result = $mysqli->query($query);
		while ($row = $result->fetch_assoc())  {
			echo "<br />";
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
	else{
		"no project selected";
	}

	//selects te name of the approver based on the approver number
  $query="Select first_name, last_name from Committee_Members where number=".$approver;
  $result=$mysqli->query($query);
	echo "<center>";
  while ($row = $result->fetch_assoc())  {
    	echo "<h3>Here are the Projects for ".$row["first_name"]." ".$row["last_name"]."</h3>";
  }
	echo "</center>";

	//queries for the projects of the given approver
  echo "<div class='row'>";
	echo "<label for='left-label' class='left inline'>";
	if(isset($_GET['approver'])){
		$query="SELECT Project_Number AS 'num', Host, address, min_volunteers AS 'min', ";
		$query.="max_volunteers AS 'max', Transportation.type as transportation, Approvals.approver as 'approver', description, tools, Projects.additional_comments AS 'comments', ";
		$query.="rain, rain_proj, ";
		$query.="restriction_violation AS 'restrictions', proj_category.cat AS 'category', Approvals.status from Projects ";
		$query.="join proj_category on Projects.category=proj_category.number ";
		$query.="left outer join Transportation on Projects.transportation=Transportation.number ";
		$query.="right outer join Approvals on Approvals.project=Projects.Project_Number ";
		$query.="where Approvals.approver='".$approver."'";
	}
	else{
		$query="SELECT Project_Number AS 'num', Host, address, min_volunteers AS 'min', ";
		$query.="max_volunteers AS 'max', Transportation.type as transportation, Approvals.approver as 'approver', description, tools, Projects.additional_comments AS 'comments', ";
		$query.="rain, rain_proj, ";
		$query.="restriction_violation AS 'restrictions', proj_category.cat AS 'category', Approvals.status from Projects ";
		$query.="join proj_category on Projects.category=proj_category.number ";
		$query.="left outer join Transportation on Projects.transportation=Transportation.number ";
		$query.="right outer join Approvals on Approvals.project=Projects.Project_Number";
	}

	$result = $mysqli->query($query);

	//outputs selected projects in a table
	if ($result && $result->num_rows > 0) {
		echo "<div class='row'>";
		echo "<center>";
    echo "<table>";
    echo "<tr><th>Project Number</th><th>Host Number</th><th>Address</th><th>Minimum Volunteers</th><th>Maximum Volunteers</th><th>Description</th><th>Tools requested</th><th>Comments</th><th>Come if it rains?</th><th>Describe the project we would do on a rainy day</th><th>Restrictions</th><th>Category</th><th>Approval Status</th><th>Edit Project</th></tr>";
    while ($row = $result->fetch_assoc())  {
      echo "<tr>";
			echo "<td style='text-align:center'>".$row["num"]."</td>";
			echo "<td>&nbsp;<a href='Hosts.php?host=".$row['Host']."'>".$row["Host"]."</a>&nbsp;&nbsp;</td>";
      echo "<td style='text-align:center'>".$row["address"]."</td>";
      echo "<td style='text-align:center'>".$row["min"]."</td>";
      echo "<td style='text-align:center'>".$row["max"]."</td>";
      echo "<td style='text-align:center'>".$row["description"]."</td>";
      echo "<td style='text-align:center'>".$row["tools"]."</td>";
      echo "<td style='text-align:center'>".$row["comments"]."</td>";
      echo "<td style='text-align:center'>".$row["rain"]."</td>";
      echo "<td style='text-align:center'>".$row["rain_proj"]."</td>";
      echo "<td style='text-align:center'>".$row["restrictions"]."</td>";
      echo "<td style='text-align:center'>".$row["category"]."</td>";
			echo "<td>&nbsp;<a href='approverView.php?project=".$row['num']."&approver=".$row['approver']."'>".$row["status"]."</a>&nbsp;&nbsp;</td>";
			echo "<td>&nbsp;<a href='editProject.php?project=".urlencode($row["num"])."&host=".$row['Host']."'>Edit</a>&nbsp;&nbsp;</td>";
      echo "</tr>";
		}
		echo "</table>";
		echo "</center>";
		echo "</div>";
	}

	echo "</label>";
	echo "</div>";
	//adds link back to main page where you can navigate to what you want to do
	echo "<br /><p>&laquo:<a href='execProjectView.php'>Back to Projects</a>";
?>


<?php new_footer("Who's Who", $mysqli); ?>
