<?php
	require_once("included_functions.php");
  require_once("session.php");
	new_header("Here are your volunteers!");
	$mysqli = db_connection();
	if (($output = message()) !== null) {
		echo $output;
	}

  $query="SELECT Project_Number AS 'num', Host, address, min_volunteers AS 'min', ";
  $query.="max_volunteers AS 'max', Transportation.type as transportation, description, tools, Projects.additional_comments AS 'comments', ";
  $query.="rain, rain_proj, ";
  $query.="restriction_violation AS 'restrictions', proj_category.cat AS 'category', Approvals.status from Projects ";
  $query.="join proj_category on Projects.category=proj_category.number ";
	$query.="left outer join Transportation on Projects.transportation=Transportation.number ";
	$query.="right outer join Approvals on Approvals.project=Projects.Project_Number";
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
      // echo "<td style='text-align:center'>".$row["Host"]."</td>";
			echo "<td>&nbsp;<a href='Hosts.php?host=".$row['Host']."'>".$row["Host"]."</a>&nbsp;&nbsp;</td>";
      echo "<td style='text-align:center'>".$row["address"]."</td>";
      echo "<td style='text-align:center'>".$row["min"]."</td>";
      echo "<td style='text-align:center'>".$row["max"]."</td>";
			if($row["transportation"] == NULL){
				echo "<td>&nbsp;<a href='transport.php?project=".$row['num']."'>None</a>&nbsp;&nbsp;</td>";
			}
			else{
				echo "<td>&nbsp;<a href='transport.php?project=".$row['num']."'>".$row["transportation"]."</a>&nbsp;&nbsp;</td>";
			}
      echo "<td style='text-align:center'>".$row["description"]."</td>";
      echo "<td style='text-align:center'>".$row["tools"]."</td>";
      echo "<td style='text-align:center'>".$row["comments"]."</td>";
      echo "<td style='text-align:center'>".$row["rain"]."</td>";
      echo "<td style='text-align:center'>".$row["rain_proj"]."</td>";
      echo "<td style='text-align:center'>".$row["restrictions"]."</td>";
      echo "<td style='text-align:center'>".$row["category"]."</td>";
			// echo "<td style='text-align:center'>".$row["status"]."</td>";
			echo "<td>&nbsp;<a href='approvals.php?project=".$row['num']."'>".$row["status"]."</a>&nbsp;&nbsp;</td>";
			echo "<td>&nbsp;<a href='editProject.php?project=".urlencode($row["num"])."'>Edit</a>&nbsp;&nbsp;</td>";
			echo "<td>&nbsp;<a href='deleteProject.php?project=".urlencode($row["num"])."' onclick='return confirm('Are you sure?');'>Delete</a>&nbsp;&nbsp;</td>";
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
