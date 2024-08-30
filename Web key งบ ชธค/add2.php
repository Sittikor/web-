<?php
$db_host = "localhost"; 
$db_user = "root";     
$db_password = "";
$db_name = "data";


$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $year = $_POST['year'];
    $dept = $_POST['dept'];
    $uftype = $_POST['uftype'];
    $monthname = $_POST['monthname'];
    $percentuf = $_POST['percentuf'];

    $sql = "INSERT INTO percentuf(Year, Dept, UFType, MonthName, PercentUF) VALUES ('$year', '$dept', '$uftype', '$monthname', '$percentuf')";

    if ($conn->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
