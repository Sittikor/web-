<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $role_id = $_POST['role'];

    if (empty($username) || empty($password) || empty($role_id)) {
        $_SESSION['notification'] = array(
            'type' => 'danger',
            'message' => 'All fields are required.'
        );
        header("Location: register.php");
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $conn->prepare("SELECT id FROM roles WHERE id = ?");
    $stmt->bind_param("i", $role_id);
    $stmt->execute();
    $role_check_result = $stmt->get_result();

    if ($role_check_result->num_rows > 0) {
        $stmt = $conn->prepare("INSERT INTO users (username, password, role_id) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $username, $hashed_password, $role_id);

        if ($stmt->execute()) {
            $_SESSION['notification'] = array(
                'type' => 'success',
                'message' => 'ลงทะเบียนสำเร็จ'
            );
        } else {
            $_SESSION['notification'] = array(
                'type' => 'danger',
                'message' => 'Error: ' . $stmt->error
            );
        }
    } else {
        $_SESSION['notification'] = array(
            'type' => 'danger',
            'message' => 'Invalid role selected.'
        );
    }
    header("Location: register.php");
    exit();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สมัครสมาชิก</title>
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="login-background-blue">

<div class="flex-login-form">
    <h1 class="text-white mb-5">สมัครสมาชิก</h1>

    <?php if (isset($_SESSION['notification'])) : ?>
        <div class="alert alert-<?php echo $_SESSION['notification']['type']; ?>" role="alert">
            <?php echo $_SESSION['notification']['message']; unset($_SESSION['notification']); ?>
        </div>
    <?php endif; ?>

    <form class="p-5 card login-card-custom" action="register.php" method="post">
        <div class="form-outline mb-3">
            <label class="form-label" for="username">Username/Email</label>
            <input type="text" name="username" class="form-control" />
        </div>

        <div class="form-outline mb-3">
            <label class="form-label" for="password">Password</label>
            <input type="password" name="password" class="form-control" />
        </div>

        <div class="form-outline mb-3">
            <label class="form-label" for="role">Role</label>
            <select name="role" class="form-control">
                <option value="1">Admin</option>
                <!-- <option value="2">Editor</option>
                <option value="3">Viewer</option> -->
            </select>
        </div>

        <div class="row">
            <p class="text-center">Already a member? <a href="login_db.php">Login</a></p>
        </div>

        <button type="submit" class="btn login-btn-blue btn-block text-white" name="submit">Register</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>
