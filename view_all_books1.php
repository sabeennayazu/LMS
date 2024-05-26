<?php
	session_start();

	// Check if user is logged in
	if (!isset($_SESSION['id']) || !isset($_SESSION['name']) || !isset($_SESSION['email'])) {
	    header("Location: login.php");
	    exit();
	}

	// Database connection with error handling
	$connection = mysqli_connect("localhost", "root", "", "lms");
	if (!$connection) {
	    die("Database connection failed: " . mysqli_connect_error());
	}

	// Fetch available books with authors
	$query = "SELECT b.book_name, b.book_no, a.author_name FROM books b JOIN authors a ON b.author_id = a.author_id WHERE b.avail = 1";
	$query_run = mysqli_query($connection, $query);

	if (!$query_run) {
	    die("Query failed: " . mysqli_error($connection));
	}

	// Check if any rows are returned
	$rows = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
	if (count($rows) == 0) {
	    die("No books available.");
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>All Books</title>
	<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="bootstrap-4.4.1/css/bootstrap.min.css">
  	<script type="text/javascript" src="bootstrap-4.4.1/js/jquery_latest.js"></script>
  	<script type="text/javascript" src="bootstrap-4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<div class="container-fluid">
			<a class="navbar-brand" href="user_dashboard.php">Samriddhi Library</a>
			<span class="navbar-text text-white"><strong>Welcome: <?php echo htmlspecialchars($_SESSION['name']); ?></strong></span>
			<span class="navbar-text text-white"><strong>Email: <?php echo htmlspecialchars($_SESSION['email']); ?></strong></span>
		    <ul class="nav navbar-nav ml-auto">
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
		        <a class="nav-link" href="logout.php">Logout</a>
		      </li>
		    </ul>
		</div>
	</nav><br>
	<span><marquee>Library opens at 8:00 AM and closes at 8:00 PM</marquee></span><br><br>
	<center><h4>All Books Detail</h4><br></center>
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-8">
			<table class="table table-bordered" style="text-align: center">
				<tr>
					<th>Name</th>
					<th>Author</th>
					<th>Number</th>
				</tr>
				<?php foreach ($rows as $row) { ?>
				<tr>
					<td><?php echo htmlspecialchars($row['book_name']); ?></td>
					<td><?php echo htmlspecialchars($row['author_name']); ?></td>
					<td><?php echo htmlspecialchars($row['book_no']); ?></td>
				</tr>
				<?php } ?>
			</table>
		</div>
		<div class="col-md-2"></div>
	</div>
</body>
</html>

<?php
	mysqli_close($connection);
?>
