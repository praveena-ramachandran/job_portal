<?php
session_start();

if($_SESSION['role']!="student"){
header("Location:../login.php");
}
?>

<h2>Student Dashboard</h2>

<a href="search_jobs.php">Search Jobs</a><br>
<a href="my_applications.php">My Applications</a><br>
<a href="../logout.php">Logout</a>