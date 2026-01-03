<?php
session_start();
include("mysqli_connect.php");

$successMessage = isset($_SESSION['successMessage']) ? $_SESSION['successMessage'] : "";
unset($_SESSION['successMessage']); // Clear after displaying

$errorMessages = [];
$comment_id = "";

if (isset($_GET['comment_id'])) {
    $comment_id = mysqli_real_escape_string($dbc, trim($_GET['comment_id']));

    // Update the SQL query to allow admin to access any comment
    $sql_select = "SELECT comment_body FROM comments WHERE comment_id = ? AND (user_id = ? OR ? = 2)";
    $stmt = mysqli_prepare($dbc, $sql_select);
    mysqli_stmt_bind_param($stmt, "iii", $comment_id, $_SESSION['user_id'], $_SESSION['user_id']); // Pass user_id twice
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $comment_body = $row['comment_body'];
    } else {
        $errorMessages[] = "Error: Comment not found or unauthorized.";
    }
    mysqli_stmt_close($stmt);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (is_numeric($comment_id) && empty($errorMessages)) {
        $sql_delete = "DELETE FROM comments WHERE comment_id = ? AND (user_id = ? OR ? = 2)";
        $stmt = mysqli_prepare($dbc, $sql_delete);
        mysqli_stmt_bind_param($stmt, "iii", $comment_id, $_SESSION['user_id'], $_SESSION['user_id']); // Pass user_id twice

        // Execute the query
        if (mysqli_stmt_execute($stmt)) {
            $successMessage = "Comment deleted successfully.";
        } else {
            $errorMessages[] = "Error deleting comment.";
        }
        mysqli_stmt_close($stmt);
    } else {
        $errorMessages[] = "Invalid Comment ID.";
    }
}

mysqli_close($dbc);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Delete Comment</title>
    <link rel="stylesheet" href="delete.css">
</head>

<body>
    <?php include("header.php"); ?>

    <div class="container">
        <h1>Delete Comment</h1>

        <?php if (!empty($successMessage)): ?>
            <div class="success-message"><?php echo htmlspecialchars($successMessage); ?></div>
        <?php endif; ?>

        <div class="card">
            <form method="post" action="delete_comments.php?comment_id=<?php echo htmlspecialchars($comment_id); ?>">
                <p>Are you sure you want to delete this comment?</p>
                <p class="delete-content"><?php echo htmlspecialchars($comment_body); ?></p>
                <input type="submit" value="Delete Comment">
            </form>
        </div>

        <?php foreach ($errorMessages as $errorMessage): ?>
            <div class="error-card"><?php echo htmlspecialchars($errorMessage); ?></div>
        <?php endforeach; ?>
    </div>

    <?php include("footer.php"); ?>
</body>

</html>