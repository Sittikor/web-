<?php
session_start();
$permissions_file = 'permissions.json';

function get_permissions($file) {
    return file_exists($file) ? json_decode(file_get_contents($file), true) : [];
}

function save_permissions($file, $permissions) {
    file_put_contents($file, json_encode($permissions, JSON_PRETTY_PRINT));
}

$permissions = get_permissions($permissions_file);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];

    if (isset($_POST['delete'])) {
        if (isset($permissions[$username])) {
            unset($permissions[$username]);
            $_SESSION['message'] = "ลบผู้ใช้งาน $username เรียบร้อยแล้ว.";
        } else {
            $_SESSION['message'] = "ไม่สามารถพบผู้ใช้งาน $username ในระบบ.";
        }    
    } else {
        $permissions[$username]['function1'] = isset($_POST['function1']);
        $permissions[$username]['function2'] = isset($_POST['function2']);
        $permissions[$username]['function1_and_2'] = isset($_POST['function1_and_2']);

        if (isset($_POST['function1_and_2'])) {
            $permissions[$username]['function1'] = true;
            $permissions[$username]['function2'] = true;
        }

        $_SESSION['message'] = "ปรับปรุงสิทธิ์ของผู้ใช้งาน $username เรียบร้อยแล้ว.";
    }

    save_permissions($permissions_file, $permissions);

    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();

}


$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
unset($_SESSION['message']);

$log_filename = 'reported_usernames.log';

function read_log($file) {
    return file_exists($file) ? file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];
}

$log_entries = read_log($log_filename);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ปรับปรุงสิทธิ์เข้าใช้งาน</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        h1 {
            color: #333;
            text-align: center;
        }
        table {
            width: 80%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 12px 15px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        form {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .logout {
            display: inline-block;
            background-color: #007bff;
            color: #fff;
            padding: 10px 15px;
            border-radius: 4px;
            text-decoration: none;
            text-align: center;
        }
        .logout:hover {
            background-color: #c82333;
        }
        .message {
            background-color: #d4edda;
            color: #155724;
            padding: 10px 20px;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
    <script>
    function confirmDelete(username) {
        return confirm("คุณต้องการลบผู้ใช้งาน " + username + " ใช่หรือไม่?");
    }
</script>

</head>
<body>
    <h1>ปรับปรุงสิทธิ์เข้าใช้งาน</h1>
    <?php if ($message): ?>
        <div class="message">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>
    <table>
        <thead>
            <tr>
                <th>Username</th>
                <th>Timestamp</th>
                <th>Function1 Permission</th>
                <th>Function2 Permission</th>
                <th>Function1 and 2 Permission</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <tbody>
    <style>
        input[type="checkbox"] {
    margin: 0;
    vertical-align: middle;
    cursor: pointer;
}
form {
    display: inline-block;
    margin: 0;
}
button {
    margin: 0;
    vertical-align: middle;
    cursor: pointer;
}
td {
    padding: 8px;
    vertical-align: middle;
}

        </style>
    <?php foreach ($log_entries as $entry): ?>
        <?php list($username, $timestamp) = explode(' - ', $entry); ?>
        <tr>
            <td><?php echo htmlspecialchars($username); ?></td>
            <td><?php echo htmlspecialchars($timestamp); ?></td>
            <td>
                <form method="post" style="display:inline;">
                    <input type="checkbox" name="function1" value="<?php echo htmlspecialchars($username); ?>" <?php echo isset($permissions[$username]['function1']) && $permissions[$username]['function1'] ? 'checked' : ''; ?> onchange="this.form.submit()">
                    <label for="function1"></label>
                </form>
            </td>
            <td>
                <form method="post" style="display:inline;">
                    <input type="checkbox" name="function2" value="<?php echo htmlspecialchars($username); ?>" <?php echo isset($permissions[$username]['function2']) && $permissions[$username]['function2'] ? 'checked' : ''; ?> onchange="this.form.submit()">
                    <label for="function2"></label>
                </form>
            </td>
            <td>
                <form method="post" style="display:inline;">
                    <input type="checkbox" name="function1_and_2" value="<?php echo htmlspecialchars($username); ?>" <?php echo isset($permissions[$username]['function1_and_2']) && $permissions[$username]['function1_and_2'] ? 'checked' : ''; ?> onchange="this.form.submit()">
                    <label for="function1_and_2"></label>
                </form>
            </td>
            <td>
                <form method="post" onsubmit="return confirmDelete('<?php echo htmlspecialchars($username); ?>')" style="display:inline;">
                    <button type="submit" name="delete" value="<?php echo htmlspecialchars($username); ?>" style="background-color: #dc3545;">Delete</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>

    </table>

    <a class="logout" href="login_db.php">Logout</a>
</body>
</html>





