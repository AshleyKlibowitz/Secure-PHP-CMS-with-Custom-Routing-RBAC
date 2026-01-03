<?php
session_start(); // Start the session
include('mysqli_connect.php');

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to the login page
    exit(); // Stop further execution
}

$user_id = mysqli_real_escape_string($dbc, trim($_SESSION['user_id']));
$blogpost_id = mysqli_real_escape_string($dbc, trim($_GET['blogpost_id']));
$success_message = ''; // Initialize success message variable
$error_message = ''; // Initialize error message variable

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $comment_body = mysqli_real_escape_string($dbc, trim($_POST['comment']));

    // Ensure the comment is not empty or just spaces
    if (!empty($comment_body)) {
        $query = "INSERT INTO comments (user_id, blogpost_id, comment_body, comment_timestamp)
                  VALUES ('$user_id', '$blogpost_id', '$comment_body', NOW())";

        $results = mysqli_query($dbc, $query);

        if ($results) {
            $success_message = "Success! Your comment was entered.";
        } else {
            $error_message = "There was an error: " . mysqli_error($dbc);
        }
    } else {
        $error_message = "Comment body is required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Comment</title>
    <link rel="stylesheet" href="form.css">
</head>

<body>
    <?php include('header.php'); ?>

    <div class="container">
        <h1>Comment</h1>

        <?php if (!empty($success_message)): ?>
            <div class="success-message"><?php echo htmlspecialchars($success_message); ?></div>
        <?php endif; ?>

        <div class="card">
            <form action="newcomment.php?blogpost_id=<?php echo htmlspecialchars($blogpost_id); ?>" method="post">
                <label for="comment">Please enter your comment for Blog Post ID:
                    <?php echo htmlspecialchars($blogpost_id); ?>:</label>
                <textarea name="comment" cols="40"
                    rows="5"><?php echo isset($comment_body) ? htmlspecialchars($comment_body) : ''; ?></textarea>
                <input type="submit" name="submit" value="Submit">
            </form>
        </div>

        <?php if (!empty($error_message)): ?>
            <div class="error-card"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>
    </div>

    <?php include("footer.php"); ?>
</body>

</html>