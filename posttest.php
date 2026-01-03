<?php
session_start(); // Start the session.

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    include('header.php');

    // Check if the logged-in user is the admin (user_id = 2)
    if ($_SESSION['user_id'] == 2) {
        echo '<div style="text-align: center;"><strong>You are logged in as admin!</strong></div>';
    } else {
        echo '<div style="text-align: center;"><strong>You are logged in!</strong></div>';
    }
} else {
    // If not logged in, you can choose to handle this situation differently,
    // or simply display a message. For example:
    include('header.php');
    echo '<div style="text-align: center;"><strong>You are not logged in. Please log in to comment.</strong></div>';
}
?>