<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible=IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <style>
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th, td {
      padding: 8px 12px;
      border: 1px solid #ddd;
      text-align: left;
    }
    th {
      background-color: #f2f2f2;
    }
  </style>
</head>
<body>
  <h1>Reported Usernames</h1>
  <table>
    <thead>
      <tr>
        <th>Username</th>
        <th>Timestamp</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
      date_default_timezone_set('Asia/Bangkok');
      $log_filename = 'reported_usernames.log';

      if (file_exists($log_filename)) {
        $log_entries = file($log_filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        if ($log_entries !== false) {
          foreach ($log_entries as $index => $log_entry) {
            list($username, $timestamp) = explode(' - ', $log_entry);
            echo '<tr>';
            echo '<td><input type="text" id="username_' . $index . '" value="' . htmlspecialchars($username) . '"></td>';
            echo '<td><input type="text" id="timestamp_' . $index . '" value="' . htmlspecialchars($timestamp) . '"></td>';
            echo '<td>';
            echo '<button onclick="updateEntry(' . $index . ')">Update</button>&nbsp;&nbsp';
            echo '<button onclick="deleteEntry(' . $index . ')">Delete</button>';
            echo '</td>';
            echo '</tr>';
          }
        } else {
          echo '<tr><td colspan="3">Error reading log file.</td></tr>';
        }
      } else {
        echo '<tr><td colspan="3">No reported usernames yet.</td></tr>';
      }
      ?>
    </tbody>
  </table>

  <script src="js/jquery-3.2.1.min.js"></script>
  <script>
    function updateEntry(index) {
      var username = document.getElementById('username_' + index).value;
      var timestamp = document.getElementById('timestamp_' + index).value;

      $.ajax({
        url: 'editEntry.php',
        method: 'POST',
        data: { index: index, username: username, timestamp: timestamp },
        success: function(response) {
          alert('อัพเดทรายการเรียบร้อยแล้ว!');
          location.reload(); // Reload the page to reflect changes
        },
        error: function(xhr, status, error) {
          console.error('Error updating entry:', error);
          alert('Failed to update entry.');
        }
      });
    }

    function deleteEntry(index) {
      $.ajax({
        url: 'deleteEntry.php',
        method: 'POST',
        data: { index: index },
        success: function(response) {
          alert('ลบรายการเรียบร้อยแล้ว!');
          location.reload(); // Reload the page to reflect changes
        },
        error: function(xhr, status, error) {
          console.error('Error deleting entry:', error);
          alert('Failed to delete entry.');
        }
      });
    }
  </script>

</body>
</html>
