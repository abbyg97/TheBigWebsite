<?php
	require_once("included_functions.php");
  require_once("session.php");
	new_header("Here are your projects!");
	$mysqli = db_connection();
	if (($output = message()) !== null) {
		echo $output;
	}

	$host_num=$_GET["id"];

	$query2="SELECT first_name, last_name from Host WHERE host_number=".$host_num;
	$result2=$mysqli->query($query2);
	while ($row = $result2->fetch_assoc())  {
		$first=$row["first_name"];
		$last=$row["last_name"];
	}

  $query="SELECT Project_Number, address, min_volunteers AS 'min', ";
  $query.="max_volunteers AS 'max', description, tools, additional_comments AS 'comments', ";
  $query.="rain, rain_proj, ";
  $query.="restriction_violation AS 'restrictions', proj_category.cat AS 'category' from Projects ";
  $query.="join proj_category on Projects.category=proj_category.number ";
  $query.="join Host on Projects.Host=Host.host_number WHERE Host.host_number=".$host_num;
	$result = $mysqli->query($query);

/********************    Uncomment Once Code Completed  **************************/

	if ($result && $result->num_rows > 0) {
		echo "<div class='row'>";
		echo "<center>";
    echo "<h2>Here are all projects for ".$first." ".$last."</h2>";
    echo "<table>";
    echo "<tr><th>Address</th><th>Minimum Volunteers</th><th>Maximum Volunteers</th><th>Description</th><th>Tools requested</th><th>Comments</th><th>Come if it rains?</th><th>Describe the project we would do on a rainy day</th><th>Restrictions</th><th>Category</th><th>Edit Link</th><th>Cancel Project</th></tr>";
    while ($row = $result->fetch_assoc())  {
      echo "<tr>";
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
      echo "<td>&nbsp;<a href='editProject.php?project=".urlencode($row["Project_Number"])."'>Edit</a>&nbsp;&nbsp;</td>";
      echo "<td>&nbsp;<a href='deleteProject.php?project=".urlencode($row["Project_Number"])."' onclick='return confirm('Are you sure?');'>Delete</a>&nbsp;&nbsp;</td>";
      echo "</tr>";
		}
		echo "</table>";
		echo "</center>";
		echo "</div>";
	}
  echo "<center>";
  echo "<br /><br /><a href='registerProject.php'>Register a Project</a>";
  echo "</center>";
?>

<?php  new_footer("Volunteers", $mysqli); ?>
