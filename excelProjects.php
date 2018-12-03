<?php
  require_once("included_functions.php");
  require_once("session.php");
  verify_login();
  //new_header("Here are your team leaders!");

  $mysqli = db_connection();

  //https://www.cloudways.com/blog/import-export-csv-using-php-and-mysql/
  //need to make this a function where you pass the query and the column headers and maybe subject in order to have appropriate csv name
   header('Content-Type: text/csv; charset=utf-8');
   //sets file name
   header('Content-Disposition: attachment; filename=projects.csv');
   //opens file to write to
   $output = fopen("php://output", "w");
   //puts array given into csv -- headers
   fputcsv($output, array('Project Number', 'Host Number', 'Address', 'Minimum Volunteers', 'Maximum Volunteers', 'Transportation required', 'Description','Tools requested','Comments','Come if it rains?','Describe the project we would do on a rainy day','Restrictions','Category','Approval Status'));
   //selects values you want to be in the excel file
   $query = "SELECT Project_Number AS 'num', Host, address, min_volunteers AS 'min', max_volunteers AS 'max', Transportation.type as transportation, description, tools, Projects.additional_comments AS 'comments', rain, rain_proj, restriction_violation AS 'restrictions', proj_category.cat AS 'category', Approvals.status from Projects join proj_category on Projects.category=proj_category.number left outer join Transportation on Projects.transportation=Transportation.number right outer join Approvals on Approvals.project=Projects.Project_Number ORDER BY num ASC";
   //execute query
   $result = $mysqli->query($query);
   //puts each row into the csv
   while($row = mysqli_fetch_assoc($result))
   {
        fputcsv($output, $row);
   }
   fclose($output);

?>
