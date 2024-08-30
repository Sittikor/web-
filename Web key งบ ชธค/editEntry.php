<?php
session_start();

$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$permissions_file = 'permissions.json';
$log_filename = 'reported_usernames.log';

function get_permissions($file) {
    return file_exists($file) ? json_decode(file_get_contents($file), true) : [];
}

function save_permissions($file, $permissions) {
    file_put_contents($file, json_encode($permissions));
}

function update_log($file, $index, $entry) {
    $log_entries = file_exists($file) ? file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];
    $log_entries[$index] = $entry;
    file_put_contents($file, implode("\n", $log_entries));
}

$permissions = get_permissions($permissions_file);

// ตรวจสอบและปรับปรุงสิทธิ์เริ่มต้นถ้าต้องการ
if (!isset($permissions[$username]['function1'])) {
    $permissions[$username]['function1'] = true;
}

if (!isset($permissions[$username]['function2'])) {
    $permissions[$username]['function2'] = true;
}

save_permissions($permissions_file, $permissions);

// ตรวจสอบและอัพเดทข้อมูลเมื่อมีการ POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $index = filter_input(INPUT_POST, 'index', FILTER_VALIDATE_INT);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $timestamp = filter_input(INPUT_POST, 'timestamp', FILTER_SANITIZE_STRING);

    if ($index !== false && $username && $timestamp) {
        $permissions = get_permissions($permissions_file);

        if (!isset($permissions[$username])) {
            $permissions[$username] = [];
        }

        // ตรวจสอบและปรับปรุงสิทธิ์ตามที่ต้องการ
        if (isset($_POST['functions'])) {
            $functions = $_POST['functions'];
            foreach ($functions as $function => $value) {
                $permissions[$username][$function] = ($value === 'true'); // หรือใช้ค่า boolean true/false
            }
        }

        save_permissions($permissions_file, $permissions);

        // อัพเดท log หากต้องการ
        update_log($log_filename, $index, $username . ' - ' . $timestamp);

        echo "อัพเดทรายการเรียบร้อยแล้ว!";
    } else {
        echo "ข้อมูลไม่ถูกต้อง!";
    }

    exit();
}
?>
