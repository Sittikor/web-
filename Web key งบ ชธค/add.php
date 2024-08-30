<?php
// Database connection (update with your own credentials)
$db_host = "localhost"; 
$db_user = "root";     
$db_password = "";
$db_name = "data";

$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $year = $conn->real_escape_string($_POST['Year']);
    $productNo = $conn->real_escape_string($_POST['ProductNo']);
    $productName = $conn->real_escape_string($_POST['ProductName']);
    $commitDate = $conn->real_escape_string($_POST['CommitDate']);
    $updateDate = $conn->real_escape_string($_POST['UpdateDate']);

    // Find the latest CustomerTargetNumber for the specified year
    $result = $conn->query("SELECT MAX(CustomerTargetNumber) as maxNumber FROM customer_target_number WHERE Year = '$year'");
    $row = $result->fetch_assoc();
    $newNumber = $row['maxNumber'] ? $row['maxNumber'] + 1 : 1;

    $sql = "INSERT INTO customer_target_number (Year, ProductNo, ProductName, CustomerTargetNumber, CommitDate, UpdateDate) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $year, $productNo, $productName, $newNumber, $commitDate, $updateDate);

    $response = ["success" => false];
    if ($stmt->execute()) {
        $response["success"] = true;
        $response["id"] = $stmt->insert_id;
        $response["customerTargetNumber"] = $newNumber;
    } else {
        $response["error"] = $stmt->error;
    }

    $stmt->close();
    $conn->close();
    echo json_encode($response);
}
?>
