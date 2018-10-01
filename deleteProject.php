<?php
	require_once("included_functions.php");
  require_once("session.php");

	//verify_login();
	new_header("Projects", "");
	$mysqli = db_connection();
	if (($output = message()) !== null) {
		echo $output;
	}

  if (isset($_GET["project"]) && $_GET["project"] !== "") {
 		$num = $_GET["project"];

    $query2 = "DELETE FROM Approvals WHERE project = ".$num;
		$result2 = $mysqli->query($query2);

		$query = "DELETE FROM Projects WHERE Project_Number = ".$num;
		// Execute query
		$result = $mysqli->query($query);
//////////////////////////////////////////////////////////////////////////////////////
		if ($result && $result2 && $mysqli->affected_rows === 1) {
			$_SESSION["message"] = "Project successfully deleted!";
			$output = message();
			echo $output;
			echo "<br /><br /><p>&laquo:<a href='bigevent.php'>Back to Main Page</a>";

		}
		else {
		$_SESSION["message"] = "Project could not be deleted!";
		redirect_to("viewHostProjects.php?id=".$num);
		exit;
		}
	}
	else {
		$_SESSION["message"] = "Project could not be found!";
		redirect_to("viewHostProjects.php?id=".$num);
		exit;
	}

?>

<?php  new_footer("Volunteers", $mysqli); ?>
