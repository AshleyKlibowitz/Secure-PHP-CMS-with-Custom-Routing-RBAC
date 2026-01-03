<?php
// Start the session to access session variables
session_start();

// Include database connection
include('mysqli_connect.php');

// Check if the connection is established
if (!isset($dbc)) {
    die("Database connection not initialized.");
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to update your bio.");
}

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];

// Determine which user's bio should be edited
if ($user_id == 2 && isset($_GET['user_id']) && is_numeric($_GET['user_id'])) {
    $profile_user_id = (int) $_GET['user_id']; // Admin editing another user's bio
} else {
    $profile_user_id = $user_id; // Regular user or missing user_id
}

$success_message = '';
$current_bio = '';

// Fetch the current bio from the database for the user being edited
$stmt = $dbc->prepare("SELECT bio FROM users WHERE user_id = ?");
$stmt->bind_param("i", $profile_user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result) {
    $row = $result->fetch_assoc();
    $current_bio = $row ? $row['bio'] : '';
}

$stmt->close(); // Close the prepared statement

// Check if the form is submitted to update the bio
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update_bio'])) {
        // Get the submitted bio and sanitize it
        $new_bio = trim($_POST['bio']); // Trim whitespace

        // Basic validation
        if (strlen($new_bio) > 500) { // Limit bio length to 500 characters
            $success_message = "Bio must be 500 characters or less.";
            $current_bio = $new_bio; // Retain the submitted bio
        } else {
            // Prepare the SQL statement to prevent SQL injection
            $stmt = $dbc->prepare("UPDATE users SET bio = ? WHERE user_id = ?");
            $stmt->bind_param("si", $new_bio, $profile_user_id);

            if ($stmt->execute()) {
                // Update the session with the new bio if the logged-in user is updating their own bio
                if ($user_id == $profile_user_id) {
                    $_SESSION['bio'] = $new_bio;
                }

                // Set success message
                $success_message = "Bio updated successfully.";
                $current_bio = $new_bio; // Update the current bio
            } else {
                $success_message = "Error updating bio: " . $stmt->error;
                $current_bio = $new_bio; // Retain the submitted bio
            }

            $stmt->close(); // Close the prepared statement
        }
    } elseif (isset($_POST['delete_bio'])) {
        // Prepare the SQL statement to delete the bio
        $stmt = $dbc->prepare("UPDATE users SET bio = '' WHERE user_id = ?");
        $stmt->bind_param("i", $profile_user_id);

        if ($stmt->execute()) {
            // Update the session with the new bio if the logged-in user is deleting their own bio
            if ($user_id == $profile_user_id) {
                $_SESSION['bio'] = '';
            }

            // Set success message
            $success_message = "Bio deleted successfully.";
            $current_bio = ''; // Clear the current bio
        } else {
            $success_message = "Error deleting bio: " . $stmt->error;
        }

        $stmt->close(); // Close the prepared statement
    }

    // Fetch the updated bio from the database for the user being edited
    $stmt = $dbc->prepare("SELECT bio FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $profile_user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        $row = $result->fetch_assoc();
        $current_bio = $row ? $row['bio'] : '';
    }

    $stmt->close(); // Close the prepared statement
}

// Close the database connection
mysqli_close($dbc);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Bio</title>
    <link rel="stylesheet" href="form.css">
</head>

<body>
    <?php include('header.php'); ?>
    <!-- Bio Editing Form -->
    <div class="container">
        <h1>Edit Bio</h1>
        <div class="card">
            <?php if ($success_message): ?>
                <div class="success-message"><?php echo $success_message; ?></div>
            <?php endif; ?>
            <form action="edit_bio.php?user_id=<?php echo htmlspecialchars($profile_user_id); ?>" method="post">
                <label for="bio">Bio:</label>
                <textarea name="bio"
                    placeholder="Enter your new bio here..."><?php echo htmlspecialchars($current_bio ?? ''); ?></textarea>
                <input type="submit" name="update_bio" value="Update Bio">
                <button type="submit" name="delete_bio" class="reset-btn">Reset Bio</button>
            </form>
        </div>
    </div>
    <?php include("footer.php"); ?>
</body>

</html>