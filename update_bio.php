<?php
session_start();
require('mysqli_connect.php'); // Connect to the database

if (isset($_SESSION['user_id']) && isset($_POST['bio'])) {
    $user_id = $_SESSION['user_id'];

    // Ensure bio is a string, even if empty
    $bio = isset($_POST['bio']) ? trim($_POST['bio']) : '';

    // Escape and sanitize input
    $bio = mysqli_real_escape_string($dbc, htmlspecialchars($bio, ENT_QUOTES, 'UTF-8'));

    $q = "UPDATE users SET bio = '$bio' WHERE user_id = $user_id";
    $r = @mysqli_query($dbc, $q);

    if ($r) {
        header("Location: profile.php?user_id=$user_id"); // Redirect back to profile
        exit();
    } else {
        echo '<p class="error">Failed to update bio.</p>';
    }
} else {
    echo '<p class="error">Please log in to update your bio.</p>';
}

mysqli_close($dbc);
