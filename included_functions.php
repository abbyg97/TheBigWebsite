
<?php
	function redirect_to($new_location) {
		header("Location: " . $new_location);
		exit;
	}

	function db_connection() {
		require_once("/home/agarrett/DBgarrett.php");
		$mysqli = new mysqli(DBHOST, USERNAME, PASSWORD, DBNAME);
		if($mysqli->connect_errno) {
			die("Could not connect to server!<br />");
		}
		else {
				//echo "Successful connection to ".DBNAME."<hr />";
		}
		return $mysqli;
	}

	function new_header($name="Default", $urlLink="") {
		echo "<head>";
		echo "	<title>$name</title>";
		//		<!-- Link to Foundation -->";
		echo "<link href='/~agarrett/MDB-Free_4.5.12/css/addons/datatables.min.css' rel='stylesheet'>";
		//original css imports
		echo "	<link rel='stylesheet' href='css/normalize.css'>";
		echo "	<link rel='stylesheet' href='css/foundation.css'>";
		echo "<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' integrity='sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm' crossorigin='anonymous'>";
		echo "<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js' charset='utf-8'></script>";
    echo "<script src='https://code.jquery.com/jquery-3.2.1.slim.min.js' integrity='sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN' crossorigin='anonymous'></script>";
    echo "<script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js' integrity='sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q' crossorigin='anonymous'></script>";
    echo "<script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js' integrity='sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl' crossorigin='anonymous'></script>";
		echo "<script type='text/javascript' src='/~agarrett/MDB-Free_4.5.12/js/addons/datatables.min.js'></script>";
		// echo "<script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js' integrity='sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ' crossorigin='anonymous'></script>";
		echo "<script type='text/javascript'>";
		echo "$(document).ready(function () {";
		  echo "$('#projects').DataTable({";
		    echo "'ordering': true";
		  echo "});";
		  echo "$('.dataTables_length').addClass('bs-select');";
		echo "});";
			echo "</script>";
		echo "<script src='js/vendor/modernizr.js'></script>";
		echo "</head>";
			echo "<nav class='navbar navbar-expand-lg navbar-dark bg-primary justify-content-between'>";
		  echo "<a class='navbar-brand' href='#'>The Big Event</a>";
		  echo "<button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>";
		    echo "<span class='navbar-toggler-icon'></span>";
		  echo "</button>";

		  echo "<div class='collapse navbar-collapse' id='navbarSupportedContent'>";
		    echo "<ul class='navbar-nav mr-auto'>";
		      echo "<li class='nav-item active'>";
		        echo "<a class='nav-link' href='/~agarrett/index.php'>Home <span class='sr-only'>(current)</span></a>";
		      echo "</li>";
		      echo "<li class='nav-item'>";
		        echo "<a class='nav-link' href='/~agarrett/register.php'>Volunteers</a>";
		      echo "</li>";
		      echo "<li class='nav-item'>";
		        echo "<a class='nav-link' href='/~agarrett/registerHost.php'>Host</a>";
		      echo "</li>";
		      echo "<li class='nav-item dropdown'>";
		        echo "<a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>";
		          echo "Executive Options";
		        echo "</a>";
		        echo "<div class='dropdown-menu' aria-labelledby='navbarDropdown'>";
		          echo "<a class='dropdown-item' href='/~agarrett/volunteer.php'>View Volunteers</a>";
		          echo "<a class='dropdown-item' href='/~agarrett/execProjectView.php'>View Projects</a>";
		          echo "<a class='dropdown-item' href='/~agarrett/teamleaders.php'>View Team Leaders</a>";
		          echo "<a class='dropdown-item' href='/~agarrett/uploadTL.php'>Upload Team Leaders</a>";
		          //<!-- <div class="dropdown-divider"></div> -->
		          echo "<a class='dropdown-item' href='groupVolunteers'>Search for a Specific Group</a>";
		        echo "</div>";
						// echo "<li class='nav-item'>";
			      //   echo "<a class='nav-link' href='/~agarrett/index.php'>Login</a>";
			      echo "</li>";
		      //echo "</li>";

					echo "<li class='nav-item dropdown'>";
						echo "<a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>";
							echo "Login";
						echo "</a>";
						echo "<div class='dropdown-menu' aria-labelledby='navbarDropdown'>";
							echo "<a class='dropdown-item' href='/~agarrett/bigevent.php'>Volunteer Login</a>";
							echo "<a class='dropdown-item' href='/~agarrett/hostLogin.php'>Host Login</a>";
							echo "<a class='dropdown-item' href='/~agarrett/orgLogin.php'>Organization Login</a>";
							echo "<a class='dropdown-item' href='/~agarrett/execLogin.php'>Exec Login</a>";
							//<!-- <div class="dropdown-divider"></div> -->
							//echo "<a class='dropdown-item' href='groupVolunteers'>Search for a Specific Group</a>";
						echo "</div>";
						// echo "<li class='nav-item'>";
						//   echo "<a class='nav-link' href='/~agarrett/index.php'>Login</a>";
						echo "</li>";
		    echo "</ul>";
		  echo "</div>";
		echo "</nav>";
		echo "<body>";
	}

	function new_footer($name="Default", $mysqli){
		echo "<br /><br /><br />";
	    echo "<h4><div class='text-center'><small>Copyright ".date("M Y").", ".$name."</small></div></h4>";
		echo "</body>";
		echo "</html>";
		//$mysqli -> close;
	}

	function print_alert($name="") {
		echo "<br />";
		echo "<div class='row'>";
		echo "<div data-alert class='alert-box info round'>".$name;

		echo "</div>";
		echo "</div>";

	}

	function password_encrypt($password) {
	  $hash_format = "$2y$10$";   // Use Blowfish with a "cost" of 10
	  $salt_length = 22; 					// Blowfish salts should be 22-characters or more
	  $salt = generate_salt($salt_length);
	  $format_and_salt = $hash_format . $salt;
	  $hash = crypt($password, $format_and_salt);
	  return $hash;
	}

	function generate_salt($length) {
	  // MD5 returns 32 characters
	  $unique_random_string = md5(uniqid(mt_rand(), true));

	  // Valid characters for a salt are [a-zA-Z0-9./]
	  $base64_string = base64_encode($unique_random_string);

	  // Replace '+' with '.' from the base64 encoding
	  $modified_base64_string = str_replace('+', '.', $base64_string);

	  // Truncate string to the correct length
	  $salt = substr($modified_base64_string, 0, $length);

		return $salt;
	}

	function password_check($password, $existing_hash) {
	  // existing hash contains format and salt at start
	  $hash = crypt($password, $existing_hash);
		$hash = substr($hash, 0, strlen($existing_hash));
	  if ($hash === $existing_hash) {
			//$_SESSION["message"] = "hash1 ".$hash;
	    return true;
	  }
	  else {
			//$_SESSION["message"] = "hash2 ".$hash." EXISTING ".$existing_hash;
	    return false;
	  }
	}

?>
