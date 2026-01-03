<?php
// Start the session at the very beginning
session_start();

// Script to display a single blog post
$page_title = 'View Blog Post';
include('header.php');
?>

<head>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>

<div class="view-blogpost-page">
    <?php
    if (isset($_GET['blogpost_id'])) {
        $blogpost_id = (int) $_GET['blogpost_id'];

        require('mysqli_connect.php'); // Connect to the database
    
        // Select the correct database
        mysqli_select_db($dbc, 'klibowi2_capstone'); // Specify the database to use
    
        // Get the blog post details
        $q = "SELECT blogpost_title, blogpost_body, blogpost_timestamp, user_id FROM blogposts WHERE blogpost_id = $blogpost_id";
        $r = @mysqli_query($dbc, $q);
        $post = mysqli_fetch_array($r, MYSQLI_ASSOC);

        if ($post) {
            // Get the author's details
            $q_author = "SELECT first_name, last_name FROM users WHERE user_id = " . $post['user_id'];
            $r_author = @mysqli_query($dbc, $q_author);
            $author = mysqli_fetch_array($r_author, MYSQLI_ASSOC);

            // Get the number of comments
            $q_comments = "SELECT COUNT(*) AS comment_count FROM comments WHERE blogpost_id = $blogpost_id";
            $r_comments = @mysqli_query($dbc, $q_comments);
            $comments = mysqli_fetch_array($r_comments, MYSQLI_ASSOC);

            echo '<div class="blogpost-container">';
            echo '<p><strong>Timestamp:</strong> ' . $post['blogpost_timestamp'] . '</p>';
            echo '<p><strong>Author:</strong> ' . $author['first_name'] . ' ' . $author['last_name'] . '</p>';
            echo '<p><strong>Post Title:</strong> ' . $post['blogpost_title'] . '</p>';
            echo '<p><strong>Post Content:</strong> ' . $post['blogpost_body'] . '</p>';
            echo '</div>';
        } else {
            echo '<p class="error">Blog post not found.</p>';
        }
    } else {
        echo '<p class="error">No blog post ID provided.</p>';
    }
    ?>
</div>

<?php include('footer.php'); ?>