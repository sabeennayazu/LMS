<?php
	include("check_admin.php");
	#fetch data from database
	$connection = mysqli_connect("localhost","root","");
	$db = mysqli_select_db($connection,"lms");

	// Fetch specific author details
	$author_name = "";
	$author_id = "";
	if (isset($_GET['aid'])) {
		$query = "SELECT * FROM authors WHERE author_id = $_GET[aid]";
		$query_run = mysqli_query($connection, $query);
		while ($row = mysqli_fetch_assoc($query_run)) {
			$author_name = $row['author_name'];
			$author_id = $row['author_id'];
		}
	}

	// Fetch all authors for the dropdown menu
	$authors_query = "SELECT * FROM authors";
	$authors_query_run = mysqli_query($connection, $authors_query);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit Author</title>
	<meta charset="utf-8" name="viewport" content="width=device-width,initial-scale=1">
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
		<center><h4>Edit Author</h4><br></center>
		<div class="row">
			<div class="col-md-4"></div>
			<div class="col-md-4">
				<form action="" method="post">
					<div class="form-group">
						<label for="name">Select Author:</label>
						<select class="form-control" name="author_id" required>
							<?php
								while ($author = mysqli_fetch_assoc($authors_query_run)) {
									echo "<option value='" . $author['author_id'] . "' ";
									if ($author['author_id'] == $author_id) {
										echo "selected";
									}
									echo ">" . $author['author_name'] . "</option>";
								}
							?>
						</select>
					</div>
					<button type="submit" name="update_author" class="btn btn-primary">Update Author</button>
				</form>
			</div>
			<div class="col-md-4"></div>
		</div>
</body>
</html>
<?php
	if(isset($_POST['update_author'])){
		$connection = mysqli_connect("localhost","root","");
		$db = mysqli_select_db($connection,"lms");
		$query = "UPDATE authors SET author_name = '$_POST[author_name]' WHERE author_id = $_POST[author_id]";
		$query_run = mysqli_query($connection,$query);
		header("location:manage_author.php");
	}
?>
