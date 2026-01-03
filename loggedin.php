<?php # Script 12.13 - loggedin.php

// The user is redirected here from login.php.
session_start(); // Start the session.

// If no session value is present, redirect the user:
// Also validate the HTTP_USER_AGENT!
if (!isset($_SESSION['agent']) || $_SESSION['agent'] !== md5($_SERVER['HTTP_USER_AGENT'])) {
    // Need the functions:
    require('includes/login_functions.inc.php');
    redirect_user();
}

// Set the page title and include the HTML header:
$page_title = 'Logged In!';
include('header.php');
?>

<head>
    <link rel="stylesheet" type="text/css" href="auth.css">
</head>

<?php
// Print a customized message:
echo "<div class='container'>";
echo "<h1>Logged In!</h1>
<p>You are now logged in, {$_SESSION['first_name']}!</p>";
echo "</div>";

include('footer.php');
?>