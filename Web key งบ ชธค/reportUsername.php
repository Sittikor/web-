<?php
date_default_timezone_set('Asia/Bangkok');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username'])) {
        $reported_username = $_POST['username'];
        
        // Log the reported username with the timestamp following the username
        $log_filename = 'reported_usernames.log';
        $log_entry = $reported_username . ' - ' . date('d-m-y H:i:s') . PHP_EOL;
        
        // Append to the log file
        file_put_contents($log_filename, $log_entry, FILE_APPEND | LOCK_EX);
        
        // Respond with success message
        echo 'Username reported successfully.';
    } else {
        http_response_code(400);
        echo 'Error: Username not provided.';
    }
} else {
    http_response_code(405);
    echo 'Error: Invalid request method.';
}
?>
