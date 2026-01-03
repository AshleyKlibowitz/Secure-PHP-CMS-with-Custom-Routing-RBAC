<?php
session_start();
include("mysqli_connect.php");

$successMessage = isset($_SESSION['successMessage']) ? $_SESSION['successMessage'] : "";
unset($_SESSION['successMessage']); // Clear after displaying

$errorMessages = [];
$comment_id = "";
$comment_body = "";
$blogpost_id = "";

if (isset($_GET['comment_id'])) {
    $comment_id = mysqli_real_escape_string($dbc, trim($_GET['comment_id']));

    // Update the SQL query to allow admin to access any comment
    $sql_select = "SELECT comment_body, blogpost_id FROM comments WHERE comment_id = ? AND (user_id = ? OR ? = 2)";
    $stmt = mysqli_prepare($dbc, $sql_select);
    mysqli_stmt_bind_param($stmt, "iii", $comment_id, $_SESSION['user_id'], $_SESSION['user_id']); // Pass user_id twice
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $comment_body = $row['comment_body'];
        $blogpost_id = $row['blogpost_id'];
    } else {
        $errorMessages[] = "Error: Comment not found or unauthorized.";
    }
    mysqli_stmt_close($stmt);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_comment_body = isset($_POST['comment_body']) ? trim($_POST['comment_body']) : "";

    if (empty($new_comment_body)) {
        $errorMessages[] = "Comment body is required.";
    }

    if (is_numeric($comment_id) && empty($errorMessages)) {
        $sql_update = "UPDATE comments SET comment_body = ? WHERE comment_id = ? AND (user_id = ? OR ? = 2)";
        $stmt = mysqli_prepare($dbc, $sql_update);
        mysqli_stmt_bind_param($stmt, "siii", $new_comment_body, $comment_id, $_SESSION['user_id'], $_SESSION['user_id']); // Pass user_id twice

        // Execute the query
        if (mysqli_stmt_execute($stmt)) {
            $successMessage = "Comment updated successfully.";
        } else {
            $errorMessages[] = "Error updating comment.";
        }
        mysqli_stmt_close($stmt);
    }
}

mysqli_close($dbc);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Comment</title>
    <link rel="stylesheet" href="form.css">
</head>

<body>
    <?php include("header.php"); ?>

    <div class="container">
        <h1>Edit Comment</h1>

        <?php if (!empty($successMessage)): ?>
            <div class="success-message"><?php echo htmlspecialchars($successMessage); ?></div>
        <?php endif; ?>

        <div class="card">
            <form method="post" action="update_comments.php?comment_id=<?php echo htmlspecialchars($comment_id); ?>">
                <label for="comment_body">Comment:</label>
                <textarea name="comment_body"><?php echo htmlspecialchars($comment_body); ?></textarea>
                <input type="submit" value="Update Comment">
            </form>
        </div>

        <?php foreach ($errorMessages as $errorMessage): ?>
            <div class="error-card"><?php echo htmlspecialchars($errorMessage); ?></div>
        <?php endforeach; ?>
    </div>

    <?php include("footer.php"); ?>
</body>

</html>