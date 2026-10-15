<?php
session_start();
include("../config/db.php");

if(isset($_POST['post'])){
$title=$_POST['title'];
$company=$_POST['company'];
$location=$_POST['location'];
$salary=$_POST['salary'];
$desc=$_POST['description'];
$emp_id=$_SESSION['user_id'];

mysqli_query($conn,"INSERT INTO jobs(employer_id,title,company,location,salary,description)
VALUES('$emp_id','$title','$company','$location','$salary','$desc')");

echo "Job Posted!";
}
?>

<form method="POST">
<input type="text" name="title" placeholder="Job Title"><br>
<input type="text" name="company" placeholder="Company"><br>
<input type="text" name="location" placeholder="Location"><br>
<input type="text" name="salary" placeholder="Salary"><br>
<textarea name="description" placeholder="Description"></textarea><br>
<button name="post">Post Job</button>
</form>