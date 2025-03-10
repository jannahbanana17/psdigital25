<?php
    $conn = new mysqli("localhost", "root", "", "canteen_db");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $menu = $conn->query("SELECT item_name, price FROM menu_items");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Available Items || PSDigital</title>
	<style>
		* {
			box-sizing:border-box;
			font-family:century gothic;
			margin:0px;
			padding:0px;
		}
		img {
			width:90px;
			display:inline-block;
			margin-left:30px;
			padding-top:20px;
		}
		#psd {
			color:white;
			margin-top:-90px;
			padding-left:130px;
		}
		#name {
			color:#32CD32;
			font-size:70px;
			padding-left:130px;
		}
		body {
			background-image: url("bg.jpg"); background-repeat: repeat-x; background-size: 200px auto; background-position: top;
		}
		.link {
			color:#32CD32;
			font-weight:bold;
		}
		#home {
			margin-left:1000px;
		}
		.date {
			position:relative;
			top:75px;
			font-weight:bold;
			text-align: center;
			margin-left: auto;
			margin-right:auto;
			display:block;
			font-size:20px;
			left: 50%;
			transform:translateX(-50%);
		}
		h3 {
			text-align:center;
			padding-top:110px;
		}
		table {
			position:absolute;
            top:50%;
            left:50%;
            transform: translate(-50%, -50%); 
            border-collapse:collapse;
            text-align:center;
			width: 20%;
			height: 20vh; 
			
		}
	</style>
</head>
<body>
	<img src="logo.png" alt="Logo">
	<h1 id='psd'>Philippine School Doha</h1>
	<h1 id='name'>PSDigital</h1>
	<a href="home.php" class="link" id='home''>Home</a>
	<a href="menu.php" class="link">Available Products</a>
	<a href="wallet.php" class="link">My Wallet</a>
	<a href="login.php" class="link">Logout</a>
	<div class="date">
		<?php
			echo "Date: ". date("Y-m-d");
		?>
	</div>
	<h3>Current Menu</h3>
	<table border="1">
    <tr>
        <th>Item Name</th>
        <th>Price (QR)</th>
    </tr>
    <?php while ($row = $menu->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['item_name']); ?></td>
            <td><?php echo htmlspecialchars($row['price']); ?></td>
        </tr>
    <?php endwhile; ?>
</table>
</body>
</html>
