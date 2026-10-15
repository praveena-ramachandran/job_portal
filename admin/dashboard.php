<?php
session_start();
if($_SESSION['role']!="admin") header("Location:../login.php");

echo "<h2>Admin Dashboard</h2>";

echo "<a href='../logout.php'>Logout</a>";