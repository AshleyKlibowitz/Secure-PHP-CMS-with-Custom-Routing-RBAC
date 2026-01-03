<?php
session_start();
include("mysqli_connect.php");

$successMessage = "";
$errorMessages = [];
$blogpost_id = "";
$blogpost_title = "";
$blogpost_body = "";

// Admin authorization check
if (!isset($_SESSION['user_id']) || ($_SESSION['user_id'] != 2)) {
    header('Location: https://klibowi2.soisweb.uwm.edu/infost440/finalproject/login.php');
    exit();
}

if (isset($_GET['blogpost_id'])) {
    $blogpost_id = mysqli_real_escape_string($dbc, trim($_GET['blogpost_id']));

    // Fetch the current values of the blogpost for default display
    $sql_select = "SELECT * FROM blogposts WHERE blogpost_id = '$blogpost_id'";
    $result = mysqli_query($dbc, $sql_select);

    if ($result !== false) {
        $row = mysqli_fetch_assoc($result);

        if ($row !== null) {
            $blogpost_title = $row['blogpost_title'];
            $blogpost_body = $row['blogpost_body'];
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $blogpost_title = isset($_POST['blogpost_title']) ? mysqli_real_escape_string($dbc, trim($_POST['blogpost_title'])) : "";
    $blogpost_body = isset($_POST['blogpost_body']) ? mysqli_real_escape_string($dbc, trim($_POST['blogpost_body'])) : "";

    // Validate required fields
    if (empty($blogpost_title)) {
        $errorMessages[] = "Blogpost title is required.";
    }

    if (empty($blogpost_body)) {
        $errorMessages[] = "Blogpost body is required.";
    }

    if (is_numeric($blogpost_id) && empty($errorMessages)) {
        $sql_update = "UPDATE blogposts SET blogpost_title = '$blogpost_title', blogpost_body = '$blogpost_body' WHERE blogpost_id = '$blogpost_id'";
        $result = mysqli_query($dbc, $sql_update);

        if ($result === false) {
            $errorMessages[] = "Error updating blogpost: " . mysqli_error($dbc);
        } else {
            $successMessage = "Blogpost updated successfully!";
        }
    } else {
        $errorMessages[] = "Invalid Blogpost ID. Blogpost ID must be a numeric value.";
    }
}

mysqli_close($dbc);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Update Blogpost</title>
    <link rel="stylesheet" type="text/css" href="form.css">
</head>

<body>
    <?php include("header.php"); ?>

    <div class="container">
        <h1>Update Blogpost</h1>

        <div class="card">
            <form method="post" action="update.php?blogpost_id=<?php echo htmlspecialchars($blogpost_id); ?>">
                <label for="blogpost_title">Blogpost Title:</label>
                <input type="text" name="blogpost_title" value="<?php echo htmlspecialchars($blogpost_title); ?>">
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($blogpost_title)) {
                    echo '<div class="error-card">Blogpost title is required.</div>';
                }
                ?>

                <label for="blogpost_body"><br>Blogpost Body:</label>
                <textarea name="blogpost_body"><?php echo htmlspecialchars($blogpost_body); ?></textarea>
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($blogpost_body)) {
                    echo '<div class="error-card">Blogpost body is required.</div>';
                }
                ?><br>
                <input type="submit" value="Update">
            </form>
        </div>

        <?php if (empty($errorMessages) && !empty($successMessage)): ?>
            <div class="success-message"><?php echo htmlspecialchars($successMessage); ?></div>
        <?php endif; ?>
    </div>

    <?php include("footer.php"); ?>
</body>

</html>