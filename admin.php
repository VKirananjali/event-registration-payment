<?php
session_start();

include('database_connection.php');

$name = $_POST['email'];
$password = $_POST['pwd'];

$sql="SELECT uname, email, pwd FROM admin WHERE email = '$name' OR uname = '$name' and pwd = '$password'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
if ($result->num_rows > 0) {
    $_SESSION['name'] = $row['uname'];
    $_SESSION['email'] = $row['email'];
    echo("loged in successfully");
    header("Location: admin_dashboard.php");
} else {
    echo "Invalid Username or password.";
}
?>