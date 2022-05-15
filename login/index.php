<?php 
// untuk mengecek apakah user telah login atau belum
session_start();
if(isset($_SESSION["login"])){
	header("Location: login.php");
	exit;
}
 ?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>index</title>
	<style type="text/css">
		.container{
			text-align: center;
		}
		h1{
			margin-top: 20vh;
			font-size: 50px;
		}
		a{
			background: rgba(0, 0, 256, 0.5);
			padding: 10px 20px;
			border-radius: 4px;
			text-decoration: none;
			font-weight: bold;
		}
	</style>
</head>
<body>
	<div class="container">
		<h1>Wellcome</h1>
	<br><br>

	<a href="logout.php">logout</a>
	</div>
</body>
</html>