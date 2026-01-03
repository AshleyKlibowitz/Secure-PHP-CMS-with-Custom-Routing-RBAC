<?php
// Start the session at the very beginning
session_start();

// Script to display user's profile with blog posts and comments
$page_title = 'User Profile';
include('header.php');

// Check for success message
if (isset($_GET['success'])) {
    echo '<div class="success">' . htmlspecialchars($_GET['success']) . '</div>';
}
?>

<link rel="stylesheet" type="text/css" href="profile.css">

<div class="wrapper">
    <div class="content">
        <?php
        // Check if a user is logged in
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];  // Get the logged-in user's ID from the session
        
            // Check if a user_id was passed in the URL for another user's profile
            if (isset($_GET['user_id'])) {
                $profile_user_id = (int) $_GET['user_id'];
            } else {
                // Default to the logged-in user
                $profile_user_id = $user_id;
            }

            require('mysqli_connect.php'); // Connect to the database
        
            // Select the correct database
            mysqli_select_db($dbc, 'klibowi2_capstone'); // Specify the database to use
        
            // Get the user's details
            $q = "SELECT first_name, last_name, email, registration_date, bio FROM users WHERE user_id = $profile_user_id";
            $r = @mysqli_query($dbc, $q);
            $row = mysqli_fetch_array($r, MYSQLI_ASSOC);

            if ($row) {
                echo '<div class="profile-container">';
                echo '<div style="position: relative;">';
                echo '<h1>' . $row['first_name'] . ' ' . $row['last_name'] . '</h1>';
                // If the logged-in user is an admin and viewing another user's profile, show the "Delete User" button
                if ($user_id == 2 && $user_id != $profile_user_id) {
                    echo '<a href="delete_user.php?user_id=' . $profile_user_id . '" class="delete-user-btn">Delete User</a>';
                }
                // If the logged-in user is viewing their own profile and is not an admin, show the "Delete Account" button
                if ($user_id == $profile_user_id && $user_id != 2) {
                    echo '<a href="delete_user.php?user_id=' . $profile_user_id . '" class="delete-user-btn">Delete Account</a>';
                }
                echo '</div>';
                echo '<div class="content-box">';
                echo '<p>Email: ' . $row['email'] . '</p>';
                echo '<p>Registered on: ' . $row['registration_date'] . '</p>';
                echo '</div>'; // Close content-box
        
                // Bio Section
                echo '<div class="bio-container">';
                echo '<h2>Bio</h2>';
                // If bio exists, display it
                if ($row['bio']) {
                    echo '<p>' . $row['bio'] . '</p>';
                } else {
                    echo '<p>No bio available.</p>';
                }
                // If the logged-in user is viewing their own profile or is an admin, show the "Edit Bio" button
                if ($user_id == $profile_user_id || $user_id == 2) {
                    echo '<a href="edit_bio.php?user_id=' . htmlspecialchars($profile_user_id) . '" class="edit-bio-btn">Edit Bio</a>';
                }
                echo '</div>'; // Close bio-container
        
                // Display user's blog posts
                echo '<div class="section blog-posts">';
                echo '<h2>My Blog Posts</h2>';
                $q_posts = "SELECT blogpost_id, blogpost_title, blogpost_body, blogpost_timestamp, user_id FROM blogposts WHERE user_id = $profile_user_id ORDER BY blogpost_timestamp DESC";
                $r_posts = @mysqli_query($dbc, $q_posts);
                if (mysqli_num_rows($r_posts) > 0) {
                    while ($post = mysqli_fetch_array($r_posts, MYSQLI_ASSOC)) {
                        echo '<div class="post">';
                        echo '<div class="post-header">' . $post['blogpost_title'] . '</div>';
                        echo '<div class="post-body">' . $post['blogpost_body'] . '</div>';
                        echo '<div class="post-footer"><span class="timestamp">Posted on: ' . $post['blogpost_timestamp'] . '</span>';
                        // Check if the logged-in user is the author of the blog post (by comparing user_id)
                        if ($user_id == $post['user_id']) {
                            echo "<div class='btn-group'>";
                            echo "<a class='btn btn-update' href='update.php?blogpost_id=" . $post['blogpost_id'] . "'>Update</a>";
                            echo "<a class='btn btn-delete' href='delete.php?delete_id=" . $post['blogpost_id'] . "'>Delete</a>";
                            echo "</div>";
                        }
                        echo '</div>'; // Close post-footer
                        echo '</div>'; // Close post
                    }
                } else {
                    echo '<p>No blog posts found.</p>';
                }
                echo '</div>'; // Close blog-posts section
        
                // Display user's comments
                echo '<div class="section comments">';
                echo '<h2> My Comments</h2>';
                $q_comments = "SELECT comment_id, comment_body, comment_timestamp, user_id, blogpost_id FROM comments WHERE user_id = $profile_user_id ORDER BY comment_timestamp DESC";
                $r_comments = @mysqli_query($dbc, $q_comments);
                if (mysqli_num_rows($r_comments) > 0) {
                    while ($comment = mysqli_fetch_array($r_comments, MYSQLI_ASSOC)) {
                        echo '<div class="comment">';
                        echo '<a href="view_blogpost.php?blogpost_id=' . $comment['blogpost_id'] . '" class="card-link">Comment for Blog Post ID: ' . $comment['blogpost_id'] . '</a>';
                        echo '<p>' . $comment['comment_body'] . '</p>';
                        echo '<div class="comment-footer"><span class="timestamp">Commented on: ' . $comment['comment_timestamp'] . '</span>';
                        // Check if the user is logged in and is the owner of the comment or user ID 2
                        if (isset($_SESSION['user_id']) && ($_SESSION['user_id'] == $comment['user_id'] || $_SESSION['user_id'] == 2)) {
                            echo "<div class='btn-group'>";
                            echo '<a class="btn btn-update" href="update_comments.php?comment_id=' . $comment['comment_id'] . '&blogpost_id=' . $comment['blogpost_id'] . '">Edit</a>';
                            echo '<a class="btn btn-delete" href="delete_comments.php?comment_id=' . $comment['comment_id'] . '&blogpost_id=' . $comment['blogpost_id'] . '&source=viewcomments">Delete</a>';
                            echo "</div>";
                        }
                        echo '</div>'; // Close comment-footer
                        echo '</div>'; // Close comment
                    }
                } else {
                    echo '<p>No comments found.</p>';
                }
                echo '</div>'; // Close comments section
                echo '</div>'; // Close profile-container
            } else {
                echo '<p class="error">User not found.</p>';
            }
        } else {
            echo '<p class="error">You are not logged in.</p>';
        }
        ?>
    </div>
    <?php include('footer.php'); // Include the footer ?>
</div>