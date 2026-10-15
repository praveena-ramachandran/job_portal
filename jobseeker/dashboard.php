<?php
session_start();
if($_SESSION['role']!="jobseeker") header("Location:../login.php");
?>

<h2>Job Seeker Dashboard</h2>
<a href="search_jobs.php">Search Jobs</a>
<a href="../logout.php">Logout</a>