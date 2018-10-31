<?php
	require_once("included_functions.php");
  require_once("session.php");
	new_header("Here is who has registered!");
	$mysqli = db_connection();
	if (($output = message()) !== null) {
		echo $output;
	}


	//****************  Add Query
	//  Query people to select PersonID, FirstName, and LastName, sorting in ascending order by LastName
	$query = "SELECT first_name, last_name, vol_number from volunteers ORDER BY last_name ASC";
	$result = $mysqli->query($query);

	//  Execute query


/********************    Uncomment Once Code Completed  **************************/
	if ($result && $result->num_rows > 0) {
		echo "<div>";
		echo "<center>";
		echo "<h2>Here are the volunteers</h2>";
		echo "<table id='projects' class='table table-striped table-bordered table-sm' cellspacing='0' width='50%'>";
		echo "<thead>";
		echo "<tr><th class='th-sm'>First Name<i class='fa fa-sort float-right' aria-hidden='true'></th><th class='th-sm'>Last Name<i class='fa fa-sort float-right' aria-hidden='true'></th><th>Edit Info</th></tr>";
		echo "</thead>";
		echo "<tbody>";
		while ($row = $result->fetch_assoc())  {
			echo "<tr>";
			echo "<td style='text-align:center'>".$row["first_name"]."</td>";
			echo "<td style='text-align:center'>".$row["last_name"]."</td>";

			//Output FirstName and LastName


			//Create an Edit and Delete link
			// echo "<td>&nbsp;<a href='editPeople.php?id=".urlencode($row["PersonID"])."'>Edit</a>&nbsp;&nbsp;</td>";
			// echo "<td>&nbsp;<a href='deletePeople.php?id=".urlencode($row["PersonID"])." ' onclick='return confirm('Are you sure?');'>Delete</a>&nbsp;&nbsp;</td>";
			//Edit should direct to editPeople.php, sending PersonID in URL
			//Delete should direct to deletePeople.php, sending PersonID in URL - include onclick to confirm delete
      echo "<td>&nbsp;<a href='edit.php?vol_number=".urlencode($row["vol_number"])."'>Edit</a>&nbsp;&nbsp;</td>";
      //echo "<td>&nbsp;<a href='delete.php?vol_number=".urlencode($row["vol_number"])." ' onclick='return confirm('Are you sure?');'>Delete</a>&nbsp;&nbsp;</td>";

			echo "</tr>";
		}
		echo "</tbody>";
		echo "</table>";
		echo "</center>";
		echo "</div>";
	}
  echo "<center>";
  echo "<br /><br /><a href='register.php'>Register a Volunteer</a>";
  echo "</center>";

	echo "<br /><br /><p>&laquo:<a href='index.php'>Back to Main Page</a>";

?>

<?php  new_footer("Volunteers", $mysqli); ?>
