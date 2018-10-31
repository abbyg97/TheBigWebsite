<?php
	require_once("included_functions.php");
  require_once("session.php");
	new_header("Here is who has registered!");
	$mysqli = db_connection();
	if (($output = message()) !== null) {
		echo $output;
	}

  $query="Select * from Committee_Members";
  $result= $mysqli->query($query);


    if ($result && $result->num_rows > 0) {
      echo "<div class='row'>";
      echo "<center>";
      echo "<h2>Here are the team leaders</h2>";
      echo "<table>";
      echo "<tr><th>First Name</th><th>Last name</th><th>View Approvals</th></tr>";
      while ($row = $result->fetch_assoc())  {
        echo "<tr>";
        echo "<td style='text-align:center'>".$row["first_name"]."</td>";
        echo "<td style='text-align:center'>".$row["last_name"]."</td>";
        echo "<td>&nbsp;<a href='approverView.php?project=&approver=".$row["number"]."'>Approvals</a>&nbsp;&nbsp;</td>";
        echo "</tr>";
      }

      echo "</center>";
      echo "</div>";

  }

	echo "<br /><br /><p>&laquo:<a href='index.php'>Back to Main Page</a>";

?>

<?php  new_footer("Committee Members", $mysqli); ?>
