<?php
	require_once("./included_functions.php");
  require_once("session.php");
	new_header("Edit Host", "");
	//outputs message letting you know if it worked or not
	$mysqli = db_connection();
	if (($output = message()) !== null) {
		echo $output;
	}

  $ID=$_GET["host"];

	//puts in headers on web page
	echo "<h3>Edit Information</h3>";
	echo "<div class='row'>";
	echo "<label for='left-label' class='left inline'>";

	//condition to check if you submited something
  if (isset($_POST["submit"])) {
		//makes sure you filled in all boxes
		if( (isset($_POST["fname"]) && $_POST["fname"] !== "") && (isset($_POST["lname"]) && $_POST["lname"] !== "") && (isset($_POST["number"]) && $_POST["number"] !== "") && (isset($_POST["email"]) && $_POST["email"] !== "") && (isset($_POST["alt_fname"]) && $_POST["alt_fname"] !== "") && (isset($_POST["alt_lname"]) && $_POST["alt_lname"] !== "") && (isset($_POST["alt_phone"]) && $_POST["alt_phone"] !== "") && (isset($_POST["alt_email"]) && $_POST["alt_email"] !== "")){

				//creates query to find the max volunteer number in order to later increment it
        $max = "Select max(host_number) AS max from Host";
        $result2 = $mysqli->query($max);
				//sets max2 to max+ 1 so that that will be the new volunteer number
        if($result2 && $result2->num_rows >= 1){
          while($row=$result2->fetch_assoc()){
            $max2 = $row['max'] + 1;
          }
        }
				//create query to insert the person into the database
				//(no project number assigned because that does not occur at registration)
				//https://stackoverflow.com/questions/6278296/extract-numbers-from-a-string -- for formatting phone number
				$query = "Update Host Set ";
				//$query .= "host_number=".$max2.", ";
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

				//checks if there is a result
		// if($result) {
		// 	//if added to the database posts and redirects to volunteer table
		// 	// $_SESSION["message"] = $_POST["fname"]." ".$_POST["lname"]." has been registered";
		// 	if (isset($_POST["username"]) && $_POST["username"] !== "" && isset($_POST["password"]) &&
		// 			$_POST["password"] !== "") {
		// 			//Grab posted values for username and password. Immediately encrypt the password so that
		// 			// it is set up to compare with the encrypted password in the database Use password_encrypt
		// 			$username = $_POST["username"];
		// 			$password = password_encrypt($_POST["password"]);
		// 			//Check to make sure user does not already exist
		// 			$query = "SELECT * FROM ";
		// 			$query .= "hostLogin WHERE ";
		// 			$query .= "username = '".$username."' ";
		// 			$query .= "LIMIT 1";
		// 			$result = $mysqli->query($query);
		// 			//User exists so output that the user already exists
		// 			if ($result && $result->num_rows > 0) {
		// 				$_SESSION["message"] = "The username already exists";
		// 				redirect_to("addLogin.php");
		// 			}
		// 			//User does not already exist so add to admins table
		// 			else {
		// 				// $query2="Select host_number from Host where first_name=".$_POST["first_name"]." and last_name=".$POST_["last_name"];
		// 				// $result2 = $mysqli->query($query2);
		// 				// while($row2=$result2->fetch_assoc()){
		// 				// 	$number = $row2['host_number'];
		// 				// }
		// 				$query = "INSERT INTO hostLogin ";
		// 				$query .= "(username, password, permissions, host_num) ";
		// 				//ended here
		// 				$query .= "VALUES ('".$username."', '".$password."', 3, ".$max2.")";
		// 				$result = $mysqli->query($query);
		// 				if ($result) {
		// 					// $_SESSION["message"] = "User successfully added";
		// 					// redirect_to("bigevent.php");
		// 					redirect_to("viewHostProjects.php?id=".$max2);
		// 					exit;
		// 				}
		// 				else {
		// 					$_SESSION["message"] = "Could not add user!";
		// 					redirect_to("addLogin.php");
		// 			}
		// 		}
    //
    //
		// 	}

		}
	}
		else {
			//sets message to remind you to fill in all boxes if you forgot one
			// $_SESSION["message"] = "Unable to add person. Fill in all information!";
      $query= "Select * from Host where host_number=".$ID;
      $result = $mysqli->query($query);
      $row = $result->fetch_assoc();

			echo "<form method='POST' action='editHost.php?host=".$ID."' style='padding-left: 15%;'>";

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

	//else {
		//creates form

	// 		echo "<form method='POST' action='registerHost.php' style='padding-left: 15%;'>";
  //
	// 					echo "First Name:<input type='text' name='fname' value='' />";
  //
	// 					echo "Last Name:<input type='text' name='lname' value='' />";
  //
	// 					echo "Username:<input type='text' name='username' value='' />";
  //
	// 					echo "Password:<input type='password' name='password' value='' />";
  //
	// 					echo "Phone Number:<input type='text' name='number' value='' />";
  //
	// 					echo "Second Number:<input type='text' name='sec_num' value='' />";
  //
	// 					echo "Email:<input type='text' name='email' value='' />";
  //
  //           echo "Please enter alternate contact information  <br></br>";
  //
  //           echo "First Name:<input type='text' name='alt_fname' value='' />";
  //
	// 					echo "Last Name:<input type='text' name='alt_lname' value='' />";
  //
	// 					echo "Phone Number:<input type='text' name='alt_phone' value='' />";
  //
	// 					echo "Email:<input type='text' name='alt_email' value='' />";
  //
	// 				echo "<input type='submit' name='submit' class='button tiny round' value='Register'>";
  //
  //
  //   echo "</form>";
  //
  //
	// }
	echo "</label>";
	echo "</div>";
	//adds link back to main page where you can navigate to what you want to do
	echo "<br /><p>&laquo:<a href='index.php'>Back to Main Page</a>";
?>


<?php new_footer("Who's Who", $mysqli); ?>
