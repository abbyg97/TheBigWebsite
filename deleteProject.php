<?php
	require_once("included_functions.php");
  require_once("session.php");

	verify_login();
	new_header("Projects", "");
	$mysqli = db_connection();
	if (($output = message()) !== null) {
		echo $output;
	}

	//as long as a project has been selected
  if (isset($_GET["project"]) && $_GET["project"] !== "") {
		//project number
 		$num = $_GET["project"];
		//host number associated with the given project
		$host = $_GET["host"];

		//must delete this projects information from approval table because of dependencies
    $query2 = "DELETE FROM Approvals WHERE project = ".$num;
		$result2 = $mysqli->query($query2);

		//must delete team leader who is on this project -- later should change this to null if possible
		$query3 = "DELETE FROM Team_Leaders WHERE tl_project = ".$num;
		$result3 = $mysqli->query($query3);

		//must set project number to null for volunteers who were supposed to be on the project to be deleted
		$query4 = "update volunteers set project=NULL where project=".$num;
		$result4 = $mysqli->query($query4);

		//finally delete project
		$query = "DELETE FROM Projects WHERE Project_Number = ".$num;
		// Execute query
		$result = $mysqli->query($query);
//////////////////////////////////////////////////////////////////////////////////////
		if ($result && $result2 && $mysqli->affected_rows === 1) {
			//if deleted redirect to the hosts registered projects
			$_SESSION["message"] = "Project successfully deleted!";
			redirect_to("viewHostProjects.php?id=".$host);
			exit;
		}

		else {
			//otherwise let user know you were unable to delete project
			$_SESSION["message"] = "Could not delete project";
			redirect_to("viewHostProjects.php?id=".$host);
			exit;
		}
	}
	else {
		$_SESSION["message"] = "Project could not be found!";
		redirect_to("viewHostProjects.php?id=".$host);
		exit;
	}

?>

<?php  new_footer("Volunteers", $mysqli); ?>
