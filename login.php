<?php
// This page processes the login form submission.
// The script now stores the HTTP_USER_AGENT value for added security.

// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Need two helper files:
    require('login_functions.inc.php');
    require('mysqli_connect.php');

    // Check the login:
    list($check, $data) = check_login($dbc, $_POST['email'], $_POST['pass']);

    if ($check) { // OK!

        // Set the session data:
        session_start();
        $_SESSION['user_id'] = $data['user_id'];
        $_SESSION['first_name'] = $data['first_name'];

        // Store the HTTP_USER_AGENT:
        $_SESSION['agent'] = md5($_SERVER['HTTP_USER_AGENT']);

        // Redirect:
        redirect_user('loggedin.php');

    } else { // Unsuccessful!

        // Assign $data to $errors for login_page.inc.php:
        $errors = $data;

    }

    mysqli_close($dbc); // Close the database connection.

} // End of the main submit conditional.

// Create the page:
include('login_page.inc.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        // Add the CSS styles:
        echo '<head>
 <style>body,
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

        header {
            background-color: #007ACC;
            color: #fff;
            padding: 10px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        form {
            background-color: #f9f9f9;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-top: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #007ACC;
            color: #fff;
            border: none;
            padding: 10px 20px;
            margin-top: 10px;
            cursor: pointer;
            border-radius: 5px;
        }

        input[type="submit"]:hover {
            background-color: #005D91;
        }

        .error {
            color: red;
        }

        footer {
            background-color: #007ACC;
            color: #fff;
            padding: 10px;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>

</html>