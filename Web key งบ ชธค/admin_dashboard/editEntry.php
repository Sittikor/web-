<?php
date_default_timezone_set('Asia/Bangkok');
$log_filename = 'reported_usernames.log';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['index']) && isset($_POST['username']) && isset($_POST['timestamp'])) {
        $index = intval($_POST['index']);
        $new_username = $_POST['username'];
        $new_timestamp = $_POST['timestamp'];

        if (file_exists($log_filename)) {
            $log_entries = file($log_filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            if ($log_entries !== false && isset($log_entries[$index])) {
                // Update the entry with the new username and timestamp
                $log_entries[$index] = $new_username . ' - ' . $new_timestamp;

                // Write the updated log entries back to the file
                file_put_contents($log_filename, implode(PHP_EOL, $log_entries) . PHP_EOL);

                echo 'Entry updated successfully';
                exit;
            }
        }
    }
    echo 'Invalid request';
} else {
    echo 'Invalid request method';
}
?>
