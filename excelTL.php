<?php
  require_once("included_functions.php");
  require_once("session.php");
  //new_header("Here are your team leaders!");

  $mysqli = db_connection();

  //need to make this a function where you pass the query and the column headers and maybe subject in order to have appropriate csv name

   header('Content-Type: text/csv; charset=utf-8');
   header('Content-Disposition: attachment; filename=teamleaders.csv');
   $output = fopen("php://output", "w");
   fputcsv($output, array('tl_number', 'First Name', 'Last Name', 'Phone', 'Email', 'Project'));
   $query = "SELECT * from Team_Leaders ORDER BY tl_number ASC";
   $result = $mysqli->query($query);
   while($row = mysqli_fetch_assoc($result))
   {
        fputcsv($output, $row);
   }
   fclose($output);

?>
