<?php
	require_once("./included_functions.php");
  require_once("session.php");
	new_header("Edit Host", "");
	verify_login();
	//outputs message letting you know if it worked or not
	$mysqli = db_connection();
	if (($output = message()) !== null) {
		echo $output;
	}

  $ID=$_GET["host"];

	//puts in headers on web page
	echo "<div style='width: 65%; padding-left: 35%;'>";
	echo "<center>";
	echo "<h3>Edit Your Information</h3>";
	echo "</center>";
	echo "<div style='text-align: left;'>";

	//condition to check if you submited something
  if (isset($_POST["submit"])) {
		//makes sure you filled in all boxes
		if( (isset($_POST["fname"]) && $_POST["fname"] !== "") && (isset($_POST["lname"]) && $_POST["lname"] !== "") && (isset($_POST["number"]) && $_POST["number"] !== "") && (isset($_POST["email"]) && $_POST["email"] !== "") && (isset($_POST["alt_fname"]) && $_POST["alt_fname"] !== "") && (isset($_POST["alt_lname"]) && $_POST["alt_lname"] !== "") && (isset($_POST["alt_phone"]) && $_POST["alt_phone"] !== "") && (isset($_POST["alt_email"]) && $_POST["alt_email"] !== "")){

				//https://stackoverflow.com/questions/6278296/extract-numbers-from-a-string -- for formatting phone number
				$query = "Update Host Set ";
				//$query .= "host_number=".$max2.", "; //host_number auto_incremented
        $query .= "first_name='".$_POST["fname"]."', ";
        $query .= "last_name='".$_POST["lname"]."', ";
        $query .= "phone=".preg_replace('/[^0-9]/', '', $_POST["number"]).", ";
        if($_POST["sec_num"] !== ""){
          $query .= "second_phone=".preg_replace('/[^0-9]/', '', $_POST["sec_num"]).", ";
        }
        $query .= "email='".$_POST["email"]."', ";
        $query .= "alt_first_name='".$_POST["alt_fname"]."', ";
        $query .= "alt_last_name='".$_POST["alt_lname"]."', ";
        $query .= "alt_phone=".preg_replace('/[^0-9]/', '', $_POST["alt_phone"]).", ";
        $query .= "alt_email='".$_POST["alt_email"]."' where host_number=".$ID;

        echo $query;

				//execute query
				$result = $mysqli->query($query);
        if($result){
          $_SESSION["message"] = $_POST["fname"]." ".$_POST["lname"]." has been updated";
          redirect_to("viewHostProjects.php?id=".$ID);
        }
        else {
  				//if a problem occured with adding to the database
  			     $_SESSION["message"] = "Error! Could not register ".$_POST["fname"]." ".$_POST["lname"];
  			}

		}
	}
		else {
			//sets message to remind you to fill in all boxes if you forgot one
			// $_SESSION["message"] = "Unable to add person. Fill in all information!";
      $query= "Select * from Host where host_number=".$ID;
      $result = $mysqli->query($query);
      $row = $result->fetch_assoc();

			echo "<form method='POST' action='editHost.php?host=".$ID."'>";

						echo "First Name:<input type='text' name='fname' value='".$row['first_name']."' />";

						echo "Last Name:<input type='text' name='lname' value='".$row['last_name']."' />";

						// echo "Username:<input type='text' name='username' value='".$row['username']."' />";
            //
						// echo "Password:<input type='password' name='password' value='' />";

						echo "Phone Number:<input type='text' name='number' value='".$row['phone']."' />";

						echo "Second Number:<input type='text' name='sec_num' value='".$row['second_phone']."' />";

						echo "Email:<input type='text' name='email' value='".$row['email']."' />";

            echo "Please enter alternate contact information  <br></br>";

            echo "First Name:<input type='text' name='alt_fname' value='".$row['alt_first_name']."' />";

						echo "Last Name:<input type='text' name='alt_lname' value='".$row['alt_last_name']."' />";

						echo "Phone Number:<input type='text' name='alt_phone' value='".$row['alt_phone']."' />";

						echo "Email:<input type='text' name='alt_email' value='".$row['alt_email']."' />";

					echo "<input type='submit' name='submit' class='button tiny round' value='Update'>";


    echo "</form>";
		//header("Location: registerHost.php");
			//exit;

		}

	//echo "</label>";
	echo "</div>";
	echo "</div>";
	//adds link back to main page where you can navigate to what you want to do
	echo "<br /><p>&laquo:<a href='index.php'>Back to Main Page</a>";
?>


<?php new_footer("Who's Who", $mysqli); ?>
