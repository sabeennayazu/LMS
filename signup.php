
<!DOCTYPE html>
<html>
<head>
	<title>LMS</title>
	<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="bootstrap-4.4.1/css/bootstrap.min.css">
  	<script type="text/javascript" src="bootstrap-4.4.1/js/jquery_latest.js"></script>
  	<script type="text/javascript" src="bootstrap-4.4.1/js/bootstrap.min.js"></script>
	<script type="text/javascript">
		function validateForm() {
			const name = document.forms["registrationForm"]["name"].value;
			const email = document.forms["registrationForm"]["email"].value;
			const password = document.forms["registrationForm"]["password"].value;
			const mobile = document.forms["registrationForm"]["mobile"].value;
			const address = document.forms["registrationForm"]["address"].value;

			if (name == "" || email == "" || password == "" || mobile == "" || address == "") {
				alert("All fields must be filled out");
				return false;
			}

			const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
			if (!emailPattern.test(email)) {
				alert("Invalid email format");
				return false;
			}

			if (password.length < 6) {
				alert("Password must be at least 6 characters long");
				return false;
			}

			if (isNaN(mobile) || mobile.length != 10) {
				alert("Mobile number must be 10 digits");
				return false;
			}

			return true;
		}
	</script>
</head>
<style type="text/css">
	#main_content {
		padding: 50px;
		background-color: whitesmoke;
	}
	#side_bar {
		background-color: whitesmoke;
		padding: 50px;
		width: 300px;
		height: 450px;
	}
</style>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="#">Library Management System (LMS)</a>
			</div>
			<ul class="nav navbar-nav navbar-right">
		      <li class="nav-item">
		        <a class="nav-link" href="index.php">Admin Login</a>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link" href="#">Register</a>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link" href="index.php">Login</a>
		      </li>
		    </ul>
		</div>
	</nav><br>
	<span><marquee>This is library management system. Library opens at 8:00 AM and closes at 8:00 PM</marquee></span><br><br>
	<div class="row">
		<div class="col-md-4" id="side_bar">
			<h5>Library Timing</h5>
			<ul>
				<li>Opening: 8:00 AM</li>
				<li>Closing: 8:00 PM</li>
				<li>(Sunday Off)</li>
			</ul>
			<h5>What We Provide?</h5>
			<ul>
				<li>Full furniture</li>
				<li>Free Wi-Fi</li>
				<li>Newspapers</li>
				<li>Discussion Room</li>
				<li>RO Water</li>
				<li>Peaceful Environment</li>
			</ul>
		</div>
		<div class="col-md-8" id="main_content">
			<center><h3><u>User Registration Form</u></h3></center>
			<form name="registrationForm" action="register.php" onsubmit="return validateForm()" method="post">
				<div class="form-group">
					<label for="name">Full Name:</label>
					<input type="text" name="name" class="form-control" required>
				</div>
				<div class="form-group">
					<label for="email">Email ID:</label>
					<input type="email" name="email" class="form-control" required>
				</div>
				<div class="form-group">
					<label for="password">Password:</label>
					<input type="password" name="password" class="form-control" required>
				</div>
				<div class="form-group">
					<label for="mobile">Mobile:</label>
					<input type="number" name="mobile" class="form-control" required>
				</div>
				<div class="form-group">
					<label for="address">Address:</label>
					<textarea name="address" class="form-control" required></textarea>
				</div>
				<button type="submit" class="btn btn-primary">Register</button>
			</form>
		</div>
	</div>
</body>
</html>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Database connection
    $connection = mysqli_connect("localhost", "root", "", "lms");
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Fetch form data and sanitize
    $name = mysqli_real_escape_string($connection, $_POST['name']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = $_POST['password'];
    $mobile = mysqli_real_escape_string($connection, $_POST['mobile']);
    $address = mysqli_real_escape_string($connection, $_POST['address']);

    // Server-side validation
    if (empty($name) || empty($email) || empty($password) || empty($mobile) || empty($address)) {
        echo "All fields are required.";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
    }

    if (strlen($password) < 6) {
        echo "Password must be at least 6 characters long.";
        exit;
    }

    if (!is_numeric($mobile) || strlen($mobile) != 10) {
        echo "Mobile number must be 10 digits.";
        exit;
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        echo "Email already registered.";
    } else {
        // Insert user data into database
        $query = "INSERT INTO users (name, email, password, mobile, address) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "sssis", $name, $email, $hashed_password, $mobile, $address);

        if (mysqli_stmt_execute($stmt)) {
            echo "Registration successful.";
            // Optionally redirect to login page
            // header("Location: index.php");
        } else {
            echo "Error: " . mysqli_error($connection);
        }
    }

    // Close statement and connection
    mysqli_stmt_close($stmt);
    mysqli_close($connection);
}
?>
