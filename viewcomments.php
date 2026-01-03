<?php
// Start the session
session_start();

// Include header and database connection
$page_title = "View Comments";
include("header.php");
include("mysqli_connect.php");

// Get the blog post ID from the query parameters
$blogid = mysqli_real_escape_string($dbc, trim($_GET['blogpost_id']));

// Retrieve comments from the database for the specified blog post
$query = "SELECT c.*, u.first_name, u.last_name FROM comments c JOIN users u ON c.user_id = u.user_id WHERE c.blogpost_id = $blogid";
$result = mysqli_query($dbc, $query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo $page_title; ?>
    </title>
    <link rel="stylesheet" href="view.css">
</head>

<body class="view-comments-page">
    <div class="wrapper">
        <div class="content">
            <div class="container">
                <?php
                // Display success message if set
                if (isset($_GET['successMessage'])) {
                    echo '<div class="message success">' . htmlspecialchars($_GET['successMessage']) . '</div>';
                }

                // Check if there are comments
                if (mysqli_num_rows($result) > 0) {
                    // Loop through and display each comment
                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                        ?>
                        <div class="card">
                            <strong>Comment for Blog Post ID: <?php echo $row['blogpost_id']; ?></strong>
                            <p><?php echo $row['comment_body']; ?></p>
                            <p><em>Posted by <?php echo $row['first_name'] . ' ' . $row['last_name']; ?> on
                                    <?php echo $row['comment_timestamp']; ?></em></p>

                            <?php
                            // Check if the user is logged in and is the owner of the comment or user ID 2
                            if (isset($_SESSION['user_id']) && ($_SESSION['user_id'] == $row['user_id'] || $_SESSION['user_id'] == 2)) {
                                ?>
                                <a class="btn btn-edit"
                                    href="update_comments.php?comment_id=<?php echo $row['comment_id']; ?>&blogpost_id=<?php echo $blogid; ?>">Edit</a>
                                <a class="btn btn-delete"
                                    href="delete_comments.php?comment_id=<?php echo $row['comment_id']; ?>&blogpost_id=<?php echo $blogid; ?>&source=viewcomments">Delete</a>
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                    }
                } else {
                    // Display a message if there are no comments
                    echo "<p>No comments available for this blog post.</p>";
                }

                // Close the database connection
                mysqli_close($dbc);
                ?>
            </div>
        </div>

        <!-- Include the footer -->
        <footer class="footer">
            <?php include("footer.php"); ?>
        </footer>
    </div>
</body>

</html>