<?php
	require_once("included_functions.php");
  require_once("session.php");

	//verify_login();
	new_header("Here is Who's who!", "");
	$mysqli = db_connection();
	if (($output = message()) !== null) {
		echo $output;
	}

  	if (isset($_GET["vol_number"]) && $_GET["vol_number"] !== "") {
 		$ID = $_GET["vol_number"];
//////////////////////////////////////////////////////////////////////////////////////
		// Create a query to delete this id from persons

		$query = "DELETE FROM volunteers WHERE vol_number = ".$ID;


		// Execute query
		$result = $mysqli->query($query);
//////////////////////////////////////////////////////////////////////////////////////
		if ($result && $mysqli->affected_rows === 1) {
			$_SESSION["message"] = "Person successfully deleted!";
			$output = message();
			echo $output;
			echo "<br /><br /><p>&laquo:<a href='bigevent.php'>Back to Main Page</a>";

		}
		else {
		$_SESSION["message"] = "Person could not be deleted!";
		redirect_to("register.php");
		exit;
		}
	}
	else {
		$_SESSION["message"] = "Person could not be found!";
		redirect_to("register.php");
		exit;
	}



?>

<?php  new_footer("Volunteers", $mysqli); ?>
