<?php
// fetch_books.php

// Database connection
$connection = mysqli_connect("localhost", "root", "", "lms");
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

$criteria = $_POST['criteria'];

// Fetch books based on the selected criteria
if ($criteria === 'all') {
    $query = "SELECT b.book_name, b.book_no, a.author_name FROM books b JOIN authors a ON b.author_id = a.author_id";
} elseif ($criteria === 'available') {
    $query = "SELECT b.book_name, b.book_no, a.author_name FROM books b JOIN authors a ON b.author_id = a.author_id WHERE b.avail = 1";
} elseif ($criteria === 'author') {
    $author_id = $_POST['author_id'];
    $query = "SELECT b.book_name, b.book_no, a.author_name FROM books b JOIN authors a ON b.author_id = a.author_id WHERE b.author_id = $author_id";
}

$query_run = mysqli_query($connection, $query);

if ($query_run) {
    while ($row = mysqli_fetch_assoc($query_run)) {
        echo '<tr>
                <td>' . htmlspecialchars($row['book_name']) . '</td>
                <td>' . htmlspecialchars($row['author_name']) . '</td>
                <td>' . htmlspecialchars($row['book_no']) . '</td>
              </tr>';
    }
} else {
    echo "Error: " . mysqli_error($connection);
}

mysqli_close($connection);
?>
