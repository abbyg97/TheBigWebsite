<?php
	require_once("./included_functions.php");
  require_once("session.php");
	new_header("Your Volunteers", "");
	$mysqli = db_connection();
	if (($output = message()) !== null) {
		echo $output;
	}

	echo "<h3>Check List</h3>";
	echo "<div class='row'>";
	echo "<label for='left-label' class='left inline'>";

  if (isset($_POST["submit"])) {
		if( (isset($_POST["fname"]) && $_POST["fname"] !== "") && (isset($_POST["lname"]) && $_POST["lname"] !== "")){

      $first = $mysqli->real_escape_string(trim($_POST['fname']));
      $last = $mysqli->real_escape_string(trim($_POST['lname']));

      $query = "SELECT Host.first_name As 'Host First Name', Host.last_name AS 'Host Last Name', ";
      $query.="GROUP_CONCAT(volunteers.first_name ORDER BY volunteers.first_name) AS 'First Name', ";
      $query.= "GROUP_CONCAT(volunteers.last_name ORDER BY volunteers.first_name) AS 'Last Name' FROM Host ";
      $query.= "JOIN Projects ON Projects.Host=Host.host_number ";
      $query.= "JOIN volunteers ON Projects.Project_Number=volunteers.project ";
      $query.= "WHERE Host.first_name='".$first."' AND Host.last_name = '".$last."' GROUP BY Host.first_name";

      echo $query;

      $result = $mysqli->query($query);

		if($result) {

			$_SESSION["message"] = $_POST["fname"]." ".$_POST["lname"]."'s Volunteers";
				header("Location: view.php");
				exit;

			}
			else {

			$_SESSION["message"] = "Error! Could not change ".$_POST["fname"]." ".$_POST["lname"];
			}
		}
		else {
			$_SESSION["message"] = "Unable to add person. Fill in all information!";
			header("Location: view.php");
			exit;
		}
	}
	else {
			echo "<form method='POST' action='select.php'>";

						echo "First Name:<input type='text' name='fname' value='' />";

						echo "Last Name:<input type='text' name='lname' value='' />";

					echo "<input type='submit' name='submit' class='button tiny round' value='Find Volunteers'>";

    echo "</form>";

					// Part b.  Include <input> tags for each of the attributes in person:
					//                  First Name, Last Name, Birthdate, Birth City, Birth State, Region



//////////////////////////////////////////////////////////////////////////////////////////////////

	}
	echo "</label>";
	echo "</div>";
	echo "<br /><p>&laquo:<a href='select.php'>Back to Main Page</a>";
?>


<?php new_footer("Who's Who", $mysqli); ?>
