<?php
include("config/db.php");

if(isset($_POST['register']))
{
$name=$_POST['name'];
$email=$_POST['email'];
$password=md5($_POST['password']);
$role=$_POST['role'];

$query=mysqli_query($conn,"INSERT INTO users(name,email,password,role)
VALUES('$name','$email','$password','$role')");

if($query){
echo "<script>
alert('Registration Successful');
window.location='login.php';
</script>";
}
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Register</title>
</head>

<body>

<h2>Register</h2>

<form method="post">

<input type="text" name="name" placeholder="Name" required><br><br>

<input type="email" name="email" placeholder="Email" required><br><br>

<input type="password" name="password" placeholder="Password" required><br><br>

<select name="role">
<option value="student">Student</option>
<option value="employer">Employer</option>
</select>

<br><br>

<button type="submit" name="register">Register</button>

</form>

<br>

<p>Already have an account?  
<a href="login.php">Login Here</a></p>

</body>
</html>