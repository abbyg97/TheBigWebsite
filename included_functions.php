
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
				echo "Successful connection to ".DBNAME."<hr />";
		}
		return $mysqli;
	}

	function new_header($name="Default", $urlLink="") {
		echo "<head>";
		echo "	<title>$name</title>";
		//		<!-- Link to Foundation -->";
		echo "	<link rel='stylesheet' href='css/normalize.css'>";
		echo "	<link rel='stylesheet' href='css/foundation.css'>";

		echo "	<script src='js/vendor/modernizr.js'></script>";
		echo "</head>";
		echo "<body>";
		echo "<div class='contain-to-grid sticky'>";
		echo "<nav class='top-bar' data-topbar data-options='sticky_on: large'>";
		echo "<ul class='title-area'>";
		echo "<li class='name'>";
		echo "  <h1 align='left'><a href='/~agarrett/".$urlLink."'>$name</a></h1>";
		echo "</li>";
		echo "</ul>";
		echo "</nav>";
		echo "</div>";
		echo "<body>";
	}

	function new_footer($name="Default", $mysqli){
		echo "<br /><br /><br />";
	    echo "<h4><div class='text-center'><small>Copyright ".date("M Y").", ".$name."</small></div></h4>";
		echo "</body>";
		echo "</html>";
		$mysqli -> close;
	}

	function print_alert($name="") {
		echo "<br />";
		echo "<div class='row'>";
		echo "<div data-alert class='alert-box info round'>".$name;

		echo "</div>";
		echo "</div>";

	}

?>
