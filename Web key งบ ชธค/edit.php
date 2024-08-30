<?php
$db_host = "localhost"; 
$db_user = "root";     
$db_password = "";
$db_name = "data";


$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['ID'];
    $year = $_POST['Year'];
    $productNo = $_POST['ProductNo'];
    $productName = $_POST['ProductName'];
    $customerTargetNumber = $_POST['CustomerTargetNumber'];
    $commitDate = $_POST['CommitDate'];
    $updateDate = $_POST['UpdateDate'];

    $sql = "UPDATE customer_target_number SET Year=?, ProductNo=?, ProductName=?, CustomerTargetNumber=?, CommitDate=?, UpdateDate=? WHERE ID=?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $year, $productNo, $productName, $customerTargetNumber, $commitDate, $updateDate, $id);

    $response = ["success" => false];
    if ($stmt->execute()) {
        $response["success"] = true;
    }

    $stmt->close();
    $conn->close();
    echo json_encode($response);
}
?>
