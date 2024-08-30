<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$role_id = $_SESSION['role_id'];

if ($role_id != 1) { 
    echo "Access Denied";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Page</title>
</head>
<body>
    <h1>Admin Only Content</h1>
</body>
</html>
