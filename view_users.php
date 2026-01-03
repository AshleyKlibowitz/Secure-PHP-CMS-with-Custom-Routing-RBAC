<?php
// Script 9.6 - view_users.php #2
// This script retrieves all the records from the users table.

session_start();

// Check if the user is an admin
$is_admin = isset($_SESSION['user_id']) && $_SESSION['user_id'] == 2; // Assuming user_id 2 is the admin

$page_title = 'View the Current Users';
include('header.php');

// Page header and combined CSS styles:
echo '<head>
    <title>Guestbook</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>';

// Page header:
echo '<div class="view-users-container">
    <h1 class="view-users-header">Registered Users</h1>';

require('mysqli_connect.php'); // Connect to the db.

// Make the query:
$q = "SELECT user_id, CONCAT(last_name, ', ', first_name) AS name, DATE_FORMAT(registration_date, '%M %d, %Y') AS dr FROM users ORDER BY registration_date ASC";
$r = @mysqli_query($dbc, $q); // Run the query.

// Count the number of returned rows:
$num = mysqli_num_rows($r);

if ($num > 0) { // If it ran OK, display the records.

    // Print how many users there are:
    echo "<p class='view-users-count'>There are currently $num registered users.</p>\n";

    // Table header.
    echo '<table class="view-users-table">
    <thead>
    <tr><th class="view-users-th">Name</th><th class="view-users-th">Date Registered</th></tr></thead><tbody>'; // Removed Actions column

    // Fetch and print all the records:
    while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
        echo '<tr><td class="view-users-td">';
        if ($is_admin) {
            echo '<a href="profile.php?user_id=' . $row['user_id'] . '">' . $row['name'] . '</a>';
        } else {
            echo $row['name'];
        }
        echo '</td><td class="view-users-td">' . $row['dr'] . '</td></tr>';
    }

    echo '</tbody></table>'; // Close the table.

    mysqli_free_result($r); // Free up the resources.

} else { // If no records were returned.

    echo '<p class="view-users-error">There are currently no registered users.</p>';

}

mysqli_close($dbc); // Close the database connection.

echo '</div>'; // Close the container div

include('footer.php');
?>