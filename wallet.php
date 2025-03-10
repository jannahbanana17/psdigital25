<?php
session_start(); // Continue the session

// Check if user is logged in
if (!isset($_SESSION['library_id'])) {
    header("Location: login.php");
    exit();
}

$library_id = $_SESSION['library_id'];

// Connect to the database
$con = mysqli_connect("localhost", "root", "", "canteen_db");
if (!$con) die("Connection failed: " . mysqli_connect_error());

// Fetch the credit balance for the logged-in user
$query = mysqli_query($con, "SELECT credit_bal FROM MyWallet WHERE library_id='$library_id'");
$row = mysqli_fetch_assoc($query);
$credit_bal = $row['credit_bal'];

// Fetch transaction history
$transactions = mysqli_query($con, "SELECT transaction_date, item_name, price FROM transactions WHERE library_id='$library_id' ORDER BY transaction_date DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Wallet || PSDigital</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: century gothic;
            margin: 0;
            padding: 0;
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
           background-image: url("bg.jpg"); background-repeat: repeat-x; background-size: 200px auto; background-position: top;
        }
        .link {
            color: #32CD32;
            font-weight: bold;
        }
        #home {
            margin-left: 1000px;
        }
        .center {
            text-align: center;
            margin-top: 60px;
        }
        table {
            width: 60%;
            margin: 20px auto;
            border-collapse: collapse;
            text-align: center;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
        }
    </style>
</head>
<body>
    <img src="logo.png" alt="Logo">
    <h1 id='psd'>Philippine School Doha</h1>
    <h1 id='name'>PSDigital</h1>
    <a href="home.php" class="link" id='home'>Home</a>
    <a href="menu.php" class="link">Available Items</a>
    <a href="wallet.php" class="link">My Wallet</a>
    <a href="logout.php" class="link">Logout</a>
    <div class="center">
        <h2>My Wallet</h2>
        <p>Current Balance: QR <?php echo $credit_bal; ?></p>
    </div>

    <div class="center">
        <h3>Transaction History</h3>
        <table>
            <tr>
                <th>Date</th>
                <th>Item Name</th>
                <th>Price (QR)</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($transactions)) { ?>
                <tr>
                    <td><?php echo date("Y-m-d H:i", strtotime($row['transaction_date'])); ?></td>
                    <td><?php echo htmlspecialchars($row['item_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['price']); ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>


