<?php
session_start();
include("mysqli_connect.php");

$successMessage = isset($_SESSION['successMessage']) ? $_SESSION['successMessage'] : "";
unset($_SESSION['successMessage']); // Clear after displaying

$errorMessages = [];
$user_id = "";
$user_name = ""; // Initialize $user_name

if (isset($_GET['user_id'])) {
    $user_id = mysqli_real_escape_string($dbc, trim($_GET['user_id']));

    // Update the SQL query to allow admin to access any user or user to access their own account
    $sql_select = "SELECT first_name, last_name FROM users WHERE user_id = ? AND (? = 2 OR user_id = ?)";
    $stmt = mysqli_prepare($dbc, $sql_select);
    mysqli_stmt_bind_param($stmt, "iii", $user_id, $_SESSION['user_id'], $_SESSION['user_id']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $user_name = $row['first_name'] . ' ' . $row['last_name'];
    } else {
        $errorMessages[] = "Error: User not found or unauthorized.";
    }
    mysqli_stmt_close($stmt);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (is_numeric($user_id) && empty($errorMessages)) {
        $sql_delete = "DELETE FROM users WHERE user_id = ? AND (? = 2 OR user_id = ?)";
        $stmt = mysqli_prepare($dbc, $sql_delete);
        mysqli_stmt_bind_param($stmt, "iii", $user_id, $_SESSION['user_id'], $_SESSION['user_id']);

        // Execute the query
        if (mysqli_stmt_execute($stmt)) {
            $successMessage = "User deleted successfully.";
            // If the user deleted their own account, log them out
            if ($user_id == $_SESSION['user_id']) {
                session_destroy();
                header("Location: register.php");
                exit();
            }
        } else {
            $errorMessages[] = "Error deleting user.";
        }
        mysqli_stmt_close($stmt);
    } else {
        $errorMessages[] = "Invalid User ID.";
    }
}

mysqli_close($dbc);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Delete User</title>
    <link rel="stylesheet" href="delete.css">
</head>

<body>
    <?php include("header.php"); ?>

    <div class="container">
        <h1>Delete User</h1>

        <?php if (!empty($successMessage)): ?>
            <div class="success-message"><?php echo htmlspecialchars($successMessage); ?></div>
        <?php endif; ?>

        <div class="card">
            <form method="post" action="delete_user.php?user_id=<?php echo htmlspecialchars($user_id); ?>">
                <p>Are you sure you want to delete this user?</p>
                <p class="delete-content"><?php echo htmlspecialchars($user_name); ?></p>
                <input type="submit" value="Delete User">
            </form>
        </div>

        <?php foreach ($errorMessages as $errorMessage): ?>
            <div class="error-card"><?php echo htmlspecialchars($errorMessage); ?></div>
        <?php endforeach; ?>
    </div>

    <?php include("footer.php"); ?>
</body>

</html>