<?php
	require_once("included_functions.php");
  require_once("session.php");
	new_header("Here are your projects!");
	verify_login();
	$mysqli = db_connection();
	if (($output = message()) !== null) {
		echo $output;
	}

	//host number
	$host_num=$_GET["host"];

	//selects host information
  $query="SELECT * FROM Host WHERE host_number=".$host_num;
	$result = $mysqli->query($query);

		//sortable table
		//https://mdbootstrap.com/content/bootstrap-table-sort/
		//not really necessary because only one host
		echo "<div style='width: 90%; padding-left: 5%;'>";
		echo "<center>";
    echo "<h2>Here is the information for Host ".$host_num."</h2>";
		echo "<table id='projects' class='table table-striped table-bordered table-sm' cellspacing='0' width='100%'>";
		echo "<thead>";
		echo "<tr><th>First Name</th><th>Last Name</th><th>Phone Number</th><th>Second Number</th><th>Email</th><th>Alternate Contact</th><th>Alternate Phone Number</th><th>Alternate Email</th><th>Edit</th></tr>";
		echo "</thead>";
		echo "<tbody>";
		while ($row = $result->fetch_assoc())  {
      echo "<tr>";
      echo "<td style='text-align:center'>".$row["first_name"]."</td>";
      echo "<td style='text-align:center'>".$row["last_name"]."</td>";
      echo "<td style='text-align:center'>".$row["phone"]."</td>";
      echo "<td style='text-align:center'>".$row["second_phone"]."</td>";
      echo "<td style='text-align:center'>".$row["email"]."</td>";
      echo "<td style='text-align:center'>".$row["alt_first_name"]." ".$row["alt_last_name"]."</td>";
      echo "<td style='text-align:center'>".$row["alt_phone"]."</td>";
      echo "<td style='text-align:center'>".$row["alt_email"]."</td>";
			echo "<td>&nbsp;<a href='editHost.php?host=".urlencode($row["host_number"])."'>Edit</a>&nbsp;&nbsp;</td>";

      echo "</tr>";
      // echo "<td>&nbsp;<a href='delete.php?vol_number=".urlencode($row["vol_number"])." ' onclick='return confirm('Are you sure?');'>Delete</a>&nbsp;&nbsp;</td>";
      echo "</tr>";
		}
		echo "</tbody>";
		echo "</table>";
		echo "</center>";
		echo "</div>";

  echo "<center>";
	echo "<br /><br /><a href='registerProject.php?host=".$host_num."'>Register a Project</a>";
	echo "</center>";
  echo "<br /><br /><a href='execProjectView.php'>Back to Projects</a>";

?>

<?php  new_footer("Volunteers", $mysqli); ?>
