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

// Query to select all records from customer_target_number table
$sql = "SELECT * FROM `customer_target_number`";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Year Table</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 7px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h2> หน้า Function1 แก้/ลบ/เพิ่มข้อมูล</h2>

<!-- HTML code for dropdown menu -->
<select id="filterDropdown">
    <option value="all">ปีทั้งหมด</option>
    <option value="2562">2562</option>
    <option value="2563">2563</option>
    <option value="2564">2564</option>
    <option value="2565">2565</option>
</select>

<!-- HTML code for table -->
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Year</th>
            <th>Product No</th>
            <th>Product Name</th>
            <th>Customer Target Number</th>
            <th>Commit Date</th>
            <th>Update Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody id="tableBody">
        <?php
        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["ID"] . "</td>";
                echo "<td>" . $row["Year"] . "</td>";
                echo "<td>" . $row["ProductNo"] . "</td>";
                echo "<td>" . $row["ProductName"] . "</td>";
                echo "<td>" . $row["CustomerTargetNumber"] . "</td>";
                echo "<td>" . $row["CommitDate"] . "</td>";
                echo "<td>" . $row["UpdateDate"] . "</td>";
                echo "<td>";
                echo "<button class='editBtn'>แก้ไขข้อมูล</button>&nbsp;&nbsp"; 
                echo "<button class='deleteBtn'>ลบข้อมูล</button>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No results found</td></tr>";
        }
        $conn->close();
        ?>
    </tbody>
</table>



<script>
    document.getElementById("filterDropdown").addEventListener("change", function () {
        var selectedYear = this.value;
        var rows = document.getElementById("tableBody").getElementsByTagName("tr");
        for (var i = 0; i < rows.length; i++) {
            var yearCell = rows[i].getElementsByTagName("td")[1]; // Assuming year is in the second column
            if (selectedYear === "all" || yearCell.textContent.trim() === selectedYear) {
                rows[i].style.display = "";
            } else {
                rows[i].style.display = "none";
            }
        }
    });

    document.addEventListener("DOMContentLoaded", function() {
        var tableBody = document.getElementById("tableBody");

        tableBody.addEventListener("click", function(event) {
            if (event.target.classList.contains("editBtn")) {
                var row = event.target.closest("tr");
                var id = row.getElementsByTagName("td")[0].textContent.trim();
                console.log("Edit ID:", id);
                // Add your edit logic here
            }

            if (event.target.classList.contains("deleteBtn")) {
                var row = event.target.closest("tr");
                var id = row.getElementsByTagName("td")[0].textContent.trim();
                console.log("Delete ID:", id);
                // Add your delete logic here
                row.remove(); // Example delete action
            }
        });
    });
    
</script>


