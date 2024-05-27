<?php
	#fetch data from database
	$conn = mysqli_connect("localhost","root","");
	$db = mysqli_select_db($conn,"lms");

    $conn->query("insert into users(name,email,password,mobile,address) values('suasdfasd','surajdahal@gmail.com','surajdahal','9876543210','adfj;aldf,adfjadsfadsf')");