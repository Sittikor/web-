<?php
$db_host = "localhost"; 
$db_user = "root";     
$db_password = "";
$db_name = "data";


$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_POST['id'];

$sql = "DELETE FROM percentuf WHERE ID='$id'";

if ($conn->query($sql) === TRUE) {
    echo "success";
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();
?>
