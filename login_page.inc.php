<?php
// This page prints any errors associated with logging in
// and it creates the entire login page, including the form.

// Include the header:
$page_title = 'Login';
include('header.php');

// Print any error messages, if they exist:
if (isset($errors) && !empty($errors)) {
    echo '<h1 class="error-title">Error!</h1>
    <p class="error">The following error(s) occurred:<br />';
    foreach ($errors as $msg) {
        echo " - $msg<br />\n";
    }
    echo '</p><p class="error-message">Please try again.</p>';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo $page_title; ?>
    </title>
    <style>
        /* Reset margin and padding for specific HTML elements to eliminate default spacing */
        body,
        h1,
        h2,
        p,
        ul,
        li {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            color: #333;
        }

        /* Header styling */
        header {
            background-color: #007ACC;
            color: #fff;
            padding: 10px;
        }

        .sort-options a:hover {
            text-decoration: underline;
        }

        /* Center error messages */
        .error {
            text-align: center;
            color: red;
        }

        .error-title {
            text-align: center;
            color: red;
        }

        .error-message {
            text-align: center;
            color: red;
        }

        /* Center the form */
        .login-form-container {
            position: absolute;
            top: 40%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .login-form {
            background-color: #fff;
            padding: 50px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 450px;
        }

        .login-form h1 {
            margin-bottom: 20px;
        }

        .login-form p {
            margin-bottom: 20px;
        }

        .login-form input[type="submit"] {
            display: block;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div class="login-form-container">
        <form class="login-form" action="login.php" method="post">
            <h1>Login</h1>
            <p>Email Address: <input type="text" name="email" size="20" maxlength="60" /> </p>
            <p>Password: <input type="password" name="pass" size="20" maxlength="20" /></p>
            <p><input type="submit" name="submit" value="Login" /></p>
        </form>
    </div>

    <?php include('footer.php'); ?>
</body>

</html>