<?php
	require_once("included_functions.php");
  require_once("session.php");
	new_header("Here are your team leaders!");
	$mysqli = db_connection();
	if (($output = message()) !== null) {
		echo $output;
	}
  $query = "Select * from Team_Leaders";

  $result=$mysqli->query($query);

	if ($result && $result->num_rows > 0) {
		echo "<div>";
		echo "<center>";
		echo "<br />";
		//sortable table of team leaders
		echo "<h2>Here are the team leaders</h2>";
		echo "<table id='projects' class='table table-striped table-bordered table-sm' cellspacing='0' width='80%'>";
		echo "<thead>";
		echo "<tr><th class='th-sm'>Team Leader Number<i class='fa fa-sort float-right' aria-hidden='true'></i></th><th class='th-sm'>First Name<i class='fa fa-sort float-right' aria-hidden='true'></i></th><th class='th-sm'>Last name<i class='fa fa-sort float-right' aria-hidden='true'></i></th><th>Phone Number</th><th>Email</th><th class='th-sm'>Project<i class='fa fa-sort float-right' aria-hidden='true'></i></th></tr>";
		echo "</thead>";
		echo "<tbody>";
		while ($row = $result->fetch_assoc())  {
			echo "<tr>";
      echo "<td style='text-align:center'>".$row["tl_number"]."</td>";
      echo "<td style='text-align:center'>".$row["tl_first_name"]."</td>";
      echo "<td style='text-align:center'>".$row["tl_last_name"]."</td>";
      echo "<td style='text-align:center'>".$row["phone"]."</td>";
      echo "<td style='text-align:center'>".$row["email"]."</td>";
      echo "<td>&nbsp;<a href='assignTLProject.php?num=".$row['tl_number']."'>".$row["tl_project"]."</a>&nbsp;&nbsp;</td>";
			echo "</tr>";
		}
		echo "</tbody>";
		echo "</table>";
		echo "</center>";
		echo "</div>";

	 echo "<center>";
	 //option to export team leaders to excel
	 echo "<div>";
        echo "<form class='form-horizontal' action='excelTL.php' method='post' name='upload_excel' enctype='multipart/form-data'>";
          	echo "<div class='form-group'>";
              	echo "<div class='col-md-4 col-md-offset-4'>";
                    echo "<input type='submit' name='Export' class='button tiny round' value='export to excel'/>";
                        echo "</div>";
               echo "</div>";
        echo "</form>";
	 echo "</div>";
	 echo "</center>";

	}
  echo "<center>";
  echo "<br /><br /><a href='execProjectView.php'>View Projects</a>";
  echo "</center>";
  echo "<br /><p>&laquo:<a href='index.php'>Back to Main Page</a>";

?>

<?php  new_footer("Volunteers", $mysqli); ?>
