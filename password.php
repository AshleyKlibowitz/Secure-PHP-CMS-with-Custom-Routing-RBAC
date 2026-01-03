<?php
// This page lets a user change their password.

session_start(); // Start the session.

$page_title = 'Change Your Password';
include('header.php');

// Include the CSS file:
echo '<head>
    <title>Change Your Password</title>
    <link rel="stylesheet" type="text/css" href="form.css">
</head>';

// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    require('mysqli_connect.php'); // Connect to the db.

    $errors = array(); // Initialize an error array.

    // Check for an email address:
    if (empty($_POST['email'])) {
        $errors[] = 'You forgot to enter your email address.';
    } else {
        $e = mysqli_real_escape_string($dbc, trim($_POST['email']));
        // Validate email format
        if (!filter_var($e, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'The email address is not in a valid format.';
        } else {
            // Check if email is on file
            $q = "SELECT user_id FROM users WHERE email='$e'";
            $r = @mysqli_query($dbc, $q);
            if (mysqli_num_rows($r) == 0) {
                $errors[] = 'The email address is not on file.';
            }
        }
    }

    // Check for the current password:
    if (empty($_POST['pass'])) {
        $errors[] = 'You forgot to enter your current password.';
    } else {
        $p = mysqli_real_escape_string($dbc, trim($_POST['pass']));
    }

    // Check for a new password and match against the confirmed password:
    if (!empty($_POST['pass1']) && !empty($_POST['pass2'])) {
        if ($_POST['pass1'] != $_POST['pass2']) {
            $errors[] = 'Your new password did not match the confirmed password.';
        } else {
            $np = mysqli_real_escape_string($dbc, trim($_POST['pass1']));

            // Check if the new password is the same as the current password
            if ($np == $p) {
                $errors[] = 'Your new password must be different from your current password.';
            }
        }
    } else {
        $errors[] = 'You forgot to enter your new password and confirm it.';
    }

    if (empty($errors)) { // If everything's OK.

        // Check that they've entered the right email address/password combination:
        $q = "SELECT user_id FROM users WHERE (email='$e' AND pass=SHA2('$p',256) )";
        $r = @mysqli_query($dbc, $q);
        $num = @mysqli_num_rows($r);
        if ($num == 1) { // Match was made.

            // Get the user_id:
            $row = mysqli_fetch_array($r, MYSQLI_NUM);

            // Make the UPDATE query:
            $q = "UPDATE users SET pass=SHA2('$np',256) WHERE user_id=$row[0]";
            $r = @mysqli_query($dbc, $q);

            if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.

                // Print a message.
                echo '<h1>Thank you!</h1>
                <p>Your password has been updated. </p><p><br /></p>';

            } else { // If it did not run OK.

                // Public message:
                echo '<h1>System Error</h1>
                <p class="error">Your password could not be changed due to a system error. We apologize for any inconvenience.</p>';

                // Debugging message:
                echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';

            }

            mysqli_close($dbc); // Close the database connection.

            // Include the footer and quit the script (to not show the form).
            include('footer.php');
            exit();

        } else { // Invalid email address/password combination.
            echo '<h1 class="error-title">Error!</h1>
            <p class="error-message">The email address and password do not match those on file.</p>';
        }

    } else { // Report the errors.

        echo '<h1 class="error-title">Error!</h1>
        <p class="error-message">The following error(s) occurred:<br />';
        foreach ($errors as $msg) { // Print each error.
            echo " - $msg<br />\n";
        }
        echo '</p><p class="error-message">Please try again.</p><p><br /></p>';

    } // End of if (empty($errors)) IF.

    mysqli_close($dbc); // Close the database connection.

} // End of the main Submit conditional.
?>
<div class="container">
    <h1>Change Your Password</h1>
    <div class="card">
        <form action="password.php" method="post">
            <label for="email">Email Address:</label>
            <input type="text" name="email" size="20" maxlength="60"
                value="<?php if (isset($_POST['email']))
                    echo $_POST['email']; ?>" />
            <label for="pass">Current Password:</label>
            <input type="password" name="pass" size="10" maxlength="20"
                value="<?php if (isset($_POST['pass']))
                    echo $_POST['pass']; ?>" />
            <label for="pass1">New Password:</label>
            <input type="password" name="pass1" size="10" maxlength="20"
                value="<?php if (isset($_POST['pass1']))
                    echo $_POST['pass1']; ?>" />
            <label for="pass2">Confirm New Password:</label>
            <input type="password" name="pass2" size="10" maxlength="20"
                value="<?php if (isset($_POST['pass2']))
                    echo $_POST['pass2']; ?>" />
            <input type="submit" name="submit" value="Change Password" />
        </form>
    </div>
</div>
<?php include('footer.php'); ?>