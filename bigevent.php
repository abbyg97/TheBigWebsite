<?php require_once("session.php"); ?>
<?php require_once("included_functions.php"); ?>

<?php new_header("Big Event","/~agarrett"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<h3>Welcome to the Big Event Home Page!</h3>

<a href = "register.php">Register to Volunteer!</a> <br></br>
<a href = "volunteer.php">View Volunteers</a> <br></br>
<a href = "selectandView.php">Search for a specific group of Volunteers</a> <br></br>
<a href = "registerHost.php">Register to be a Host</a> <br></br>
<a href = "registerProject.php">Register to be a Project</a> <br></br>
<a href = "viewHostProjects.php">View Your Projects</a> <br></br>
<a href = "execProjectView.php">exec Project View</a> <br></br>


<?php  new_footer("Who's Who", $mysqli); ?>
