<?php
session_start();
include("../config/db.php");

$job_id=$_GET['id'];
$user_id=$_SESSION['user_id'];

if(isset($_POST['apply'])){
$resume=$_FILES['resume']['name'];
move_uploaded_file($_FILES['resume']['tmp_name'],"../uploads/".$resume);

mysqli_query($conn,"INSERT INTO applications(job_id,user_id,resume)
VALUES('$job_id','$user_id','$resume')");

echo "Applied Successfully!";
}
?>

<form method="POST" enctype="multipart/form-data">
Upload Resume:
<input type="file" name="resume" required>
<button name="apply">Apply</button>
</form>