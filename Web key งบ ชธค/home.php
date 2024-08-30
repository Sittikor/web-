<?php
session_start();

$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$permissions_file = 'permissions.json';

function get_permissions($file) {
    return file_exists($file) ? json_decode(file_get_contents($file), true) : [];
}

$permissions = get_permissions($permissions_file);

$has_function1_permission = isset($permissions[$username]['function1']) && $permissions[$username]['function1'];
$has_function2_permission = isset($permissions[$username]['function2']) && $permissions[$username]['function2'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Home</title>
    <style>
        .top-center {
            margin-top: 5px;
            font-size: 50px;
            text-align: center;
            color: #4D4D4D;
        }
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
            background-color: #87CEFA;
        }
        .button-container {
            display: flex;
            gap: 20px;
            margin-top: 100px;
        }
        button {
            padding: 100px 180px;
            font-size: 25px;
            cursor: pointer;
            border: 3px solid #ccc;
            border-radius: 10px;
            background-color: #f0f0f0;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #FFB852;
        }
        button.disabled {
            background-color: #ddd;
            cursor: not-allowed;
        }
        .bottom-center {
            position: fixed;
            bottom: 100px;
            width: 100%;
            text-align: center;
        }
        .bottom-center button {
            padding: 20px 50px;
            font-size: 20px;
            border: 3px solid #ccc;
            border-radius: 10px;
            background-color: #f0f0f0;
            transition: background-color 0.3s;
        }
        .bottom-center button:hover {
            background-color: #FFB852;
        }
    </style>
</head>
<body>

<div class="top-center">
    ระบบ Key งบประมาณ ชธค.
</div>

<div class="button-container">
    <form action="function1.php" method="post">
        <button type="submit" <?php echo $has_function1_permission ? '' : 'class="disabled" disabled'; ?>>Function1</button>
        <input type="hidden" name="username" value="<?php echo htmlspecialchars($username); ?>">
    </form>
    <form action="function2.php" method="post">
        <button type="submit" <?php echo $has_function2_permission ? '' : 'class="disabled" disabled'; ?>>Function2</button>
        <input type="hidden" name="username" value="<?php echo htmlspecialchars($username); ?>">
    </form>
</div>

<div class="bottom-center">
    <form action="login-user.php" method="post">
        <button type="submit">เสร็จสิ้น</button>
    </form>
</div>

</body>
</html>
