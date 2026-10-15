<?php
session_start();
include("../config/db.php");

if($_SESSION['role']!="jobseeker"){
    header("Location:../login.php");
    exit();
}

$result = mysqli_query($conn,"SELECT * FROM jobs");
?>

<!DOCTYPE html>
<html>
<head>
<title>Available Jobs</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
<h2>Available Jobs</h2>
<a href="dashboard.php" class="btn btn-secondary mb-3">Back</a>

<?php while($row=mysqli_fetch_assoc($result)){ ?>
<div class="card mb-3">
<div class="card-body">
<h4><?php echo $row['title']; ?></h4>
<p><b>Company:</b> <?php echo $row['company']; ?></p>
<p><b>Location:</b> <?php echo $row['location']; ?></p>
<p><b>Salary:</b> <?php echo $row['salary']; ?></p>
<p><?php echo $row['description']; ?></p>

<a href="apply_job.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Apply</a>
</div>
</div>
<?php } ?>

</div>

</body>
</html>