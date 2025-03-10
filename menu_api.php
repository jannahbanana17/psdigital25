<?php
	header("Content-Type: application/json");
	$conn = new mysqli("localhost", "root", "", "canteen_db");
	$result = $conn->query("SELECT id, item_name, price FROM menu_items");

	$menu = [];
	while ($row = $result->fetch_assoc()) {
		$row['price'] = intval($row['price']); 
		$menu[] = $row;
	}
	echo json_encode($menu);
?>