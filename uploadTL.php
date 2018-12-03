<?php
	require_once("./included_functions.php");

  require_once("session.php");
	new_header("Transportation Assignment", "");
	//outputs message letting you know if it worked or not
	$mysqli = db_connection();
	if (($output = message()) !== null) {
		echo $output;
	}

	//puts in headers on web page
	echo "<center>";
	echo "<h3>Upload Team Leader Information</h3>";
	echo "<br />";
	echo "<div>";
	//echo "<label for='left-label' class='left inline'>";

	//condition to check if you submited something
	//formatting all wrong for query to execute

  if (isset($_FILES['teamleaders'])) {

		//deletes all team leaders before uploading file
		$query = "DELETE from Team_Leaders";
		$result = $mysqli->query($query);

		//https://stackoverflow.com/questions/5593473/how-to-upload-and-parse-a-csv-file-in-php
		$tmpName = $_FILES['teamleaders']['tmp_name'];

		if($_FILES['teamleaders']['size']>0){
			//could run into format issues because I manually adjusted the csv get_included_files
			//https://www.cloudways.com/blog/import-export-csv-using-php-and-mysql/
			$tls = fopen($tmpName, "r");
			//splits data by , in order to populate database
			while(($getData = fgetcsv($tls, 1000, ",")) !== FALSE){
				$sql = "INSERT INTO Team_Leaders VALUES (".$getData[0].", '".$getData[1]."', '".$getData[2]."', ".$getData[3].", '".$getData[4]."', ".$getData[5].")";
				$result = $mysqli->query($sql);
				if($result)
				{
					echo "<script type=\"text/javascript\">
					alert(\"CSV File has been successfully Imported.\");
					window.location = \"teamleaders.php\"
				</script>";
				}
				else {
					echo "<script type=\"text/javascript\">
							alert(\"Invalid File:Please Upload CSV File.\");
							window.location = \"uploadTL.php\"
							</script>";
				}
	     }

	         fclose($file);
		}

  }
  //
	else {
		//creates form
    echo "<form action='' method='POST' enctype='multipart/form-data'>";
			echo "<center>";
       echo "<input type='file' name='teamleaders' />";
			 echo "</center>";
       // echo "<input type='submit'/>";
			 echo "<input type='submit' class='button tiny round' value='Upload'>";
    echo "</form>";
  }


	// }
	//echo "</label>";
	echo "</div>";
	echo "</center>";
	//adds link back to main page where you can navigate to what you want to do
	echo "<br /><p>&laquo:<a href='execProjectView.php'>Back to Projects</a>";

	echo "<br /><p>&laquo:<a href='index.php'>Back to Main Page</a>";
?>


<?php new_footer("Who's Who", $mysqli); ?>
