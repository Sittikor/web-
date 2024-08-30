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
$sql = "SELECT * FROM `percentuf`";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Function2</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffff;
            padding: 20px;
        }
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
        button {
            background-color: #4CAF50; 
            border: none;
            color: white;
            padding: 9px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            cursor: pointer;
            border-radius: 8px;
            margin-right: 15px;
        }
        .addBtn {
            background-color: #28a745; /* Green */
            color: white;
        }
        .addBtn:hover {
            background-color: #218838;
        }
        .editBtn {
            background-color: #007BFF; /* Blue */
            color: white;
        }
        .deleteBtn{
            background-color: #DE1B1B;   
            color: white;
        }
        .viewBtn{
            background-color: #28a745;
            color: white;
        }
        .editBtn:hover {
            background-color: #0056b3;
        }
        .deleteBtn:hover{
            background-color: #c82333;
        }
        .viewBtn:hover{
            background-color: #218838;
        }
        #addInfoModal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border: 1px solid black;
            padding: 20px;
            background-color: white;
            z-index: 1000;
            border-top: 5px solid #FCE500; /* Yellow border at the top */
        }
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
         .centered {
            text-align: center;
            margin-bottom: 10px;
      
        }
        select {
        padding: 8px 12px; /* Padding for dropdown options */
        font-size: 16px; /* Font size */
        border: 1px solid #ccc; /* Border color */
        border-radius: 4px; /* Rounded corners */
        background-color: #fff; /* Background color */
    }
    .logout {
            display: inline-block;
            background-color: #c82333;
            color: #fff;
            padding: 10px 15px;
            border-radius: 4px;
            text-decoration: none;
            text-align: center;
        }
        .container {
            text-align: center;
            margin-top: 1%;
        }
    
    </style>
</head>
<body>

<!-- Add Info Button -->
<div class="centered">
<button id="addInfoBtn" class="addBtn">เพิ่มข้อมูล</button>
</div>
<!-- Add Info Modal -->
<div class="modal-overlay" id="modalOverlay"></div>
<div id="addInfoModal">
    <h2>เพิ่มข้อมูลใหม่</h2>
    <div class="form-group">
        <label for="newYear">Year:</label>
        <select id="newYear">
            <option value="2562">2562</option>
            <option value="2563">2563</option>
            <option value="2564">2564</option>
            <option value="2565">2565</option>
            <option value="2566">2566</option>
        </select>
    </div>
    <div class="form-group">
        <label for="newDept">Dept:</label>
        <select id="newDept">
            <option value="อบย.">อบย.</option>
            <option value="อบค.">อบค.</option>
            <option value="อบฟ.">อบฟ.</option>
            <option value="อรอ.">อรอ.</option>
            <option value="อคม.">อคม.</option>
        </select>
    </div>
    <div class="form-group">
        <label for="newUFType">UFType:</label>
        <input type="text" id="newUFType">
    </div>
    <div class="form-group">
        <label for="newMonthName">Month:</label>
        <select id="newMonthName">
            <option value="มกราคม">มกราคม</option>
            <option value="กุมภาพันธ์">กุมภาพันธ์</option>
            <option value="มีนาคม">มีนาคม</option>
            <option value="เมษายน">เมษายน</option>
            <option value="พฤษภาคม">พฤษภาคม</option>
            <option value="มิถุนายน">มิถุนายน</option>
            <option value="กรกฎาคม">กรกฎาคม</option>
            <option value="สิงหาคม">สิงหาคม</option>
            <option value="กันยายน">กันยายน</option>
            <option value="ตุลาคม">ตุลาคม</option>
            <option value="พฤศจิกายน">พฤศจิกายน</option>
            <option value="ธันวาคม">ธันวาคม</option>
        </select>
    </div>
    <div class="form-group">
        <label for="newPercentUF">Percent UF:</label>
        <input type="text" id="newPercentUF">
    </div>
    <button id="saveNewInfoBtn" class="addBtn">Save</button>
    <button id="cancelNewInfoBtn" class="addBtn">Cancel</button>
</div>

<div class="centered dropdown-container">
<select id="filterDropdown">
    <option value="all">เดือน</option>
    <option value="มกราคม">มกราคม</option>
    <option value="กุมภาพันธ์">กุมภาพันธ์</option>
    <option value="มีนาคม">มีนาคม</option>
    <option value="เมษายน">เมษายน</option>
    <option value="พฤษภาคม">พฤษภาคม</option>
    <option value="มิถุนายน">มิถุนายน</option>
    <option value="กรกฎาคม">กรกฎาคม</option>
    <option value="สิงหาคม">สิงหาคม</option>
    <option value="กันยายน">กันยายน</option>
    <option value="ตุลาคม">ตุลาคม</option>
    <option value="พฤศจิกายน">พฤศจิกายน</option>
    <option value="ธันวาคม">ธันวาคม</option>
</select>

<select id="yearDropdown">
    <option value="all">ปี</option>
    <option value="2562">2562</option>
    <option value="2563">2563</option>
    <option value="2564">2564</option>
    <option value="2565">2565</option>
    <option value="2566">2566</option> 
</select>

<select id="deptDropdown">
    <option value="all">ฝ่าย</option>
    <option value="อบย.">อบย.</option>
    <option value="อบค.">อบค.</option>
    <option value="อบฟ.">อบฟ.</option>
    <option value="อรอ.">อรอ.</option>
    <option value="อคม.">อคม.</option>
</select>
</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Year</th>
            <th>Dept</th>
            <th>UFType</th>
            <th>MonthName</th>
            <th>PercentUF</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody id="tableBody">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["ID"] . "</td>";
                echo "<td>" . $row["Year"] . "</td>";
                echo "<td>" . $row["Dept"] . "</td>";
                echo "<td>" . $row["UFType"] . "</td>";
                echo "<td>" . $row["MonthName"] . "</td>";
                echo "<td>" . $row["PercentUF"] . "</td>";
                echo "<td>";
                echo "<button class='editBtn'>แก้ไขข้อมูล</button>&nbsp;&nbsp;"; 
                echo "<button class='deleteBtn'>ลบข้อมูล</button>&nbsp;&nbsp;";
                echo "<button class='viewBtn'>ดูรายละเอียด</button>";
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

<script>
    function filterTable() {
        var selectedMonth = document.getElementById("filterDropdown").value;
        var selectedYear = document.getElementById("yearDropdown").value;
        var selectedDept = document.getElementById("deptDropdown").value;
        var rows = document.getElementById("tableBody").getElementsByTagName("tr");

        for (var i = 0; i < rows.length; i++) {
            var monthCell = rows[i].getElementsByTagName("td")[4].textContent.trim();
            var yearCell = rows[i].getElementsByTagName("td")[1].textContent.trim();
            var deptCell = rows[i].getElementsByTagName("td")[2].textContent.trim();

            if ((selectedMonth === "all" || monthCell === selectedMonth) &&
                (selectedYear === "all" || yearCell === selectedYear) &&
                (selectedDept === "all" || deptCell === selectedDept)) {
                rows[i].style.display = "";
            } else {
                rows[i].style.display = "none";
            }
        }
    }

    document.getElementById("filterDropdown").addEventListener("change", filterTable);
    document.getElementById("yearDropdown").addEventListener("change", filterTable);
    document.getElementById("deptDropdown").addEventListener("change", filterTable);

    function handleEdit(event) {
        var row = event.target.closest('tr');
        var cells = row.getElementsByTagName('td');
        if (event.target.textContent === "แก้ไขข้อมูล") {
            for (var i = 1; i < cells.length - 1; i++) {
                var cellValue = cells[i].textContent.trim();
                cells[i].innerHTML = '<input type="text" value="' + cellValue + '">';
            }
            event.target.textContent = "บันทึก";
        } else {
            var data = {};
            for (var i = 1; i < cells.length - 1; i++) {
                var input = cells[i].getElementsByTagName('input')[0];
                cells[i].textContent = input.value;
                data[cells[0].closest('table').getElementsByTagName('th')[i].innerText.toLowerCase()] = input.value;
            }
            data.id = cells[0].textContent;

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "update.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                    console.log("Data updated successfully");
                }
            };
            xhr.send(Object.keys(data).map(key => key + '=' + encodeURIComponent(data[key])).join('&'));

            event.target.textContent = "แก้ไขข้อมูล";
        }
    }

    function handleDelete(event) {
        var row = event.target.closest('tr');
        var id = row.getElementsByTagName('td')[0].textContent.trim();

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "delete2.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                if (this.responseText === "success") {
                    row.remove();
                    console.log("Data deleted successfully");
                } else {
                    console.error("Error deleting data: " + this.responseText);
                }
            }
        };
        xhr.send("id=" + encodeURIComponent(id));
    }

    function handleView(event) {
        var row = event.target.closest('tr');
        var ufType = row.getElementsByTagName('td')[3].textContent.trim();
        var percentUF = row.getElementsByTagName('td')[5].textContent.trim();

        alert("UFType: " + ufType + "\nPercentUF: " + percentUF);
    }

    var editButtons = document.getElementsByClassName('editBtn');
    for (var i = 0; i < editButtons.length; i++) {
        editButtons[i].addEventListener('click', handleEdit);
    }

    var deleteButtons = document.getElementsByClassName('deleteBtn');
    for (var i = 0; i < deleteButtons.length; i++) {
        deleteButtons[i].addEventListener('click', handleDelete);
    }

    var viewButtons = document.getElementsByClassName('viewBtn');
    for (var i = 0; i < viewButtons.length; i++) {
        viewButtons[i].addEventListener('click', handleView);
    }

    // Add Info Button Functionality
    document.getElementById('addInfoBtn').addEventListener('click', function() {
        document.getElementById('addInfoModal').style.display = 'block';
        document.getElementById('modalOverlay').style.display = 'block';
    });
 
    document.getElementById('cancelNewInfoBtn').addEventListener('click', function() {
        document.getElementById('addInfoModal').style.display = 'none';
        document.getElementById('modalOverlay').style.display = 'none';
    });

    document.getElementById('saveNewInfoBtn').addEventListener('click', function() {
        var newYear = document.getElementById('newYear').value;
        var newDept = document.getElementById('newDept').value;
        var newUFType = document.getElementById('newUFType').value;
        var newMonthName = document.getElementById('newMonthName').value;
        var newPercentUF = document.getElementById('newPercentUF').value;

        var data = {
            year: newYear,
            dept: newDept,
            uftype: newUFType,
            monthname: newMonthName,
            percentuf: newPercentUF
        };

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "add2.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                if (this.responseText === "success") {
                    var tableBody = document.getElementById('tableBody');
                    var newRow = tableBody.insertRow();
                    newRow.innerHTML = "<td>New ID</td>" + 
                                       "<td>" + newYear + "</td>" + 
                                       "<td>" + newDept + "</td>" + 
                                       "<td>" + newUFType + "</td>" + 
                                       "<td>" + newMonthName + "</td>" + 
                                       "<td>" + newPercentUF + "</td>" + 
                                       "<td><button class='editBtn'>แก้ไขข้อมูล</button>&nbsp;&nbsp;" + 
                                       "<button class='deleteBtn'>ลบข้อมูล</button>&nbsp;&nbsp;" + 
                                       "<button class='viewBtn'>ดูรายละเอียด</button></td>";
                    document.getElementById('addInfoModal').style.display = 'none';
                    document.getElementById('modalOverlay').style.display = 'none';
                    console.log("Data added successfully");

                    // Re-add event listeners for new row buttons
                    var editButtons = newRow.getElementsByClassName('editBtn');
                    for (var i = 0; i < editButtons.length; i++) {
                        editButtons[i].addEventListener('click', handleEdit);
                    }

                    var deleteButtons = newRow.getElementsByClassName('deleteBtn');
                    for (var i = 0; i < deleteButtons.length; i++) {
                        deleteButtons[i].addEventListener('click', handleDelete);
                    }

                    var viewButtons = newRow.getElementsByClassName('viewBtn');
                    for (var i = 0; i < viewButtons.length; i++) {
                        viewButtons[i].addEventListener('click', handleView);
                    }
                } else {
                    console.error("Error adding data: " + this.responseText);
                }
            }
        };
        xhr.send(Object.keys(data).map(key => key + '=' + encodeURIComponent(data[key])).join('&'));
    });
</script>
<div class="container">
<a class="logout" href="home.php">ออกจากระบบ</a>
</div>
</body>
</html>
