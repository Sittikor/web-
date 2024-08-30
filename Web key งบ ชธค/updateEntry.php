<?php
session_start();
$permissions_file = 'permissions.json';

function get_permissions($file) {
    return file_exists($file) ? json_decode(file_get_contents($file), true) : [];
}

function save_permissions($file, $permissions) {
    file_put_contents($file, json_encode($permissions, JSON_PRETTY_PRINT));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $index = $_POST['index'];
    $username = $_POST['username'];
    $timestamp = $_POST['timestamp'];
    $function1 = $_POST['function1'];
    $function2 = $_POST['function2'];

    $log_filename = 'reported_usernames.log';
    $log_entries = file($log_filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    if ($log_entries !== false && isset($log_entries[$index])) {
        $log_entries[$index] = "$username - $timestamp";
        file_put_contents($log_filename, implode(PHP_EOL, $log_entries) . PHP_EOL);
    }

    $permissions = get_permissions($permissions_file);
    $permissions[$username] = [
        'function1' => $function1 === 'function1',
        'function2' => $function2 === 'function2'
    ];
    save_permissions($permissions_file, $permissions);

    echo json_encode(['status' => 'success']);
}
?>
