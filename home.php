<?php
session_start(); // Start the session

// Check if the user is logged in (session variable 'library_id' should exist)
if (!isset($_SESSION['library_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Set a flag in the session when the user first visits the page
if (!isset($_SESSION['first_visit'])) {
    $_SESSION['first_visit'] = true;
} else {
    // If this is not the first visit (duplicate or refresh), log them out
    session_unset(); // Unset all session variables
    session_destroy(); // Destroy the session
    header("Location: login.php"); // Redirect to login
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Home || PSDigital</title>
	<style>
		* {
			box-sizing: border-box;
			font-family: century gothic;
			margin: 0px;
			padding: 0px;
		}
		img {
			width: 90px;
			display: inline-block;
			margin-left: 30px;
			padding-top: 20px;
		}
		#psd {
			color: white;
			margin-top: -90px;
			padding-left: 130px;
		}
		#name {
			color: #32CD32;
			font-size: 70px;
			padding-left: 130px;
		}
		body {
			background-image: url("bg.jpg");
			background-repeat: repeat-x;
			background-size: 200px auto;
			background-position: top;
		}
		#bldg {
			width: 1200px;
			position: absolute;
			top: 60%;
			left: 48%;
			transform: translate(-50%, -50%);
			max-width: 100%;
			height: auto;
		}
		.link {
			color: #32CD32;
			font-weight: bold;
		}
		#home {
			margin-left: 1000px;
		}
	</style>
</head>
<body>
	<img src="logo.png" alt="Logo">
	<h1 id='psd'>Philippine School Doha</h1>
	<h1 id='name'>PSDigital</h1>
	<img src="bld.png" id='bldg'>
	<a href="home.php" class="link" id='home'>Home</a>
	<a href="menu.php" class="link">Available Products</a>
	<a href="wallet.php" class="link">My Wallet</a>
	<a href="login.php" class="link">Logout</a>
</body>
</html>
