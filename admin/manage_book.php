<?php
require("functions.php");
session_start();

// Fetch data from the database
$connection = mysqli_connect("localhost", "root", "", "lms");
if (mysqli_connect_errno()) {
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}

$name = "";
$email = "";
$mobile = "";
$query = "SELECT * FROM admins WHERE email = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("s", $_SESSION['email']);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $name = htmlspecialchars($row['name']);
    $email = htmlspecialchars($row['email']);
    $mobile = htmlspecialchars($row['mobile']);
}
$stmt->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Book</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../bootstrap-4.4.1/css/bootstrap.min.css">
    <script type="text/javascript" src="../bootstrap-4.4.1/js/jquery_latest.js"></script>
    <script type="text/javascript" src="../bootstrap-4.4.1/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        function alertMsg() {
            alert("Book added successfully...");
            window.location.href = "admin_dashboard.php";
        }
    </script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="admin_dashboard.php">Samriddhi Library</a>
            </div>
            <font style="color: white"><span><strong>Welcome: <?php echo htmlspecialchars($_SESSION['name']); ?></strong></span></font>
            <font style="color: white"><span><strong>Email: <?php echo htmlspecialchars($_SESSION['email']); ?></strong></font>
            <ul class="nav navbar-nav navbar-right">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown">My Profile</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="view_profile.php">View Profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="edit_profile.php">Edit Profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="change_password.php">Change Password</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav><br>
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd">
        <div class="container-fluid">
            <ul class="nav navbar-nav navbar-center">
                <li class="nav-item">
                    <a class="nav-link" href="admin_dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown">Books</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="add_book.php">Add New Book</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="manage_book.php">Manage Books</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown">Category</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="add_cat.php">Add New Category</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="manage_cat.php">Manage Category</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown">Authors</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="add_author.php">Add New Author</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="manage_author.php">Manage Author</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="issue_book.php">Issue Book</a>
                </li>
            </ul>
        </div>
    </nav><br>
    <span><marquee>Library opens at 8:00 AM and closes at 8:00 PM</marquee></span><br><br>
    <center><h4>Manage Books</h4><br></center>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th>ISBN No.</th>
                        <th>Price</th>
                        <th>Available</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT books.book_name, authors.author_name, category.cat_name, books.book_no, books.book_price, books.avail 
                              FROM books 
                              JOIN authors ON books.author_id = authors.author_id 
                              JOIN category ON books.cat_id = category.cat_id";
                    $query_run = mysqli_query($connection, $query);
                    if (!$query_run) {
                        echo "Error: " . mysqli_error($connection);
                        exit;
                    }
                    while ($row = mysqli_fetch_assoc($query_run)) {
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['book_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['author_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['cat_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['book_no']); ?></td>
                            <td><?php echo htmlspecialchars($row['book_price']); ?></td>
                            <td><?php echo $row["avail"] == 1 ? "Yes" : "No"; ?></td>
                            <td>
                                <button class="btn btn-primary"><a href="edit_book.php?bn=<?php echo htmlspecialchars($row['book_no']); ?>" style="color: white;">Edit</a></button>
                                <button class="btn btn-danger"><a href="delete_book.php?bn=<?php echo htmlspecialchars($row['book_no']); ?>" style="color: white;">Delete</a></button>
                            </td>
                        </tr>
                        <?php
                    }
                    mysqli_close($connection);
                    ?>
                </tbody>
            </table>
        </div>
        <div class="col-md-2"></div>
    </div>
</body>
</html>
