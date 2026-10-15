<?php
session_start();
include("../config/db.php");

if(!isset($_SESSION['role']) || $_SESSION['role']!="employer"){
    header("Location:../login.php");
    exit();
}

$emp_id = $_SESSION['user_id'];

/* ================= JOB ANALYTICS ================= */

/* Total Jobs */
$jobs = mysqli_query($conn,"SELECT COUNT(*) as total_jobs FROM jobs WHERE employer_id='$emp_id'");
$row_jobs = mysqli_fetch_assoc($jobs);
$total_jobs = $row_jobs['total_jobs'] ?? 0;

/* Total Applicants */
$applicants = mysqli_query($conn,"
SELECT COUNT(*) as total_applicants
FROM applications
JOIN jobs ON applications.job_id = jobs.id
WHERE jobs.employer_id='$emp_id'
");
$row_app = mysqli_fetch_assoc($applicants);
$total_applicants = $row_app['total_applicants'] ?? 0;

/* Total Internships */
$internships = mysqli_query($conn,"
SELECT COUNT(*) as total_internships
FROM jobs
WHERE employer_id='$emp_id' AND job_type='Internship'
");
$row_int = mysqli_fetch_assoc($internships);
$total_internships = $row_int['total_internships'] ?? 0;

/* Active Jobs */
$active_jobs = mysqli_query($conn,"
SELECT COUNT(*) as active_jobs
FROM jobs
WHERE employer_id='$emp_id' AND status='active'
");
$row_active = mysqli_fetch_assoc($active_jobs);
$total_active_jobs = $row_active['active_jobs'] ?? 0;


/* ================= POST JOB ================= */

if(isset($_POST['post_job'])){

$title = $_POST['title'];
$company = $_POST['company'];
$location = $_POST['location'];
$salary = $_POST['salary'];
$desc = $_POST['description'];
$type = $_POST['job_type'];

$insert = mysqli_query($conn,"INSERT INTO jobs
(employer_id,title,company,location,salary,description,job_type,status)
VALUES('$emp_id','$title','$company','$location','$salary','$desc','$type','active')");

if($insert){
echo "<script>alert('Job Posted Successfully');</script>";
}

}

$page = $_GET['page'] ?? '';
?>

<!DOCTYPE html>
<html>
<head>

<title>Employer Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
background:#f4f7fc;
font-family:'Segoe UI',sans-serif;
}

.dashboard-title{
font-weight:700;
margin-bottom:25px;
color:#333;
}

.dashboard-menu a{
margin:5px;
border-radius:8px;
font-weight:500;
}

.dashboard-card{
background:white;
padding:25px;
border-radius:10px;
box-shadow:0 4px 10px rgba(0,0,0,0.1);
margin-top:20px;
}

.container{
max-width:1000px;
}

.table th{
background:#0d6efd;
color:white;
}

</style>

</head>

<body>

<div class="container mt-4">

<h2 class="dashboard-title">Employer Dashboard</h2>

<div class="dashboard-menu mb-3">

<a href="?page=post" class="btn btn-primary">Post Job</a>
<a href="?page=view" class="btn btn-success">My Jobs</a>
<a href="?page=internships" class="btn btn-warning">My Internships</a>
<a href="?page=internship_applicants" class="btn btn-dark">Internship Applicants</a>
<a href="?page=search" class="btn btn-info">Search Jobs</a>
<a href="../logout.php" class="btn btn-danger">Logout</a> 



</div>

<!-- ================= DASHBOARD ANALYTICS ================= -->

<div class="row">

<div class="col-md-3">
<div class="card text-white bg-primary mb-3">
<div class="card-body">
<h5>Total Jobs</h5>
<h2><?php echo $total_jobs; ?></h2>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card text-white bg-success mb-3">
<div class="card-body">
<h5>Total Applicants</h5>
<h2><?php echo $total_applicants; ?></h2>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card text-white bg-warning mb-3">
<div class="card-body">
<h5>Internships</h5>
<h2><?php echo $total_internships; ?></h2>
</div>
</div>
</div>

<div class="col-md-3">
<div class="card text-white bg-danger mb-3">
<div class="card-body">
<h5>Active Jobs</h5>
<h2><?php echo $total_active_jobs; ?></h2>
</div>
</div>
</div>

</div>

<?php

/* ================= POST JOB ================= */

if($page=="post"){
?>

<div class="dashboard-card">

<h4>Post Job / Internship</h4>

<form method="POST">

<input type="text" name="title" class="form-control mb-3" placeholder="Job Title" required>

<input type="text" name="company" class="form-control mb-3" placeholder="Company Name" required>

<input type="text" name="location" class="form-control mb-3" placeholder="Location" required>

<select name="job_type" class="form-control mb-3" required>
<option value="">Select Type</option>
<option value="Job">Job</option>
<option value="Internship">Internship</option>
</select>

<input type="text" name="salary" class="form-control mb-3" placeholder="Salary / Stipend" required>

<textarea name="description" class="form-control mb-3" placeholder="Job Description"></textarea>

<button type="submit" name="post_job" class="btn btn-primary">Post</button>

</form>

</div>

<?php
}

/* ================= MY JOBS ================= */

elseif($page=="view"){

$result = mysqli_query($conn,"SELECT * FROM jobs WHERE employer_id='$emp_id' AND job_type='Job'");
?>

<div class="dashboard-card">

<h4>My Jobs</h4>

<table class="table table-bordered">

<tr>
<th>Title</th>
<th>Company</th>
<th>Location</th>
<th>Salary</th>
<th>Status</th>
</tr>

<?php while($row=mysqli_fetch_assoc($result)){ ?>

<tr>
<td><?php echo $row['title']; ?></td>
<td><?php echo $row['company']; ?></td>
<td><?php echo $row['location']; ?></td>
<td><?php echo $row['salary']; ?></td>
<td><?php echo $row['status']; ?></td>
</tr>

<?php } ?>

</table>

</div>

<?php
}

/* ================= INTERNSHIPS ================= */

elseif($page=="internships"){

$result=mysqli_query($conn,"SELECT * FROM jobs WHERE employer_id='$emp_id' AND job_type='Internship'");
?>

<div class="dashboard-card">

<h4>My Internships</h4>

<table class="table table-bordered">

<tr>
<th>Title</th>
<th>Company</th>
<th>Location</th>
<th>Stipend</th>
<th>Status</th>
</tr>

<?php while($row=mysqli_fetch_assoc($result)){ ?>

<tr>
<td><?php echo $row['title']; ?></td>
<td><?php echo $row['company']; ?></td>
<td><?php echo $row['location']; ?></td>
<td><?php echo $row['salary']; ?></td>
<td><?php echo $row['status']; ?></td>
</tr>

<?php } ?>

</table>

</div>

<?php
}

/* ================= INTERNSHIP APPLICANTS ================= */

elseif($page=="internship_applicants"){

$query = mysqli_query($conn,"
SELECT internship_applications.*, 
users.name, users.email,
jobs.title
FROM internship_applications
JOIN users ON internship_applications.user_id = users.id
JOIN jobs ON internship_applications.internship_id = jobs.id
WHERE jobs.employer_id='$emp_id'
");
?>

<div class="dashboard-card">

<h4>Internship Applicants</h4>

<table class="table table-bordered">

<tr>
<th>Student Name</th>
<th>Email</th>
<th>Internship Title</th>
<th>Apply Date</th>
</tr>

<?php while($row=mysqli_fetch_assoc($query)){ ?>

<tr>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['email']; ?></td>
<td><?php echo $row['title']; ?></td>
<td><?php echo $row['apply_date']; ?></td>
</tr>

<?php } ?>

</table>

</div>

<?php
}
/*============== Apply Internship ================*/
/*============== Apply Internship ================*/
 elseif(isset($_POST['apply_internship'])){

$internship_id = $_POST['internship_id'];

mysqli_query($conn,"
INSERT INTO internship_applications(internship_id,user_id)
VALUES('$internship_id','$user_id')
");

echo "<script>alert('Internship Applied Successfully');</script>";

}

/* ================= GOOGLE SEARCH ================= */

elseif($page=="search"){
?>

<div class="dashboard-card">

<h4>Search Jobs</h4>

<form action="https://www.google.com/search" method="GET" target="_blank">

<div class="row">

<div class="col-md-8">
<input type="text" name="q" class="form-control" placeholder="Enter job title" required>
</div>

<div class="col-md-4">
<button type="submit" class="btn btn-success w-100">Search</button>
</div>

</div>

</form>

</div>

<?php } ?>

</div>

</body>
</html>