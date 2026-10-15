<?php
session_start();
include("config/db.php");

if(isset($_POST['login']))
{
$email=$_POST['email'];
$password=md5($_POST['password']);

$query=mysqli_query($conn,"SELECT * FROM users WHERE email='$email' AND password='$password'");

if(mysqli_num_rows($query) > 0)
{
$user=mysqli_fetch_assoc($query);

$_SESSION['user_id']=$user['id'];
$_SESSION['role']=$user['role'];

if($user['role']=="student"){
header("Location: student/dashboard.php");
exit();
}

elseif($user['role']=="employer"){
header("Location: employer/dashboard.php");
exit();
}

elseif($user['role']=="admin"){
header("Location: admin/dashboard.php");
exit();
}

}
else
{
echo "Invalid Email or Password";
}
}
?>