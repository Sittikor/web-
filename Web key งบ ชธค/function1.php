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
    <title>Function1</title>
    <!-- ตารางข้อมูล -->
    <style>
       /* table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 100px;
} */

/* table, th, td {
    border: 1px solid black;
} */

/* th, td {
    padding: 10px;
    text-align: left;
} */

.center {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 10vh; 
}
    </style>
</head>
<body>
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
<!-- <h2></h2> ชื่อบน header -->

<!-- HTML code for dropdown menu -->
<style>
        body {
            margin: 0;
            padding: 0;
            background-color: #ffff;
        }
        #filterDropdown {
            position: absolute;
            top: 5px; 
            left: 45%;  
            transform: translateX(-100%);  
            padding: 10px;
        }
    </style>

<style>
  select {
    background-color: #4CAF50; 
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 15px;
    margin: 4px 2px;
    cursor: pointer;
    border-radius: 8px;
  }
</style>
<select id="filterDropdown">
    <option value="all">ปี</option>
    <option value="2562">2562</option>
    <option value="2563">2563</option>
    <option value="2564">2564</option>
    <option value="2565">2565</option>
</select>

<!-- ตารางdata -->
<style>
        table {
            width: 80%;
            margin: auto;
            text-align: center;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
        }
        th {
            background-color: #FCE500;
        }
        tr {
            font-size: smaller;
            text-align: center;
        }
        .logout {
            display: inline-block;
            background-color: #c82333;
            color: #fff;
            padding: 10px 15px;
            border-radius: 4px;
            text-decoration: none;
            text-align: center
        }
        .container {
            text-align: center;
            margin-top: 1%;
        }
        </style>
<table>
    <thead>
    <div class="center">
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
                while ($row = $result->fetch_assoc()) {
                    echo "<tr data-id='" . $row["ID"] . "'>";
                    echo "<td>" . $row["ID"] . "</td>";
                    echo "<td>" . $row["Year"] . "</td>";
                    echo "<td>" . $row["ProductNo"] . "</td>";
                    echo "<td>" . $row["ProductName"] . "</td>";
                    echo "<td>" . $row["CustomerTargetNumber"] . "</td>";
                    echo "<td>" . $row["CommitDate"] . "</td>";
                    echo "<td>" . $row["UpdateDate"] . "</td>";
                    echo "<td>";
                    
                    $buttonColor = "#0082FC";
                    echo "<button type='button' class='btn btn-primary editBtn' style='background-color: $buttonColor;' aria-label='Edit Information'>แก้ไขข้อมูล</button>&nbsp;&nbsp;";
                    echo "<button type='button' class='btn btn-primary deleteBtn' style='background-color: $buttonColor;'aria-label='Delet Information'>ลบข้อมูล</button>&nbsp;&nbsp;";
                    echo "<button type='button' class='btn btn-primary viewBtn' style='background-color :$buttonColor;'aria-label=' View Information'>ดูรายละเอียด</button>&nbsp;&nbsp;";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No results found</td></tr>";
            }
            $conn->close();
            ?>
        </tbody>
    </table>
    <style>
        .button-container {
            position: fixed;
            top: 10px; /* Adjust as needed */
            left: 600px; /* Adjust as needed */
            transform: translateX(100%);
        }
    </style>
    <div class="button-container">
        <button onclick="openAddModal()">เพิ่มข้อมูล</button>
    </div>
    <script>
        function openAddModal() {
        }
    </script>
    <style>
        /* ปุ่มเพิ่มข้อมูล */
        .button-container {
            position: fixed;
            top: 10px; /* Adjust as needed */
            left: calc(50% + 90px); /* Adjust the value to shift right by 15px */
            transform: translateX(-100%);
        }

        /* Button styles */
        button {
            background-color: #4CAF50; 
            border: none;
            color: white;
            padding: 9px 15px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            cursor: pointer;
            border-radius: 8px;
            margin-right: 15px; /* Provides spacing between buttons */
        }


  button:hover {
    background-color: #45a049; 
  }
</style>

    <!-- เพิ่มข้อมูล -->
    <div id="addModal" style="display: none;">
        <form id="addForm">
            <label for="addID">ID:</label>
            <input type="text" id="addID" name="ID" required>
            <label for="addYear">Year:</label>
            <input type="text" id="addYear" name="Year" required>
            <label for="addProductNo">Product No:</label>
            <input type="text" id="addProductNo" name="ProductNo" required>
            <label for="addProductName">Product Name:</label>
            <input type="text" id="addProductName" name="ProductName" required>
            <label for="addCustomerTargetNumber">Customer Target Number:</label>
            <input type="text" id="addCustomerTargetNumber" name="CustomerTargetNumber" required>
            <label for="addCommitDate">Commit Date:</label>
            <input type="date" id="addCommitDate" name="CommitDate" required>
            <label for="addUpdateDate">Update Date:</label>
            <input type="datetime-local" id="addUpdateDate" name="UpdateDate" required>
            <button type="submit">Add</button>
            <button type="button" onclick="closeAddModal()">Cancel</button>
        </form>
    </div>

            <!-- แก้ไขข้อมูล -->
    <div id="editModal" style="display: none;">
        <form id="editForm">
            <input type="hidden" id="editID" name="ID">
            <label for="editID">ID:</label>
            <input type="text" id="editID" name="ID" required>
            <label for="editYear">Year:</label>
            <input type="text" id="editYear" name="Year" required>
            <label for="editProductNo">Product No:</label>
            <input type="text" id="editProductNo" name="ProductNo" required>
            <label for="editProductName">Product Name:</label>
            <input type="text" id="editProductName" name="ProductName" required>
            <label for="editCustomerTargetNumber">Customer Target Number:</label>
            <input type="text" id="editCustomerTargetNumber" name="CustomerTargetNumber" required>
            <label for="editCommitDate">Commit Date:</label>
            <input type="date" id="editCommitDate" name="CommitDate" required>
            <label for="editUpdateDate">Update Date:</label>
            <input type="datetime-local" id="editUpdateDate" name="UpdateDate" required>
            <button type="submit">Save</button>
            <button type="button" onclick="closeModal()">Cancel</button>
        </form>
    </div>

            <!-- ดูรายละเอียด -->
    <div id="viewModal" style="display: none;">
        <div id="viewContent"></div>
        <button type="button" onclick="closeViewModal()">Close</button>
    </div>

    <script>
        document.getElementById("filterDropdown").addEventListener("change", function () {
            var selectedYear = this.value;
            var rows = document.getElementById("tableBody").getElementsByTagName("tr");
            for (var i = 0; i < rows.length; i++) {
                var yearCell = rows[i].getElementsByTagName("td")[1]; 
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
                    var year = row.getElementsByTagName("td")[1].textContent.trim();
                    var productNo = row.getElementsByTagName("td")[2].textContent.trim();
                    var productName = row.getElementsByTagName("td")[3].textContent.trim();
                    var customerTargetNumber = row.getElementsByTagName("td")[4].textContent.trim();
                    var commitDate = row.getElementsByTagName("td")[5].textContent.trim();
                    var updateDate = row.getElementsByTagName("td")[6].textContent.trim();

                    document.getElementById("editID").value = id;
                    document.getElementById("editYear").value = year;
                    document.getElementById("editProductNo").value = productNo;
                    document.getElementById("editProductName").value = productName;
                    document.getElementById("editCustomerTargetNumber").value = customerTargetNumber;
                    document.getElementById("editCommitDate").value = commitDate;
                    document.getElementById("editUpdateDate").value = updateDate;

                    document.getElementById("editModal").style.display = "block";
                }

                if (event.target.classList.contains("deleteBtn")) {
                    var row = event.target.closest("tr");
                    var id = row.getElementsByTagName("td")[0].textContent.trim();
                    if (confirm("คุณแน่ใจใช่ไหมว่าจะลบข้อมูลนี้!")) {
                        fetch('delete.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({ ID: id })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('ลบบันทึกเรียบร้อยแล้ว!');
                                row.remove();
                            } else {
                                alert('Error deleting record.');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                    }
                }

                if (event.target.classList.contains("viewBtn")) {
                    var row = event.target.closest("tr");
                    var id = row.getElementsByTagName("td")[0].textContent.trim();
                    var year = row.getElementsByTagName("td")[1].textContent.trim();
                    var productNo = row.getElementsByTagName("td")[2].textContent.trim();
                    var productName = row.getElementsByTagName("td")[3].textContent.trim();
                    var customerTargetNumber = row.getElementsByTagName("td")[4].textContent.trim();
                    var commitDate = row.getElementsByTagName("td")[5].textContent.trim();
                    var updateDate = row.getElementsByTagName("td")[6].textContent.trim();

                    var viewContent = `
                        <p>ID: ${id}</p>
                        <p>Year: ${year}</p>
                        <p>Product No: ${productNo}</p>
                        <p>Product Name: ${productName}</p>
                        <p>Customer Target Number: ${customerTargetNumber}</p>
                        <p>Commit Date: ${commitDate}</p>
                        <p>Update Date: ${updateDate}</p>
                    `;

                    document.getElementById("viewContent").innerHTML = viewContent;
                    document.getElementById("viewModal").style.display = "block";
                }

                if (event.target.classList.contains("exportBtn")) {
                    var row = event.target.closest("tr");
                    var id = row.getElementsByTagName("td")[0].textContent.trim();
                    alert('Export functionality not implemented yet.');
                }
            });

            document.getElementById("editForm").addEventListener("submit", function(event) {
                event.preventDefault();

                var formData = new FormData(this);

                fetch('edit.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('อัปเดตข้อมูลเรียบร้อยแล้ว!');
                        var id = document.getElementById("editID").value;
                        var row = document.querySelector("tr[data-id='" + id + "']");
                        row.getElementsByTagName("td")[0].textContent = document.getElementById("editID").value;
                        row.getElementsByTagName("td")[1].textContent = document.getElementById("editYear").value;
                        row.getElementsByTagName("td")[2].textContent = document.getElementById("editProductNo").value;
                        row.getElementsByTagName("td")[3].textContent = document.getElementById("editProductName").value;
                        row.getElementsByTagName("td")[4].textContent = document.getElementById("editCustomerTargetNumber").value;
                        row.getElementsByTagName("td")[5].textContent = document.getElementById("editCommitDate").value;
                        row.getElementsByTagName("td")[6].textContent = document.getElementById("editUpdateDate").value;

                        closeModal();
                    } else {
                        alert('Error updating data.');
                    }
                })
                .catch(error => console.error('Error:', error));
            });

            document.getElementById("addForm").addEventListener("submit", function(event) {
    event.preventDefault();

    var formData = new FormData(this);

    fetch('add.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('เพิ่มข้อมูลเรียบร้อยแล้ว!');
            // Add new data to table
            var tableBody = document.getElementById("tableBody");
            var newRow = document.createElement("tr");
            newRow.setAttribute("data-id", data.id);
            newRow.innerHTML = `
                <td>${data.id}</td>
                <td>${document.getElementById("addYear").value}</td>
                <td>${document.getElementById("addProductNo").value}</td>
                <td>${document.getElementById("addProductName").value}</td>
                <td>${document.getElementById("addCustomerTargetNumber").value}</td>
                <td>${document.getElementById("addCommitDate").value}</td>
                <td>${document.getElementById("addUpdateDate").value}</td>
                <td>
                    <button class='editBtn'>แก้ไขข้อมูล</button>
                    <button class='deleteBtn'>ลบข้อมูล</button>
                    <button class='viewBtn'>ดูรายละเอียด</button>
                </td>
            `;
            tableBody.appendChild(newRow);

            closeAddModal();
        } else {
            alert('Error adding data.');
        }
    })
    .catch(error => console.error('Error:', error));
});

            });

        function openAddModal() {
            document.getElementById("addModal").style.display = "block";
        }

        function closeAddModal() {
            document.getElementById("addModal").style.display = "none";
        }

        function closeModal() {
            document.getElementById("editModal").style.display = "none";
        }

        function closeViewModal() {
            document.getElementById("viewModal").style.display = "none";
        }
    </script>
    <div class="container">
    <a class="logout" href="home.php">ออกจากระบบ</a>
</body>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> -->
</html>