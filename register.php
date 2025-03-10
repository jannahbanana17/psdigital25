<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "canteen_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $targetDir = "photos/";
    $fileName = basename($_FILES["photo"]["name"]);
    $targetFilePath = $targetDir . md5(time() . $fileName) . "." . pathinfo($fileName, PATHINFO_EXTENSION);

    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFilePath)) {
        // Insert data with credit_bal set to 0
        $sql = "INSERT INTO mywallet (library_id, fname, gname, mname, section, photo, credit_bal, password) 
                VALUES ('" . mysqli_real_escape_string($conn, $_POST['lc']) . "',
                        '" . mysqli_real_escape_string($conn, $_POST['fname']) . "',
                        '" . mysqli_real_escape_string($conn, $_POST['gname']) . "',
                        '" . mysqli_real_escape_string($conn, $_POST['mname']) . "',
                        '" . mysqli_real_escape_string($conn, $_POST['gs']) . "',
                        '" . $targetFilePath . "',
                        0,
                        '" . password_hash($_POST['pass'], PASSWORD_DEFAULT) . "')";

        if (mysqli_query($conn, $sql)) {
            header("Location: home.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "Error uploading the photo.";
    }
}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register || PSDigital</title>
    <style>
        * { box-sizing: border-box; font-family: century gothic; margin: 0px; padding: 0px; }
        img { width: 90px; display: inline-block; margin-left: 30px; padding-top: 20px; }
        #psd { color: white; margin-top: -90px; padding-left: 130px; }
        #name { color: #32CD32; font-size: 70px; padding-left: 130px; }
        body { background-image: url("bg.jpg"); background-repeat: repeat-x; background-size: 200px auto; background-position: top;}
        h3 { text-align: center; padding-top: 130px; }
        form { text-align: center; padding-top: 40px; }
        #lc, #fn, #gn, #mn, #gs, #pass { width: 200px; height: 25px; border-color: green; }
        #reg { margin-top: 10px; width: 60px; background-color: yellow; border-color: green; font-weight: bold; width:100px;}
    </style>
</head>
<body>
    <img src="logo.png" alt="Logo">
    <h1 id='psd'>Philippine School Doha</h1>
    <h1 id='name'>PSDelicious</h1>
    <h3>Register Here</h3>
    <form action='register.php' method='post' enctype="multipart/form-data">
        Library Card Number: <input type='text' id='lc' name='lc' required/><br>
        Family Name: <input type='text' id='fn' name='fname' required/><br>
        Given Name: <input type='text' id='gn' name='gname' required/><br>
        Middle Name: <input type='text' id='mn' name='mname' required/><br>
        Grade & Section: <select id="gs" name="gs">
            <option value="">--</option>
            <option value="7-Armstrong">7-Armstrong</option>
            <option value="7-Cassini">7-Cassini</option>
            <option value="7-Copernicus">7-Copernicus</option>
            <option value="7-Galilei">7-Galilei</option>
            <option value="7-Halley">7-Halley</option>
            <option value="7-Herschel">7-Herschel</option>
            <option value="7-Hubble">7-Hubble</option>
            <option value="7-Kepler">7-Kepler</option>
            <option value="7-Ptolemy">7-Ptolemy</option>
            <option value="8-Aristotle">8-Aristotle</option>
            <option value="8-Darwin">8-Darwin</option>
            <option value="8-Fleming">8-Fleming</option>
            <option value="8-Hooke">8-Hooke</option>
            <option value="8-Jenner">8-Jenner</option>
            <option value="8-Linnaeus">8-Linnaeus</option>
            <option value="8-Mendel">8-Mendel</option>
            <option value="8-Pasteur">8-Pasteur</option>
            <option value="9-Arrhenius">9-Arrhenius</option>
            <option value="9-Boyle">9-Boyle</option>
            <option value="9-Curie">9-Curie</option>
            <option value="9-Dalton">9-Dalton</option>
            <option value="9-Frankling">9-Franklin</option>
            <option value="9-Lavoisier">9-Lavoisier</option>
            <option value="9-Mendeleev">9-Mendeleev</option>
            <option value="9-Pauling">9-Pauling</option>
            <option value="9-Rutherford">9-Rutherford</option>
            <option value="10-Archimedes">10-Archimedes</option>
            <option value="10-Bernoulli">10-Bernoulli</option>
            <option value="10-Edison">10-Edison</option>
            <option value="10-Einstein">10-Einstein</option>
            <option value="10-Faraday">10-Faraday</option>
            <option value="10-Maxwell">10-Maxwell</option>
            <option value="10-Newton">10-Newton</option>
            <option value="10-Pascal">10-Pascal</option>
            <option value="10-Thomson">10-Thomson</option>
        </select><br>
        Create Password: <input type='password' id='pass' name='pass' required/><br>
		Student Photo: <input type="file" id="photo" name="photo" accept="image/*" required/><br>
        <input type='submit' id='reg' value='Register'/>
    </form>
</body>
</html>
