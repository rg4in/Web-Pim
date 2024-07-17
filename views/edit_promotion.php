<?php
session_start();
include 'connect.php';

$promotion_id = $_POST['promotion_id'];
$promotion_name = $_POST['promotion_name'];
$description = $_POST['description'];
$discount_percentage = $_POST['discount_percentage'];

if ($_FILES['image']['name']) {
    $target_dir = "images/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    $image_url = $target_file;
    $sql = "UPDATE promotions SET promotion_name='$promotion_name', description='$description', discount_percentage='$discount_percentage', image_url='$image_url' WHERE promotion_id='$promotion_id'";
} else {
    $sql = "UPDATE promotions SET promotion_name='$promotion_name', description='$description', discount_percentage='$discount_percentage' WHERE promotion_id='$promotion_id'";
}

if ($conn->query($sql) === TRUE) {
    $_SESSION['message'] = "อัปเดตโปรโมชั่นเรียบร้อยแล้ว";
} else {
    $_SESSION['message'] = "เกิดข้อผิดพลาดในการอัปเดตโปรโมชั่น: " . $conn->error;
}

$conn->close();

header("Location: manage_store.php");
exit;
?>
