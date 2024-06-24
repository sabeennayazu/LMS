<?php
include("check_admin.php");
$connection = mysqli_connect("localhost", "root", "", "lms");

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['book_no']) && isset($_POST['student_id'])) {
        $book_no = $_POST['book_no'];
        $student_id = $_POST['student_id'];

        // Prepare and bind
        $stmt = $connection->prepare("DELETE FROM issued_books WHERE book_no = ? AND student_id = ?");
        $stmt->bind_param("ss", $book_no, $student_id);

        // Execute the statement
        if ($stmt->execute()) {
            echo "<script>alert('book returned successfully')</script>";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
    echo "<script>alert('Book number and student id are required.')</script>";
    }
}

// Close the connection
mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return Book</title>
    <link rel="stylesheet" type="text/css" href="../bootstrap-4.4.1/css/bootstrap.min.css">
  	<script type="text/javascript" src="../bootstrap-4.4.1/js/juqery_latest.js"></script>
  	<script type="text/javascript" src="../bootstrap-4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="admin_dashboard.php">Samriddhi Library</a>
			</div>
			<font style="color: white"><span><strong>Welcome: <?php echo $_SESSION['name'];?></strong></span></font>
			<font style="color: white"><span><strong>Email: <?php echo $_SESSION['email'];?></strong></font>
		    <ul class="nav navbar-nav navbar-right">
		      <li class="nav-item dropdown">
	        	<a class="nav-link dropdown-toggle" data-toggle="dropdown">My Profile </a>
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
	<span><marquee>Library opens at 8:00 AM and close at 8:00 PM</marquee></span><br><br>
    <!-- <form method="post">
        <input name="book_no" placeholder="Returned Book Number" required>
        <input name="s_no" placeholder="Student Number" required>
        <input type="submit" name="submit" value="Return Book">
    </form> -->
    <form method="post">
  <div class="form-group" >
    <label for="book_no">ISBN number</label>
    <input  class="form-control" id="book_no" name="book_no" aria-describedby="book_no" placeholder="Enter ISBN number">
  </div>
  <div class="form-group">
    <label for="student_id">Student id</label>
    <input name="student_id" class="form-control" id="exampleInputPassword1" placeholder="Student id" required>
  </div>
  <input type="submit" class="btn btn-primary" name="submit" value="Return Book" required>

  <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
</form>
</body>
</html>
