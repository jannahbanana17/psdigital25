<?php
    $conn = new mysqli("localhost", "root", "", "canteen_db");

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_item'])) {
        $item_name = $_POST['item_name'];
        $price = intval($_POST['price']); 
        $stmt = $conn->prepare("INSERT INTO menu_items (item_name, price) VALUES (?, ?)");
        $stmt->bind_param("si", $item_name, $price);
        $stmt->execute();
    }

    if (isset($_POST['delete']) && isset($_POST['delete_item'])) {
        $item_name = $_POST['delete_item'];
        $stmt = $conn->prepare("DELETE FROM menu_items WHERE item_name = ?");
        $stmt->bind_param("s", $item_name);
        $stmt->execute();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        header("Location: admin.php");
        exit();
    }

    $menu = $conn->query("SELECT * FROM menu_items");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Menu</title>
</head>
<body>
    <?php
        echo "Date: ". date("Y-m-d");
    ?>

    <h2>Add Item</h2>
    <form method="POST">
        <input type="text" name="item_name" placeholder="Item Name" required>
        <input type="number" name="price" placeholder="Price" required>
        <button type="submit" name="add_item">Add</button>
    </form>

    <h2>Delete Item</h2>
    <form method="POST">
        <select name="delete_item" required>
            <option value="" disabled selected>Select item to delete</option>
            <?php while ($row = $menu->fetch_assoc()): ?>
                <option value="<?php echo $row['item_name']; ?>"><?php echo $row['item_name'] . " - QR" . $row['price']; ?></option>
            <?php endwhile; ?>
        </select>
        <button type="submit" name="delete" onclick="return confirm('Are you sure you want to delete this item?');">Delete</button>
    </form>

    <h2>Available Items</h2>
    <ul>
        <?php
            $menu = $conn->query("SELECT * FROM menu_items");
            while ($row = $menu->fetch_assoc()):
        ?>
            <li>
                <?php echo $row['item_name'] . " - QR" . $row['price']; ?>
            </li>
        <?php endwhile; ?>
    </ul>
</body>
</html>

