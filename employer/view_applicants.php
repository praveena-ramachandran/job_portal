<?php
session_start();
include("../config/db.php");

$emp_id = $_SESSION['user_id'];

$result = mysqli_query($conn,"
SELECT applications.*, users.name, jobs.title
FROM applications
JOIN users ON applications.user_id = users.id
JOIN jobs ON applications.job_id = jobs.id
WHERE jobs.employer_id = '$emp_id'
");
?>

<h2>Applicants</h2>

<table border="1">
<tr>
<th>Job Title</th>
<th>Candidate</th>
<th>Resume</th>
<th>Status</th>
</tr>

<?php while($row=mysqli_fetch_assoc($result)){ ?>
<tr>
<td><?php echo $row['title']; ?></td>
<td><?php echo $row['name']; ?></td>
<td>
<a href="../uploads/<?php echo $row['resume']; ?>" target="_blank">View Resume</a>
</td>
<td><?php echo $row['status']; ?></td>
</tr>
<?php } ?>
</table>