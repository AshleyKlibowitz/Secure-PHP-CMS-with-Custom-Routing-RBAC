<?php
// Include the session start in the main file 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$page_title = "The Blog"; // Set the page title

// Import posttest.php
include 'posttest.php';
include 'mysqli_connect.php';

//***********************************************
//PAGINATION SETUP START
//***********************************************

// Number of records to show per page:
$display = 5;

// Determine how many pages there are...
if (isset($_GET['p']) && is_numeric($_GET['p'])) { // Already been determined.
    $pages = $_GET['p'];
} else { // Need to determine.
    // Count the number of records:
    $q = "SELECT COUNT(blogpost_id) FROM blogposts";
    $r = mysqli_query($dbc, $q);
    $rowp = mysqli_fetch_array($r, MYSQLI_NUM);
    $records = $rowp[0];
    // Calculate the number of pages...
    if ($records > $display) { // More than 1 page.
        $pages = ceil($records / $display);
    } else {
        $pages = 1;
    }
} // End of p IF.

// Determine where in the database to start returning results...
if (isset($_GET['s']) && is_numeric($_GET['s'])) {
    $start = $_GET['s'];
} else {
    $start = 0;
}

//***********************************************
//PAGINATION SETUP END
//***********************************************

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="styles.css">
</head>

<body class="index-page">

    <header>
        <h1>Welcome to the Blog</h1>
    </header>

    <div class="container">
        <div class="sort-options">
            <strong>Sort By:</strong>
            <a href="?sort=newest">Date (Newest to Oldest)</a> |
            <a href="?sort=oldest">Date (Oldest to Newest)</a>
        </div>

        <div class="comments">
            <?php
            include("mysqli_connect.php");

            $sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'newest';

            switch ($sort) {
                case 'lname':
                    $order_by = 'last_name ASC';
                    break;
                case 'fname':
                    $order_by = 'first_name ASC';
                    break;
                case 'newest':
                    $order_by = 'blogpost_timestamp DESC';
                    break;
                case 'oldest':
                    $order_by = 'blogpost_timestamp ASC';
                    break;
                default:
                    $order_by = 'blogpost_timestamp DESC';
                    $sort = 'newest';
                    break;
            }

            $limit = "LIMIT $start, $display";

            $sql = "SELECT users.first_name, users.last_name, blogposts.*, 
                     COUNT(comments.comment_id) AS comment_count
                     FROM blogposts
                     LEFT JOIN users ON blogposts.user_id = users.user_id
                     LEFT JOIN comments ON blogposts.blogpost_id = comments.blogpost_id
                     GROUP BY blogposts.blogpost_id
                     ORDER BY $order_by $limit";

            $result = mysqli_query($dbc, $sql);

            // Check for SQL query execution errors
            if (!$result) {
                die("Error in SQL query: " . mysqli_error($dbc));
            }

            // Process the result
            if ($result) {
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $user_id = $row['user_id'];
                        $blogpost_title = $row['blogpost_title'];
                        $blogpost_body = $row['blogpost_body'];
                        $author_name = $row['first_name'] . ' ' . $row['last_name'];

                        echo "<div class='card'>";
                        echo "<strong>Timestamp:</strong> {$row['blogpost_timestamp']}<br>";
                        echo "<strong>Author:</strong> $author_name<br>";
                        echo "<strong>Post Title:</strong> $blogpost_title<br>";
                        echo "<strong>Post Content:</strong> $blogpost_body<br>";
                        echo "<strong>Number of Comments:</strong> {$row['comment_count']}<br>";

                        $blogpostId = isset($row['post_id']) ? $row['post_id'] : '';

                        // View Comments button
                        echo "<div class='btn-container'>";
                        echo "<a class='btn' href='viewcomments.php?blogpost_id=" . $row['blogpost_id'] . "'>View Comments</a>";

                        // Add Comment button
                        if (isset($_SESSION['user_id'])) {
                            echo "<a class='btn' href='newcomment.php?blogpost_id=" . $row['blogpost_id'] . "'>Add Comment</a>";
                        }

                        // Only signed-in users can add comments
                        if (isset($_SESSION['user_id'])) {
                            // Check if the logged-in user is the author of the blog post (by comparing user_id)
                            if ($_SESSION['user_id'] == $row['user_id']) {
                                // Allow the author to update or delete their own post
                                echo "<a class='btn' href='update.php?blogpost_id=" . $row['blogpost_id'] . "'>Update Blogpost</a>";
                                echo "<a class='btn' href='delete.php?delete_id=" . $row['blogpost_id'] . "'>Delete Blogpost</a>";
                            }
                        }
                        echo "</div>";  // Close the button container
            
                        echo "</div>";
                    }
                }
            }
            ?>
        </div>

        <!-- Pagination Links -->
        <?php
        //***********************************************
        //PAGINATION PREVIOUS AND NEXT PAGE BUTTONS/LINKS START
        //***********************************************
        
        // Make the links to other pages, if necessary.
        if ($pages > 1) {
            echo '<div class="pagination"><p>';
            $current_page = ($start / $display) + 1;

            // If it's not the first page, make a Previous button:
            if ($current_page != 1) {
                echo '<a href="?s=' . ($start - $display) . '&p=' . $pages . '">Previous</a> ';
            }

            // Make all the numbered pages:
            for ($i = 1; $i <= $pages; $i++) {
                if ($i != $current_page) {
                    echo '<a href="?s=' . (($display * ($i - 1))) . '&p=' . $pages . '">' . $i . '</a> ';
                } else {
                    echo $i . ' ';
                }
            } // End of FOR loop.
        
            // If it's not the last page, make a Next button:
            if ($current_page != $pages) {
                echo '<a href="?s=' . ($start + $display) . '&p=' . $pages . '">Next</a>';
            }

            echo '</p></div>'; // Close the pagination div.
        } // End of links section.
        
        //***********************************************
        //PAGINATION PREVIOUS AND NEXT PAGE BUTTONS/LINKS END
        //***********************************************
        ?>

    </div>

    <!-- Include the footer -->
    <footer>
        <?php include("footer.php"); ?>
    </footer>

</body>

</html>