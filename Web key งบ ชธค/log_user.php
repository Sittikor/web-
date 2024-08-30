<?php
session_start();

$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$log_file = 'access.log';
$log_entry = $username . ' - ' . date('Y-m-d H:i:s') . PHP_EOL;

file_put_contents($log_file, $log_entry, FILE_APPEND);
header('Location: home.php');
exit();
?>
