<?php
session_start();
require('mysqli_connect.php');

if (isset($_GET['comment_id']) && isset($_GET['blogpost_id'])) {
    $comment_id = (int) $_GET['comment_id'];
    $blogpost_id = (int) $_GET['blogpost_id'];
} else {
    // Redirect with an error message if comment_id or blogpost_id is not set
    header("Location: viewcomments.php?blogpost_id=" . (isset($_GET['blogpost_id']) ? (int) $_GET['blogpost_id'] : '') . "&error=" . urlencode("No comment ID or blog post ID provided."));
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Confirm Delete</title>
</head>

<body>
    <h1>Are you sure you want to delete this comment?</h1>
    <form method="post" action="delete_comments.php">
        <input type="hidden" name="comment_id" value="<?php echo htmlspecialchars($comment_id); ?>">
        <input type="hidden" name="blogpost_id" value="<?php echo htmlspecialchars($blogpost_id); ?>">
        <input type="submit" name="confirm" value="Yes">
        <a href="viewcomments.php?blogpost_id=<?php echo htmlspecialchars($blogpost_id); ?>">No</a>
    </form>
</body>

</html>