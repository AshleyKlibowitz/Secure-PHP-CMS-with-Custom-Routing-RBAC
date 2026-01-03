<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="header.css">
</head>

<body>

    <div id="navigation">
        <ul>
            <li><a href="index">Home Page</a></li>
            <?php if (!isset($_SESSION['user_id'])): ?>
                <li><a href="register">Register</a></li>
            <?php endif; ?>
            <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == 2): ?>
                <li><a href="view_users">View Users</a></li>
            <?php endif; ?>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="password">Change Password</a></li>
                <li><a href="profile.php">Profile</a></li>
            <?php endif; ?>

            <?php
            // Create a login/logout link
            if (isset($_SESSION['user_id']) && (basename($_SERVER['PHP_SELF']) !== 'logout')) {
                echo '<li><a href="logout">Logout</a></li>';
                // Show "New Blog Post" for admin user
                if ($_SESSION['user_id'] == 2) {
                    echo '<li><a href="newblogpost">New Blog Post</a></li>';
                }
            } else {
                echo '<li><a href="login">Login</a></li>';
            }
            ?>
        </ul>
    </div>

</body>

</html>