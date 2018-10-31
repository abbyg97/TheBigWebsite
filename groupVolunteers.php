<?php
	require_once("./included_functions.php");
  require_once("session.php");
	//new header
	new_header("Your Volunteers", "");
	$mysqli = db_connection();
	if (($output = message()) !== null) {
		echo $output;
	}
//
// fix finding the table
	// echo "<br />";
	// echo "<h3 style='padding-left: 1%;'>Select Volunteer Group</h3>";
	// echo "<div>";
	// echo "<label for='left-label' class='left inline'>";

	//check if you clicked submit
  if (isset($_POST["submit"])) {
		//checks to see if organization is empty
		if(isset($_POST["project"]) && $_POST["project"] !== ""){
			//query to select all volunteers from organization selected
      if($_POST["project"] === "all"){
        $query="select vol_number as 'num', first_name as 'fname', last_name as 'lname', ";
        $query.="email, provide_transport, restrictions, phone_numbers as 'phone', Organization.name as 'org' from volunteers ";
  			$query.="left outer join Organization on volunteers.organization=Organization.number";
      }
  		else{
        $query="select vol_number as 'num', first_name as 'fname', last_name as 'lname', ";
        $query.="email, provide_transport, restrictions, phone_numbers as 'phone', Organization.name as 'org' from volunteers ";
        $query.="left outer join Organization on volunteers.organization=Organization.number ";
        $query.="where volunteers.project=".$_POST["project"];
      }

			//execute query
			$result = $mysqli->query($query);

			//if result not empty create table with volunteer first and last name
			// echo "<br />";
			// echo "<h3 style='padding-left: 1%;'>Select Volunteer Group</h3>";
			echo "<div>";
			//echo "<label for='left-label' class='left inline'>";
			if ($result && $result->num_rows > 0) {
				echo "<div>";
				echo "<center>";
				echo "<h2>Here are the volunteers for Project ".$_POST["project"]."</h2>";
				echo "<table id='projects' class='table table-striped table-bordered table-sm' cellspacing='0' width='50%' style='padding-right: 15%;'>";
				echo "<thead>";
				echo "<tr><th>First Name</th><th>Last Name</th><th>Email</th><th>Phone Number</th><th>Provide Transportation?</th><th>Restrictions</th><th>Organization</th><th>Edit</th><th>Delete</th></tr>";
				echo "</thead>";
				echo "<tbody>";
				while ($row = $result->fetch_assoc())  {
					echo "<tr>";
		      echo "<td style='text-align:center'>".$row["fname"]."</td>";
					echo "<td style='text-align:center'>".$row["lname"]."</td>";
          echo "<td style='text-align:center'>".$row["email"]."</td>";
					echo "<td style='text-align:center'>".$row["phone"]."</td>";
          echo "<td style='text-align:center'>".$row["provide_transport"]."</td>";
					echo "<td style='text-align:center'>".$row["restrictions"]."</td>";
          echo "<td style='text-align:center'>".$row["org"]."</td>";
          echo "<td>&nbsp;<a href='edit.php?vol_number=".urlencode($row["num"])."'>Edit</a>&nbsp;&nbsp;</td>";
          echo "<td>&nbsp;<a href='delete.php?vol_number=".urlencode($row["num"])." ' onclick='return confirm('Are you sure?');'>Delete</a>&nbsp;&nbsp;</td>";
					echo "</tr>";
				}
				echo "</tbody>";
				echo "</table>";
				echo "</center>";
				echo "</div>";
			}
			echo "<center>";
			echo "<br /><br /><a href='groupVolunteers.php'>Back to Selecting</a>";
			echo "</center>";
		}
	}
		else if(isset($_POST["submitorg"])){
			if(isset($_POST["org"]) && $_POST["org"] !== ""){
			//query to select all volunteers from organization selected
			$query="select volunteers.first_name, volunteers.last_name from volunteers ";
			$query.="join Organization on volunteers.organization=Organization.number WHERE Organization.number=";
			$query.="(Select number from Organization where name='".$_POST["org"]."') ORDER BY volunteers.last_name ASC";

			//execute query
			$result = $mysqli->query($query);

			//if result not empty create table with volunteer first and last name
				if ($result && $result->num_rows > 0) {
					echo "<div>";
					echo "<center>";
					echo "<h2>Here are the volunteers for ".$_POST["org"]."</h2>";
					echo "<table id='projects' class='table table-striped table-bordered table-sm' cellspacing='0' width='25%'>";
					echo "<thead>";
					echo "<tr><th>First Name</th><th>Last Name</th></tr>";
					echo "</thead>";
					echo "<tbody>";
					while ($row = $result->fetch_assoc())  {
						echo "<tr>";
			      echo "<td style='text-align:center'>".$row["first_name"]."</td>";
						echo "<td style='text-align:center'>".$row["last_name"]."</td>";
						echo "</tr>";
					}
					echo "</tbody>";
					echo "</table>";
					echo "</center>";
					echo "</div>";
				}
			  echo "<center>";
			  echo "<br /><br /><a href='groupVolunteers.php'>Back to Selecting</a>";
			  echo "</center>";
			}
		}
	else {
				echo "<div style = 'padding-left: 7%;'>";
				echo "<form method='POST' action='groupVolunteers.php'  style='width: 25%;'>";

					echo "Select a project:<select name='project'>";
						echo "<option></option>";
            echo "<option value = 'all'>View All Volunteers</option>";
							$query = "Select Project_Number from Projects order by Project_Number";
							$result = $mysqli->query($query);
							if($result && $result->num_rows >= 1){
								while($row=$result->fetch_assoc()){
									echo "<option value = '".$row['Project_Number']."'>".$row['Project_Number']."</option>";
								}
							}
					echo "</select>";

							echo "<input type='submit' name='submit' class='button tiny round' value='Find Volunteers'>";
		    echo "</form>";

				echo "<form method='POST' action='groupVolunteers.php' style='width: 25%;'>";

					echo "Select your organization:<select name='org'>";
						echo "<option></option>";
							$query = "Select name from Organization";
							$result = $mysqli->query($query);
							if($result && $result->num_rows >= 1){
								while($row=$result->fetch_assoc()){
									echo "<option value = '".$row['name']."'>".$row['name']."</option>";
								}
							}
					echo "</select>";

							echo "<input type='submit' name='submitorg' class='button tiny round' value='Find Volunteers'>";
		    echo "</form>";
				echo "</div>";

	}
	echo "</label>";
	echo "</div>";
  echo "<center>";
	echo "<div class='row'>";
  //link to register a new volunteer -- later will be link to register another project
  echo "</center>";
	//link back to index.php
	echo "<br /><p>&laquo:<a href='index.php'>Back to Main Page</a>";
	echo "</div>";
?>


<?php new_footer("Who's Who", $mysqli); ?>
