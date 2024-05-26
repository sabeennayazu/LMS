<?php
// fetch_authors.php

// Database connection
$connection = mysqli_connect("localhost", "root", "", "lms");
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Fetch author names
$query = "SELECT author_id, author_name FROM authors";
$query_run = mysqli_query($connection, $query);

if ($query_run) {
    while ($row = mysqli_fetch_assoc($query_run)) {
        echo '<a class="dropdown-item" href="#" onclick="filterBooks(\'author\', ' . $row['author_id'] . ')">' . $row['author_name'] . '</a>';
    }
} else {
    echo "Error: " . mysqli_error($connection);
}

mysqli_close($connection);
?>
