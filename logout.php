<?php
// This page lets the user logout.
// This version uses sessions.

session_start(); // Access the existing session.

// If no session variable exists, redirect the user:
if (!isset($_SESSION['user_id'])) {

    // Need the functions:
    require('login_functions.inc.php');
    redirect_user();

} else { // Cancel the session:

    $_SESSION = array(); // Clear the variables.
    session_destroy(); // Destroy the session itself.
    setcookie('PHPSESSID', '', time() - 3600, '/', '', 0, 0); // Destroy the cookie.

}

// Add the CSS styles:
echo '<head>
    <title>Guestbook</title>
    <link rel="stylesheet" type="text/css" href="auth.css">
</head>';

// Set the page title and include the HTML header:
$page_title = 'Logged Out!';
include('header.php');

// Print a customized message:
echo "<div class='centered'><h1>Logged Out!</h1>
<p>You are now logged out!</p></div>";

include('footer.php');
?>