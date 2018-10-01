<?php
	require_once("./included_functions.php");
  require_once("session.php");
	//new header
	new_header("Your Volunteers", "");
	$mysqli = db_connection();
	if (($output = message()) !== null) {
		echo $output;
	}

	echo "<h3>Volunteers</h3>";
	echo "<div class='row'>";
	echo "<label for='left-label' class='left inline'>";

	//check if you clicked submit
  if (isset($_POST["submit"])) {
		//checks if you entered a first and last name
		if( (isset($_POST["fname"]) && $_POST["fname"] !== "") && (isset($_POST["lname"]) && $_POST["lname"] !== "")){

			//sets names to be the trimmed version of what you entered
      $first = $mysqli->real_escape_string(trim($_POST['fname']));
      $last = $mysqli->real_escape_string(trim($_POST['lname']));

			//create query to search for all of volunteers associated with that host
			if($_POST["fname"] !== "all" && $_POST["lname"] !== "none"){
				$query = "SELECT volunteers.first_name, volunteers.last_name, volunteers.project FROM volunteers ";
			  $query.="JOIN Projects ON Projects.Project_Number=volunteers.project ";
			  $query.= "JOIN Host ON Projects.Host=Host.host_number ";
			  $query.="WHERE Host.first_name='".$first."' AND Host.last_name = '".$last."' ORDER BY volunteers.last_name ASC";
			}
			else{
				$query="SELECT Host.first_name As 'Host First Name', Host.last_name ";
				$query.="AS 'Host Last Name', GROUP_CONCAT(volunteers.first_name ";
				$query.="ORDER BY volunteers.first_name) AS 'volunteers' ";
				$query.="FROM Host JOIN Projects ON Projects.Host=Host.host_number JOIN ";
				$query.="volunteers ON Projects.Project_Number=volunteers.project GROUP BY Host.first_name";
			}
			//execute query
      $result = $mysqli->query($query);

			//if result not empty
			if ($result && $result->num_rows > 0) {
				echo "<div class='row'>";
				echo "<center>";

				//output in a table the first and last name of each volunteer associated with the Host searched for
				//also show project number in case one host has multiple projects
				if($_POST["fname"] !== "all" && $_POST["lname"] !== "none"){
					echo "<h2>Here are the volunteers for ".$_POST["fname"]." ".$_POST["lname"]."</h2>";
					echo "<table>";
					echo "<tr><th>Volunteer First Name</th><th>Volunteer Last Name</th><th>Project Number</th></tr>";
					while ($row = $result->fetch_assoc())  {
						echo "<tr>";
			      echo "<td style='text-align:center'>".$row["first_name"]."</td>";
						echo "<td style='text-align:center'>".$row["last_name"]."</td>";
						echo "<td style='text-align:center'>".$row["project"]."</td>";
						echo "</tr>";
					}
				}
				else{
					echo "<h2>Here are the volunteers</h2>";
					echo "<table>";
					echo "<tr><th>Host First Name</th><th>Host Last Name</th><th>Volunteers</th></tr>";
					while ($row = $result->fetch_assoc())  {
						echo "<tr>";
			      echo "<td style='text-align:center'>".$row["Host First Name"]."</td>";
						echo "<td style='text-align:center'>".$row["Host Last Name"]."</td>";
						echo "<td style='text-align:center'>".$row["volunteers"]."</td>";
						echo "</tr>";
					}
				}
				echo "</table>";
				echo "</center>";
				echo "</div>";
			}
		  echo "<center>";
			//link to register a new volunteer -- later will be link to register another project
			echo "<br /><br /><a href='selectandView.php'>Back to Selecting</a>";
		  echo "</center>";


		}

		//checks to see if organization is empty
		else if(isset($_POST["org"]) && $_POST["org"] !== ""){
			//query to select all volunteers from organization selected
			$query="select volunteers.first_name, volunteers.last_name from volunteers ";
			$query.="join Organization on volunteers.organization=Organization.number WHERE Organization.number=";
			$query.="(Select number from Organization where name='".$_POST["org"]."') ORDER BY volunteers.last_name ASC";

			//execute query
			$result = $mysqli->query($query);

			//if result not empty create table with volunteer first and last name
			if ($result && $result->num_rows > 0) {
				echo "<div class='row'>";
				echo "<center>";
				echo "<h2>Here are the volunteers for ".$_POST["org"]."</h2>";
				echo "<table>";
				echo "<tr><th>First Name</th><th>Last Name</th></tr>";
				while ($row = $result->fetch_assoc())  {
					echo "<tr>";
		      echo "<td style='text-align:center'>".$row["first_name"]."</td>";
					echo "<td style='text-align:center'>".$row["last_name"]."</td>";
					echo "</tr>";
				}
				echo "</table>";
				echo "</center>";
				echo "</div>";
			}
		  echo "<center>";
		  echo "<br /><br /><a href='selectandView.php'>Back to Selecting</a>";
		  echo "</center>";
		}
	}
	//messed this up
	else if(isset($_POST["submitmin"])){
		if( (isset($_POST["fname"]) && $_POST["fname"] !== "") && (isset($_POST["lname"]) && $_POST["lname"] !== "")){

			//sets names to be the trimmed version of what you entered
			$first = $mysqli->real_escape_string(trim($_POST['fname']));
			$last = $mysqli->real_escape_string(trim($_POST['lname']));

			//create query to search for all of volunteers associated with that host

			if($_POST["fname"] !== "all" && $_POST["lname"] !== "none"){
				$query = "SELECT Host.first_name AS 'Host First Name', ";
				$query.= "Host.last_name AS 'Host Last Name', ";
				$query.="SUM(min_volunteers) AS 'Minimum Volunteers Needed' ";
				$query.="FROM Projects Join Host ON Projects.Host=Host.host_number ";
				$query.="WHERE first_name='".$first."' AND last_name='".$last."'";
			}
			else{
				$query = "SELECT Host.first_name AS 'Host First Name', ";
				$query.= "Host.last_name AS 'Host Last Name', ";
				$query.="SUM(min_volunteers) AS 'Minimum Volunteers Needed' ";
				$query.="FROM Projects Join ";
				$query.="Host ON Projects.Host=Host.host_number GROUP BY `Host` ORDER BY Host";
			}
			//execute query
			$result = $mysqli->query($query);

			//if result not empty
			if ($result && $result->num_rows > 0) {
				echo "<div class='row'>";
				echo "<center>";
				echo "<h2>Here are the minimum volunteers</h2>";
				echo "<table>";
				//output in a table the first and last name of each volunteer associated with the Host searched for
				//also show project number in case one host has multiple projects
				echo "<tr><th>First Name</th><th>Last Name</th><th>Minimum Number of Volunteers</th></tr>";
				while ($row = $result->fetch_assoc())  {
					echo "<tr>";
					echo "<td style='text-align:center'>".$row["Host First Name"]."</td>";
					echo "<td style='text-align:center'>".$row["Host Last Name"]."</td>";
					echo "<td style='text-align:center'>".$row["Minimum Volunteers Needed"]."</td>";
					echo "</tr>";
				}
				echo "</table>";
				echo "</center>";
				echo "</div>";
			}
			echo "<center>";
			//link to register a new volunteer -- later will be link to register another project
			echo "<br /><br /><a href='selectandView.php'>Back to Selecting</a>";
			echo "</center>";

	}
}
	else {
		//create form to search for volunteers of a specific host
			echo "<form method='POST' action='selectandView.php'>";

						// echo "First Name:<input type='text' name='fname' value='' />";
						echo "Select your first name:<select name='fname'>";
							echo "<option value = 'all'>Select All</option>";
								$query = "Select first_name, last_name from Host";
								$result = $mysqli->query($query);
								if($result && $result->num_rows >= 1){
									while($row=$result->fetch_assoc()){
										echo "<option value = '".$row['first_name']." ".$row["last_name"]."'>".$row['first_name']." ".$row['last_name']."</option>";
									}
								}
						echo "</select>";


					echo "<input type='submit' name='submit' class='button tiny round' value='Find Volunteers'>";
					echo "<br />";
					echo "<input type='submit' name='submitmin' class='button tiny round' value='Find Minimum Volunteers Needed'>";

    echo "</form>";

					// Part b.  Include <input> tags for each of the attributes in person:
					//                  First Name, Last Name, Birthdate, Birth City, Birth State, Region

				echo "<form method='POST' action='selectandView.php'>";

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

							echo "<input type='submit' name='submit' class='button tiny round' value='Find Volunteers'>";
		    echo "</form>";

	}
	echo "</label>";
	echo "</div>";
	//link back to bigevent.php
	echo "<br /><p>&laquo:<a href='bigevent.php'>Back to Main Page</a>";
?>


<?php new_footer("Who's Who", $mysqli); ?>
