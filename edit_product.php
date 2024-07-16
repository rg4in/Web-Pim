<?php
session_start();
include 'connect.php';

$product_id = $_POST['product_id'];
$name = $_POST['name'];
$description = $_POST['description'];
$price = $_POST['price'];
$category = $_POST['category'];

if(isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
    $target_dir = "images/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

    $sql = "UPDATE products SET name='$name', description='$description', price='$price', category='$category', image_url='$target_file' WHERE product_id='$product_id'";
} else {
    $sql = "UPDATE products SET name='$name', description='$description', price='$price', category='$category' WHERE product_id='$product_id'";
}

if ($conn->query($sql) === TRUE) {
    $_SESSION['message'] = "แก้ไขสินค้าเรียบร้อยแล้ว";
} else {
    $_SESSION['message'] = "เกิดข้อผิดพลาดในการแก้ไขสินค้า: " . $conn->error;
}

$conn->close();

header("Location: manage_store.php");
exit;
?>
