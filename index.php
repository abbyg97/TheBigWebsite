<?php require_once("session.php"); ?>
<?php require_once("included_functions.php"); ?>

<?php new_header("Big Event","/~agarrett"); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<br />
<center>
<h1>Welcome to the Big Event Home Page!</h1>
</center>

<div class="container">
  <h3>Our Mission</h3>
  <div class = "container">The Ole Miss Big Event is an organization focused on
    helping students and the community form lasting relationships.  The goal every school year is to send out roughly 1000 students
    accomplish over 200 projects in the Oxford Layfayette Community in order to provide a platform for relationships
    to begin to form.</div>
    <br />
  <center>
    <img class="containter" src="/~agarrett/bePic.jpg" alt="" style="height:60%; width:60%">
  </center>

  <br></br>

  <h3>Our Pilot Project</h3>
  <div class = "container">This year, the Big Event is working to make a difference in the community for more than just one day
  by hosting a Big Event Gala.  This year the money raised from the Gala will go towards providing shelves and other maintenance needs
  to the Oxford Lafayette Public Library.  The shevles will be installed on the day of the Big Event by our volunteers.</div>
  <br />
  <center>
    <img class="containter" src="/~agarrett/library.jpg" alt="" style="height:60%; width:60%">
  </center>

  <br></br>
  <center>
  <h2>Thank you for your involvement with the Big Event on March 23rd</h2>
  </center>

<!-- <a href = "register.php">Register to Volunteer!</a> <br></br>
<a href = "groupVolunteers.php">View Volunteers</a> <br></br>
<a href = "selectandView.php">Search for a specific group of Volunteers</a> <br></br>
<a href = "registerHost.php">Register to be a Host</a> <br></br>
<a href = "registerProject.php">Register to be a Project</a> <br></br>
<a href = "viewHostProjects.php">View Your Projects</a> <br></br>
<a href = "execProjectView.php">Exec Project View</a> <br></br>
<a href = "teamleaders.php">Team Leaders</a> <br></br>
<a href = "uploadTL.php">Upload CSV for Team Leaders</a> <br></br>
<a href = "committeeMembers.php">See approvals</a> <br></br> -->

<?php  new_footer("Big Event", $mysqli); ?>
