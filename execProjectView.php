<?php
	require_once("included_functions.php");
  require_once("session.php");
	verify_login();

	new_header("Here are your volunteers!");
	$mysqli = db_connection();
	if (($output = message()) !== null) {
		echo $output;
	}

	//query to select all projects and join tables to have all necessary information about a project in one view
  $query="SELECT Project_Number AS 'num', Host, address, min_volunteers AS 'min', ";
  $query.="max_volunteers AS 'max', Transportation.type as transportation, description, tools, Projects.additional_comments AS 'comments', ";
  $query.="rain, rain_proj, ";
  $query.="restriction_violation AS 'restrictions', proj_category.cat AS 'category', Approvals.status from Projects ";
  $query.="join proj_category on Projects.category=proj_category.number ";
	$query.="left outer join Transportation on Projects.transportation=Transportation.number ";
	$query.="right outer join Approvals on Approvals.project=Projects.Project_Number";

	$result = $mysqli->query($query);

	//if query successful output in sortable table
	if ($result && $result->num_rows > 0) {
		echo "<div>";
		echo "<center>";
    echo "<h2>Here are all projects</h2>";
		echo "</center>";
		echo "<div class='scrollable'>";
		//https://mdbootstrap.com/content/bootstrap-table-sort/
		//thead, tbody, td, th, full table line necessary to make sortable
    echo "<table id='projects' class='table table-striped table-bordered table-sm' cellspacing='0' width='100%'>";
		echo "<thead>";
    echo "<tr><th class='th-sm'>Project Number<i class='fa fa-sort float-right' aria-hidden='true'></i></th><th class='th-sm'>Host Number<i class='fa fa-sort float-right' aria-hidden='true'></i></th><th class='th-sm'>Address<i class='fa fa-sort float-right' aria-hidden='true'></i></th><th class='th-sm'>Minimum Volunteers<i class='fa fa-sort float-right' aria-hidden='true'></i></th><th class='th-sm'>Maximum Volunteers<i class='fa fa-sort float-right' aria-hidden='true'></i></th><th class='th-sm'>Transportation required<i class='fa fa-sort float-right' aria-hidden='true'></i></th><th class='th-sm'>Description<i class='fa fa-sort float-right' aria-hidden='true'></i></th><th class='th-sm'>Tools requested<i class='fa fa-sort float-right' aria-hidden='true'></i></th><th class='th-sm'>Comments<i class='fa fa-sort float-right' aria-hidden='true'></i></th><th class='th-sm'>Come if it rains?<i class='fa fa-sort float-right' aria-hidden='true'></i></th><th class='th-sm'>Rainy Day Project<i class='fa fa-sort float-right' aria-hidden='true'></i></th><th class='th-sm'>Restrictions<i class='fa fa-sort float-right' aria-hidden='true'></i></th><th class='th-sm'>Category<i class='fa fa-sort float-right' aria-hidden='true'></i></th><th class='th-sm'>Approval Status<i class='fa fa-sort float-right' aria-hidden='true'></i></th><th>Edit Project</th><th>Delete Project</th></tr>";
		echo "</thead>";
		echo "<tbody>";
		while ($row = $result->fetch_assoc())  {
      echo "<tr>";
			echo "<td style='text-align:center'>".$row["num"]."</td>";
			//link to view host information
			echo "<td>&nbsp;<a href='Hosts.php?host=".$row['Host']."'>".$row["Host"]."</a>&nbsp;&nbsp;</td>";
      echo "<td style='text-align:center'>".$row["address"]."</td>";
      echo "<td style='text-align:center'>".$row["min"]."</td>";
      echo "<td style='text-align:center'>".$row["max"]."</td>";
			//has link to change transportation assignment
			if($row["transportation"] == NULL){
				echo "<td>&nbsp;<a href='transport.php?project=".$row['num']."'>None</a>&nbsp;&nbsp;</td>";
			}
			else{
				echo "<td>&nbsp;<a href='transport.php?project=".$row['num']."'>".$row["transportation"]."</a>&nbsp;&nbsp;</td>";
			}
      echo "<td style='text-align:center'>".$row["description"]."</td>";
      echo "<td style='text-align:center'>".$row["tools"]."</td>";
      echo "<td style='text-align:center'>".$row["comments"]."</td>";
      echo "<td style='text-align:center'>".$row["rain"]."</td>";
      echo "<td style='text-align:center'>".$row["rain_proj"]."</td>";
      echo "<td style='text-align:center'>".$row["restrictions"]."</td>";
      echo "<td style='text-align:center'>".$row["category"]."</td>";
			echo "<td>&nbsp;<a href='approvals.php?project=".$row['num']."'>".$row["status"]."</a>&nbsp;&nbsp;</td>";
			//link to edit
			echo "<td>&nbsp;<a href='editProject.php?project=".urlencode($row["num"])."&host=".$row['Host']."'>Edit</a>&nbsp;&nbsp;</td>";
			//link to delete
			echo "<td>&nbsp;<a href='deleteProject.php?project=".urlencode($row["num"])."' onclick='return confirm('Are you sure?');'>Delete</a>&nbsp;&nbsp;</td>";
      echo "</tr>";
		}
		echo "</tbody>";
		echo "</table>";
		echo "</div>";
		//echo "</center>";
		echo "</div>";
		echo "<center>";
 	 echo "<div>";
	 //button to export project information to a spreadsheet
         echo "<form class='form-horizontal' action='excelProjects.php' method='post' name='upload_excel' enctype='multipart/form-data'>";
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
  echo "<br /><br /><a href='select.php'>Register a Volunteer</a>";
  echo "</center>";
?>

<?php  new_footer("Volunteers", $mysqli); ?>
