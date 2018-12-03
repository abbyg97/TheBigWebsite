<?php
	require_once("./included_functions.php");
  require_once("session.php");
	//new header
	new_header("Your Volunteers", "");
	$mysqli = db_connection();
	if (($output = message()) !== null) {
		echo $output;
	}
	//organization number
  $org = $_GET['org'];

//query to get volunteers associated with the organization selected
$query="select volunteers.first_name, volunteers.last_name, Organization.name as 'name' from volunteers ";
$query.="join Organization on volunteers.organization=Organization.number WHERE Organization.number=";
$query.=$org." ORDER BY volunteers.last_name ASC";

//execute query
$result = $mysqli->query($query);

//if result not empty create table with volunteer first and last name
if ($result && $result->num_rows > 0) {
  echo "<div>";
  echo "<center>";
  //gets name associated with organization number
	$query2="Select name from Organization where number=".$org;
	$result2=$mysqli->query($query2);
	$row2 = $result2->fetch_assoc();

	//sortable table of volunteers registered under that organization
  echo "<h2>Here are the volunteers for ".$row2['name']."</h2>";
	echo "<div style='width: 25%;'>";
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
	echo "</div>";
  echo "</center>";
  echo "</div>";
}
echo "<center>";
if (isset($_SESSION["username"]) && isset($_SESSION["permission"]) && $_SESSION["permission"] === "4") {
	echo "<br /><br /><a href='groupVolunteers.php'>Back to Selecting</a>";
}
echo "</center>";
