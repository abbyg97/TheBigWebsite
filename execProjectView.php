<?php
	require_once("included_functions.php");
  require_once("session.php");
	new_header("Here are your volunteers!");
	$mysqli = db_connection();
	if (($output = message()) !== null) {
		echo $output;
	}

  $query="SELECT Project_number AS 'num', Host, address, min_volunteers AS 'min', ";
  $query.="max_volunteers AS 'max', 'transportation', description, tools, Projects.additional_comments AS 'comments', ";
  $query.="rain, rain_proj, ";
  $query.="proj_restriction.restriction AS 'restrictions', proj_category.cat AS 'category' from Projects join proj_restriction on Projects.restriction_violation=proj_restriction.number ";
  $query.="join proj_category on Projects.category=proj_category.number";
	//$query.="join Approvals on Approvals.project=Projects.Project_number";

	$result = $mysqli->query($query);

/********************    Uncomment Once Code Completed  **************************/
	if ($result && $result->num_rows > 0) {
		echo "<div class='row'>";
		echo "<center>";
    echo "<h2>Here are all projects</h2>";
    echo "<table>";
    echo "<tr><th>Project Number</th><th>Host Number</th><th>Address</th><th>Minimum Volunteers</th><th>Maximum Volunteers</th><th>Transportation required</th><th>Description</th><th>Tools requested</th><th>Comments</th><th>Come if it rains?</th><th>Describe the project we would do on a rainy day</th><th>Restrictions</th><th>Category</th><th>Approval Status</th></tr>";
    while ($row = $result->fetch_assoc())  {
      echo "<tr>";
			echo "<td style='text-align:center'>".$row["num"]."</td>";
      echo "<td style='text-align:center'>".$row["Host"]."</td>";
      echo "<td style='text-align:center'>".$row["address"]."</td>";
      echo "<td style='text-align:center'>".$row["min"]."</td>";
      echo "<td style='text-align:center'>".$row["max"]."</td>";
			echo "<td style='text-align:center'>".$row["transportation"]."</td>";
      echo "<td style='text-align:center'>".$row["description"]."</td>";
      echo "<td style='text-align:center'>".$row["tools"]."</td>";
      echo "<td style='text-align:center'>".$row["comments"]."</td>";
      echo "<td style='text-align:center'>".$row["rain"]."</td>";
      echo "<td style='text-align:center'>".$row["rain_proj"]."</td>";
      echo "<td style='text-align:center'>".$row["restrictions"]."</td>";
      echo "<td style='text-align:center'>".$row["category"]."</td>";
			echo "<td style='text-align:center'>".$row["status"]."</td>";
      echo "</tr>";
      // echo "<td>&nbsp;<a href='edit.php?vol_number=".urlencode($row["vol_number"])."'>Edit</a>&nbsp;&nbsp;</td>";
      // echo "<td>&nbsp;<a href='delete.php?vol_number=".urlencode($row["vol_number"])." ' onclick='return confirm('Are you sure?');'>Delete</a>&nbsp;&nbsp;</td>";
		}
		echo "</table>";
		echo "</center>";
		echo "</div>";
	}
  echo "<center>";
  echo "<br /><br /><a href='select.php'>Register a Volunteer</a>";
  echo "</center>";
?>

<?php  new_footer("Volunteers", $mysqli); ?>
