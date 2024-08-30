<?php
session_start();

// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $index = filter_input(INPUT_POST, 'index', FILTER_VALIDATE_INT);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $permissions_file = 'permissions.json';

    if ($index !== false && $username) {
        // Load existing permissions
        if (file_exists($permissions_file)) {
            $permissions = json_decode(file_get_contents($permissions_file), true);

            // Update permissions
            if (!isset($permissions[$username])) {
                $permissions[$username] = [];
            }
            $permissions[$username]['function1'] = true;
            $permissions[$username]['function2'] = false; // Set function2 to false

            // Save permissions back to the file
            file_put_contents($permissions_file, json_encode($permissions));

            echo 'Success';
        } else {
            echo 'Permissions file not found';
        }
    } else {
        echo 'Invalid input';
    }
} else {
    echo 'Invalid request method';
}
?>
