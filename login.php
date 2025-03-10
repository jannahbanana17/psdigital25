<?php
session_start(); // Start the session

// Database connection
$conn = new mysqli("localhost", "root", "", "canteen_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error_message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['user'];
    $password = $_POST['pass'];

    // Query to check if the username exists
    $sql = "SELECT * FROM mywallet WHERE library_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User exists, check password
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Password is correct, store library_id in session
            $_SESSION['library_id'] = $row['library_id'];

            // Regenerate session ID to prevent session fixation attacks
            session_regenerate_id(true);

            // Set flag for login state
            $_SESSION['is_logged_in'] = true;

            header("Location: home.php");
            exit();
        } else {
            $error_message = "Invalid password.";
        }
    } else {
        $error_message = "Invalid username.";
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Log-in || PSDigital</title>
    <style>
        * { box-sizing: border-box; font-family: century gothic; margin: 0px; padding: 0px; }
        img { width: 90px; display: inline-block; margin-left: 30px; padding-top: 20px; }
        #psd { color: white; margin-top: -90px; padding-left: 130px; }
        #name { color: #32CD32; font-size: 70px; padding-left: 130px; }
        body { background-image: url("bg.jpg"); background-repeat: repeat-x; background-size: 200px auto; background-position: top;}
        h3 { text-align: center; padding-top: 255px; }
        form { text-align: center; padding-top: 40px; }
        #user, #pass { width: 200px; height: 30px; border-color: green; }
        #login { margin-top: 10px; width: 60px; background-color: yellow; border-color: green; font-weight: bold; }
        a:link { text-align: center; padding-left: 650px; position: relative; top: 30px; }

        /* Styling for error message */
        .error-message {
            color: red;
            font-weight: bold;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <img src="logo.png" alt="Logo">
    <h1 id="psd">Philippine School Doha</h1>
    <h1 id="name">PSDigital</h1>
    <h3>Log-in Here</h3>
    
    <form action="login.php" method="post">
        <input type="text" id="user" name="user" placeholder="Username"/><br>
        <input type="password" id="pass" name="pass" placeholder="Password"/><br>
        <input type="submit" id="login" value="Log-in"/>
    </form>
    
    <!-- Display error message here if there's any -->
    <?php if (!empty($error_message)): ?>
        <div class="error-message">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>
    
    <a href="register.php">New user? Click here to register</a>
</body>
</html>

