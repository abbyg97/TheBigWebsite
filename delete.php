<?php
	require_once("included_functions.php");
  require_once("session.php");
	//from session.php -- makes sure user is logged in
	verify_login();
	new_header("Here is Who's who!", "");
	$mysqli = db_connection();
	if (($output = message()) !== null) {
		echo $output;
	}

  if (isset($_GET["vol_number"]) && $_GET["vol_number"] !== "") {
		//variable to hold volunteer number passed in url
 		$ID = $_GET["vol_number"];

		//deletes the volunteer specified by the volunteer number
		$query = "DELETE FROM volunteers WHERE vol_number = ".$ID;

		// Execute query
		$result = $mysqli->query($query);

		//as long as only one person is deleted the user is succesfully deleted
		if ($result && $mysqli->affected_rows === 1) {
			$_SESSION["message"] = "Person successfully deleted!";
			$output = message();
			echo $output;
			echo "<br /><br /><p>&laquo:<a href='index.php'>Back to Main Page</a>";
		}

		else {
			$_SESSION["message"] = "Person could not be deleted!";
			redirect_to("register.php");
			exit;
		}

	}

	//this would only be if there is an error in passing the volunteer number in the url
	else {
		$_SESSION["message"] = "Person could not be found!";
		redirect_to("register.php");
		exit;
	}

?>

<?php  new_footer("Volunteers", $mysqli); ?>
