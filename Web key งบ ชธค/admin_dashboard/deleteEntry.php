<?php
date_default_timezone_set('Asia/Bangkok');
$log_filename = 'reported_usernames.log';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['index'])) {
        $index = intval($_POST['index']);

        if (file_exists($log_filename)) {
            $log_entries = file($log_filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            if ($log_entries !== false && isset($log_entries[$index])) {
                // Remove the specified entry
                unset($log_entries[$index]);

                // Reindex array and write the updated log entries back to the file
                $log_entries = array_values($log_entries);
                file_put_contents($log_filename, implode(PHP_EOL, $log_entries) . PHP_EOL);

                echo 'Entry deleted successfully';
                exit;
            }
        }
    }
    echo 'Invalid request';
} else {
    echo 'Invalid request method';
}
?>
