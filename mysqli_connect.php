<?php
$servername = "localhost"; // Server name
$username = "klibowi2_finaladmin"; // MySQL username
$password = "Q@mv6GJ-D"; // MySQL password
$database = "klibowi2_capstone"; // Database name

// Create a connection to the database
$dbc = mysqli_connect($servername, $username, $password, $database);

// Check the connection
if (!$dbc) {
    die("Connection failed: " . mysqli_connect_error());
}
?>