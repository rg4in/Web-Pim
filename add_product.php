<?php
session_start();
include 'connect.php';

$name = $_POST['name'];
$description = $_POST['description'];
$price = $_POST['price'];
$category = $_POST['category'];

$target_dir = "images/";
$target_file = $target_dir . basename($_FILES["image"]["name"]);
move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

$sql = "INSERT INTO products (name, description, price, category, image_url) VALUES ('$name', '$description', '$price', '$category', '$target_file')";

if ($conn->query($sql) === TRUE) {
    $_SESSION['message'] = "เพิ่มสินค้าใหม่เรียบร้อยแล้ว";
} else {
    $_SESSION['message'] = "เกิดข้อผิดพลาดในการเพิ่มสินค้า: " . $conn->error;
}

$conn->close();

header("Location: manage_store.php");
exit;
?>
