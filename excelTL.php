<?php
  require_once("included_functions.php");
  require_once("session.php");
  verify_login();
  //new_header("Here are your team leaders!");

  $mysqli = db_connection();

  //need to make this a function where you pass the query and the column headers and maybe subject in order to have appropriate csv name

  //https://www.cloudways.com/blog/import-export-csv-using-php-and-mysql/
   header('Content-Type: text/csv; charset=utf-8');
   //sets file name to teamleaders.csv
   header('Content-Disposition: attachment; filename=teamleaders.csv');
   //opens csv file to write to
   $output = fopen("php://output", "w");
   //writes headers to csv file
   fputcsv($output, array('tl_number', 'First Name', 'Last Name', 'Phone', 'Email', 'Project'));
   //selects desired team leader information
   $query = "SELECT * from Team_Leaders ORDER BY tl_number ASC";
   $result = $mysqli->query($query);
   //writes each row to csv file
   while($row = mysqli_fetch_assoc($result))
   {
        fputcsv($output, $row);
   }
   fclose($output);

?>
