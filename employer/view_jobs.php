<?php
session_start();
include("../config/db.php");

if($_SESSION['role']!="employer"){
    header("Location:../login.php");
    exit();
}

$emp_id = $_SESSION['user_id'];

$result = mysqli_query($conn,"SELECT * FROM jobs WHERE employer_id='$emp_id'");
?>

<!DOCTYPE html>
<html>
<head>
<title>My Posted Jobs</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
<h2>My Posted Jobs</h2>
<a href="dashboard.php" class="btn btn-secondary mb-3">Back</a>

<table class="table table-bordered bg-white">
<tr>
<th>Title</th>
<th>Company</th>
<th>Location</th>
<th>Salary</th>
<th>Description</th>
</tr>

<?php
while($row=mysqli_fetch_assoc($result)){
?>
<tr>
<td><?php echo $row['title']; ?></td>
<td><?php echo $row['company']; ?></td>
<td><?php echo $row['location']; ?></td>
<td><?php echo $row['salary']; ?></td>
<td><?php echo $row['description']; ?></td>
</tr>
<?php } ?>

</table>
</div>

</body>
</html>