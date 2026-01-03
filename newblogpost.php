<?php
session_start();
include("mysqli_connect.php");

// Check if the user is logged in and is an admin (user_id = 2)
if (!isset($_SESSION['user_id']) || ($_SESSION['user_id'] != 2)) {
    header('Location: https://klibowi2.soisweb.uwm.edu/capstone/newblogpost');
    exit();
}

$page_title = "New Blog Post"; // Set the page title

// Check if the 'pinned' column exists before adding it
$checkColumnQuery = "SHOW COLUMNS FROM blogposts LIKE 'pinned'";
$checkColumnResult = mysqli_query($dbc, $checkColumnQuery);

if (mysqli_num_rows($checkColumnResult) == 0) {
    $alterQuery = "ALTER TABLE blogposts ADD COLUMN pinned TINYINT(1) NOT NULL DEFAULT 0";
    mysqli_query($dbc, $alterQuery);
}

$success_message = '';
$error_messages = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle the form submission for creating a new blog post
    $user_id = $_SESSION['user_id'];
    $blogpost_title = mysqli_real_escape_string($dbc, $_POST['blogpost_title']);
    $blogpost_content = mysqli_real_escape_string($dbc, $_POST['blogpost_content']);
    $pinned = isset($_POST['pinned']) ? 1 : 0;  // Set to 1 if checked, 0 if not

    // Validate required fields
    if (empty($blogpost_title)) {
        $error_messages['blogpost_title'] = "Blogpost title is required.";
    }

    if (empty($blogpost_content)) {
        $error_messages['blogpost_content'] = "Blogpost content is required.";
    }

    // Insert blog post into the blogposts table if no errors
    if (empty($error_messages)) {
        $sql = "INSERT INTO blogposts (user_id, blogpost_title, blogpost_body, pinned) VALUES ('$user_id', '$blogpost_title', '$blogpost_content', '$pinned')";
        $result = mysqli_query($dbc, $sql);

        if ($result) {
            // Set success message
            $success_message = "Blog post added successfully!";
        } else {
            echo "Error adding blog post: " . mysqli_error($dbc);
        }
    }
}

mysqli_close($dbc);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="form.css">
</head>

<body>
    <?php include('header.php'); ?>

    <div class="container">
        <h1>Create New Blog Post</h1>

        <div class="card">
            <form method="post" action="newblogpost.php">
                <label for="blogpost_title">Blog Post Title:</label>
                <input type="text" name="blogpost_title" value="<?php echo htmlspecialchars($blogpost_title ?? ''); ?>">
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($blogpost_title)) {
                    echo '<div class="error-card">Blogpost title is required.</div>';
                }
                ?>

                <label for="blogpost_content"><br>Blog Post Content:</label>
                <textarea name="blogpost_content"><?php echo htmlspecialchars($blogpost_content ?? ''); ?></textarea>
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($blogpost_content)) {
                    echo '<div class="error-card">Blogpost content is required.</div>';
                }
                ?><br>
                <input type="submit" value="Create">
            </form>
        </div>

        <?php if (empty($error_messages) && !empty($success_message)): ?>
            <div class="success-message"><?php echo htmlspecialchars($success_message); ?></div>
        <?php endif; ?>
    </div>

    <?php include('footer.php'); ?>
</body>

</html>