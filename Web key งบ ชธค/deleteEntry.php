<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $index = $_POST['index'];

    $log_filename = 'reported_usernames.log';
    $log_entries = file($log_filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    if ($log_entries !== false && isset($log_entries[$index])) {
        unset($log_entries[$index]);
        file_put_contents($log_filename, implode(PHP_EOL, $log_entries) . PHP_EOL);
    }

    echo json_encode(['status' => 'success']);
}
?>
