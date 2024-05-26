<?php
	// if(isset($_POST['add_book']))
	// {
	// 	echo "hello";
	// 	$connection = mysqli_connect("localhost","root","");
	// 	$db = mysqli_select_db($connection,"lms");
		
	// 	$stmt = $connection->query("insert into books(book_name,author_id,cat_id,book_no,book_price) values(?,?,?,?,?)");

	// 	$stmt->bind_param("siiid",$_POST["book_name"],$_POST["book_author"],$_POST["book_category"],$_POST["book_no"],$_POST["book_price"]);
		
	// 	$stmt->execute();
	// 	echo $_POST[book_name];
	// 	#header("location:add_book.php");
	// }
?>


<?php
	if(isset($_POST['add_book']))
	{

            echo "hello";
		$connection = mysqli_connect("localhost","root","");
		$db = mysqli_select_db($connection,"lms");
		$query = "insert into books(book_name,author_id,cat_id,book_no,book_price) values('$_POST[book_name]','$_POST[book_author]','$_POST[book_category]',$_POST[book_no],$_POST[book_price])";
		$query_run = mysqli_query($connection,$query);
		header("location:manage_book.php");
	}
?>
