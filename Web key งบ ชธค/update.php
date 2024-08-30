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
$year = $_POST['year'];
$dept = $_POST['dept'];
$ufType = $_POST['uftype'];
$monthName = $_POST['monthname'];
$percentUF = $_POST['percentuf'];

$sql = "UPDATE percentuf SET Year='$year', Dept='$dept', UFType='$ufType', MonthName='$monthName', PercentUF='$percentUF' WHERE ID='$id'";

if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
?>
