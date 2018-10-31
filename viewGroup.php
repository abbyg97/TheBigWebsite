<?php
	require_once("./included_functions.php");
  require_once("session.php");
	//new header
	new_header("Your Volunteers", "");
	$mysqli = db_connection();
	if (($output = message()) !== null) {
		echo $output;
	}

  $org = $_GET['org'];

$query="select volunteers.first_name, volunteers.last_name, Organization.name as 'name' from volunteers ";
$query.="join Organization on volunteers.organization=Organization.number WHERE Organization.number=";
$query.=$org." ORDER BY volunteers.last_name ASC";

//execute query
$result = $mysqli->query($query);

//if result not empty create table with volunteer first and last name
if ($result && $result->num_rows > 0) {
  echo "<div>";
  echo "<center>";
  //$row = $result->fetch_assoc();
	$query2="Select name from Organization where number=".$org;
	$result2=$mysqli->query($query2);
	$row2 = $result2->fetch_assoc();
  echo "<h2>Here are the volunteers for ".$row2['name']."</h2>";
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
