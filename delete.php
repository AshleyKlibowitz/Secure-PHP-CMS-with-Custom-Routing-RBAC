<?php
session_start();
include 'mysqli_connect.php';

$successMessage = isset($_SESSION['successMessage']) ? $_SESSION['successMessage'] : "";
unset($_SESSION['successMessage']); // Clear after displaying

$errorMessages = [];
$blogpost_id = "";
$blogpost_title = "";
$blogpost_body = "";
$blogpost_timestamp = "";
$author_name = "";
$comment_count = 0;

if (isset($_GET['delete_id']) && is_numeric($_GET['delete_id'])) {
    $blogpost_id = mysqli_real_escape_string($dbc, trim($_GET['delete_id']));

    // Fetch the blog post to confirm deletion
    $sql_select = "SELECT blogpost_title, blogpost_body, blogpost_timestamp, users.first_name, users.last_name 
                   FROM blogposts 
                   JOIN users ON blogposts.user_id = users.user_id 
                   WHERE blogpost_id = ?";
    $stmt = mysqli_prepare($dbc, $sql_select);
    mysqli_stmt_bind_param($stmt, "i", $blogpost_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $blogpost_title = $row['blogpost_title'];
        $blogpost_body = $row['blogpost_body'];
        $blogpost_timestamp = $row['blogpost_timestamp'];
        $author_name = $row['first_name'] . ' ' . $row['last_name'];

        // Fetch the number of comments
        $sql_comments = "SELECT COUNT(*) AS comment_count FROM comments WHERE blogpost_id = ?";
        $stmt_comments = mysqli_prepare($dbc, $sql_comments);
        mysqli_stmt_bind_param($stmt_comments, "i", $blogpost_id);
        mysqli_stmt_execute($stmt_comments);
        $result_comments = mysqli_stmt_get_result($stmt_comments);
        if ($row_comments = mysqli_fetch_assoc($result_comments)) {
            $comment_count = $row_comments['comment_count'];
        }
        mysqli_stmt_close($stmt_comments);
    } else {
        $errorMessages[] = "Error: Blog post not found.";
    }
    mysqli_stmt_close($stmt);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (is_numeric($blogpost_id) && empty($errorMessages)) {
        $sql_delete = "DELETE FROM blogposts WHERE blogpost_id = ?";
        $stmt = mysqli_prepare($dbc, $sql_delete);
        mysqli_stmt_bind_param($stmt, "i", $blogpost_id);

        // Execute the query
        if (mysqli_stmt_execute($stmt)) {
            $successMessage = "Blog post deleted successfully.";
        } else {
            $errorMessages[] = "Error deleting blog post.";
        }
        mysqli_stmt_close($stmt);
    } else {
        $errorMessages[] = "Invalid Blog Post ID.";
    }
}

mysqli_close($dbc);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Delete Blog Post</title>
    <link rel="stylesheet" href="delete.css">
</head>

<body>
    <?php include("header.php"); ?>

    <div class="container">
        <h1>Delete Blog Post</h1>

        <?php if (!empty($successMessage)): ?>
            <div class="success-message"><?php echo htmlspecialchars($successMessage); ?></div>
        <?php endif; ?>

        <div class="card">
            <form method="post" action="delete.php?delete_id=<?php echo htmlspecialchars($blogpost_id); ?>">
                <p>Are you sure you want to delete <strong>Blog Post ID:
                        <?php echo htmlspecialchars($blogpost_id); ?></strong>?</p>
                <p class="delete-content">
                    <strong>Posted on:</strong> <?php echo htmlspecialchars($blogpost_timestamp); ?><br>
                    <strong>Author:</strong> <?php echo htmlspecialchars($author_name); ?><br>
                    <strong>Title:</strong> <?php echo htmlspecialchars($blogpost_title); ?><br>
                    <strong>Content:</strong> <?php echo nl2br(htmlspecialchars($blogpost_body)); ?><br>
                    <strong>Number of comments:</strong> <?php echo htmlspecialchars($comment_count); ?>
                </p>
                <input type="submit" value="Delete Blog Post">
            </form>
        </div>

        <?php foreach ($errorMessages as $errorMessage): ?>
            <div class="error-card"><?php echo htmlspecialchars($errorMessage); ?></div>
        <?php endforeach; ?>
    </div>

    <?php include("footer.php"); ?>
</body>

</html>